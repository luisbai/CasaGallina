<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Modules\Shared\Application\Services\MailRelayService;
use Illuminate\Support\Facades\Log;

class NewsletterForm extends Component
{
    public string $nombre = '';
    public string $email = '';
    public string $telefono = '';
    public string $organizacion = '';

    public string $language = 'es';
    public bool $submitted = false;

    /**
     * Computed property to check if form is valid for submission
     */
    public function getIsFormValidProperty(): bool
    {
        // Email is required and must be valid
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // If nombre is provided, it must be at least 2 characters
        if (!empty($this->nombre) && strlen(trim($this->nombre)) < 2) {
            return false;
        }

        // If telefono is provided, it must match the phone pattern
        if (!empty($this->telefono)) {
            $phonePattern = '/^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/';
            if (!preg_match($phonePattern, $this->telefono)) {
                return false;
            }
        }

        return true;
    }

    public function mount()
    {
        $routeName = request()->route() ? request()->route()->getName() : '';
        if ($routeName && str_starts_with($routeName, 'english.')) {
            $this->language = 'en';
        }
    }

    public function submit(MailRelayService $mailRelayService)
    {
        // Rate limiting: 3 attempts per minute per IP
        $key = 'newsletter-form:' . request()->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            $message = $this->language === 'en'
                ? "Too many subscription attempts. Please try again in {$seconds} seconds."
                : "Demasiados intentos de suscripción. Por favor intenta de nuevo en {$seconds} segundos.";

            session()->flash('error', $message);
            return;
        }

        $this->validate([
            'email' => 'required|email|max:255',
            'nombre' => 'nullable|string|min:2|max:255',
            'telefono' => 'nullable|string|regex:/^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/|max:50',
            'organizacion' => 'nullable|string|max:255',
        ], [
            'email.required' => $this->language === 'en' ? 'Email is required to subscribe.' : 'El correo electrónico es obligatorio para suscribirte.',
            'email.email' => $this->language === 'en' ? 'Please enter a valid email address.' : 'Por favor ingresa un correo electrónico válido.',
            'nombre.min' => $this->language === 'en' ? 'Name must be at least 2 characters.' : 'El nombre debe tener al menos 2 caracteres.',
            'telefono.regex' => $this->language === 'en' ? 'Please enter a valid phone number.' : 'Por favor ingresa un número de teléfono válido.',
        ]);

        try {
            $additionalData = [];
            if ($this->telefono) {
                $additionalData['telefono'] = $this->telefono;
            }
            if ($this->organizacion) {
                $additionalData['organizacion'] = $this->organizacion;
            }

            // If name is empty, use email part as fallback or just empty string depending on service requirement
            $name = $this->nombre ?: explode('@', $this->email)[0];

            $success = $mailRelayService->subscribeContact(
                $this->email,
                $name,
                $additionalData
            );

            if ($success) {
                // Hit the rate limiter on successful subscription
                \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

                $this->submitted = true;

                // Flash success message
                session()->flash('success', $this->language === 'en'
                    ? 'Thank you for subscribing to our newsletter!'
                    : '¡Gracias por suscribirte a nuestro boletín!');

                $this->reset(['nombre', 'email', 'telefono', 'organizacion']);
            } else {
                throw new \Exception('MailRelay subscription returned false');
            }

        } catch (\Exception $e) {
            \Log::error('Error subscribing to newsletter: ' . $e->getMessage());
            session()->flash('error', $this->language === 'en'
                ? 'An error occurred while subscribing. Please try again later.'
                : 'Ocurrió un error al suscribirte. Por favor intenta de nuevo más tarde.');
        }
    }

    public function render()
    {
        return view('livewire.forms.newsletter-form');
    }
}
