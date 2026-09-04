<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'vendor' && ! $user->isSubscriptionActive()) {
            Swal::error([
                'title' => 'Akses Dibatasi',
                'text' => 'Langganan Anda tidak aktif. Menu lain pada platform saat ini terkunci.',
            ]);

            return redirect()->route('vendor.dashboard');
        }

        return $next($request);
    }
}
