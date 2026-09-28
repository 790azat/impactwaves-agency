{{-- Expects: $eyebrow, $title, $lead --}}
<section class="relative isolate overflow-hidden pt-40 pb-20 sm:pt-48">
    <div class="grid-fade absolute inset-0 -z-10"></div>
    <div class="absolute -top-48 left-1/2 -z-10 h-[560px] w-[900px] -translate-x-1/2 rounded-full bg-[radial-gradient(closest-side,rgb(99_102_241/.3),transparent)] blur-2xl"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <p class="eyebrow" data-reveal>{{ $eyebrow }}</p>
        <h1 class="mt-6 max-w-4xl font-display text-5xl leading-[1.05] font-semibold tracking-tight text-slate-900 text-balance sm:text-6xl lg:text-7xl" data-reveal style="--reveal-delay:80ms">{!! $title !!}</h1>
        <p class="mt-7 max-w-2xl text-lg leading-relaxed text-slate-600 text-pretty sm:text-xl" data-reveal style="--reveal-delay:160ms">{{ $lead }}</p>
        {{ $slot ?? '' }}
    </div>
</section>
