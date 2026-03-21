<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * One-time-style admin bootstrap via secret URL (for Railway / empty DB).
 *
 * Visit: /setup-first-admin?token=YOUR_SETUP_ADMIN_TOKEN
 * Set SETUP_ADMIN_TOKEN + SEED_* variables in Railway. Remove or rotate token after use.
 */
class SetupAdminController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $expected = (string) config('snack_inn.setup_admin_token', '');

        if ($expected === '' || ! hash_equals($expected, (string) $request->query('token', ''))) {
            abort(404);
        }

        $name = env('SEED_ADMIN_NAME', 'admin');
        $email = env('SEED_ADMIN_EMAIL', 'admin@akeira.local');

        $password = env('SEED_ADMIN_PASSWORD');
        if ($password === null || $password === '') {
            if (app()->environment('production')) {
                abort(404);
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

        return redirect()
            ->route('login')
            ->with('status', "Admin ready. Sign in with username \"{$name}\" and your SEED_ADMIN_PASSWORD.");
    }
}
