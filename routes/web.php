<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');

Route::view('/services', 'pages.services')->name('services.index');

Route::get('/services/{slug}', function (string $slug) {
    $services = config('agency.services');
    abort_unless(isset($services[$slug]), 404);

    return view('pages.service', [
        'slug' => $slug,
        'service' => $services[$slug],
        'others' => collect($services)->except($slug)->all(),
    ]);
})->name('services.show');

Route::redirect('/tiktok-agency', '/services/tiktok-agency', 301);

Route::view('/expertise', 'pages.about')->name('about');

Route::view('/contact', 'pages.contact')->name('contact');

Route::get('/sitemap.xml', function () {
    $urls = collect([route('home'), route('services.index'), route('about'), route('contact')])
        ->merge(collect(config('agency.services'))->keys()->map(fn ($slug) => route('services.show', $slug)));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $url) {
        $xml .= '<url><loc>'.e($url).'</loc></url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');
