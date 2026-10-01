@props(['title' => null, 'description' => null, 'type' => 'website', 'keywords' => [], 'noindex' => false])
@php
    $siteName = config('agency.legal_name');
    $pageTitle = $title ? $title.' | '.config('agency.name') : 'Performance Marketing Agency for the US, EU and Canada | '.config('agency.name');
    $pageDescription = $description ?? config('agency.description');
    $canonical = \App\Support\Seo::canonical();
    $indexable = ! $noindex && \App\Support\Seo::onPublicHost();
    $location = \App\Support\Company::location();
@endphp
<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $indexable ? 'index, follow, max-image-preview:large, max-snippet:-1' : 'noindex, nofollow' }}">
    @if ($keywords)
        <meta name="keywords" content="{{ implode(', ', $keywords) }}">
    @endif
    <link rel="alternate" type="application/rss+xml" title="{{ $siteName }}" href="{{ route('feed') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta property="og:type" content="{{ $type }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:image" content="{{ config('agency.site_url') }}/og-image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $siteName }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    {!! \App\Support\Seo::jsonLd(array_filter([
        "\x40type" => 'Organization',
        "\x40id" => config('agency.site_url').'/#organization',
        'name' => $siteName,
        'alternateName' => config('agency.name'),
        'url' => config('agency.site_url').'/',
        'logo' => config('agency.site_url').'/logo.png',
        'image' => config('agency.site_url').'/og-image.png',
        'description' => config('agency.description'),
        'email' => config('agency.email'),
        'sameAs' => [config('agency.linkedin')],
        'areaServed' => ['US', 'EU', 'CA'],
        'knowsAbout' => ['Performance marketing', 'Paid social advertising', 'PPC', 'Conversion rate optimization', 'TikTok advertising', 'Search arbitrage', 'Search feed monetization'],
        'contactPoint' => ["\x40type" => 'ContactPoint', 'contactType' => 'sales', 'email' => config('agency.email'), 'url' => config('agency.site_url').'/contact', 'availableLanguage' => ['English']],
        'address' => $location['city'] || $location['country'] ? array_filter(["\x40type" => 'PostalAddress', 'streetAddress' => $location['address'], 'addressLocality' => $location['city'], 'addressCountry' => $location['country']]) : null,
    ])) !!}
    @stack('schema')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-dvh overflow-x-clip">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:text-ocean-950">Skip to content</a>

    @include('partials.header')

    <main id="main">
        {{ $slot }}
    </main>

    @include('partials.footer')
    @persist('chat')
        <livewire:chat-widget defer />
    @endpersist
    @livewireScripts
</body>
</html>
