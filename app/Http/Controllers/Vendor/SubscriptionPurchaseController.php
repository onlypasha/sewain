<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class SubscriptionPurchaseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subscription_plan_id' => ['required', 'exists:subscription_plans,id'],
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $user = Auth::user();
        $profile = $user->vendorProfiles;

        if (! $profile) {
            Swal::error([
                'title' => 'Gagal',
                'text' => 'Profil vendor tidak ditemukan.',
            ]);

            return redirect()->back();
        }

        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);

        $subscription = Subscription::firstOrCreate(
            ['vendor_profile_id' => $profile->id],
            [
                'subscription_plan_id' => $plan->id,
                'status' => 'inactive',
            ]
        );

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        SubscriptionPurchase::create([
            'subscription_id' => $subscription->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $plan->price,
            'payment_proof_path' => $proofPath,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        Swal::success([
            'title' => 'Pembayaran Terkirim',
            'text' => 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi Superadmin.',
        ]);

        return redirect()->back();
    }
}
