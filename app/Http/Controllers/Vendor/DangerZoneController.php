<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use SweetAlert2\Laravel\Swal;

class DangerZoneController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->vendorProfiles;
        $subscription = $profile?->latestSubscription();

        return view('vendor.dangerzone', compact('subscription'));
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => $validated['password'],
        ]);

        Auth::logoutOtherDevices($validated['password']);
        $request->session()->regenerate();

        Swal::success([
            'title' => 'Password Berhasil Diubah',
            'text' => 'Kata sandi baru akun Anda telah disimpan. Sesi di perangkat lain telah diakhiri.',
        ]);

        return redirect()->route('vendor.dangerzone');
    }
}
