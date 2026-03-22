<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasShop
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user === null || $user->shop_id === null) {
            abort(403, 'Your account is not linked to a shop. Contact an administrator or run database migrations.');
        }

        return $next($request);
    }
}
