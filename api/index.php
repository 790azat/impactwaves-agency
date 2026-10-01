<?php

/*
 * Vercel entry point. Serverless functions only have a writable /tmp, so point
 * every cache/compiled path there. Accounts, leads and admin-edited articles
 * live in Postgres (Neon, connected in Vercel Storage); without it the public
 * site still works from Markdown files and stateless drivers.
 */

// Neon's Vercel integration exposes these. The direct (unpooled) URL is
// preferred because PDO uses server-side prepared statements.
$databaseUrl = null;
foreach (['DATABASE_URL_UNPOOLED', 'POSTGRES_URL_NON_POOLING', 'DATABASE_URL', 'POSTGRES_URL'] as $key) {
    if (($value = getenv($key)) && str_starts_with($value, 'postgres')) {
        $databaseUrl = $value;
        break;
    }
}

// These must hold on Vercel no matter what is set in the dashboard (for example
// values imported from .env.example): the filesystem is read-only.
$forced = [
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'SESSION_DRIVER' => 'cookie',
    'LOG_CHANNEL' => 'stderr',
    'QUEUE_CONNECTION' => 'sync',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK' => 'local',
    'APP_MAINTENANCE_DRIVER' => 'file',
];

$forced += $databaseUrl ? [
    'DB_CONNECTION' => 'pgsql',
    'DB_URL' => $databaseUrl,
    'DB_SSLMODE' => 'require',
    'DB_AUTO_MIGRATE' => 'true',
    'CACHE_STORE' => 'database',
] : [
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => ':memory:',
    'CACHE_STORE' => 'array',
];

// Sensible values when the dashboard leaves these empty.
$defaults = [
    'APP_NAME' => 'Impact Waves Agency',
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'APP_LOCALE' => 'en',
    'APP_FALLBACK_LOCALE' => 'en',
    'LOG_LEVEL' => 'error',
    'SESSION_LIFETIME' => '120',
    'MAIL_MAILER' => 'log',
];

$set = function (string $key, string $value): void {
    putenv("$key=$value");
    $_ENV[$key] = $_SERVER[$key] = $value;
};

foreach ($forced as $key => $value) {
    $set($key, $value);
}

foreach ($defaults as $key => $value) {
    $current = getenv($key);
    if ($current === false || trim($current) === '' || in_array(strtolower($current), ['null', '(null)'], true)) {
        $set($key, $value);
    }
}

// Drop empty or "null" optional settings so Laravel falls back to its own defaults.
foreach (array_keys(getenv()) as $key) {
    $value = getenv($key);
    if (! array_key_exists($key, $forced) && ! array_key_exists($key, $defaults)
        && (trim($value) === '' || in_array(strtolower($value), ['null', '(null)'], true))) {
        putenv($key);
        unset($_ENV[$key], $_SERVER[$key]);
    }
}

if (! is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0755, true);
}

if (! getenv('APP_KEY')) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "APP_KEY is not set. Add it in Vercel: Project Settings -> Environment Variables, then redeploy.\n";
    exit;
}

require __DIR__.'/../public/index.php';
