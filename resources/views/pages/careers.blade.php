<x-layouts.app title="Careers: Media Buying, Design and Tech Jobs" description="Join Impact Waves Agency: open positions for media buyers, designers, tracking specialists and developers in a performance marketing team.">
    @push('schema')
        {!! \App\Support\Seo::jsonLd([
            "\x40type" => 'CollectionPage',
            'name' => 'Careers at '.config('agency.legal_name'),
            'url' => \App\Support\Seo::url(route('careers')),
            'breadcrumb' => \App\Support\Seo::breadcrumbs([['Careers', route('careers')]]),
        ]) !!}
    @endpush
    @include('partials.page-hero', [
        'eyebrow' => 'Careers',
        'title' => 'Build campaigns that <span class="text-gradient">make waves</span>',
        'lead' => 'We are a performance marketing team of media buyers, designers, tech specialists and developers. If you like clear numbers, fast tests and owning your results, there is a place for you here.',
    ])

    <section class="py-20" id="positions">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Open positions" :title="$vacancies->isEmpty() ? 'No open roles right now' : $vacancies->count().' open '.str('role')->plural($vacancies->count())" />

            @if ($vacancies->isNotEmpty())
                <ul class="mt-12 divide-y divide-ocean-100 overflow-hidden rounded-2xl border border-ocean-100 bg-white">
                    @foreach ($vacancies as $vacancy)
                        <li data-reveal style="--reveal-delay: {{ $loop->index * 50 }}ms">
                            <a href="{{ route('careers.show', $vacancy->slug) }}" wire:navigate class="group flex flex-col gap-4 p-6 transition hover:bg-ocean-50 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-ocean-600">{{ $vacancy->departmentTitle() }}</p>
                                    <h3 class="mt-1 font-display text-xl font-semibold text-ocean-950 group-hover:text-ocean-700">{{ $vacancy->title }}</h3>
                                    @if ($vacancy->summary)<p class="mt-2 max-w-2xl text-slate-600">{{ $vacancy->summary }}</p>@endif
                                </div>
                                <div class="flex shrink-0 flex-wrap items-center gap-2 text-sm text-slate-600">
                                    @if ($vacancy->location)<span class="inline-flex items-center gap-1.5 rounded-md border border-ocean-100 px-2.5 py-1"><x-icon name="map-pin" class="size-4 text-ocean-500" /> {{ $vacancy->location }}</span>@endif
                                    <span class="inline-flex items-center gap-1.5 rounded-md border border-ocean-100 px-2.5 py-1"><x-icon name="clock" class="size-4 text-ocean-500" /> {{ $vacancy->employment_type }}</span>
                                    <x-icon name="arrow" class="ml-2 hidden size-5 text-ocean-600 transition group-hover:translate-x-1 sm:block" />
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-8 flex flex-col gap-4 rounded-2xl border border-ocean-100 bg-ocean-50 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8" data-reveal>
                <div>
                    <h3 class="font-display text-xl font-semibold text-ocean-950">{{ $vacancies->isEmpty() ? 'Send us an open application' : 'Did not find your role?' }}</h3>
                    <p class="mt-1 text-slate-600">Tell us what you do best and attach your CV or portfolio. We read every application.</p>
                </div>
                <a href="mailto:{{ config('agency.careers_email') }}?subject={{ rawurlencode('Open application') }}" class="btn btn-primary shrink-0"><x-icon name="mail" class="size-4" /> {{ config('agency.careers_email') }}</a>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Teams" title="Where you could work">
                Media buyers, creatives, tech and development work as one team on the same campaigns.
            </x-section-heading>
            <div class="mt-12">@include('partials.team')</div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Why Impact Waves" title="What you get with us" />
            <div class="mt-12 grid gap-x-10 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['chart', 'Real budgets', 'Work with serious spend on TikTok, Meta, Google and Tier-1 search feeds, not test money.'],
                    ['bolt', 'Fast decisions', 'Short chain from idea to launch. Tests go live the same day, not after three approvals.'],
                    ['layers', 'Team behind you', 'Designers, tech and developers in-house: creatives, tracking and landings on request.'],
                    ['rocket', 'Growth', 'Results are visible and rewarded. Clear path from junior to team lead.'],
                ] as [$icon, $title, $text])
                    <div data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
                        <h3 class="font-display text-xl font-semibold text-ocean-950">{{ $title }}</h3>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
