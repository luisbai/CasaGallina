<div x-data="{
    nombre: @entangle('nombre'),
    email: @entangle('email'),
    telefono: @entangle('telefono'),
    organizacion: @entangle('organizacion'),
    mensaje: @entangle('mensaje'),
    nombreTouched: false,
    emailTouched: false,
    telefonoTouched: false,
    organizacionTouched: false,
    mensajeTouched: false,
    
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

    get mensajeError() {
        if (!this.mensajeTouched || !this.mensaje) return '';
        if (this.mensaje.trim().length < 10) {
            return '{{ $language === "en" ? "Message must be at least 10 characters." : "El mensaje debe tener al menos 10 caracteres." }}';
        }
        return '';
    },
    
    get isFormValid() {
        if (!this.nombre || this.nombre.trim().length < 2) return false;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.email || !emailRegex.test(this.email)) return false;
        
        if (this.telefono) {
            const phoneRegex = /^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/;
            if (!phoneRegex.test(this.telefono)) return false;
        }

        if (!this.mensaje || this.mensaje.trim().length < 10) return false;
        
        return true;
    }
}" class="bg-white p-8 rounded-xl shadow-sm max-w-lg mx-auto">
    @if(!$submitted)
        <h2 class="text-lg font-bold text-green-600 mb-4 font-libre !tracking-tight">
            {{ __('Colabora con nosotros') }}
        </h2>

        <form wire:submit="submit">
            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="text-red-600 text-sm">{{ session('error') }}</div>
                </div>
            @endif

            <!-- User details -->
            <div class="space-y-4 mb-6">
                <div>
                    <label for="aliados-nombre"
                        class="block mb-2 text-base font-medium text-green-600">{{ __('Nombre *') }}</label>
                    <input type="text" wire:model.blur="nombre" x-model="nombre" @blur="nombreTouched = true"
                        class="w-full px-3 py-2.5 text-base border-2 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal transition-colors"
                        :class="nombreError ? 'border-red-500' : (nombreTouched && nombre ? 'border-green-600' : 'border-green-600')"
                        id="aliados-nombre" placeholder="{{ __('Escribe tu nombre') }}" autocomplete="off">
                    <div x-show="nombreError" x-text="nombreError" class="text-red-500 text-sm mt-1"></div>
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="aliados-email"
                        class="block mb-2 text-base font-medium text-green-600">{{ __('Correo Electrónico *') }}</label>
                    <input type="email" wire:model.blur="email" x-model="email" @blur="emailTouched = true"
                        class="w-full px-3 py-2.5 text-base border-2 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal transition-colors"
                        :class="emailError ? 'border-red-500' : (emailTouched && email && !emailError ? 'border-green-600' : 'border-green-600')"
                        id="aliados-email" placeholder="{{ __('Escribe tu dirección de correo electrónico') }}"
                        autocomplete="off">
                    <div x-show="emailError" x-text="emailError" class="text-red-500 text-sm mt-1"></div>
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="aliados-telefono"
                        class="block mb-2 text-base font-medium text-green-600">{{ __('Teléfono (opcional)') }}</label>
                    <input type="text" wire:model.blur="telefono" x-model="telefono" @blur="telefonoTouched = true"
                        class="w-full px-3 py-2.5 text-base border-2 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal transition-colors"
                        :class="telefonoError ? 'border-red-500' : (telefonoTouched && telefono && !telefonoError ? 'border-green-600' : 'border-green-600')"
                        id="aliados-telefono" placeholder="{{ __('Escribe tu número de teléfono') }}" autocomplete="off">
                    <div x-show="telefonoError" x-text="telefonoError" class="text-red-500 text-sm mt-1"></div>
                    @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="aliados-organizacion"
                        class="block mb-2 text-base font-medium text-green-600">{{ __('Organización (opcional)') }}</label>
                    <input type="text" wire:model.blur="organizacion" x-model="organizacion"
                        class="w-full px-3 py-2.5 text-base border-2 border-green-600 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal"
                        id="aliados-organizacion" placeholder="{{ __('Escribe el nombre de tu organización') }}"
                        autocomplete="off">
                    @error('organizacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="aliados-mensaje"
                        class="block mb-2 text-base font-medium text-green-600">{{ __('Cuéntanos sobre tu organización y cómo te gustaría colaborar *') }}</label>
                    <textarea wire:model.blur="mensaje" x-model="mensaje" @blur="mensajeTouched = true"
                        class="w-full px-3 py-2.5 text-base border-2 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal transition-colors"
                        :class="mensajeError ? 'border-red-500' : (mensajeTouched && mensaje ? 'border-green-600' : 'border-green-600')"
                        id="aliados-mensaje" rows="4"
                        placeholder="{{ __('Tell us about your ideas for collaboration...') }}"></textarea>
                    <div x-show="mensajeError" x-text="mensajeError" class="text-red-500 text-sm mt-1"></div>
                    @error('mensaje') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input id="aliados-subscribe" wire:model="subscribeToNewsletter" type="checkbox"
                        class="w-4 h-4 text-green-600 bg-white border-2 border-green-600 rounded focus:ring-0 focus:outline-none">
                    <label for="aliados-subscribe"
                        class="ml-3 mb-0 text-base font-medium text-green-600">{{ __('Suscribirme al boletín') }}</label>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" wire:loading.attr="disabled" wire:target="submit" :disabled="!isFormValid"
                class="w-full text-white bg-green-600 hover:bg-green-700 font-bold !text-2xl py-3 px-6 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="submit">{{ __('Enviar') }}</span>
                <span wire:loading wire:target="submit">{{ __('Enviando...') }}</span>
            </button>
        </form>
    @else
        <div class="text-center">
            <h3 class="text-xl font-bold text-green-600 mb-2">{{ __('¡Gracias por tu interés en colaborar!') }}</h3>
            <p class="text-green-600">{{ __('Hemos recibido tu mensaje y te contactaremos pronto.') }}</p>
        </div>
    @endif
</div>