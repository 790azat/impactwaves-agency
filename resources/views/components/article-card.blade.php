@props(['article'])
@php $section = config('agency.sections')[$article['section']]; @endphp
<a href="{{ route('article', [$article['section'], $article['slug']]) }}" wire:navigate
   {{ $attributes->class('card-glow glass group flex h-full flex-col rounded-2xl p-7 transition duration-300 hover:-translate-y-1') }}>
    <div class="flex items-center gap-2 text-xs font-medium tracking-[.12em] text-ocean-600 uppercase">
        <x-icon :name="$section['icon']" class="size-4" /> {{ $article['tag'] ?? $section['title'] }}
    </div>
    <h3 class="mt-4 font-display text-xl leading-snug font-semibold text-ocean-950 text-balance">{{ $article['title'] }}</h3>
    <div class="mt-3 flex-1"><p class="line-clamp-3 leading-relaxed text-slate-600">{{ $article['description'] }}</p></div>
    <div class="mt-6 flex items-center justify-between border-t border-ocean-100 pt-5 text-sm text-slate-500">
        <span class="inline-flex items-center gap-2"><x-icon name="clock" class="size-4" /> {{ $article['minutes'] }} min read</span>
        <span class="inline-flex items-center gap-1.5 font-semibold text-ocean-950"><x-icon name="arrow" class="size-4 transition group-hover:translate-x-0.5" /> Read</span>
    </div>
</a>
