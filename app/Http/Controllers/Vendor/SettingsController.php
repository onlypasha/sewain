<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'profiles_picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        $user = Auth::user();
        $profile = VendorProfiles::where('user_id', $user->id)->firstOrFail();

        $profileData = [
            'owner_name' => $validated['owner_name'],
            'address' => $validated['address'] ?? '',
        ];

        if ($request->hasFile('profiles_picture')) {
            if ($profile->profiles_picture && Storage::disk('public')->exists($profile->profiles_picture)) {
                Storage::disk('public')->delete($profile->profiles_picture);
            }

            $profileData['profiles_picture'] = $request->file('profiles_picture')->store('profiles_pictures', 'public');
        }

        $profile->update($profileData);

        $user->update([
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        return redirect()->route('vendor.settings')->with('success', 'Pengaturan berhasil disimpan');
    }
}
