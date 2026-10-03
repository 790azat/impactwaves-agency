@php
    $nav = [
        ['label' => 'Services', 'icon' => 'layers', 'href' => route('services.index'), 'active' => request()->routeIs('services.*')],
        ['label' => 'Media Buying Guides', 'icon' => 'book', 'href' => route('section', 'guides'), 'active' => request()->is('guides*')],
        ['label' => 'For Traffic Providers', 'icon' => 'globe', 'href' => route('section', 'traffic-providers'), 'active' => request()->is('traffic-providers*')],
        ['label' => 'News', 'icon' => 'newspaper', 'href' => route('section', 'news'), 'active' => request()->is('news*')],
        ['label' => 'Careers', 'icon' => 'briefcase', 'href' => route('careers'), 'active' => request()->routeIs('careers*')],
        ['label' => 'About', 'icon' => 'users', 'href' => route('about'), 'active' => request()->routeIs('about')],
    ];
@endphp
<header x-data="{ open: false, scrolled: false }"
        x-init="scrolled = window.scrollY > 12"
        @scroll.window="scrolled = window.scrollY > 12"
        @keydown.escape.window="open = false"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
        :class="scrolled || open ? 'bg-navy/95 py-2 shadow-lg shadow-black/20 backdrop-blur-md' : 'py-4'">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <nav class="flex items-center justify-between py-2.5">
            <a href="{{ route('home') }}" wire:navigate aria-label="Impact Waves home">
                <x-logo dark class="h-7 w-auto sm:h-8" />
            </a>

            <ul class="hidden items-center gap-1 lg:flex">
                @foreach ($nav as $item)
                    <li>
                        <a href="{{ $item['href'] }}" wire:navigate
                           @class([
                               'inline-flex items-center rounded-md px-2 py-2 text-[13px] font-medium whitespace-nowrap transition xl:px-3.5 xl:text-sm',
                               'bg-white/10 text-white' => $item['active'],
                               'text-slate-300 hover:bg-white/5 hover:text-white' => ! $item['active'],
                           ])>{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account') }}"
                       class="hidden items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white sm:inline-flex"
                       title="{{ auth()->user()->is_admin ? 'Admin panel' : 'My account' }}">
                        <x-icon :name="auth()->user()->is_admin ? 'shield' : 'user'" class="size-4 text-ocean-400" /><span class="hidden xl:inline">{{ auth()->user()->is_admin ? 'Admin' : 'Account' }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white sm:inline-flex">
                        <x-icon name="user" class="size-4 text-ocean-400" /><span class="hidden xl:inline">Sign in</span>
                    </a>
                @endauth
                <a href="{{ route('contact') }}" wire:navigate class="btn btn-primary hidden !py-2.5 whitespace-nowrap sm:inline-flex lg:!px-4 xl:!px-5">
                    Start a Partnership <x-icon name="arrow" class="size-4" />
                </a>
                <button type="button" class="grid size-10 place-items-center rounded-md text-white hover:bg-white/10 lg:hidden"
                        @click="open = !open" :aria-expanded="open" aria-controls="mobile-nav" aria-label="Toggle menu">
                    <x-icon name="menu" class="size-6" x-show="!open" />
                    <x-icon name="close" class="size-6" x-show="open" x-cloak />
                </button>
            </div>
        </nav>

        <div id="mobile-nav" x-show="open" x-cloak
             x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-3"
             class="mt-2 mb-3 rounded-lg border border-white/10 bg-navy-800 p-3 shadow-2xl shadow-black/30 lg:hidden">
            <ul class="grid gap-1">
                @foreach ($nav as $item)
                    <li><a href="{{ $item['href'] }}" wire:navigate @click="open = false" class="flex items-center gap-3 rounded-md px-4 py-3 text-base font-medium text-white hover:bg-white/5"><x-icon :name="$item['icon']" class="size-5 text-ocean-400" />{{ $item['label'] }}</a></li>
                @endforeach
                <li>
                    @auth
                        <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account') }}" class="flex items-center gap-3 rounded-md px-4 py-3 text-base font-medium text-white hover:bg-white/5"><x-icon :name="auth()->user()->is_admin ? 'shield' : 'user'" class="size-5 text-ocean-400" />{{ auth()->user()->is_admin ? 'Admin panel' : 'My account' }}</a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-3 rounded-md px-4 py-3 text-base font-medium text-white hover:bg-white/5"><x-icon name="user" class="size-5 text-ocean-400" />Sign in</a>
                    @endauth
                </li>
                <li class="pt-2"><a href="{{ route('contact') }}" wire:navigate class="btn btn-primary w-full">Start a Partnership <x-icon name="arrow" class="size-4" /></a></li>
            </ul>
        </div>
    </div>
</header>
