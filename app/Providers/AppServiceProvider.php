<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('database.auto_migrate') && ! $this->app->runningInConsole()) {
            $this->setUpDatabaseOnce();
        }

        \App\Support\ServiceTexts::apply();
    }

    /**
     * Vercel builds without PHP, so pending migrations run on the first request
     * an instance serves. A marker in /tmp keeps it to one check per instance.
     * Migrations are transactional on Postgres, so two instances racing is safe:
     * the loser rolls back and retries on its next request.
     */
    protected function setUpDatabaseOnce(): void
    {
        $files = glob(database_path('migrations/*.php'));
        $marker = sys_get_temp_dir().'/migrated-'.md5(implode('|', array_map('basename', $files)).config('auth.admin.email'));

        if (is_file($marker)) {
            return;
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            static::ensureAdminAccount();
            @touch($marker);
        } catch (\Throwable $e) {
            Log::error('Automatic migration failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Create the admin account from ADMIN_EMAIL / ADMIN_PASSWORD if missing.
     */
    public static function ensureAdminAccount(): void
    {
        ['email' => $email, 'password' => $password] = config('auth.admin');

        if (! $email || ! $password || User::where('email', strtolower($email))->exists()) {
            return;
        }

        $user = User::create(['name' => 'Admin', 'email' => strtolower($email), 'password' => $password]);
        $user->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();
    }
}
