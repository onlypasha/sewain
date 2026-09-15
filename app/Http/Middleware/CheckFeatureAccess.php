<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckFeatureAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'vendor' && ! $user->hasFeatureAccess($featureKey)) {
            // Redirect back with an error if accessed directly via URL
            return redirect()->route('vendor.dashboard')->with('error', 'Paket langganan Anda tidak memiliki akses ke fitur ini. Silakan upgrade paket langganan Anda.');
        }

        return $next($request);
    }
}
