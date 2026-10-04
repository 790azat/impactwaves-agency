@php
    $url = \App\Support\Seo::url(route('article', [$article['section'], $article['slug']]));
    $sectionUrl = \App\Support\Seo::url(route('section', $article['section']));
@endphp
<x-layouts.app :title="$article['title']" :description="$article['description']" type="article" :keywords="$article['keywords']">
    @push('schema')
        <meta property="article:published_time" content="{{ $article['date']->toIso8601String() }}">
        @if ($article['updated'])
            <meta property="article:modified_time" content="{{ $article['updated']->toIso8601String() }}">
        @endif
        <meta property="article:section" content="{{ $section['title'] }}">
        <script type="application/ld+json">
            {!! json_encode([
                "\x40context" => 'https://schema.org',
                "\x40graph" => [
                    [
                        "\x40type" => $article['section'] === 'news' ? 'NewsArticle' : 'Article',
                        'headline' => $article['title'],
                        'description' => $article['description'],
                        'keywords' => implode(', ', $article['keywords']),
                        'datePublished' => $article['date']->toIso8601String(),
                        'dateModified' => ($article['updated'] ?? $article['date'])->toIso8601String(),
                        'author' => ["\x40type" => 'Organization', 'name' => $article['author'], 'url' => route('about')],
                        'publisher' => ["\x40type" => 'Organization', 'name' => config('agency.legal_name'), 'logo' => ["\x40type" => 'ImageObject', 'url' => url('/logo.png')]],
                        'image' => url(($article['cover'] ?? null) ?: '/og-image.png'),
                        'mainEntityOfPage' => $url,
                        'articleSection' => $section['title'],
                        'wordCount' => str_word_count(strip_tags($article['html'])),
                    ],
                    [
                        "\x40type" => 'BreadcrumbList',
                        'itemListElement' => [
                            ["\x40type" => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                            ["\x40type" => 'ListItem', 'position' => 2, 'name' => $section['title'], 'item' => $sectionUrl],
                            ["\x40type" => 'ListItem', 'position' => 3, 'name' => $article['title'], 'item' => $url],
                        ],
                    ],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    <article>
        <header class="bg-sea relative isolate overflow-hidden border-b border-ocean-100 pt-36 pb-16 sm:pt-44 sm:pb-20">
            @include('partials.silk')
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <nav aria-label="Breadcrumb" class="text-sm text-slate-500" data-reveal>
                    <ol class="flex flex-wrap items-center gap-2">
                        <li><a href="{{ route('home') }}" wire:navigate class="hover:text-ocean-950">Home</a></li>
                        <li aria-hidden="true">/</li>
                        <li><a href="{{ $sectionUrl }}" wire:navigate class="hover:text-ocean-950">{{ $section['title'] }}</a></li>
                    </ol>
                </nav>
                <p class="eyebrow mt-6" data-reveal>{{ $article['tag'] ?? $section['title'] }}</p>
                <h1 class="mt-6 font-display text-4xl leading-[1.1] font-semibold tracking-tight text-ocean-950 text-balance sm:text-5xl lg:text-6xl" data-reveal style="--reveal-delay:80ms">{{ $article['title'] }}</h1>
                <p class="mt-6 text-lg leading-relaxed text-slate-600 text-pretty sm:text-xl" data-reveal style="--reveal-delay:140ms">{{ $article['description'] }}</p>
                <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-500" data-reveal style="--reveal-delay:200ms">
                    <span class="inline-flex items-center gap-2"><x-logo-mark class="h-3.5 w-auto text-[#007BFF]" /> {{ $article['author'] }}</span>
                    <time datetime="{{ $article['date']->toDateString() }}">{{ $article['date']->format('F j, Y') }}</time>
                    <span class="inline-flex items-center gap-2"><x-icon name="clock" class="size-4" /> {{ $article['minutes'] }} min read</span>
                </div>
            </div>
        </header>

        <div class="mx-auto grid max-w-6xl gap-12 px-4 pt-14 pb-16 sm:px-6 sm:pt-16 lg:grid-cols-[1fr_240px]">
            <div class="min-w-0">
                @if ($article['cover'] ?? null)
                    <img src="{{ $article['cover'] }}" alt="" width="1600" height="1000" class="mb-12 w-full rounded-2xl shadow-xl shadow-ocean-950/15" fetchpriority="high">
                @endif
                <div class="prose-article">{!! $article['html'] !!}</div>
            </div>

            @if (count($article['toc']) > 2)
                <aside class="hidden lg:block">
                    <div class="sticky top-28 rounded-2xl border border-ocean-100 bg-ocean-50 p-6">
                        <p class="text-xs font-semibold tracking-[.12em] text-slate-500 uppercase">On this page</p>
                        <ul class="mt-4 space-y-2.5 text-sm">
                            @foreach ($article['toc'] as $item)
                                <li><a href="#{{ $item['id'] }}" class="text-slate-600 transition hover:text-ocean-600">{{ $item['text'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            @endif
        </div>

        @if ($article['keywords'])
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <ul class="flex flex-wrap gap-2 border-t border-ocean-100 pt-8" aria-label="Topics">
                    @foreach ($article['keywords'] as $keyword)
                        <li class="rounded-md bg-ocean-50 px-3 py-1 text-sm text-slate-600">{{ $keyword }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </article>

    @if ($related->isNotEmpty())
        <section class="py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="font-display text-3xl font-semibold text-ocean-950" data-reveal>Keep reading</h2>
                    <x-button href="{{ $sectionUrl }}" variant="ghost" icon="arrow-left" wire:navigate data-reveal>All {{ strtolower($section['nav']) }}</x-button>
                </div>
                <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-article-card :article="$item" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('partials.cta')
</x-layouts.app>
