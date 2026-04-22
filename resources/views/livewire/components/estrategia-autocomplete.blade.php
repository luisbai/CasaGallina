<div class="relative">
    <div class="relative">
        <flux:input 
            wire:model.live.debounce.300ms="search" 
            wire:focus="focusInput"
            wire:blur="hideDropdown"
            placeholder="{{ $placeholder }}"
            size="sm"
            icon="magnifying-glass"
            class="w-full"
        />
        
        @if($selectedId)
            <button 
                wire:click="clearSelection" 
                type="button"
                class="absolute right-8 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        @endif
    </div>

    @if($showDropdown && $this->results->count() > 0)
        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
            @foreach($this->results as $result)
                <div 
                    wire:click="selectItem({{ $result['id'] }}, '{{ addslashes($result['titulo']) }}')"
                    class="px-4 py-3 cursor-pointer hover:bg-gray-50 border-b border-gray-100 last:border-b-0"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">
                                {{ $result['titulo'] }}
                            </div>
                            @if($result['subtitulo'])
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ \Str::limit($result['subtitulo'], 60) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-2">
                            @if($result['status'] === 'public')
                                <flux:badge size="sm" color="green">Activa</flux:badge>
                            @else
                                <flux:badge size="sm" color="gray">Borrador</flux:badge>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif($showDropdown && strlen($search) >= 2)
        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
            <div class="px-4 py-3 text-gray-500 text-sm">
                No se encontraron estrategias
            </div>
        </div>
    @endif
</div>