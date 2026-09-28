<x-layouts.app title="Expertise" description="How Impact Waves Agency works: a data-driven approach built on communication, transparency and strategy.">
    @include('partials.page-hero', [
        'eyebrow' => 'Expertise',
        'title' => 'A performance team that treats your budget <span class="text-gradient">like its own</span>',
        'lead' => 'Impact Waves is a performance marketing agency. We identify the best tools and resources for optimizing your revenue opportunities and provide complete solutions for your most critical growth requirements.',
    ])

    <section class="py-16">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 md:grid-cols-3">
            @foreach ([
                ['Acquire', 'Paid social and PPC campaigns that find the right people at the right cost.', 'megaphone'],
                ['Convert', 'CRO and landing pages that turn more of that traffic into customers.', 'chart'],
                ['Monetize', 'Tier-1 feed partnerships that turn traffic itself into revenue.', 'layers'],
            ] as [$title, $text, $icon])
                <div class="glass rounded-3xl p-8" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <x-icon :name="$icon" class="size-8 text-cyan-600" />
                    <h2 class="mt-6 font-display text-3xl font-semibold text-slate-900">{{ $title }}</h2>
                    <p class="mt-3 leading-relaxed text-slate-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Principles" title="What working with us feels like" />
            <div class="mt-14 grid gap-x-10 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('agency.values') as $value)
                    <div data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
                        <span class="grid size-12 place-items-center rounded-2xl border border-slate-200 bg-slate-50"><x-icon :name="$value['icon']" class="size-6 text-fuchsia-600" /></span>
                        <h3 class="mt-5 font-display text-xl font-semibold text-slate-900">{{ $value['title'] }}</h3>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-10 rounded-[2rem] border border-slate-200 bg-slate-50 p-8 sm:p-12 lg:grid-cols-2" data-reveal>
                <div>
                    <p class="eyebrow">Channels</p>
                    <h2 class="mt-5 font-display text-3xl font-semibold text-slate-900 sm:text-4xl">Where we run campaigns</h2>
                    <p class="mt-4 leading-relaxed text-slate-600">We go where your audience is, with hands-on experience in the US, EU and Canadian markets.</p>
                </div>
                <div class="flex flex-wrap content-center gap-3">
                    @foreach (array_merge(config('agency.platforms'), config('agency.feed_partners')) as $platform)
                        <span class="glass rounded-full px-5 py-2.5 font-display text-slate-900">{{ $platform }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @include('partials.cta')
</x-layouts.app>
