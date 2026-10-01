@props(['title' => 'Admin'])
@php
    $nav = [
        ['label' => 'Dashboard', 'icon' => 'chart', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
        ['label' => 'Leads', 'icon' => 'inbox', 'route' => 'admin.leads.index', 'match' => 'admin.leads.*'],
        ['label' => 'Chats', 'icon' => 'chat', 'route' => 'admin.chats.index', 'match' => 'admin.chats.*'],
        ['label' => 'Users', 'icon' => 'users', 'route' => 'admin.users.index', 'match' => 'admin.users.*'],
        ['label' => 'Articles', 'icon' => 'newspaper', 'route' => 'admin.articles.index', 'match' => 'admin.articles.*'],
        ['label' => 'Vacancies', 'icon' => 'briefcase', 'route' => 'admin.vacancies.index', 'match' => 'admin.vacancies.*'],
        ['label' => 'Company', 'icon' => 'map-pin', 'route' => 'admin.company.edit', 'match' => 'admin.company.*'],
    ];
    $badges = [
        'Leads' => \App\Models\Lead::where('status', 'new')->count(),
        'Chats' => \App\Models\ChatConversation::where(fn ($q) => $q->whereNull('admin_read_at')->orWhereColumn('admin_read_at', '<', 'last_message_at'))->count(),
    ];
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Impact Waves Admin</title>
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-slate-50">
    <div class="lg:flex">
        <aside class="border-b border-ocean-100 bg-white lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-b-0">
            <div class="flex items-center justify-between gap-4 px-5 py-4 lg:py-6">
                <a href="{{ route('admin.dashboard') }}" aria-label="Admin dashboard"><x-logo class="h-6 w-auto" /></a>
                <span class="shrink-0 rounded bg-ocean-50 px-1.5 py-0.5 text-[10px] font-semibold tracking-wider text-ocean-700 uppercase">Admin</span>
            </div>
            <nav class="flex gap-1 overflow-x-auto px-3 pb-3 lg:flex-1 lg:flex-col lg:overflow-visible lg:pb-0">
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" @class([
                        'flex shrink-0 items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition',
                        'bg-ocean-50 text-ocean-950' => request()->routeIs($item['match']),
                        'text-slate-600 hover:bg-slate-50 hover:text-ocean-950' => ! request()->routeIs($item['match']),
                    ])>
                        <x-icon :name="$item['icon']" class="size-5 text-ocean-500" />
                        {{ $item['label'] }}
                        @if ($badges[$item['label']] ?? 0)
                            <span class="ml-auto rounded-md bg-ocean-600 px-1.5 text-xs font-semibold text-white">{{ $badges[$item['label']] }}</span>
                        @endif
                    </a>
                @endforeach
            </nav>
            <div class="hidden border-t border-ocean-100 p-3 lg:block">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-ocean-950"><x-icon name="arrow-up-right" class="size-5 text-ocean-500" /> View site</a>
                <a href="{{ route('account') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-ocean-950"><x-icon name="user" class="size-5 text-ocean-500" /> {{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-ocean-950"><x-icon name="logout" class="size-5 text-ocean-500" /> Sign out</button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1 lg:pl-64">
            <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8 lg:py-10">
                @isset($header)
                    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">{{ $header }}</div>
                @endisset

                @if (session('status'))
                    <p class="mb-6 rounded-lg border border-ocean-200 bg-ocean-50 px-4 py-3 text-sm text-ocean-900">{{ session('status') }}</p>
                @endif
                @if (session('error'))
                    <p class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</p>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
