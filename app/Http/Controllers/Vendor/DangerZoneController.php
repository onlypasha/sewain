<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class DangerZoneController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->vendorProfiles;
        $subscription = $profile ? Subscription::where('vendor_profile_id', $profile->id)->latest()->first() : null;

        return view('vendor.dangerzone', compact('subscription'));
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

        Swal::success([
            'title' => 'Password Berhasil Diubah',
            'text' => 'Kata sandi baru akun Anda telah disimpan.',
        ]);

        return redirect()->route('vendor.dangerzone');
    }

    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        $profile = $user->vendorProfiles;
        $subscription = $profile ? Subscription::where('vendor_profile_id', $profile->id)->latest()->first() : null;

        if ($subscription && $subscription->status === 'active') {
            $subscription->update([
                'status' => 'canceled',
            ]);

            Swal::success([
                'title' => 'Langganan Dibatalkan',
                'text' => 'Perpanjangan otomatis toko Anda telah dinonaktifkan.',
            ]);
        }

        return redirect()->route('vendor.dangerzone');
    }
}
