<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isSubActive = $user ? $user->isSubscriptionActive() : false;

        $hasAssetAccess = $isSubActive && $user->hasFeatureAccess('asset_management');
        $hasCategoryAccess = $isSubActive && $user->hasFeatureAccess('category_management');
        $hasBookingAccess = $isSubActive && $user->hasFeatureAccess('booking_system');
        $hasVerifikasiAccess = config('sewain.modules.ktp_verification')
            && $isSubActive
            && $user->hasFeatureAccess('verifikasi_ktp');

        $stats = [
            'totalItems' => $hasAssetAccess ? $user->items()->where('status', '!=', 'archived')->count() : 0,
            'totalCategories' => $hasCategoryAccess ? $user->itemsCategories()->count() : 0,
            'totalBookings' => $hasBookingAccess ? $user->bookings()->count() : 0,
            'pendingVerifications' => 0,
        ];

        return view('vendor.dashboard', compact(
            'isSubActive',
            'hasAssetAccess',
            'hasCategoryAccess',
            'hasBookingAccess',
            'hasVerifikasiAccess',
            'stats'
        ));
    }
}
