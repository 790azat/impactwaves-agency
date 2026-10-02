<x-layouts.app>
    @push('schema')
        {!! \App\Support\Seo::jsonLd([
            "\x40type" => 'WebSite',
            "\x40id" => config('agency.site_url').'/#website',
            'name' => config('agency.legal_name'),
            'url' => config('agency.site_url').'/',
            'publisher' => ["\x40id" => config('agency.site_url').'/#organization'],
            'inLanguage' => 'en',
        ]) !!}
    @endpush
    {{-- HERO: deep navy with one large silk wave as the light source. --}}
    <section class="bg-sea relative isolate overflow-hidden pt-36 pb-24 text-white sm:pt-44 lg:pb-36">
        <div class="silk silk-hero silk-drift inset-y-0 right-[-30%] left-[10%] opacity-95 [mask-image:linear-gradient(90deg,transparent,#000_30%)] lg:left-[30%] lg:right-[-12%]"></div>
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(60%_60%_at_80%_55%,rgb(0_123_255/.18),transparent_70%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6">
            <div class="max-w-2xl">
                <p class="eyebrow eyebrow-dark" data-reveal>Performance marketing agency</p>
                <h1 class="mt-7 font-display text-5xl leading-[1.02] font-semibold tracking-tight text-balance sm:text-6xl lg:text-7xl xl:text-[4.8rem]" data-reveal style="--reveal-delay:80ms">
                    Make waves.<br><span class="text-ocean-500">Measure impact.</span>
                </h1>
                <p class="mt-7 max-w-xl text-lg leading-relaxed text-slate-300 text-pretty sm:text-xl" data-reveal style="--reveal-delay:160ms">
                    We help brands, media buyers and traffic partners acquire, optimize and scale traffic across TikTok, Meta and search with a data-driven approach.
                </p>
                <div class="mt-10 flex flex-wrap items-center gap-4" data-reveal style="--reveal-delay:240ms">
                    <a href="{{ route('contact') }}" wire:navigate class="btn btn-primary">Start a project <x-icon name="arrow" class="size-4" /></a>
                    <a href="{{ route('services.index') }}" wire:navigate class="btn btn-outline-light">Our services</a>
                </div>
            </div>

            <ul class="absolute top-2 right-6 hidden border-l border-white/25 pl-5 text-[11px] leading-6 font-medium tracking-[.22em] text-slate-300 uppercase lg:block" aria-hidden="true">
                <li>Paid media</li><li>Creative</li><li>Optimization</li><li>Scaling</li>
            </ul>
            <ul class="absolute right-6 bottom-[-4rem] hidden border-l border-white/25 pl-5 text-[11px] leading-6 font-medium tracking-[.22em] text-slate-300 uppercase lg:block" aria-hidden="true">
                <li>More traffic</li><li>More opportunities</li><li>More impact</li>
            </ul>
        </div>
    </section>

    {{-- PLATFORMS --}}
    <section id="partners" class="relative border-t border-white/10 bg-black py-7 text-white">
        <div class="mx-auto flex max-w-7xl items-center gap-10 px-4 sm:px-6">
            <p class="hidden shrink-0 text-[11px] font-semibold tracking-[.2em] text-slate-400 uppercase md:block">Platforms we work with</p>
            <div class="relative min-w-0 flex-1 overflow-hidden [mask-image:linear-gradient(90deg,transparent,#000_8%,#000_92%,transparent)]">
                <div class="animate-marquee flex w-max gap-14 pr-14">
                    @foreach (array_merge(config('agency.partners'), config('agency.partners')) as $partner)
                        <span class="font-display text-lg font-semibold whitespace-nowrap text-white/85">{{ $partner }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    <section class="relative py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-8 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <p class="eyebrow" data-reveal>Services</p>
                    <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-ocean-950 text-balance sm:text-5xl" data-reveal>End-to-end performance marketing.</h2>
                </div>
                <div class="lg:col-span-5" data-reveal>
                    <p class="text-lg leading-relaxed text-slate-600">From strategy and creative to acquisition and optimization, we help you turn paid traffic into measurable growth.</p>
                    <a href="{{ route('services.index') }}" wire:navigate class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-ocean-600 hover:text-ocean-950">View all services <x-icon name="arrow" class="size-4" /></a>
                </div>
            </div>

            <div class="mt-16 grid border-t border-slate-200 sm:grid-cols-2 lg:grid-cols-5">
                @foreach (config('agency.services') as $slug => $service)
                    <a href="{{ route('services.show', $slug) }}" wire:navigate data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms"
                       class="group flex flex-col border-b border-slate-200 py-8 sm:px-6 sm:[&:nth-child(odd)]:pl-0 lg:border-b-0 lg:border-l lg:px-6 lg:first:border-l-0 lg:first:pl-0 lg:[&:nth-child(odd)]:pl-6 lg:first:!pl-0">
                        <span class="text-xs font-medium text-slate-400 tabular-nums">0{{ $loop->iteration }}</span>
                        <h3 class="mt-3 font-display text-xl font-semibold text-ocean-950">{{ $service['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ implode(' · ', array_slice($service['platforms'], 0, 3)) }}</p>
                        <span class="mt-auto pt-8"><span class="grid size-9 place-items-center rounded-full border border-slate-300 text-ocean-950 transition group-hover:border-ocean-600 group-hover:bg-ocean-600 group-hover:text-white"><x-icon name="arrow" class="size-4" /></span></span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- APPROACH: the wave runs off the left edge, no frame around it. --}}
    <section class="relative isolate overflow-hidden bg-ocean-50/60">
        <div class="grid lg:grid-cols-2">
            <div class="relative isolate min-h-72 overflow-hidden bg-navy lg:min-h-[26rem]">
                <div class="silk silk-tile silk-drift inset-0"></div>
            </div>
            <div class="px-4 py-16 sm:px-12 lg:py-24 lg:pl-16" data-reveal>
                <p class="eyebrow">Our approach</p>
                <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-ocean-950 text-balance sm:text-5xl">We don't just buy traffic. <span class="text-ocean-600">We understand it.</span></h2>
                <p class="mt-5 max-w-md text-lg leading-relaxed text-slate-600">Data-driven strategy, creative testing and continuous optimization to scale what works.</p>
                <a href="{{ route('about') }}" wire:navigate class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-ocean-600 hover:text-ocean-950">Learn more <x-icon name="arrow" class="size-4" /></a>
            </div>
        </div>
    </section>

    {{-- RESULTS --}}
    <section class="relative py-20 sm:py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-4" data-reveal>
                <p class="eyebrow">Real results</p>
                <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-ocean-950 text-balance">Performance drives everything.</h2>
            </div>
            <dl class="grid grid-cols-3 lg:col-span-8">
                @foreach ([['3.4x', 'Average ROAS'], ['−31%', 'Lower CPA'], ['+64%', 'Higher CTR']] as [$value, $label])
                    <div class="border-l border-slate-200 px-4 sm:px-8" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <dd class="font-display text-4xl font-semibold text-ocean-950 tabular-nums sm:text-6xl">{{ $value }}</dd>
                        <dt class="mt-2 text-sm text-slate-500">{{ $label }}</dt>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- GUIDES --}}
    <section class="relative bg-ocean-50/60 py-24 sm:py-28">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12">
            <div class="lg:col-span-4" data-reveal>
                <p class="eyebrow">Media buying guides</p>
                <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-ocean-950 text-balance">Practical knowledge for real media buyers.</h2>
                <p class="mt-5 leading-relaxed text-slate-600">In-depth guides, strategies and insights from people working with paid traffic every day.</p>
                <a href="{{ route('section', 'guides') }}" wire:navigate class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-ocean-600 hover:text-ocean-950">Explore guides <x-icon name="arrow" class="size-4" /></a>
            </div>
            <div class="grid gap-5 sm:grid-cols-3 lg:col-span-8">
                @foreach (\App\Support\Articles::inSection('guides')->take(3) as $article)
                    <a href="{{ route('article', ['guides', $article['slug']]) }}" wire:navigate class="group flex flex-col overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-ocean-950/10" data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms">
                        @include('partials.article-cover', ['article' => $article, 'class' => 'aspect-[16/10]'])
                        <span class="flex flex-1 flex-col p-5">
                            <span class="text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($article['date'])->format('M j, Y') }}</span>
                            <span class="mt-2 font-display font-semibold leading-snug text-ocean-950 text-balance">{{ $article['title'] }}</span>
                        </span>
                    </a>
                @endforeach
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

    {{-- TRAFFIC PROVIDERS: a soft wave behind the copy, edge to edge. --}}
    <section class="relative isolate overflow-hidden py-24 sm:py-28">
        <div class="silk silk-band inset-x-0 top-0 bottom-0 opacity-90 [background-position:center_40%]"></div>
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:flex-row lg:items-end lg:justify-between">
            <div data-reveal>
                <p class="eyebrow">For traffic providers</p>
                <h2 class="mt-4 max-w-2xl font-display text-4xl font-semibold tracking-tight text-ocean-950 text-balance sm:text-5xl">Have traffic? Let's build something together.</h2>
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-600">We work with traffic providers, publishers and partners looking for performance-driven opportunities and long-term relationships.</p>
            </div>
            <a href="{{ route('section', 'traffic-providers') }}" wire:navigate class="inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-ocean-600 hover:text-ocean-950" data-reveal>Become a partner <x-icon name="arrow" class="size-4" /></a>
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
