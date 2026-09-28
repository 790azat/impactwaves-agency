{{-- Animated layered waves, used as a decorative background. --}}
<div class="pointer-events-none absolute inset-x-0 bottom-0 h-56 overflow-hidden opacity-70" aria-hidden="true">
    @foreach ([['#22d3ee', 18, '.35', 0], ['#6366f1', 26, '.45', 18], ['#e879f9', 34, '.3', 36]] as [$color, $dur, $opacity, $offset])
        <svg class="absolute bottom-0 left-0 h-full w-[200%]" style="animation: marquee {{ $dur }}s linear infinite; opacity: {{ $opacity }}" viewBox="0 0 2880 220" preserveAspectRatio="none">
            <path fill="none" stroke="{{ $color }}" stroke-width="1.6"
                  d="M0 {{ 120 + $offset / 3 }} C 240 {{ 40 + $offset }}, 480 {{ 200 - $offset }}, 720 {{ 120 + $offset / 3 }} S 1200 {{ 40 + $offset }}, 1440 {{ 120 + $offset / 3 }} S 1920 {{ 200 - $offset }}, 2160 {{ 120 + $offset / 3 }} S 2640 {{ 40 + $offset }}, 2880 {{ 120 + $offset / 3 }}" />
        </svg>
    @endforeach
</div>
