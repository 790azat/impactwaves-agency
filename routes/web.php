<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Middleware\EnsureAdmin;
use App\Models\Vacancy;
use App\Support\Articles;
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

Route::view('/about', 'pages.about')->name('about');
Route::redirect('/expertise', '/about', 301);

Route::view('/contact', 'pages.contact')->name('contact');

Route::get('/careers', fn () => view('pages.careers', ['vacancies' => Vacancy::open()]))->name('careers');

Route::get('/careers/{slug}', function (string $slug) {
    $vacancy = Vacancy::open()->firstWhere('slug', $slug);
    abort_unless($vacancy, 404);

    return view('pages.vacancy', [
        'vacancy' => $vacancy,
        'others' => Vacancy::open()->where('id', '!=', $vacancy->id)->take(3),
    ]);
})->where('slug', '[a-z0-9-]+')->name('careers.show');

Route::post('/telegram/webhook', TelegramWebhookController::class)->name('telegram.webhook');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,10');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:6,10')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/account', [AccountController::class, 'show'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'password'])->name('account.password');
});

Route::middleware(['auth', EnsureAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::get('/leads', [Admin\LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/{lead}', [Admin\LeadController::class, 'show'])->name('leads.show');
    Route::put('/leads/{lead}', [Admin\LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{lead}', [Admin\LeadController::class, 'destroy'])->name('leads.destroy');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/chats', [Admin\ChatController::class, 'index'])->name('chats.index');
    Route::post('/chats/telegram', [Admin\ChatController::class, 'connect'])->name('chats.connect');
    Route::get('/chats/{conversation}', [Admin\ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{conversation}', [Admin\ChatController::class, 'reply'])->name('chats.reply');
    Route::delete('/chats/{conversation}', [Admin\ChatController::class, 'destroy'])->name('chats.destroy');

    Route::get('/articles', [Admin\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [Admin\ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [Admin\ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{section}/{slug}', [Admin\ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{section}/{slug}', [Admin\ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{section}/{slug}', [Admin\ArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('/services', [Admin\ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{slug}', [Admin\ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{slug}', [Admin\ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{slug}', [Admin\ServiceController::class, 'destroy'])->name('services.destroy');

    Route::resource('vacancies', Admin\VacancyController::class)->except('show');

    Route::get('/company', [Admin\CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company', [Admin\CompanyController::class, 'update'])->name('company.update');
});

$sections = array_keys(config('agency.sections'));

Route::get('/{section}', function (string $section) {
    return view('pages.section', [
        'key' => $section,
        'section' => config('agency.sections')[$section],
        'articles' => Articles::inSection($section),
    ]);
})->whereIn('section', $sections)->name('section');

Route::get('/{section}/{slug}', function (string $section, string $slug) {
    $article = Articles::find($section, $slug);
    abort_unless($article, 404);

    return view('pages.article', [
        'article' => $article,
        'section' => config('agency.sections')[$section],
        'related' => Articles::all()->reject(fn ($a) => $a['section'] === $section && $a['slug'] === $slug)
            ->sortBy(fn ($a) => $a['section'] === $section ? 0 : 1)->take(3)->values(),
    ]);
})->whereIn('section', $sections)->where('slug', '[a-z0-9-]+')->name('article');

Route::get('/sitemap.xml', function () {
    $urls = collect([route('home'), route('services.index'), route('about'), route('careers'), route('contact')])
        ->merge(Vacancy::open()->map(fn ($v) => route('careers.show', $v->slug)))
        ->merge(collect(config('agency.services'))->keys()->map(fn ($slug) => route('services.show', $slug)))
        ->merge(collect(config('agency.sections'))->keys()->map(fn ($key) => route('section', $key)))
        ->map(fn ($url) => ['loc' => $url, 'lastmod' => null])
        ->merge(Articles::all()->map(fn ($a) => [
            'loc' => route('article', [$a['section'], $a['slug']]),
            'lastmod' => ($a['updated'] ?? $a['date'])->toDateString(),
        ]));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $url) {
        $xml .= '<url><loc>'.e($url['loc']).'</loc>'.($url['lastmod'] ? '<lastmod>'.$url['lastmod'].'</lastmod>' : '').'</url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/feed.xml', function () {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<rss version="2.0"><channel>'
        .'<title>'.e(config('agency.legal_name')).'</title><link>'.e(route('home')).'</link>'
        .'<description>'.e(config('agency.description')).'</description>';
    foreach (Articles::all() as $a) {
        $url = route('article', [$a['section'], $a['slug']]);
        $xml .= '<item><title>'.e($a['title']).'</title><link>'.e($url).'</link><guid>'.e($url).'</guid>'
            .'<pubDate>'.$a['date']->toRssString().'</pubDate><description>'.e($a['description']).'</description></item>';
    }
    $xml .= '</channel></rss>';

    return response($xml, 200, ['Content-Type' => 'application/rss+xml']);
})->name('feed');
