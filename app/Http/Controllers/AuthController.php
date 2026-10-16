<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            }

            if ($user->role === 'vendor') {
                // Status diperiksa lebih dulu: vendor nonaktif tidak boleh
                // masuk walau sudah pernah mengganti password.
                if ($user->vendorProfiles?->status === 'active') {
                    if ($user->must_change_password) {
                        return redirect()->route('vendor.force-password');
                    }

                    return redirect()->route('vendor.dashboard');
                }

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->back()->withErrors(['email' => 'Akun vendor Anda belum diaktivasi oleh admin.']);
            }

            // Role yang belum dirilis (mis. customer) tidak diberi sesi.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->back()->withErrors(['email' => 'Akun ini belum dapat digunakan untuk masuk.']);
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
