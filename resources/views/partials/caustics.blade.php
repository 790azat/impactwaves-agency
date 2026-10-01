{{--
    Sunlight on water. $tint = true on light backgrounds (blue shimmer),
    otherwise white light for water panels. $fade is a CSS mask that fades it out.
--}}
<div class="pointer-events-none absolute inset-0 -z-10" style="mask-image: {{ $fade ?? 'linear-gradient(180deg, #000 0%, transparent 85%)' }}" aria-hidden="true">
    <div class="{{ ($tint ?? false) ? 'caustics-tint' : 'caustics' }}" style="opacity: {{ $opacity ?? 1 }}"></div>
</div>
