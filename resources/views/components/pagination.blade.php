@if ($paginator->hasPages())
    <div wire:loading.delay class="flex justify-center mb-2">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2" style="border-color: #68945c;"></div>
    </div>
    
    {{-- Responsive pagination container --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 sm:space-x-6">

        {{-- Page Info --}}
        <div class="font-serif text-base sm:text-lg text-gray-600 text-center sm:text-left order-1 mt-4 md:mt-0">
            <span class="hidden sm:inline">Mostrando {{ $paginator->firstItem() }} a {{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados</span>
            <span class="sm:hidden">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} de {{ $paginator->total() }}</span>
        </div>

        {{-- Navigation --}}
        <nav role="navigation" aria-label="Navegación de páginas" class="!flex items-center justify-center space-x-1 sm:space-x-2 order-1 sm:order-2">
            
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-2 py-2 sm:px-3 text-gray-400 cursor-not-allowed">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <button 
                    wire:click="previousPage" 
                    wire:loading.attr="disabled" 
                    rel="prev"
                    class="px-2 py-2 sm:px-3 text-gray-600 hover:text-white rounded-lg transition-all duration-500 flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                    onmouseover="this.style.backgroundColor='#68945c'; this.style.color='#FFF';"
                    onmouseout="this.style.backgroundColor=''; this.style.color='';"
                    aria-label="Página anterior">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-2 py-2 sm:px-3 text-gray-500">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 sm:px-4 text-white font-medium rounded-lg shadow-sm" style="background-color: #68945c;">
                                {{ $page }}
                            </span>
                        @else
                            <button 
                                wire:click="gotoPage({{ $page }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 sm:px-4 text-gray-600 hover:text-white font-medium rounded-lg transition-all duration-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                onmouseover="this.style.backgroundColor='#68945c'; this.style.color='#FFF';"
                                onmouseout="this.style.backgroundColor=''; this.style.color='';"
                                aria-label="Ir a página {{ $page }}">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button 
                    wire:click="nextPage" 
                    wire:loading.attr="disabled" 
                    rel="next"
                    class="px-2 py-2 sm:px-3 text-gray-600 hover:text-white rounded-lg transition-all duration-500 flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                    onmouseover="this.style.backgroundColor='#68945c'; this.style.color='#FFF';"
                    onmouseout="this.style.backgroundColor=''; this.style.color='';"
                    aria-label="Página siguiente">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            @else
                <span class="px-2 py-2 sm:px-3 text-gray-400 cursor-not-allowed">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </nav>
    </div>
@endif 