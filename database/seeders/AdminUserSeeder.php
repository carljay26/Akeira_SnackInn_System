<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Creates or updates the default admin user (login uses `name` + `password` in this app).
 *
 * Railway / production: set SEED_ADMIN_NAME, SEED_ADMIN_EMAIL, SEED_ADMIN_PASSWORD in the service variables,
 * then run: php artisan db:seed --class=AdminUserSeeder --force
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = env('SEED_ADMIN_NAME', 'admin');
        $email = env('SEED_ADMIN_EMAIL', 'admin@akeira.local');

        $password = env('SEED_ADMIN_PASSWORD');
        if ($password === null || $password === '') {
            if (app()->environment('production')) {
                throw new \RuntimeException(
                    'Set SEED_ADMIN_PASSWORD in your environment (e.g. Railway Variables) before running this seeder in production.'
                );
            }
            $password = 'password123';
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if ($this->command) {
            $this->command->info("Admin user ready: name=\"{$name}\" email=\"{$email}\"");
            if (! app()->environment('production')) {
                $this->command->warn('Local default password is used unless SEED_ADMIN_PASSWORD is set.');
            }
        }
    }
}
