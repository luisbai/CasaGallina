# Guía de Implementación: Validación en Tiempo Real e Indicadores de Progreso

## Validación en Tiempo Real con Livewire

### Implementación Básica

Para habilitar validación en tiempo real en cualquier formulario Livewire, simplemente cambia `wire:model` por `wire:model.live`:

```blade
<!-- Antes: Validación solo al enviar -->
<input type="email" wire:model="email">

<!-- Después: Validación en tiempo real -->
<input type="email" wire:model.live="email">
```

### Validación con Debounce

Para evitar validaciones excesivas mientras el usuario escribe, usa `wire:model.live.debounce`:

```blade
<!-- Valida 500ms después de que el usuario deja de escribir -->
<input type="text" wire:model.live.debounce.500ms="nombre">
```

### Ejemplo Completo en ContactForm

```blade
<div>
    <label for="nombre">Nombre</label>
    <input 
        type="text" 
        id="nombre"
        wire:model.live.debounce.300ms="nombre"
        class="@error('nombre') border-red-500 @enderror"
    >
    @error('nombre')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
```

---

## Indicadores de Progreso para Uploads

### Configuración con Alpine.js

Livewire emite eventos durante el proceso de upload que podemos capturar con Alpine.js:

```blade
<div 
    x-data="{ uploading: false, progress: 0 }" 
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false; progress = 0"
    x-on:livewire-upload-error="uploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <input type="file" wire:model="multimedia">
    
    <!-- Barra de progreso -->
    <div x-show="uploading" class="mt-2">
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div 
                class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                :style="'width: ' + progress + '%'"
            ></div>
        </div>
        <p class="text-sm text-gray-600 mt-1" x-text="'Subiendo: ' + progress + '%'"></p>
    </div>
</div>
```

### Indicador de Loading durante Validación

```blade
<!-- Muestra spinner mientras se procesa el formulario -->
<div wire:loading wire:target="submit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6">
        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-2 text-gray-700">Procesando...</p>
    </div>
</div>
```

---

## Implementación Recomendada por Formulario

### 1. ContactForm
- ✅ Validación en tiempo real para email
- ✅ Debounce 300ms para nombre y mensaje
- ✅ Loading state durante envío

### 2. NewsletterForm
- ✅ Validación en tiempo real para email
- ✅ Loading state durante suscripción

### 3. DonationForm
- ✅ Validación en tiempo real para monto
- ✅ Loading state durante procesamiento de pago

### 4. Admin Forms (Exhibition, Program, etc.)
- ✅ Indicador de progreso para uploads de imágenes
- ✅ Validación en tiempo real para campos de texto
- ✅ Loading state durante guardado

---

## Ejemplo de Implementación Completa

### Archivo: `resources/views/livewire/forms/contact-form.blade.php`

```blade
<div class="max-w-2xl mx-auto p-6">
    @if($submitted)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ $language === 'en' ? 'Thank you for your message!' : '¡Gracias por tu mensaje!' }}
        </div>
    @else
        <form wire:submit.prevent="submit">
            <!-- Nombre con validación en tiempo real -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">
                    {{ $language === 'en' ? 'Name' : 'Nombre' }} *
                </label>
                <input 
                    type="text" 
                    id="nombre"
                    wire:model.live.debounce.300ms="nombre"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                >
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email con validación en tiempo real -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ $language === 'en' ? 'Email' : 'Correo Electrónico' }} *
                </label>
                <input 
                    type="email" 
                    id="email"
                    wire:model.live.debounce.300ms="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium text-gray-700">
                    {{ $language === 'en' ? 'Phone' : 'Teléfono' }}
                </label>
                <input 
                    type="tel" 
                    id="telefono"
                    wire:model="telefono"
                    placeholder="+52 55 1234 5678"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono') border-red-500 @enderror"
                >
                @error('telefono')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mensaje -->
            <div class="mb-4">
                <label for="mensaje" class="block text-sm font-medium text-gray-700">
                    {{ $language === 'en' ? 'Message' : 'Mensaje' }} *
                </label>
                <textarea 
                    id="mensaje"
                    wire:model.live.debounce.500ms="mensaje"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('mensaje') border-red-500 @enderror"
                ></textarea>
                <p class="mt-1 text-sm text-gray-500">
                    {{ strlen($mensaje) }}/5000 caracteres
                </p>
                @error('mensaje')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón de envío -->
            <div class="flex items-center justify-end">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="submit">
                        {{ $language === 'en' ? 'Send Message' : 'Enviar Mensaje' }}
                    </span>
                    <span wire:loading wire:target="submit" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $language === 'en' ? 'Sending...' : 'Enviando...' }}
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
```

---

## Ventajas de la Implementación

### Validación en Tiempo Real
✅ Feedback inmediato al usuario  
✅ Reduce errores al enviar el formulario  
✅ Mejor experiencia de usuario  
✅ Menor frustración  

### Indicadores de Progreso
✅ Usuario sabe que el sistema está trabajando  
✅ Reduce abandonos durante uploads largos  
✅ Percepción de velocidad mejorada  
✅ Profesionalismo  

---

## Notas de Implementación

1. **Alpine.js requerido**: Asegúrate de que Alpine.js esté incluido en tu proyecto
2. **Tailwind CSS**: Los ejemplos usan Tailwind, ajusta según tu framework CSS
3. **Performance**: Usa debounce apropiado para evitar validaciones excesivas
4. **Accesibilidad**: Mantén labels y mensajes de error accesibles

---

## Próximos Pasos

1. Implementar validación en tiempo real en formularios públicos
2. Agregar indicadores de progreso en formularios con uploads
3. Probar en diferentes navegadores
4. Ajustar tiempos de debounce según feedback de usuarios
