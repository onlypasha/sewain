<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$status): Response
    {
        if (!in_array($request->user()->role, $status)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini!, Minta admin untuk aktivasi profil');
        }
        return $next($request);
    }
}
