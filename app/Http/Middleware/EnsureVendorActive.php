<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorActive
{
    /**
     * Paksa status profil vendor diperiksa pada setiap request, bukan hanya
     * saat login, supaya vendor yang dinonaktifkan langsung kehilangan akses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'vendor' && $user->vendorProfiles?->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Akun vendor Anda belum diaktivasi oleh admin.']);
        }

        return $next($request);
    }
}
