<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Railway / reverse proxies send X-Forwarded-Proto: https — without this
        // Laravel generates http:// URLs for forms and redirects, Chrome warns on POST.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'shop' => \App\Http\Middleware\EnsureUserHasShop::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
