@props([
    'paginator' => null,
    'showSummary' => true,
])

@php
$simple = ! $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
@endphp

@if ($simple)
    <div {{ $attributes->class('pt-3 border-t border-forest-100 flex justify-between items-center') }} data-flux-pagination>
        <div></div>

        @if ($paginator->hasPages())
            <div class="flex items-center bg-white border border-forest-200 rounded-[8px] p-[1px]">
                @if ($paginator->onFirstPage())
                    <div class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-forest-300">
                        <flux:icon.chevron-left variant="micro" />
                    </div>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-forest-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-left variant="micro" />
                        </button>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-left variant="micro" />
                        </button>
                    @endif
                @endif

                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-right variant="micro" />
                        </button>
                    @else
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-right variant="micro" />
                        </button>
                    @endif
                @else
                    <div class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-right variant="micro" />
                    </div>
                @endif
            </div>
        @endif
    </div>
@else
    <div {{ $attributes->class('mt-3 pt-3 border-t border-forest-100 flex justify-between items-center gap-3') }} data-flux-pagination>
        @if ($showSummary)
            @if ($paginator->total() > 0)
            <div class="text-forest-800 text-xs font-medium whitespace-nowrap">
                    Mostrando {{ $paginator->firstItem() }} de {{ $paginator->lastItem() }} de un total de {{ $paginator->total() }} resultados
                </div>
            @else
                <div></div>
            @endif
        @else
            <div></div>
        @endif

        @if ($paginator->hasPages())
            {{-- Mobile pagination --}}
            <div class="flex sm:hidden items-center bg-white border border-zinc-200 rounded-[8px] p-[1px]">
                @if ($paginator->onFirstPage())
                    <div aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-8 rounded-[6px] text-zinc-300">
                        <flux:icon.chevron-left variant="micro" />
                    </div>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-8 rounded-[6px] text-zinc-400 hover:bg-zinc-100 hover:text-zinc-800">
                        <flux:icon.chevron-left variant="micro" />
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-8 rounded-[6px] text-zinc-400 hover:bg-zinc-100 hover:text-zinc-800">
                        <flux:icon.chevron-right variant="micro" />
                    </button>
                @else
                    <div aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-8 rounded-[6px] text-zinc-300">
                        <flux:icon.chevron-right variant="micro" />
                    </div>
                @endif
            </div>

            {{-- Desktop pagination --}}
            <div class="hidden sm:flex items-center bg-forest-600 border border-forest-700 rounded-[8px] p-[1px]">
                @if ($paginator->onFirstPage())
                    <div aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-6 rounded-[6px] text-forest-100">
                        <flux:icon.chevron-left variant="micro" />
                    </div>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-6 rounded-[6px] text-forest-100 hover:bg-zinc-100 hover:text-zinc-800">
                        <flux:icon.chevron-left variant="micro" />
                    </button>
                @endif

                @foreach (\Livewire\invade($paginator)->elements() as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <div
                            aria-disabled="true"
                            class="cursor-default flex justify-center items-center text-xs size-6 rounded-[6px] font-medium text-forest-700"
                        >{{ $element }}</div>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <div
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                    aria-current="page"
                                    class="cursor-default flex justify-center items-center text-xs h-6 px-2 rounded-[6px] font-medium text-forest-50"
                                >{{ $page }}</div>
                            @else
                                <button
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    type="button"
                                    class="text-xs h-6 px-2 rounded-[6px] text-forest-200 font-medium hover:bg-zinc-100 hover:text-zinc-800"
                                >{{ $page }}</button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-6 rounded-[6px] text-forest-200 hover:bg-zinc-100 hover:text-zinc-800">
                        <flux:icon.chevron-right variant="micro" />
                    </button>
                @else
                    <div aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300">
                        <flux:icon.chevron-right variant="micro" />
                    </div>
                @endif
            </div>
        @endif
    </div>
@endif
