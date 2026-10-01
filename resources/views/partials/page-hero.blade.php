{{-- Expects: $eyebrow, $title, $lead --}}
<section class="bg-sea relative isolate overflow-hidden border-b border-ocean-100 pt-40 pb-20 sm:pt-48 sm:pb-24">
    @include('partials.caustics', ['tint' => true, 'fade' => 'radial-gradient(ellipse 70% 80% at 80% 10%, #000 15%, transparent 70%)'])
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <p class="eyebrow" data-reveal>{{ $eyebrow }}</p>
        <h1 class="mt-6 max-w-4xl font-display text-5xl leading-[1.05] font-semibold tracking-tight text-ocean-950 text-balance sm:text-6xl lg:text-7xl" data-reveal style="--reveal-delay:80ms">{!! $title !!}</h1>
        <p class="mt-7 max-w-2xl text-lg leading-relaxed text-slate-600 text-pretty sm:text-xl" data-reveal style="--reveal-delay:160ms">{{ $lead }}</p>
        {{ $slot ?? '' }}
    </div>
    @include('partials.bubbles', ['count' => 7, 'light' => true, 'rise' => '480px'])
</section>
