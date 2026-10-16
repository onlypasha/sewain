<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $plan = SubscriptionPlan::where('is_active', true)->findOrFail($request->subscription_plan_id);
        $subscription = $profile->latestSubscription();

        // Pergantian paket saat langganan masih berjalan ditangani admin
        // supaya sisa masa aktif yang sudah dibayar tidak hilang.
        if ($subscription && $subscription->isActive() && $subscription->subscription_plan_id !== $plan->id) {
            Swal::error([
                'title' => 'Hubungi Admin',
                'text' => 'Paket Anda saat ini masih aktif. Untuk berpindah paket, silakan hubungi Superadmin.',
            ]);

            return redirect()->back();
        }

        if ($subscription && $subscription->purchases()->where('status', 'pending')->exists()) {
            Swal::error([
                'title' => 'Masih Menunggu Verifikasi',
                'text' => 'Pembayaran sebelumnya belum diverifikasi. Tunggu konfirmasi Superadmin sebelum mengirim ulang.',
            ]);

            return redirect()->back();
        }

        $proofPath = $request->file('payment_proof')->store('proofs', 'proofs');

        DB::transaction(function () use ($profile, $plan, $proofPath) {
            $subscription = $profile->latestSubscription() ?? Subscription::create([
                'vendor_profile_id' => $profile->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'inactive',
            ]);

            SubscriptionPurchase::create([
                'subscription_id' => $subscription->id,
                'subscription_plan_id' => $plan->id,
                'amount' => $plan->price,
                'payment_proof_path' => $proofPath,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);
        });

        Swal::success([
            'title' => 'Pembayaran Terkirim',
            'text' => 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi Superadmin.',
        ]);

        return redirect()->route('vendor.subscription');
    }
}
