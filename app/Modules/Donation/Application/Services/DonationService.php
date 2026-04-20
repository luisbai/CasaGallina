<?php

namespace App\Modules\Donation\Application\Services;

use App\Modules\Donation\Infrastructure\Mail\FiscalReceiptMail;
use App\Modules\Donation\Infrastructure\Models\Donation;
use App\Modules\Donation\Infrastructure\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Modules\Donation\Application\Services\DonationEmailService;

class DonationService
{
    public function __construct(
        protected DonationEmailService $emailService
    ) {
    }
    public function findOrCreateDonor(string $name, string $email, bool $receipt): Donor
    {
        $donor = Donor::where('email', $email)->first();

        if (!$donor) {
            $donor = Donor::create([
                'name' => $name,
                'email' => $email,
                'comprobante' => $receipt,
            ]);
        }

        // Ensure Stripe ID exists
        if (!$donor->stripe_id) {
            $donor->createAsStripeCustomer();
        }

        return $donor;
    }

    public function createDonationRecord(Donor $donor, $amount, $noticiaId = null, $stripePaymentIntentId = null, $status = 'pending'): Donation
    {
        return Donation::create([
            'donador_id' => $donor->id,
            'noticia_id' => $noticiaId,
            'amount' => $amount,
            'stripe_payment_intent_id' => $stripePaymentIntentId,
            'status' => $status,
        ]);
    }

    public function processCheckout(Donor $donor, float $amount, string $type, ?int $noticiaId = null, array $stripeKeys)
    {
        // Create Donation Record
        $donation = $this->createDonationRecord($donor, $amount, $noticiaId);

        $successUrl = route('donaciones') . '?success=true&donation_id=' . $donation->id;
        $cancelUrl = route('donaciones') . '?cancelled=true&donation_id=' . $donation->id;

        if ($type == 'mensual') {
            $suscripcionKey = 'suscripcion_' . $amount;

            // Assuming stripeKeys structure matches what was in controller
            $stripePriceId = $stripeKeys['billing_periods']['recurring'][$amount] ?? null;

            if (!$stripePriceId) {
                // Fallback or error handling
                throw new \Exception("Price ID not found for amount: $amount");
            }

            $checkout = $donor->newSubscription($suscripcionKey, $stripePriceId)
                ->checkout([
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                ]);

            if (isset($checkout->payment_intent)) {
                $donation->update(['stripe_payment_intent_id' => $checkout->payment_intent]);
            }

            return $checkout;

        } elseif ($type == 'unica') {

            if (isset($stripeKeys['billing_periods']['one_time'][$amount])) {
                $stripePriceId = $stripeKeys['billing_periods']['one_time'][$amount];

                return $donor->checkout($stripePriceId, [
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                ]);
            }

            return $donor->checkoutCharge($amount * 100, 'Donación Casa Gallina', 1, [
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);
        }

        return null;
    }

    public function processCharge(array $donorData, string $paymentMethod, ?int $noticiaId = null)
    {
        $donor = Donor::where('email', $donorData['email'])->first();

        if (!$donor) {
            // Should not happen if flow is correct, but let's handle it or assume it exists
            // Logic in controller was getting it by email but previously creating it? 
            // Controller: processCharge takes donorData.
            // Actually PaymentController logic was re-fetching.
            // Let's reuse findOrCreate
            $donor = $this->findOrCreateDonor(
                $donorData['name'] ?? 'Unknown',
                $donorData['email'],
                // Assuming 'comprobante' key exists or null
                isset($donorData['comprobante']) && $donorData['comprobante'] == 'on'
            );
        }

        if (!$donor->hasDefaultPaymentMethod()) {
            $donor->updateDefaultPaymentMethod($paymentMethod);
        }

        $donor->addPaymentMethod($paymentMethod);

        $donation = $this->createDonationRecord(
            $donor,
            $donorData['cantidad'],
            $noticiaId,
            null,
            'pending'
        );

        try {
            $payment = $donor->charge($donorData['cantidad'] * 100, $paymentMethod);

            $donation->update([
                'status' => 'completed',
                'stripe_payment_intent_id' => $payment->id ?? null
            ]);

            // Send receipt if requested
            if ($donor->comprobante) {
                Mail::to('luis@casagallina.org.mx')->send(new FiscalReceiptMail($donor));
            }

            $this->emailService->sendSuccessEmail($donor);

            return $donation;

        } catch (\Exception $e) {
            $donation->update(['status' => 'failed']);
            throw $e;
        }
    }
}
