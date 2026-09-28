<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use SweetAlert2\Laravel\Swal;

class ForcePasswordController extends Controller
{
    public function edit()
    {
        return view('vendor.force-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => $validated['password'],
            'must_change_password' => false,
        ]);

        Auth::logoutOtherDevices($validated['password']);
        $request->session()->regenerate();

        Swal::success([
            'title' => 'Password Diperbarui',
            'text' => 'Password baru berhasil disimpan. Silakan lanjut ke dashboard.',
        ]);

        return redirect()->route('vendor.dashboard');
    }
}
