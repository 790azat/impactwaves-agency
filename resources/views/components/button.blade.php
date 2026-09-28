@props(['href' => null, 'variant' => 'primary', 'icon' => 'arrow'])
@php
$classes = $variant === 'primary' ? 'group btn btn-primary' : 'group btn btn-ghost';
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <span>{{ $slot }}</span>
        @if ($icon)<x-icon :name="$icon" class="size-4 transition-transform group-hover:translate-x-0.5" />@endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        <span>{{ $slot }}</span>
        @if ($icon)<x-icon :name="$icon" class="size-4 transition-transform group-hover:translate-x-0.5" />@endif
    </button>
@endif
