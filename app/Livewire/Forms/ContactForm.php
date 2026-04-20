<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Modules\Contact\Application\Services\ContactService;
use Flux\Flux;
use Illuminate\Support\Facades\Log;

class ContactForm extends Component
{
    public string $nombre = '';
    public string $email = '';
    public string $telefono = '';
    public string $organizacion = '';
    public string $mensaje = '';
    public bool $subscribeToNewsletter = false;

    public string $language = 'es';
    public bool $submitted = false;

    public function mount()
    {
        $routeName = request()->route() ? request()->route()->getName() : '';
        if ($routeName && str_starts_with($routeName, 'english.')) {
            $this->language = 'en';
        }
    }

    public function submit(ContactService $contactService)
    {
        // Rate limiting: 5 attempts per minute per IP
        $key = 'contact-form:' . request()->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            $message = $this->language === 'en'
                ? "Too many attempts. Please try again in {$seconds} seconds."
                : "Demasiados intentos. Por favor intenta de nuevo en {$seconds} segundos.";

            session()->flash('error', $message);
            return;
        }

        $this->validate([
            'nombre' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10|max:5000',
            'telefono' => 'nullable|string|regex:/^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/|max:50',
            'organizacion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => $this->language === 'en' ? 'Name is required.' : 'El nombre es obligatorio.',
            'nombre.min' => $this->language === 'en' ? 'Name must be at least 2 characters.' : 'El nombre debe tener al menos 2 caracteres.',
            'email.required' => $this->language === 'en' ? 'Email is required.' : 'El correo electrónico es obligatorio.',
            'email.email' => $this->language === 'en' ? 'Please enter a valid email address.' : 'Por favor ingresa un correo electrónico válido.',
            'mensaje.required' => $this->language === 'en' ? 'Message is required.' : 'El mensaje es obligatorio.',
            'mensaje.min' => $this->language === 'en' ? 'Message must be at least 10 characters.' : 'El mensaje debe tener al menos 10 caracteres.',
            'mensaje.max' => $this->language === 'en' ? 'Message cannot exceed 5000 characters.' : 'El mensaje no puede exceder 5000 caracteres.',
            'telefono.regex' => $this->language === 'en' ? 'Please enter a valid phone number.' : 'Por favor ingresa un número de teléfono válido.',
        ]);

        try {
            $data = [
                'form_type' => 'contact',
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'organizacion' => $this->organizacion,
                'metadata' => [
                    'source' => 'web_contact_form',
                    'mensaje' => $this->mensaje
                ],
            ];

            $submission = $contactService->create($data);

            if ($this->subscribeToNewsletter && $submission) {
                $contactService->subscribeToNewsletter($submission->id);
            }

            // Hit the rate limiter on successful submission
            \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

            $this->submitted = true;
            $this->reset(['nombre', 'email', 'telefono', 'organizacion', 'mensaje', 'subscribeToNewsletter']);

        } catch (\Exception $e) {
            \Log::error('Error submitting contact form: ' . $e->getMessage());
            session()->flash('error', $this->language === 'en'
                ? 'An error occurred while sending your message. Please try again later.'
                : 'Ocurrió un error al enviar tu mensaje. Por favor intenta de nuevo más tarde.');
        }
    }

    public function render()
    {
        return view('livewire.forms.contact-form');
    }
}
