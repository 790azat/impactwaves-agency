{{-- Article cover for cards: the article's own image, or a silk wave when it has none. --}}
<span class="relative isolate block overflow-hidden bg-navy {{ $class ?? '' }}">
    @if ($article['cover'] ?? null)
        <img src="{{ $article['cover'] }}" alt="" width="1600" height="1000" loading="lazy" class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105">
    @else
        <span class="silk silk-tile inset-0 transition duration-700 group-hover:scale-105" style="background-position: {{ ['20% 40%', '70% 60%', '45% 20%'][crc32($article['slug']) % 3] }}"></span>
    @endif
</span>
