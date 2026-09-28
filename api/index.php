<?php

/*
 * Vercel entry point. Serverless functions only have a writable /tmp and no
 * database, so point every cache/compiled path there and use stateless drivers.
 */

// These must hold on Vercel no matter what is set in the dashboard (for example
// values imported from .env.example): the filesystem is read-only and there is no DB.
$forced = [
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'LOG_CHANNEL' => 'stderr',
    'QUEUE_CONNECTION' => 'sync',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => ':memory:',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK' => 'local',
    'APP_MAINTENANCE_DRIVER' => 'file',
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
