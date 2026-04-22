<!-- 
    Componente de ejemplo para validación en tiempo real con Livewire
    Uso: Incluir wire:model.live para validación instantánea
-->

<div>
    <!-- Ejemplo de validación en tiempo real -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">
            {{ $language === 'en' ? 'Email' : 'Correo Electrónico' }}
        </label>
        <input 
            type="email" 
            id="email" 
            wire:model.live="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Indicador de progreso para uploads -->
    <div class="mb-4" x-data="{ uploading: false, progress: 0 }" 
         x-on:livewire-upload-start="uploading = true"
         x-on:livewire-upload-finish="uploading = false"
         x-on:livewire-upload-error="uploading = false"
         x-on:livewire-upload-progress="progress = $event.detail.progress">
        
        <label for="file" class="block text-sm font-medium text-gray-700">
            {{ $language === 'en' ? 'Upload File' : 'Subir Archivo' }}
        </label>
        
        <input 
            type="file" 
            id="file" 
            wire:model="file"
            class="mt-1 block w-full"
        >
        
        <!-- Progress Bar -->
        <div x-show="uploading" class="mt-2">
            <div class="relative pt-1">
                <div class="flex mb-2 items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold inline-block text-indigo-600">
                            {{ $language === 'en' ? 'Uploading...' : 'Subiendo...' }}
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold inline-block text-indigo-600" x-text="progress + '%'">
                        </span>
                    </div>
                </div>
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200">
                    <div 
                        :style="`width: ${progress}%`"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-300"
                    ></div>
                </div>
            </div>
        </div>
        
        @error('file')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Loading state durante validación -->
    <div wire:loading wire:target="submit" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">
                {{ $language === 'en' ? 'Processing...' : 'Procesando...' }}
            </span>
        </div>
    </div>
</div>
