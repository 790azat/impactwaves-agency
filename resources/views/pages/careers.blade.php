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

    <section class="pt-20" id="team">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="Our team" title="A team built around performance">
                At the core are 15 media buyers, including 5 top performers, backed by dedicated departments that keep every campaign moving.
            </x-section-heading>
            <div class="mt-12">@include('partials.team')</div>
            <p class="mt-6 text-slate-600" data-reveal>We keep processes simple and reward results.</p>
        </div>
    </section>

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
                    <p class="mt-1 text-slate-600">Send us your CV on Telegram and tell us what you do best.</p>
                </div>
                <a href="{{ config('agency.careers_telegram') }}" target="_blank" rel="noopener" class="btn btn-primary shrink-0">Talk to HR <x-icon name="arrow-up-right" class="size-4" /></a>
            </div>
        </div>
    </section>

    <section class="pb-24" id="hiring">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <x-section-heading eyebrow="How we hire" title="Hiring process" />
            <ol class="mt-12 grid gap-px overflow-hidden rounded-2xl border border-ocean-100 bg-ocean-100 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ([
                    ['Apply', 'Send us your CV on Telegram.'],
                    ['HR interview', 'A conversation with HR to understand your goals and experience.'],
                    ['Experience check', 'We verify your experience, and a recommendation may be requested.'],
                    ['Team interview', 'Meet the team you will actually be working with.'],
                    ['Offer', 'A clear decision and a transparent profit-share structure.'],
                ] as [$step, $text])
                    <li class="bg-white p-7" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
                        <span class="font-display text-sm font-semibold text-ocean-600">{{ sprintf('%02d', $loop->iteration) }}</span>
                        <h3 class="mt-3 font-display text-lg font-semibold text-ocean-950">{{ $step }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
            <div class="mt-8" data-reveal>
                <a href="{{ config('agency.careers_telegram') }}" target="_blank" rel="noopener" class="btn btn-primary">Talk to HR <x-icon name="arrow-up-right" class="size-4" /></a>
            </div>
        </div>
    </section>
</x-layouts.app>
