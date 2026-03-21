<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer([
            'dashboard',
            'ordering',
            'order-queue',
            'history',
            'reports',
            'product',
        ], function ($view) {
            $user = Auth::user();
            if ($user === null) {
                $view->with([
                    'headerNotifications' => collect(),
                    'unreadNotificationCount' => 0,
                ]);

                return;
            }

            $view->with([
                'headerNotifications' => Notification::query()
                    ->where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->limit(8)
                    ->get(),
                'unreadNotificationCount' => Notification::query()
                    ->where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count(),
            ]);
        });
    }
}
