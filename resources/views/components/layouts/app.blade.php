@props(['title' => null, 'description' => null])
@php
    $siteName = config('agency.legal_name');
    $pageTitle = $title ? $title.' · '.$siteName : $siteName.' · Performance marketing for US, EU and Canada';
    $pageDescription = $description ?? config('agency.description');
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ url('/og-image.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">
        {!! json_encode([
            "\x40context" => 'https://schema.org',
            "\x40type" => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
            'logo' => url('/logo.svg'),
            'description' => config('agency.description'),
            'email' => config('agency.email'),
            'sameAs' => [config('agency.linkedin')],
            'areaServed' => ['US', 'EU', 'CA'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-dvh overflow-x-clip">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-full focus:bg-white focus:px-4 focus:py-2 focus:text-ink-950">Skip to content</a>

    @include('partials.header')

    <main id="main">
        {{ $slot }}
    </main>

    @include('partials.footer')
    @livewireScripts
</body>
</html>
