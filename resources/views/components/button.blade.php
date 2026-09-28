@props(['href' => null, 'variant' => 'primary', 'icon' => 'arrow'])
@php
$classes = $variant === 'primary' ? 'group btn btn-primary' : 'group btn btn-ghost';
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-4 shrink-0 transition-transform duration-300 group-hover:scale-110" />@endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if ($icon)<x-icon :name="$icon" class="size-4 shrink-0 transition-transform duration-300 group-hover:scale-110" />@endif
        <span>{{ $slot }}</span>
    </button>
@endif
