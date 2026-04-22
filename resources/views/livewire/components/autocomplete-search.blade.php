<div class="relative" x-data="{ focused: false }">
    <div class="relative">
        <flux:input 
            wire:model.live.debounce.300ms="search"
            wire:focus="focusInput"
            wire:blur="hideDropdown"
            x-on:focus="focused = true"
            x-on:blur="setTimeout(() => focused = false, 150)"
            :placeholder="$placeholder"
            class="w-full"
            autocomplete="off"
        />
        
        @if($selectedId)
            <button 
                type="button"
                wire:click="clearSelection"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        @endif
    </div>

    @if($showDropdown && count($this->results) > 0)
        <div 
            class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"
            x-show="focused || $wire.showDropdown"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
        >
            @foreach($this->results as $result)
                <div 
                    wire:click="selectItem({{ $result['id'] }}, '{{ addslashes($result['titulo']) }}')"
                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0"
                >
                    <div class="font-medium text-gray-900">{{ $result['titulo'] }}</div>
                    <div class="text-sm text-gray-500">{{ $result['type'] }}</div>
                </div>
            @endforeach
        </div>
    @endif

    @if($showDropdown && empty($search))
        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg p-3">
            <div class="text-sm text-gray-500">Type at least 2 characters to search...</div>
        </div>
    @endif

    @if($showDropdown && !empty($search) && count($this->results) === 0)
        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg p-3">
            <div class="text-sm text-gray-500">No results found</div>
        </div>
    @endif

    <!-- Hidden input to store the selected ID for form submission -->
    <input type="hidden" name="exposicion_id" value="{{ $selectedId }}" />
</div>
