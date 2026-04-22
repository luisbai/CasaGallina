<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Modules\Donation\Infrastructure\Models\Donor;
use App\Modules\Donation\Infrastructure\Models\Donation;

class DonationForm extends Component
{
    public $noticia;
    public $donationType = 'unica';
    public $selectedAmount = 500;
    public $customAmount = '';
    public $name = '';
    public $email = '';
    public $comprobante = false;
    public $language = 'es';

    public $amounts = [500, 1000, 1500, 2000, 2500, 3000];

    public function mount($noticia = null, $donationType = 'unica', $language = 'es')
    {
        $this->noticia = $noticia;
        $this->donationType = $donationType;
        $this->language = $language;
    }

    public function selectAmount($amount)
    {
        $this->selectedAmount = $amount;
        $this->customAmount = '';
    }

    public function updatedCustomAmount()
    {
        if ($this->customAmount) {
            $this->selectedAmount = null;
        }
    }

    public function getAmountProperty()
    {
        return $this->customAmount ?: $this->selectedAmount;
    }

    public function submit()
    {
        // Add debugging
        \Log::info('DonationForm submit started', [
            'selectedAmount' => $this->selectedAmount,
            'customAmount' => $this->customAmount,
            'name' => $this->name,
            'email' => $this->email,
            'noticia_id' => $this->noticia->id ?? null,
        ]);

        $this->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'customAmount' => 'nullable|numeric|min:100|max:1000000',
        ]);

        $amount = $this->getAmountProperty();
        \Log::info('Final amount calculated', ['amount' => $amount]);
        
        // Validate amount
        if (!$amount || !is_numeric($amount) || $amount < 100) {
            $errorMessage = $this->language === 'en'
                ? 'The minimum donation amount is $100 MXN'
                : 'El monto mínimo de donación es $100 MXN';
            $this->addError('amount', $errorMessage);
            return;
        }

        if ($amount > 1000000) {
            $errorMessage = $this->language === 'en'
                ? 'The maximum donation amount is $1,000,000 MXN. Please contact us for larger donations.'
                : 'El monto máximo de donación es $1,000,000 MXN. Por favor contáctanos para donaciones mayores.';
            $this->addError('amount', $errorMessage);
            return;
        }

        try {
            // Create or find donador - same logic as PaymentController
            $donador = Donor::where('email', $this->email)->first();
            \Log::info('Donador lookup', ['found' => $donador ? 'yes' : 'no', 'email' => $this->email]);

            if (!$donador) {
                $donador = Donor::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'comprobante' => $this->comprobante,
                ]);
                \Log::info('New donador created', ['id' => $donador->id]);
            }


            // Create Stripe customer if needed
            if (!$donador->stripe_id) {
                \Log::info('Creating Stripe customer');
                $donador->createAsStripeCustomer();
                \Log::info('Stripe customer created', ['stripe_id' => $donador->stripe_id]);
            }

            // Create donation record
            $donacion = $this->createDonacionRecord($donador, $amount, $this->noticia->id ?? null);
            \Log::info('Donation record created', ['donation_id' => $donacion->id]);

            // Get Stripe configuration
            $stripeKeys = config('stripe.' . config('app.env') . '.products.donacion');
            \Log::info('Stripe config loaded', ['env' => config('app.env'), 'has_config' => $stripeKeys ? 'yes' : 'no']);

            if (!$stripeKeys) {
                throw new \Exception('Stripe configuration not found for environment: ' . config('app.env'));
            }

            // Use Laravel Cashier checkout method - return to appropriate page with thank you
            if ($this->noticia) {
                $routeName = $this->language === 'en' ? 'english.noticia' : 'noticia';
                $slug = $this->language === 'en'
                    ? ($this->noticia->slug_en ?: $this->noticia->slug)
                    : $this->noticia->slug;
                $successUrl = route($routeName, $slug) . '?gracias=true&donation_id=' . $donacion->id;
                $cancelUrl = route($routeName, $slug) . '?cancelled=true&donation_id=' . $donacion->id;
            } else {
                // For donation type pages, return to the respective donation page
                $routePrefix = $this->language === 'en' ? 'english.' : '';
                $donationRoute = $routePrefix . 'donaciones.' . $this->donationType;
                $successUrl = route($donationRoute) . '?gracias=true&donation_id=' . $donacion->id;
                $cancelUrl = route($donationRoute) . '?cancelled=true&donation_id=' . $donacion->id;
            }

            // Handle different donation types
            if ($this->donationType == 'mensual') {
                // Monthly donation - subscription
                if (isset($stripeKeys['billing_periods']['recurring'][$amount])) {
                    $stripePriceId = $stripeKeys['billing_periods']['recurring'][$amount];
                    $suscripcionKey = 'suscripcion_' . $amount;

                    \Log::info('Creating monthly subscription', ['price_id' => $stripePriceId, 'amount' => $amount]);

                    $checkout = $donador->newSubscription($suscripcionKey, $stripePriceId)->checkout([
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ]);
                } else {
                    throw new \Exception('Monthly subscription not available for this amount');
                }
            } else {
                // One-time donation
                if (isset($stripeKeys['billing_periods']['one_time']) && in_array($amount, $stripeKeys['billing_periods']['one_time'])) {
                    $stripePriceId = $stripeKeys['billing_periods']['one_time'][$amount];
                    \Log::info('Using preset price', ['price_id' => $stripePriceId, 'amount' => $amount]);

                    $checkout = $donador->checkout($stripePriceId, [
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ]);
                } else {
                    \Log::info('Using custom charge', ['amount' => $amount]);
                    $checkout = $donador->checkoutCharge($amount * 100, 'Donación Casa Gallina', 1, [
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ]);
                }
            }

            \Log::info('Checkout created successfully', ['checkout_url' => $checkout->url]);

            // Redirect to Stripe Checkout
            return redirect($checkout->url);

        } catch (\Exception $e) {
            \Log::error('Donation submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Update donation status to failed if donation was created
            if (isset($donacion)) {
                $donacion->update(['status' => 'failed']);
            }

            $errorMessage = $this->language === 'en'
                ? 'Error processing payment: ' . $e->getMessage()
                : 'Error al procesar el pago: ' . $e->getMessage();
            $this->addError('payment', $errorMessage);
            return;
        }
    }

    /**
     * Create a donation record for tracking - same as PaymentController
     */
    private function createDonacionRecord($donador, $amount, $noticiaId = null, $stripePaymentIntentId = null, $status = 'pending')
    {
        return Donation::create([
            'donador_id' => $donador->id,
            'noticia_id' => $noticiaId,
            'amount' => $amount,
            'stripe_payment_intent_id' => $stripePaymentIntentId,
            'status' => $status,
        ]);
    }

    public function render()
    {
        return view('livewire.components.donation-form');
    }
}
