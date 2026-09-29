<x-layouts.app :title="$service['title']" :description="$service['short']">
    @include('partials.page-hero', [
        'eyebrow' => $service['eyebrow'],
        'title' => e($service['headline']),
        'lead' => $service['intro'],
    ])

    <section class="-mt-6 pb-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-wrap items-center gap-3" data-reveal>
                @foreach ($service['platforms'] as $platform)
                    <span class="glass rounded-full px-4 py-2 text-sm text-ocean-950">{{ $platform }}</span>
                @endforeach
            </div>
            <div class="mt-10 flex flex-wrap gap-4" data-reveal>
                <x-button href="{{ route('contact') }}?service={{ $slug }}" icon="chat" wire:navigate>Talk to us about {{ $service['title'] }}</x-button>
                <x-button href="{{ route('home') }}#calculator" variant="ghost" icon="chart">Estimate your ROI</x-button>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="What's included" title="Built for results, <span class='text-gradient'>not reports</span>" />
            <div class="mt-14 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($service['features'] as $feature)
                    <div class="card-glow glass rounded-3xl p-8" data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms">
                        <span class="grid size-10 place-items-center rounded-xl bg-brand text-white"><x-icon name="check" class="size-5" /></span>
                        <h3 class="mt-6 font-display text-xl font-semibold text-ocean-950">{{ $feature['title'] }}</h3>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $feature['text'] }}</p>
                    </div>
                @endforeach
                <div class="flex flex-col justify-between rounded-3xl border border-dashed border-ocean-100 p-8" data-reveal>
                    <p class="font-display text-xl font-semibold text-ocean-950">Need something custom?</p>
                    <p class="mt-2 leading-relaxed text-slate-600">Tell us about your goals and we will shape the scope around them.</p>
                    <a href="{{ route('contact') }}?service={{ $slug }}" wire:navigate class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-ocean-950">Get in touch <x-icon name="arrow" class="size-4" /></a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="How we work" title="Our process" />
            <ol class="mt-12 grid gap-6 md:grid-cols-4">
                @foreach (config('agency.process') as $step)
                    <li class="border-t border-ocean-100 pt-6" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <span class="font-display text-sm text-gradient font-semibold">0{{ $loop->iteration }}</span>
                        <h3 class="mt-2 font-display text-lg font-semibold text-ocean-950">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <h2 class="font-display text-2xl font-semibold text-ocean-950" data-reveal>Other services</h2>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($others as $otherSlug => $other)
                    <a href="{{ route('services.show', $otherSlug) }}" wire:navigate class="card-glow group glass rounded-2xl p-6 transition hover:-translate-y-0.5" data-reveal>
                        <x-icon :name="$other['icon']" class="size-6 text-cyan-600" />
                        <p class="mt-4 font-semibold text-ocean-950">{{ $other['title'] }}</p>
                        <span class="mt-3 inline-flex items-center gap-1 text-sm text-slate-600 group-hover:text-ocean-950">Learn more <x-icon name="arrow" class="size-3.5" /></span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta')
</x-layouts.app>
