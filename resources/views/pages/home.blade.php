<x-layouts.app>
    {{-- HERO --}}
    <section class="bg-sea relative isolate overflow-hidden pt-36 pb-36 sm:pt-44 lg:pb-48">
        <div class="grid-fade absolute inset-0 -z-10"></div>
        <div class="absolute -top-40 left-1/2 -z-10 h-[680px] w-[1100px] -translate-x-1/2 rounded-full bg-[radial-gradient(closest-side,rgb(8_150_181/.18),transparent)] blur-2xl"></div>
        <div class="absolute inset-x-0 bottom-0">
            @include('partials.sea-waves', ['id' => 'hero-wave', 'fill' => '#ecfafd', 'class' => 'h-28 sm:h-40'])
        </div>

        <div class="mx-auto grid max-w-7xl items-center gap-16 px-4 sm:px-6 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <p class="eyebrow" data-reveal>
                    <span class="size-1.5 rounded-full bg-ocean-500"></span>
                    Official TikTok agency · US · EU · CA
                </p>
                <h1 class="mt-7 font-display text-5xl leading-[1.02] font-semibold tracking-tight text-ocean-950 text-balance sm:text-6xl lg:text-7xl xl:text-[5.4rem]" data-reveal style="--reveal-delay:80ms">
                    Make waves.<br><span class="text-gradient">Measure impact.</span>
                </h1>
                <p class="mt-7 max-w-xl text-lg leading-relaxed text-slate-600 text-pretty sm:text-xl" data-reveal style="--reveal-delay:160ms">
                    Swift and effective growth for your company. We run paid social, PPC and conversion optimization with a data-driven approach built on communication, transparency and strategy.
                </p>
                <div class="mt-10 flex flex-wrap items-center gap-4" data-reveal style="--reveal-delay:240ms">
                    <x-button href="{{ route('contact') }}" icon="sparkles" wire:navigate>Get a free growth audit</x-button>
                    <x-button href="#calculator" variant="ghost" icon="chart">Estimate your ROI</x-button>
                </div>
                <dl class="mt-14 grid max-w-xl grid-cols-3 gap-4 border-t border-ocean-100 pt-8" data-reveal style="--reveal-delay:320ms">
                    <div><dt class="text-xs tracking-wider text-slate-500 uppercase">Markets</dt><dd class="mt-1 font-display text-lg font-semibold text-ocean-950 sm:text-2xl">US · EU · CA</dd></div>
                    <div><dt class="text-xs tracking-wider text-slate-500 uppercase">Feed partners</dt><dd class="mt-1 font-display text-lg font-semibold text-ocean-950 sm:text-2xl">Tier-1</dd></div>
                    <div><dt class="text-xs tracking-wider text-slate-500 uppercase">Services</dt><dd class="mt-1 font-display text-lg font-semibold text-ocean-950 sm:text-2xl">{{ count(config('agency.services')) }} in one team</dd></div>
                </dl>
            </div>

            {{-- Impact visual --}}
            <div class="relative mx-auto aspect-square w-full max-w-[520px] lg:col-span-5" data-reveal style="--reveal-delay:200ms" aria-hidden="true">
                <div class="absolute inset-0 grid place-items-center">
                    @foreach ([0, 3] as $i)
                        <span class="animate-ripple absolute size-[70%] rounded-full border border-ocean-300/40" style="animation-duration: 6s; animation-delay: {{ $i }}s"></span>
                    @endforeach
                    <div class="absolute size-[92%] rounded-full border border-ocean-100"></div>
                    <div class="glass relative grid size-40 place-items-center rounded-[2.2rem] shadow-[0_24px_60px_-24px_rgb(8_120_152/.45)] sm:size-48">
                        <x-logo-mark id="hero" class="size-24 sm:size-28" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PARTNERS MARQUEE --}}
    <section id="partners" class="relative border-b border-ocean-100 bg-ocean-50 pt-4 pb-10">
        <p class="text-center text-xs font-medium tracking-[.2em] text-slate-500 uppercase">Platforms and Tier-1 partners we work with</p>
        <div class="relative mt-7 overflow-hidden [mask-image:linear-gradient(90deg,transparent,#000_12%,#000_88%,transparent)]">
            <div class="animate-marquee flex w-max gap-14 pr-14">
                @foreach (array_merge(config('agency.partners'), config('agency.partners')) as $partner)
                    <span class="font-display text-2xl font-semibold whitespace-nowrap text-slate-500 transition hover:text-ocean-950">{{ $partner }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    <section class="relative py-28 sm:py-36">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
                <x-section-heading eyebrow="What we do" title="Complete solutions for your most <span class='text-gradient'>critical growth</span> requirements">
                    We find the best tools and resources to optimize your revenue opportunities, then execute across every channel that matters.
                </x-section-heading>
                <x-button href="{{ route('services.index') }}" variant="ghost" icon="layers" wire:navigate data-reveal>All services</x-button>
            </div>

            <div class="mt-16 grid gap-5 md:grid-cols-2 lg:grid-cols-6">
                @foreach (config('agency.services') as $slug => $service)
                    <a href="{{ route('services.show', $slug) }}" wire:navigate data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms"
                       @class([
                           'card-glow group glass relative flex flex-col overflow-hidden rounded-3xl p-8 transition duration-500 hover:-translate-y-1',
                           'lg:col-span-3 lg:min-h-80' => $loop->index < 2,
                           'lg:col-span-2' => $loop->index >= 2,
                       ])>
                        <div class="flex items-start justify-between">
                            <span class="grid size-12 place-items-center rounded-2xl bg-gradient-to-br from-cyan-400/20 to-teal-500/20 text-ocean-600 ring-1 ring-ocean-100">
                                <x-icon :name="$service['icon']" class="size-6" />
                            </span>
                            <x-icon name="arrow-up-right" class="size-5 text-slate-500 transition duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-ocean-950" />
                        </div>
                        <p class="mt-8 text-xs font-medium tracking-[.14em] text-cyan-700 uppercase">{{ $service['eyebrow'] }}</p>
                        <h3 class="mt-2 font-display text-2xl font-semibold text-ocean-950">{{ $service['title'] }}</h3>
                        <p class="mt-3 leading-relaxed text-slate-600">{{ $service['short'] }}</p>
                        <div class="mt-auto flex flex-wrap gap-2 pt-7">
                            @foreach (array_slice($service['platforms'], 0, 4) as $platform)
                                <span class="rounded-full border border-ocean-100 px-3 py-1 text-xs text-slate-700">{{ $platform }}</span>
                            @endforeach
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TIKTOK SPOTLIGHT --}}
    <section class="relative py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="relative isolate overflow-hidden rounded-[2.5rem] border border-ocean-100 bg-ocean-50 px-6 py-16 sm:px-14 lg:py-20" data-reveal>
                <div class="absolute -top-32 -right-24 -z-10 size-[460px] rounded-full bg-teal-500/25 blur-[110px]"></div>
                <div class="absolute -bottom-40 -left-24 -z-10 size-[420px] rounded-full bg-cyan-400/20 blur-[110px]"></div>
                <div class="grid items-center gap-14 lg:grid-cols-2">
                    <div>
                        <p class="eyebrow">Official TikTok agency</p>
                        <h2 class="mt-5 font-display text-4xl font-semibold tracking-tight text-ocean-950 sm:text-5xl">Attract audiences and drive revenue on <span class="text-gradient">TikTok</span></h2>
                        <p class="mt-5 text-lg leading-relaxed text-slate-600">Agency ad accounts, a dedicated official TikTok support team and creative resources that keep your ads ahead of the feed.</p>
                        <div class="mt-9 flex flex-wrap gap-4">
                            <x-button href="{{ route('services.show', 'tiktok-agency') }}" icon="bolt" wire:navigate>Explore TikTok Agency</x-button>
                            <x-button href="{{ route('contact') }}?service=tiktok-agency" variant="ghost" icon="plus" wire:navigate>Request an account</x-button>
                        </div>
                    </div>
                    <ul class="grid gap-4 sm:grid-cols-2">
                        @foreach ([
                            ['globe', 'Target markets', 'Reach audiences in the US, EU and Canada.'],
                            ['sparkles', 'Tailored strategies', 'Boost your online presence with strategies built for you.'],
                            ['lifebuoy', 'Comprehensive support', 'Tutorials, technical help and personalized assessments.'],
                            ['bolt', 'Creative resources', 'Learning center, ad library and hands-on tutorials.'],
                        ] as [$icon, $title, $text])
                            <li class="glass rounded-2xl p-6">
                                <x-icon :name="$icon" class="size-6 text-teal-600" />
                                <h3 class="mt-4 font-semibold text-ocean-950">{{ $title }}</h3>
                                <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $text }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ROI CALCULATOR --}}
    <section id="calculator" class="relative scroll-mt-24 py-28 sm:py-36">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="ROI calculator" title="See what better conversion is <span class='text-gradient'>worth to you</span>" align="center">
                Move the sliders to model your paid traffic. Then see how a lift in conversion rate from CRO changes the math.
            </x-section-heading>
            <div class="mt-14" data-reveal>
                <livewire:roi-calculator />
            </div>
        </div>
    </section>

    {{-- PROCESS --}}
    <section class="relative py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="How we work" title="From audit to scale in four clear steps" />
            <ol class="relative mt-16 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="absolute top-7 right-8 left-8 hidden h-px bg-gradient-to-r from-cyan-400/60 via-ocean-500/60 to-teal-500/60 lg:block"></div>
                @foreach (config('agency.process') as $step)
                    <li class="relative" data-reveal style="--reveal-delay: {{ $loop->index * 90 }}ms">
                        <span class="relative grid size-14 place-items-center rounded-2xl border border-ocean-100 bg-white font-display text-lg font-semibold text-ocean-950 shadow-lg shadow-ocean-500/10">
                            0{{ $loop->iteration }}
                        </span>
                        <h3 class="mt-6 font-display text-xl font-semibold text-ocean-950">{{ $step['title'] }}</h3>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- WHY US --}}
    <section class="relative py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Why Impact Waves" title="Communication, transparency and strategy. <span class='text-slate-500'>Every day.</span>" />
            <div class="mt-16 grid gap-px overflow-hidden rounded-3xl border border-ocean-100 bg-ocean-100 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('agency.values') as $value)
                    <div class="group bg-white p-8 transition hover:bg-ocean-50" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
                        <x-icon :name="$value['icon']" class="size-7 text-cyan-600 transition group-hover:text-teal-600" />
                        <h3 class="mt-5 font-display text-xl font-semibold text-ocean-950">{{ $value['title'] }}</h3>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEED PARTNERS --}}
    <section class="relative py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid items-center gap-10 rounded-[2rem] border border-ocean-100 bg-gradient-to-br from-ocean-50/60 to-white p-8 sm:p-12 lg:grid-cols-5" data-reveal>
                <div class="lg:col-span-2">
                    <p class="eyebrow">Our partners</p>
                    <h2 class="mt-5 font-display text-3xl font-semibold tracking-tight text-ocean-950 sm:text-4xl">Tier-1 feed providers</h2>
                    <p class="mt-4 leading-relaxed text-slate-600">Monetize your traffic through established search feed partners, with our team helping you onboard and grow.</p>
                    <a href="{{ route('services.show', 'search-feeds') }}" wire:navigate class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-ocean-950">Search Feed Monetization <x-icon name="arrow" class="size-4" /></a>
                </div>
                <div class="grid grid-cols-2 gap-4 lg:col-span-3">
                    @foreach (config('agency.feed_partners') as $partner)
                        <div class="card-glow glass grid h-28 place-items-center rounded-2xl">
                            <span class="font-display text-2xl font-semibold text-ocean-950">{{ $partner }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Audiences and latest articles --}}
    <section class="relative py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Resources" title="Guides for <span class='text-gradient'>media buyers</span> and <span class='text-gradient'>traffic providers</span>">
                Practical playbooks from a team that buys and monetizes traffic every day.
            </x-section-heading>
            <div class="mt-12 grid gap-5 md:grid-cols-2">
                @foreach (['guides', 'traffic-providers'] as $key)
                    @php $s = config('agency.sections')[$key]; @endphp
                    <a href="{{ route('section', $key) }}" wire:navigate class="card-glow group relative overflow-hidden rounded-[2rem] border border-ocean-100 bg-ocean-50 p-8 transition duration-300 hover:-translate-y-1 sm:p-10" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <span class="grid size-12 place-items-center rounded-2xl bg-brand text-white"><x-icon :name="$s['icon']" class="size-6" /></span>
                        <p class="mt-6 text-sm font-medium tracking-[.12em] text-ocean-600 uppercase">{{ $s['audience'] }}</p>
                        <h3 class="mt-2 font-display text-3xl font-semibold text-ocean-950">{{ $s['title'] }}</h3>
                        <p class="mt-3 max-w-md leading-relaxed text-slate-600">{{ $s['lead'] }}</p>
                        <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-ocean-950"><x-icon name="arrow" class="size-4 transition group-hover:translate-x-0.5" /> Explore</span>
                    </a>
                @endforeach
            </div>
            <div class="mt-5 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach (\App\Support\Articles::latest(3) as $article)
                    <x-article-card :article="$article" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="relative py-28">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <x-section-heading eyebrow="FAQ" title="Questions, answered" />
            </div>
            <div class="lg:col-span-8" x-data="{ active: 0 }">
                @foreach (config('agency.faq') as $item)
                    <div class="border-b border-ocean-100" data-reveal>
                        <button type="button" class="flex w-full items-center justify-between gap-6 py-6 text-left"
                                @click="active = active === {{ $loop->index }} ? null : {{ $loop->index }}"
                                :aria-expanded="active === {{ $loop->index }}">
                            <span class="font-display text-lg font-medium text-ocean-950 sm:text-xl">{{ $item['q'] }}</span>
                            <span class="grid size-9 shrink-0 place-items-center rounded-full border border-ocean-100 text-ocean-950 transition duration-300"
                                  :class="active === {{ $loop->index }} && 'rotate-45 bg-ocean-50'">
                                <x-icon name="plus" class="size-4" />
                            </span>
                        </button>
                        <div x-show="active === {{ $loop->index }}" x-collapse @if (! $loop->first) x-cloak @endif>
                            <p class="max-w-2xl pb-6 leading-relaxed text-slate-600">{{ $item['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta')
</x-layouts.app>
