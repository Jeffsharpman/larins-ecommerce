@props(['href', 'active' => false])

@php
$isActive = $active || request()->is(trim($href, '/')) || (request()->is('/') && $href === '/');
$classes = $isActive 
    ? 'text-blue-600 dark:text-blue-500' 
    : 'text-gray-500 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500';
@endphp

<a wire:navigate href="{{ $href }}" {{ $attributes->merge(['class' => "font-medium flex items-center py-3 md:py-6 transition-colors " . $classes]) }}>
    
    @if(isset($icon))
        <span class="mr-2">{{ $icon }}</span>
    @endif

    <span>{{ $slot }}</span>

    @if(isset($badge))
        <span class="ms-2 py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-600 border border-blue-200">
            {{ $badge }}
        </span>
    @endif
</a>