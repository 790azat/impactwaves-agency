<?php

/*
 * Vercel entry point. Serverless functions only have a writable /tmp, and no
 * database, so point every cache/compiled path there and use stateless drivers.
 * Values set in the Vercel dashboard still win.
 */
$defaults = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
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
    'MAIL_MAILER' => 'log',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => ':memory:',
];

foreach ($defaults as $key => $value) {
    if (getenv($key) === false || getenv($key) === '') {
        putenv("$key=$value");
        $_ENV[$key] = $_SERVER[$key] = $value;
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
