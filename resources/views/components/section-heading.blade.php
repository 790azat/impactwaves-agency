@props(['eyebrow' => null, 'title', 'align' => 'left'])
<div {{ $attributes->class(['max-w-3xl', 'mx-auto text-center' => $align === 'center']) }}>
    @if ($eyebrow)
        <p class="eyebrow" data-reveal>{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-ocean-950 text-balance sm:text-5xl" data-reveal>{!! $title !!}</h2>
    @if ($slot->isNotEmpty())
        <p class="mt-5 text-lg leading-relaxed text-slate-600 text-pretty" data-reveal>{{ $slot }}</p>
    @endif
</div>
