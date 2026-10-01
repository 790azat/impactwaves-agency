{{--
    Rising air bubbles. Options: $count, $rise (how far they travel, CSS length),
    $light (true on light backgrounds: blue rims instead of white).
--}}
@php
    $count = $count ?? 12;
    $rise = $rise ?? '520px';
@endphp
<div @class(['pointer-events-none absolute inset-0 overflow-hidden', 'bubbles-light' => $light ?? false]) style="--rise: {{ $rise }}" aria-hidden="true">
    @for ($i = 0; $i < $count; $i++)
        @php
            // Deterministic spread: mostly small bubbles, a few larger ones.
            $size = [5, 8, 4, 11, 6, 9, 5, 14, 7, 4, 10, 6, 18, 5][$i % 14];
            $left = ($i * 37 + 11) % 100;
            $duration = 8 + ($i * 5) % 9 - $size * .2;
            $delay = -1 * (($i * 2.3) % $duration);
            $wobble = 1.6 + ($i % 4) * .5;
        @endphp
        <span class="bubble-rise" style="left: {{ $left }}%; --d: {{ $duration }}s; --delay: {{ $delay }}s">
            <span class="bubble" style="width: {{ $size }}px; height: {{ $size }}px; --w: {{ $wobble }}s"></span>
        </span>
    @endfor
</div>
