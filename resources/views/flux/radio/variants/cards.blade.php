@php $iconVariant = $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@aware([ 'indicator' ])

@props([
    'iconVariant' => 'micro',
    'description' => null,
    'indicator' => true,
    'accent' => true,
    'label' => null,
    'icon' => null,
])

@php
$iconClasses = Flux::classes()
    ->add('inline-block mt-0.5 text-zinc-400 [ui-radio[data-checked]_&]:text-zinc-800 dark:[ui-radio[data-checked]_&]:text-white')
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-4' : '')
    ;

$classes = Flux::classes()
    ->add('relative flex justify-between gap-3 flex-1 p-4')
    ->add('rounded-lg shadow-xs')
    ->add('bg-white')
    ->add('after:absolute after:-inset-px after:rounded-lg *:relative')
    ->add('border border-zinc-800/15')
    ->add([
        '[--haze:color-mix(in_oklab,_var(--color-accent-content),_transparent_97.5%)]',
        '[--haze-border:color-mix(in_oklab,_var(--color-accent-content),_transparent_80%)]',
        '[--haze-light:color-mix(in_oklab,_var(--color-accent),_transparent_98%)]',
    ])
    ->add(match ($accent) {
        true => [
            '[&:hover_[data-flux-radio-indicator]]:border-[var(--haze-border)]',
            'hover:border-[var(--haze-border)]',

            'data-checked:border-(--color-accent) hover:data-checked:border-(--color-accent)',
            'hover:after:bg-[var(--haze-light)] data-checked:after:bg-(--haze) hover:data-checked:after:bg-(--haze)',
        ],
        false => [
            'data-checked:bg-zinc-50 data-checked:border-zinc-800',
            'hover:bg-zinc-50',
        ],
    })
    ->add('[&[disabled]]:opacity-50 [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none')
    ;
@endphp

{{-- We have to put tabindex="-1" here because otherwise, Livewire requests will wipe out tabindex state, --}}
{{-- even with durable attributes for some reason... --}}
{{-- We have to put "data-flux-field" so that a single box can be disabled without "disabling" the group field label... --}}
<ui-radio {{ $attributes->class($classes) }} data-flux-control data-flux-radio-cards tabindex="-1" data-flux-field>
    <?php if ($label): ?>
        <div class="flex-1 flex gap-2">
            <?php if (is_string($icon) && $icon !== ''): ?>
                <flux:icon :icon="$icon" :variant="$iconVariant" :class="$iconClasses" />
            <?php elseif ($icon): ?>
                {{ $icon }}
            <?php endif; ?>

            <div class="flex-1">
                <flux:heading>{{ $label ?? $slot }}</flux:heading>

                <?php if ($description): ?>
                    <flux:subheading size="sm">{{ $description }}</flux:subheading>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($indicator): ?>
            <flux:radio.indicator />
        <?php endif; ?>
    <?php else: ?>
        {{ $slot }}
    <?php endif; ?>
</ui-radio>
