<?php

namespace Database\Seeders;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creates the admin from ADMIN_EMAIL / ADMIN_PASSWORD, as production does on boot.
        AppServiceProvider::ensureAdminAccount();
    }
}
