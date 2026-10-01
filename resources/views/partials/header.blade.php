@php
    $nav = [
        ['label' => 'Services', 'icon' => 'layers', 'href' => route('services.index'), 'active' => request()->routeIs('services.*')],
        ['label' => 'Guides', 'icon' => 'book', 'href' => route('section', 'guides'), 'active' => request()->is('guides*')],
        ['label' => 'Traffic Providers', 'icon' => 'globe', 'href' => route('section', 'traffic-providers'), 'active' => request()->is('traffic-providers*')],
        ['label' => 'News', 'icon' => 'newspaper', 'href' => route('section', 'news'), 'active' => request()->is('news*')],
        ['label' => 'About', 'icon' => 'users', 'href' => route('about'), 'active' => request()->routeIs('about')],
    ];
@endphp
<header x-data="{ open: false, scrolled: false }"
        x-init="scrolled = window.scrollY > 12"
        @scroll.window="scrolled = window.scrollY > 12"
        @keydown.escape.window="open = false"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
        :class="scrolled || open ? 'py-3' : 'py-5'">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <nav class="flex items-center justify-between rounded-md px-4 py-2.5 transition-all duration-500 sm:px-5"
             :class="scrolled || open ? 'glass shadow-2xl shadow-ocean-900/10' : 'border border-transparent'">
            <a href="{{ route('home') }}" wire:navigate aria-label="Impact Waves home">
                <x-logo class="h-8 w-auto sm:h-9" />
            </a>

            <ul class="hidden items-center gap-1 lg:flex">
                @foreach ($nav as $item)
                    <li>
                        <a href="{{ $item['href'] }}" wire:navigate
                           @class([
                               'inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm xl:px-4 font-medium transition',
                               'bg-ocean-50 text-ocean-950' => $item['active'],
                               'text-slate-700 hover:bg-ocean-50 hover:text-ocean-950' => ! $item['active'],
                           ])><x-icon :name="$item['icon']" class="size-4 text-ocean-500" />{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account') }}"
                       class="hidden items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-ocean-50 hover:text-ocean-950 sm:inline-flex"
                       title="{{ auth()->user()->is_admin ? 'Admin panel' : 'My account' }}">
                        <x-icon :name="auth()->user()->is_admin ? 'shield' : 'user'" class="size-4 text-ocean-500" /><span class="hidden xl:inline">{{ auth()->user()->is_admin ? 'Admin' : 'Account' }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-ocean-50 hover:text-ocean-950 sm:inline-flex">
                        <x-icon name="user" class="size-4 text-ocean-500" /><span class="hidden xl:inline">Sign in</span>
                    </a>
                @endauth
                <a href="{{ route('contact') }}" wire:navigate class="btn btn-primary hidden !py-2.5 sm:inline-flex">
                    <x-icon name="rocket" class="size-4" /> Start a project
                </a>
                <button type="button" class="grid size-10 place-items-center rounded-full text-ocean-950 hover:bg-ocean-50 lg:hidden"
                        @click="open = !open" :aria-expanded="open" aria-controls="mobile-nav" aria-label="Toggle menu">
                    <x-icon name="menu" class="size-6" x-show="!open" />
                    <x-icon name="close" class="size-6" x-show="open" x-cloak />
                </button>
            </div>
        </nav>

        <div id="mobile-nav" x-show="open" x-cloak
             x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-3"
             class="mt-3 rounded-2xl border border-ocean-100 bg-white/95 p-3 shadow-2xl shadow-ocean-900/10 backdrop-blur-xl lg:hidden">
            <ul class="grid gap-1">
                @foreach ($nav as $item)
                    <li><a href="{{ $item['href'] }}" wire:navigate @click="open = false" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-base font-medium text-ocean-950 hover:bg-ocean-50"><x-icon :name="$item['icon']" class="size-5 text-ocean-500" />{{ $item['label'] }}</a></li>
                @endforeach
                <li>
                    @auth
                        <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-base font-medium text-ocean-950 hover:bg-ocean-50"><x-icon :name="auth()->user()->is_admin ? 'shield' : 'user'" class="size-5 text-ocean-500" />{{ auth()->user()->is_admin ? 'Admin panel' : 'My account' }}</a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-base font-medium text-ocean-950 hover:bg-ocean-50"><x-icon name="user" class="size-5 text-ocean-500" />Sign in</a>
                    @endauth
                </li>
                <li class="pt-2"><a href="{{ route('contact') }}" wire:navigate class="btn btn-primary w-full"><x-icon name="rocket" class="size-4" /> Start a project</a></li>
            </ul>
        </div>
    </div>
</header>
