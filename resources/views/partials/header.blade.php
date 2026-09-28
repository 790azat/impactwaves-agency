@php
    $nav = [
        ['label' => 'Services', 'href' => route('services.index'), 'active' => request()->routeIs('services.*')],
        ['label' => 'TikTok Agency', 'href' => route('services.show', 'tiktok-agency'), 'active' => request()->is('services/tiktok-agency')],
        ['label' => 'Expertise', 'href' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'ROI Calculator', 'href' => route('home').'#calculator', 'active' => false],
    ];
@endphp
<header x-data="{ open: false, scrolled: false }"
        x-init="scrolled = window.scrollY > 12"
        @scroll.window="scrolled = window.scrollY > 12"
        @keydown.escape.window="open = false"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
        :class="scrolled || open ? 'py-3' : 'py-5'">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <nav class="flex items-center justify-between rounded-full px-4 py-2.5 transition-all duration-500 sm:px-5"
             :class="scrolled || open ? 'glass shadow-2xl shadow-slate-900/10' : 'border border-transparent'">
            <a href="{{ route('home') }}" wire:navigate aria-label="Impact Waves home">
                <x-logo id="hdr" />
            </a>

            <ul class="hidden items-center gap-1 lg:flex">
                @foreach ($nav as $item)
                    <li>
                        <a href="{{ $item['href'] }}" wire:navigate
                           @class([
                               'rounded-full px-4 py-2 text-sm font-medium transition',
                               'bg-slate-100 text-slate-900' => $item['active'],
                               'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => ! $item['active'],
                           ])>{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-2">
                <a href="{{ route('contact') }}" wire:navigate class="btn btn-primary hidden !py-2.5 sm:inline-flex">
                    Start a project
                </a>
                <button type="button" class="grid size-10 place-items-center rounded-full text-slate-900 hover:bg-slate-100 lg:hidden"
                        @click="open = !open" :aria-expanded="open" aria-controls="mobile-nav" aria-label="Toggle menu">
                    <x-icon name="menu" class="size-6" x-show="!open" />
                    <x-icon name="close" class="size-6" x-show="open" x-cloak />
                </button>
            </div>
        </nav>

        <div id="mobile-nav" x-show="open" x-cloak
             x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-3"
             class="mt-3 rounded-3xl border border-slate-200 bg-white/95 p-3 shadow-2xl shadow-slate-900/10 backdrop-blur-xl lg:hidden">
            <ul class="grid gap-1">
                @foreach ($nav as $item)
                    <li><a href="{{ $item['href'] }}" wire:navigate @click="open = false" class="block rounded-2xl px-4 py-3 text-base font-medium text-slate-900 hover:bg-slate-100">{{ $item['label'] }}</a></li>
                @endforeach
                <li class="pt-2"><a href="{{ route('contact') }}" wire:navigate class="btn btn-primary w-full">Start a project</a></li>
            </ul>
        </div>
    </div>
</header>
