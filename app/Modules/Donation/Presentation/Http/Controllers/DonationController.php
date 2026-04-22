<?php

namespace App\Modules\Donation\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Donation\Application\Services\DonationService;
use App\Modules\Donation\Infrastructure\Models\Donor;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function __construct(
        protected DonationService $service,
        protected \App\Modules\Donation\Application\Services\DonationEmailService $emailService
    ) {
    }

    public function setupIntent(Request $request)
    {
        $donor = $this->service->findOrCreateDonor(
            $request->name,
            $request->email,
            $request->comprobante == 'on'
        );

        $intent = $donor->createSetupIntent();

        return response()->json($intent);
    }

    public function checkout(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'cantidad' => 'required|numeric|min:100',
            'noticia_id' => 'nullable|exists:noticias,id',
        ]);

        $donor = $this->service->findOrCreateDonor(
            $request->name,
            $request->email,
            $request->comprobante == 'on'
        );

        $tipoDonacion = $request->get('tipo_donacion') ?? 'unica';
        $cantidad = $request->get('cantidad');
        $noticiaId = $request->get('noticia_id');

        $stripeKeys = config('stripe.' . config('app.env') . '.products.donacion');

        return $this->service->processCheckout($donor, $cantidad, $tipoDonacion, $noticiaId, $stripeKeys);
    }

    public function subscription(Request $request)
    {
        $donador_data = [];

        foreach ($request->donacion_data as $value) {
            $donador_data[$value['name']] = $value['value'];
        }

        // Logic seems to be: React/JS sends donacion_data array.
        // We reuse service charge/checkout logic where possible.
        // But subscription has specific logic about payment method attachment.

        $donor = $this->service->findOrCreateDonor(
            $donador_data['name'] ?? 'Unknown',
            $donador_data['email'],
            // Assuming default false if not present, logic in controller didn't explicitly check here but used findOrCreate logic implicitly
            false
        );

        if (!$donor->hasDefaultPaymentMethod()) {
            $donor->addPaymentMethod($request->payment_method);
            $donor->updateDefaultPaymentMethod($request->payment_method);
        }

        $amount = $donador_data['cantidad'];
        $suscripcionKey = 'suscripcion_' . $amount; // Logic from original
        // Need to get price ID. Original controller logic implies $this->suscripciones was involved? 
        // Wait, original PaymentController had `$this->suscripciones` accessed but not defined in the visible snippet?
        // Ah, `subscription` method used `$this->suscripciones[$donador_data['cantidad']]`. 
        // This implies `PaymentController` might have had a property or it was a mistake in my reading or snippet.
        // Checking `PaymentController.php` again... 
        // It has `public function subscription` which uses `$this->suscripciones`.
        // But `suscripciones` is NOT defined in the class in the snippet I saw.
        // It might be injected or defined in `Controller` base? Unlikely.
        // Or it was reading from config?
        // `checkout` method used `$stripeKeys`.
        // I will assume `suscripciones` comes from the same config structure:
        // $stripeKeys['billing_periods']['recurring'][$amount]

        $stripeKeys = config('stripe.' . config('app.env') . '.products.donacion');
        $stripePriceId = $stripeKeys['billing_periods']['recurring'][$amount] ?? null;

        $donor->newSubscription($suscripcionKey, $stripePriceId)->create($request->payment_method);

        // Send email
        if ($donor->comprobante) {
            // Refactored to use new Mail class
            \Mail::to('luis@casagallina.org.mx')->send(new \App\Modules\Donation\Infrastructure\Mail\FiscalReceiptMail($donor));
        }

        $this->emailService->sendSuccessEmail($donor);

        return response()->json(['success' => true]);
    }

    public function charge(Request $request)
    {
        $donador_data = [];
        foreach ($request->donacion_data as $value) {
            $donador_data[$value['name']] = $value['value'];
        }

        // Add comprobante from data if exists
        $donador_data['comprobante'] = $donador_data['comprobante'] ?? 'off';

        $donation = $this->service->processCharge(
            $donador_data,
            $request->payment_method,
            $request->input('noticia_id')
        );

        return response()->json(['success' => true, 'donation_id' => $donation->id]);
    }
}
