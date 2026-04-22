<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Modules\Contact\Application\Services\ContactService;
use Illuminate\Support\Facades\Log;

class AliadosForm extends Component
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
        $this->validate([
            'nombre' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|regex:/^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/|max:50',
            'organizacion' => 'nullable|string|max:255',
            'mensaje' => 'required|string|min:10|max:5000',
        ], [
            'nombre.required' => $this->language === 'en' ? 'Name is required.' : 'El nombre es obligatorio.',
            'nombre.min' => $this->language === 'en' ? 'Name must be at least 2 characters.' : 'El nombre debe tener al menos 2 caracteres.',
            'email.required' => $this->language === 'en' ? 'Email is required.' : 'El correo electrónico es obligatorio.',
            'email.email' => $this->language === 'en' ? 'Please enter a valid email address.' : 'Por favor ingresa un correo electrónico válido.',
            'telefono.regex' => $this->language === 'en' ? 'Please enter a valid phone number.' : 'Por favor ingresa un número de teléfono válido.',
            'mensaje.required' => $this->language === 'en' ? 'Please tell us about your project.' : 'Por favor cuéntanos sobre tu proyecto.',
            'mensaje.min' => $this->language === 'en' ? 'Message must be at least 10 characters.' : 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        try {
            $data = [
                'form_type' => 'aliados',
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'organizacion' => $this->organizacion,
                'subscribed_to_mailrelay' => $this->subscribeToNewsletter,
                'metadata' => [
                    'source' => 'aliados_form',
                    'mensaje' => $this->mensaje
                ],
            ];

            $submission = $contactService->create($data);

            if ($this->subscribeToNewsletter && $submission) {
                // Subscribe logic is handled here if ContactService supports it, 
                // or we can call subscribeToNewsletter explicitly if it's separate.
                // Looking at ContactForm, it calls it explicitly.
                $contactService->subscribeToNewsletter($submission->id);
            }

            $this->submitted = true;
            $this->reset(['nombre', 'email', 'telefono', 'organizacion', 'mensaje', 'subscribeToNewsletter']);

        } catch (\Exception $e) {
            Log::error('Error submitting aliados form: ' . $e->getMessage());
            session()->flash('error', $this->language === 'en'
                ? 'An error occurred while sending your message. Please try again later.'
                : 'Ocurrió un error al enviar tu mensaje. Por favor intenta de nuevo más tarde.');
        }
    }

    public function render()
    {
        return view('livewire.forms.aliados-form');
    }
}
