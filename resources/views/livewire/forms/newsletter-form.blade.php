<div x-data="{
    nombre: @entangle('nombre'),
    email: @entangle('email'),
    telefono: @entangle('telefono'),
    organizacion: @entangle('organizacion'),
    nombreTouched: false,
    emailTouched: false,
    telefonoTouched: false,
    organizacionTouched: false,
    
    get nombreError() {
        if (!this.nombreTouched || !this.nombre) return '';
        if (this.nombre.trim().length < 2) {
            return '{{ $language === "en" ? "Name must be at least 2 characters." : "El nombre debe tener al menos 2 caracteres." }}';
        }
        return '';
    },
    
    get emailError() {
        if (!this.emailTouched || !this.email) return '';
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.email)) {
            return '{{ $language === "en" ? "Please enter a valid email address." : "Por favor ingresa un correo electrónico válido." }}';
        }
        return '';
    },
    
    get telefonoError() {
        if (!this.telefonoTouched || !this.telefono) return '';
        const phoneRegex = /^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/;
        if (!phoneRegex.test(this.telefono)) {
            return '{{ $language === "en" ? "Please enter a valid phone number." : "Por favor ingresa un número de teléfono válido." }}';
        }
        return '';
    },
    
    get isFormValid() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.email || !emailRegex.test(this.email)) return false;
        
        if (this.nombre && this.nombre.trim().length < 2) return false;
        
        if (this.telefono) {
            const phoneRegex = /^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/;
            if (!phoneRegex.test(this.telefono)) return false;
        }
        
        return true;
    }
}">
    @if(!$submitted)
        <form wire:submit="submit" class="space-y-1.5 mt-2">
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <input type="text" wire:model.blur="nombre" x-model="nombre" @blur="nombreTouched = true"
                    placeholder="{{ __('Nombre (opcional)') }}" autocomplete="off"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm transition-colors"
                    :class="nombreError ? 'border-2 border-red-500' : (nombreTouched && nombre ? 'border-2 border-green-500' : '')">
                <div x-show="nombreError" x-text="nombreError" class="text-red-500 text-sm mt-1"></div>
                @error('nombre')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="email" wire:model.blur="email" x-model="email" @blur="emailTouched = true"
                    placeholder="{{ __('Correo Electrónico') }}" autocomplete="off"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm transition-colors"
                    :class="emailError ? 'border-2 border-red-500' : (emailTouched && email && !emailError ? 'border-2 border-green-500' : '')">
                <div x-show="emailError" x-text="emailError" class="text-red-500 text-sm mt-1"></div>
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="text" wire:model.blur="telefono" x-model="telefono" @blur="telefonoTouched = true"
                    placeholder="{{ __('Teléfono (opcional)') }}" autocomplete="off"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm transition-colors"
                    :class="telefonoError ? 'border-2 border-red-500' : (telefonoTouched && telefono && !telefonoError ? 'border-2 border-green-500' : '')">
                <div x-show="telefonoError" x-text="telefonoError" class="text-red-500 text-sm mt-1"></div>
                @error('telefono')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="text" wire:model.blur="organizacion" x-model="organizacion" @blur="organizacionTouched = true"
                    placeholder="{{ __('Organización (opcional)') }}" autocomplete="off"
                    class="w-full bg-gray-200 text-gray-900 px-2 py-1.5 !text-sm transition-colors">
                @error('organizacion')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-forest-700 hover:bg-forest-800 text-white font-medium py-1.5 px-2 !text-sm transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled" wire:target="submit" :disabled="!isFormValid">
                    <span wire:loading.remove wire:target="submit">{{ __('Enviar') }}</span>
                    <span wire:loading wire:target="submit">{{ __('Enviando...') }}</span>
                </button>
            </div>
        </form>
    @else
        <div class="bg-forest-100 border border-forest-400 text-forest-700 px-4 py-3 rounded text-center">
            {{ __('Gracias por suscribirte a nuestro newsletter.') }}
        </div>
    @endif
</div>