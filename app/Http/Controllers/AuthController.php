<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Services\SnackInnNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function loginForm(): View
    {
        return view('login');
    }

    public function registerForm(): View
    {
        return view('register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'team_code' => ['nullable', 'string', 'max:32'],
        ]);

        $teamCode = $validated['team_code'] ?? null;
        if ($teamCode !== null && trim($teamCode) !== '' && Shop::findByTeamCode($teamCode) === null) {
            return back()
                ->withErrors(['team_code' => 'That team code was not found. Ask a manager for the code on the dashboard, or leave blank if your server uses a default shop.'])
                ->withInput($request->only('name', 'email', 'team_code'));
        }

        $shop = Shop::assignForNewRegistration($teamCode, $validated['name']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'shop_id' => $shop->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        SnackInnNotifier::notifyLoginWelcome($user);

        return redirect()->route('dashboard');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['name' => 'Invalid username or password.'])->onlyInput('name');
        }

        $request->session()->regenerate();

        if ($user = $request->user()) {
            SnackInnNotifier::notifyLoginWelcome($user);
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
