@props([
    'placeholder' => null,
    'suffix' => null,
    'max' => null,
])

@php
    $classes = Flux::classes()
        ->add('truncate flex gap-2 text-start flex-1 text-zinc-700')
        ->add('[[disabled]_&]:text-zinc-500');
@endphp

<ui-selected x-ignore wire:ignore {{ $attributes->class($classes) }}>
    <template name="placeholder">
        <span class="text-zinc-400 [[disabled]_&]:text-zinc-400/70" data-flux-select-placeholder>
            {{ $placeholder }}
        </span>
    </template>

    <template name="overflow" max="{{ $max ?? 1 }}" >
        <div><slot name="count"></slot> {{ $suffix ?? 'seleccionadas' }}</div>
    </template>
</ui-selected>
