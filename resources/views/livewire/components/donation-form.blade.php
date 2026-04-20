<div x-data="{
    selectedAmount: 500,
    customAmount: '',
    amounts: [500, 1000, 1500, 2000, 2500, 3000],
    
    selectAmount(amount) {
        this.selectedAmount = amount;
        this.customAmount = '';
        @this.selectAmount(amount);
    },
    
    updateCustomAmount() {
        if (this.customAmount) {
            this.selectedAmount = null;
            @this.updatedCustomAmount();
        }
    },
    
    get finalAmount() {
        return this.customAmount || this.selectedAmount;
    }
}" class="bg-white p-8 rounded-xl shadow-lg">

    <h2 class="text-lg font-bold text-green-600 mb-4 font-libre !tracking-tight">
        {{ $language === 'en' ? 'Support this cause' : 'Apoya esta causa' }}
    </h2>
    
    <form wire:submit="submit">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Amount selection buttons -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <template x-for="(amount, index) in amounts" :key="index">
                <button type="button" 
                        @click="selectAmount(amount)"
                        :class="selectedAmount === amount ? 
                            'bg-green-600 text-white hover:bg-green-700' : 
                            'border-2 border-green-600 text-green-600 hover:bg-green-50'"
                        class="block w-full text-center py-2 px-4 rounded-lg cursor-pointer transition-colors duration-200 font-medium !text-xl">
                    $<span x-text="amount.toLocaleString()"></span>
                </button>
            </template>
        </div>

        <!-- Custom amount -->
        <div class="mb-6">
            <div class="flex border-2 border-green-600 rounded-lg overflow-hidden">
                <span class="inline-flex items-center pl-3 pr-2 text-base font-medium text-green-600 bg-white">$</span>
                <input type="number"
                       x-model="customAmount"
                       @input="updateCustomAmount()"
                       wire:model="customAmount"
                       class="flex-1 px-3 py-2.5 text-base text-gray-400 bg-white border-0 focus:ring-0 focus:outline-none placeholder-green-600 font-normal"
                       placeholder="{{ $language === 'en' ? 'Other amount (MXN)' : 'Otra cantidad (MXN)' }}"
                       min="100">
            </div>
        </div>

        <!-- User details -->
        <div class="space-y-4 mb-6">
            <div>
                <label for="nombre" class="block mb-2 text-base font-medium text-green-600">{{ $language === 'en' ? 'Name' : 'Nombre' }}</label>
                <input type="text"
                       wire:model="name"
                       class="w-full px-3 py-2.5 text-base border-2 border-green-600 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal"
                       id="nombre"
                       placeholder="{{ $language === 'en' ? 'Enter your name' : 'Escribe tu nombre' }}"
                       required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block mb-2 text-base font-medium text-green-600">{{ $language === 'en' ? 'Email' : 'Correo Electrónico' }}</label>
                <input type="email"
                       wire:model="email"
                       class="w-full px-3 py-2.5 text-base border-2 border-green-600 rounded-lg focus:ring-0 focus:outline-none placeholder-green-600 font-normal"
                       id="email"
                       placeholder="{{ $language === 'en' ? 'Enter your email address' : 'Escribe tu dirección de correo electrónico' }}"
                       required>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center">
                <input id="comprobante"
                       wire:model="comprobante"
                       type="checkbox"
                       class="w-4 h-4 text-green-600 bg-white border-2 border-green-600 rounded focus:ring-0 focus:outline-none">
                <label for="comprobante" class="ml-3 mb-0 text-base font-medium text-green-600">{{ $language === 'en' ? 'I would like a tax receipt' : 'Deseo comprobante fiscal' }}</label>
            </div>
        </div>

        <!-- Submit button -->
        <button type="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="w-full text-white bg-green-600 hover:bg-green-700 font-bold !text-2xl py-3 px-6 rounded-lg transition-colors duration-200">
            <span wire:loading.remove>{{ $language === 'en' ? 'Continue' : 'Continuar' }}</span>
            <span wire:loading>{{ $language === 'en' ? 'Processing...' : 'Procesando...' }}</span>
        </button>
    </form>
</div>