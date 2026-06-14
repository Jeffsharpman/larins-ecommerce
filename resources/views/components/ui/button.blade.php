@props([
    'tag' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'loading' => false,
    'disabled' => false,
    'href' => null,
    'icon' => null,
    'type' => 'button',
])

@php
    $classes = 'btn inline-flex items-center justify-center font-black uppercase leading-none transition-all duration-300 select-none';

    $classes .= match ($variant) {
        'primary' => ' btn-primary',
        'secondary' => ' btn-secondary',
        'outline' => ' btn-outline',
        'ghost' => ' btn-ghost',
        'soft' => ' btn-soft',
        'dark' => ' btn-dark',
        'danger' => ' btn-danger',
        default => ' btn-primary',
    };

    $classes .= match ($size) {
        'sm' => ' btn-sm',
        'md' => ' btn-md',
        'lg' => ' btn-lg',
        'xl' => ' btn-xl',
        default => ' btn-md',
    };

    if ($loading) {
        $classes .= ' is-loading';
    }

    $classes .= ' focus-visible:outline-2 focus-visible:outline-ring focus-visible:outline-offset-2';
@endphp

@if($href && !$disabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if($icon)
            <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
    </button>
@endif
