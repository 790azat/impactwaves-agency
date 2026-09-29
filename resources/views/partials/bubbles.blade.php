{{-- Rising bubbles. Optional: $count, $color (Tailwind classes for each bubble). --}}
@php
    $count = $count ?? 14;
    $color = $color ?? 'border-ocean-300/60 bg-white/40';
@endphp
<div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
    @for ($i = 0; $i < $count; $i++)
        @php
            $size = 6 + ($i * 7) % 18;
            $left = ($i * 37 + 11) % 100;
            $delay = -1 * (($i * 1.7) % 9);
            $duration = 7 + ($i * 3) % 7;
        @endphp
        <span class="animate-bubble absolute -bottom-6 rounded-full border {{ $color }}"
              style="left: {{ $left }}%; width: {{ $size }}px; height: {{ $size }}px; animation-delay: {{ $delay }}s; animation-duration: {{ $duration }}s"></span>
    @endfor
</div>
