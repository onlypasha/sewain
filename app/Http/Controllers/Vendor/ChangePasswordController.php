<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('vendor.changepassword');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('vendor.changepassword')->with('success', 'Password berhasil diubah');
    }
}
