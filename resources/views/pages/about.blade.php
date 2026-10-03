<x-layouts.app title="About Us: We Build, Test, and Scale What Works" description="Impact Waves is a performance-driven growth company focused on traffic acquisition, monetization, and scalable digital businesses. Test. Learn. Scale.">
    @push('schema')
        {!! \App\Support\Seo::jsonLd([
            "\x40type" => 'AboutPage',
            'url' => \App\Support\Seo::url(route('about')),
            'about' => ["\x40id" => config('agency.site_url').'/#organization'],
            'breadcrumb' => \App\Support\Seo::breadcrumbs([['About', route('about')]]),
        ]) !!}
    @endpush
    @include('partials.page-hero', [
        'eyebrow' => 'About us',
        'title' => 'We build, test, and <span class="text-gradient">scale what works.</span>',
        'lead' => 'Impact Waves is a performance-driven growth company focused on traffic acquisition, monetization, and scalable digital businesses.',
    ])

    <section class="py-16 sm:py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:items-center">
            <div class="space-y-5 text-lg leading-relaxed text-slate-600 lg:col-span-7" data-reveal>
                <p>We operate at the intersection of media buying, technology, data, and monetization - constantly testing new channels, strategies, and opportunities to find what delivers real results.</p>
                <p>Our approach is simple: <strong class="font-semibold text-ocean-950">test fast, learn from the data, and scale what works.</strong></p>
                <p>We work with partners, platforms, and traffic sources to create sustainable growth opportunities while treating every dollar of budget as if it were our own.</p>
            </div>
            <p class="font-display text-5xl leading-[1.05] font-semibold tracking-tight text-ocean-950 sm:text-6xl lg:col-span-5 lg:text-right" data-reveal>Test.<br>Learn.<br><span class="text-ocean-600">Scale.</span></p>
        </div>
    </section>

    <section class="py-24" id="team">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <x-section-heading eyebrow="Our team" title="Specialists for every part of the funnel">
                    Every campaign is run by an in-house team: media buyers work side by side with designers, tech specialists and developers, so creatives, tracking and landing pages never wait on an outside contractor.
                </x-section-heading>
                @if ($place = \App\Support\Company::place())
                    @php $location = \App\Support\Company::location(); @endphp
                    <div class="glass shrink-0 rounded-2xl p-6 lg:max-w-xs" data-reveal>
                        <p class="flex items-center gap-2 text-xs font-semibold tracking-[.12em] text-slate-500 uppercase"><x-icon name="map-pin" class="size-4 text-ocean-600" /> Headquarters</p>
                        <p class="mt-3 font-display text-2xl font-semibold text-ocean-950">{{ $place }}</p>
                        @if ($location['address'])<p class="mt-1 text-sm text-slate-600">{{ $location['address'] }}</p>@endif
                        @if ($location['note'])<p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $location['note'] }}</p>@endif
                    </div>
                @endif
            </div>
            <div class="mt-14">@include('partials.team')</div>
            <div class="mt-10 flex flex-col gap-4 rounded-2xl border border-ocean-100 bg-ocean-50 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8" data-reveal>
                <div>
                    <h3 class="font-display text-xl font-semibold text-ocean-950">Want to join us?</h3>
                    <p class="mt-1 text-slate-600">We are growing and looking for media buyers, designers and engineers.</p>
                </div>
                <a href="{{ route('careers') }}" wire:navigate class="btn btn-primary shrink-0"><x-icon name="briefcase" class="size-4" /> Open positions</a>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Principles" title="What working with us feels like" />
            <div class="mt-14 grid gap-x-10 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('agency.values') as $value)
                    <div data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
                        <span class="grid size-12 place-items-center rounded-xl border border-ocean-100 bg-ocean-50"><x-icon :name="$value['icon']" class="size-6 text-ocean-700" /></span>
                        <h3 class="mt-5 font-display text-xl font-semibold text-ocean-950">{{ $value['title'] }}</h3>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-10 rounded-2xl border border-ocean-100 bg-ocean-50 p-8 sm:p-12 lg:grid-cols-2" data-reveal>
                <div>
                    <p class="eyebrow">Channels</p>
                    <h2 class="mt-5 font-display text-3xl font-semibold text-ocean-950 sm:text-4xl">Where we run campaigns</h2>
                    <p class="mt-4 leading-relaxed text-slate-600">We go where your audience is, with hands-on experience in the US, EU and Canadian markets.</p>
                </div>
                <div class="flex flex-wrap content-center gap-3">
                    @foreach (array_merge(config('agency.platforms'), config('agency.feed_partners')) as $platform)
                        <span class="glass rounded-md px-5 py-2.5 font-display text-ocean-950">{{ $platform }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @include('partials.cta')
</x-layouts.app>
