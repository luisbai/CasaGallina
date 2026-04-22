<div x-data="{
    nombre: @entangle('nombre'),
    email: @entangle('email'),
    mensaje: @entangle('mensaje'),
    nombreTouched: false,
    emailTouched: false,
    mensajeTouched: false,

    get nombreError() {
        if (!this.nombreTouched) return '';
        if (!this.nombre || this.nombre.trim().length < 2) {
            return '{{ $language === "en" ? "Name must be at least 2 characters." : "El nombre debe tener al menos 2 caracteres." }}';
        }
        return '';
    },

    get emailError() {
        if (!this.emailTouched) return '';
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.email || !emailRegex.test(this.email)) {
            return '{{ $language === "en" ? "Please enter a valid email address." : "Por favor ingresa un correo electrónico válido." }}';
        }
        return '';
    },

    get mensajeError() {
        if (!this.mensajeTouched) return '';
        if (!this.mensaje || this.mensaje.trim().length < 10) {
            return '{{ $language === "en" ? "Message must be at least 10 characters." : "El mensaje debe tener al menos 10 caracteres." }}';
        }
        return '';
    },

    get isFormValid() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return (
            this.nombre && this.nombre.trim().length >= 2 &&
            this.email && emailRegex.test(this.email) &&
            this.mensaje && this.mensaje.trim().length >= 10
        );
    }
}">
    @if(!$submitted)
        <form wire:submit="submit" class="space-y-1.5 mt-2">
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <input type="text" wire:model.blur="nombre" x-model="nombre" @blur="nombreTouched = true" placeholder="{{ __('Nombre') }}"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm border-0 focus:ring-2 focus:ring-forest-500"
                    :class="nombreError ? 'border-2 border-red-500' : ''">
                <div x-show="nombreError" x-text="nombreError" class="text-red-500 text-xs mt-1"></div>
                @error('nombre')
                    <div class="text-red-500 text-xs mt-1" x-show="!nombreError">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="email" wire:model.blur="email" x-model="email" @blur="emailTouched = true" placeholder="{{ __('Correo Electrónico') }}"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm border-0 focus:ring-2 focus:ring-forest-500"
                    :class="emailError ? 'border-2 border-red-500' : ''">
                <div x-show="emailError" x-text="emailError" class="text-red-500 text-xs mt-1"></div>
                @error('email')
                    <div class="text-red-500 text-xs mt-1" x-show="!emailError">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="text" wire:model.blur="telefono" placeholder="{{ __('Teléfono (opcional)') }}"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm border-0 focus:ring-2 focus:ring-forest-500">
                @error('telefono')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="text" wire:model.blur="organizacion" placeholder="{{ __('Organización (opcional)') }}"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm border-0 focus:ring-2 focus:ring-forest-500">
                @error('organizacion')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <textarea wire:model.blur="mensaje" x-model="mensaje" @blur="mensajeTouched = true" placeholder="{{ __('¿En qué podemos ayudarte?') }}"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm border-0 focus:ring-2 focus:ring-forest-500" rows="4"
                    :class="mensajeError ? 'border-2 border-red-500' : ''"></textarea>
                <div x-show="mensajeError" x-text="mensajeError" class="text-red-500 text-xs mt-1"></div>
                @error('mensaje')
                    <div class="text-red-500 text-xs mt-1" x-show="!mensajeError">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center !mb-3">
                <input type="checkbox" wire:model="subscribeToNewsletter" id="subscribe" class="mr-2">
                <label for="subscribe" class="text-gray-200 !m-0">{{ __('Suscribirme al boletín') }}</label>
            </div>

            <div>
                <button type="submit" :disabled="!isFormValid"
                    class="w-full bg-forest-700 hover:bg-forest-800 text-white font-medium py-1.5 px-2 !text-sm transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Enviar') }}</span>
                    <span wire:loading>{{ __('Enviando...') }}</span>
                </button>
            </div>
        </form>
    @else
        <div class="bg-forest-100 border border-forest-400 text-forest-700 px-4 py-3 rounded text-center">
            <h3 class="font-medium">{{ __('Gracias por contactarnos.') }}</h3>
            <p class="text-sm mt-1">{{ __('Hemos recibido tu mensaje y te responderemos pronto.') }}</p>
        </div>
    @endif
</div>