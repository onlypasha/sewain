<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $profiles = VendorProfiles::where('user_id', $id)->firstOrFail();

        return view('vendor.settings', compact('profiles'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'owner_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        $profile = VendorProfiles::where('user_id', $user->id)->firstOrFail();

        $profile->update([
            'owner_name' => $validated['owner_name'],
            'address' => $validated['address'] ?? '',
        ]);

        $user->update([
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        return redirect()->route('vendor.settings')->with('success', 'Pengaturan berhasil disimpan');
    }

    public function changepassword()
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
