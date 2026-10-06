<x-layouts.app :title="$section['meta_title']" :description="$section['meta_description']">
    @push('schema')
        <script type="application/ld+json">
            {!! json_encode([
                "\x40context" => 'https://schema.org',
                "\x40type" => 'CollectionPage',
                'name' => $section['title'],
                'description' => $section['meta_description'],
                'url' => \App\Support\Seo::url(route('section', $key)),
                'breadcrumb' => \App\Support\Seo::breadcrumbs([[$section['title'], route('section', $key)]]),
                'hasPart' => $articles->map(fn ($a) => [
                    "\x40type" => $key === 'news' ? 'NewsArticle' : 'Article',
                    'headline' => $a['title'],
                    'url' => \App\Support\Seo::url(route('article', [$a['section'], $a['slug']])),
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
        <section class="pt-14 pb-4 sm:pt-16">
            <div class="mx-auto flex max-w-7xl flex-wrap gap-3 px-4 sm:px-6" data-reveal>
                <a href="{{ route('contact') }}?service=traffic-partnerships" wire:navigate class="btn btn-primary">Become a Feed Partner <x-icon name="arrow" class="size-4" /></a>
                <a href="{{ config('agency.partners_telegram') }}" target="_blank" rel="noopener" class="btn btn-ghost"><x-icon name="send" class="size-4" /> Message us on Telegram</a>
                <x-button href="{{ route('services.show', 'traffic-partnerships') }}" variant="ghost" icon="layers" wire:navigate>Traffic Acquisition & Partnerships</x-button>
            </div>
        </section>
    @endif

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <h2 class="font-display text-3xl font-semibold text-ocean-950" data-reveal>{{ $key === 'news' ? 'Latest news' : 'Articles' }}</h2>
                <nav class="flex flex-wrap gap-2" aria-label="Sections" data-reveal>
                    @foreach (\App\Support\Sections::visible() as $k => $s)
                        <a href="{{ route('section', $k) }}" wire:navigate @class([
                            'inline-flex items-center gap-2 rounded-md border px-4 py-2 text-sm font-medium transition',
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
