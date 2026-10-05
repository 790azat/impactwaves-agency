@props(['article'])
@php $section = config('agency.sections')[$article['section']]; @endphp
<a href="{{ route('article', [$article['section'], $article['slug']]) }}" wire:navigate
   {{ $attributes->class('card-glow glass group flex h-full flex-col overflow-hidden rounded-2xl transition duration-300 hover:-translate-y-1') }}>
    @include('partials.article-cover', ['article' => $article, 'class' => 'aspect-[16/10]'])
    <div class="flex flex-1 flex-col p-7">
    <div class="flex items-center gap-2 text-xs font-medium tracking-[.12em] text-ocean-600 uppercase">
        {{ $article['tag'] ?? $section['title'] }}
    </div>
    <h3 class="mt-4 font-display text-xl leading-snug font-semibold text-ocean-950 text-balance">{{ $article['title'] }}</h3>
    <div class="mt-3 flex-1"><p class="line-clamp-3 leading-relaxed text-slate-600">{{ $article['description'] }}</p></div>
    </div>
</a>
