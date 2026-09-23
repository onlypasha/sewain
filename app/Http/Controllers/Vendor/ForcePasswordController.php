<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => $validated['password'],
            'must_change_password' => false,
        ]);

        Swal::success([
            'title' => 'Password Diperbarui',
            'text' => 'Password baru berhasil disimpan. Silakan lanjut ke dashboard.',
        ]);

        return redirect()->route('vendor.dashboard');
    }
}
