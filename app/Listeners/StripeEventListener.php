<?php

namespace App\Listeners;

use App\Modules\Donation\Infrastructure\Models\Donor;
use App\Modules\Donation\Infrastructure\Mail\FiscalReceiptMail;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            $data = $event->payload['data']['object'];

            // Search for Donador by Stripe Customer ID
            $donor = Donor::where('stripe_id', $data['customer'])->first();

            if ($donor) {
                if ($donor->comprobante) {
                    $toEmail = 'luis@casagallina.org.mx';
                    // $toEmail = 'ricgarcas@gmail.com';
                    Mail::to($toEmail)->send(new FiscalReceiptMail($donor));
                }
                app(\App\Modules\Donation\Application\Services\DonationEmailService::class)->sendSuccessEmail($donor);
            }
        } elseif ($event->payload['type'] === 'checkout.session.completed') {
            $data = $event->payload['data']['object'];

            $donor = null;
            if (isset($data['customer']) && $data['customer']) {
                $donor = Donor::where('stripe_id', $data['customer'])->first();
            } elseif (isset($data['customer_details']['email'])) {
                $donor = Donor::where('email', $data['customer_details']['email'])->first();
            }

            if ($donor) {
                app(\App\Modules\Donation\Application\Services\DonationEmailService::class)->sendSuccessEmail($donor);
            }
        }
    }
}
