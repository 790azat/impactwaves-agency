<x-layouts.app :title="$section['meta_title']" :description="$section['meta_description']">
    @push('schema')
        <script type="application/ld+json">
            {!! json_encode([
                "\x40context" => 'https://schema.org',
                "\x40type" => 'CollectionPage',
                'name' => $section['title'],
                'description' => $section['meta_description'],
                'url' => route('section', $key),
                'hasPart' => $articles->map(fn ($a) => [
                    "\x40type" => $key === 'news' ? 'NewsArticle' : 'Article',
                    'headline' => $a['title'],
                    'url' => route('article', [$a['section'], $a['slug']]),
                    'datePublished' => $a['date']->toDateString(),
                ])->all(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    @include('partials.page-hero', [
        'eyebrow' => $section['audience'],
        'title' => $section['headline'],
        'lead' => $section['lead'],
    ])

    @if ($key === 'traffic-providers')
        <section class="pb-8">
            <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 md:grid-cols-3">
                @foreach ([
                    ['layers', 'Tier-1 feed access', 'Onboarding with established search feed partners such as '.implode(', ', config('agency.feed_partners')).'.'],
                    ['eye', 'Traffic quality first', 'We review your sources and setup before launch, so your account starts healthy and stays that way.'],
                    ['chart', 'Transparent reporting', 'Clear numbers on searches, clicks and revenue across feeds, so you always know where the margin is.'],
                ] as [$icon, $title, $text])
                    <div class="glass rounded-3xl p-7" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <x-icon :name="$icon" class="size-7 text-cyan-600" />
                        <h2 class="mt-5 font-display text-xl font-semibold text-ocean-950">{{ $title }}</h2>
                        <p class="mt-2 leading-relaxed text-slate-600">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mx-auto mt-8 flex max-w-7xl flex-wrap gap-3 px-4 sm:px-6" data-reveal>
                <x-button href="{{ route('contact') }}?service=search-feeds" icon="rocket" wire:navigate>Monetize my traffic</x-button>
                <x-button href="{{ route('services.show', 'search-feeds') }}" variant="ghost" icon="layers" wire:navigate>Search feed service</x-button>
            </div>
        </section>
    @endif

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <h2 class="font-display text-3xl font-semibold text-ocean-950" data-reveal>{{ $key === 'news' ? 'Latest news' : 'Articles' }}</h2>
                <nav class="flex flex-wrap gap-2" aria-label="Sections" data-reveal>
                    @foreach (config('agency.sections') as $k => $s)
                        <a href="{{ route('section', $k) }}" wire:navigate @class([
                            'inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium transition',
                            'border-ocean-200 bg-ocean-50 text-ocean-700' => $k === $key,
                            'border-ocean-100 text-slate-600 hover:border-ocean-200 hover:text-ocean-950' => $k !== $key,
                        ])><x-icon :name="$s['icon']" class="size-4" /> {{ $s['nav'] }}</a>
                    @endforeach
                </nav>
            </div>

            @if ($articles->isEmpty())
                <p class="mt-10 text-slate-600">New articles are on the way.</p>
            @else
                <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <x-article-card :article="$article" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @include('partials.cta')
</x-layouts.app>
