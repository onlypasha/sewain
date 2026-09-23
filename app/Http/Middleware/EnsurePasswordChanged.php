<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password) {
            if ($request->routeIs('vendor.force-password*') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('vendor.force-password');
        }

        return $next($request);
    }
}
