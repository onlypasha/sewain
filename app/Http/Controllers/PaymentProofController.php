<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PaymentProofController extends Controller
{
    /**
     * Serve bukti pembayaran dengan cek kepemilikan.
     * Hanya superadmin atau vendor pemilik purchase yang boleh melihat.
     */
    public function show(Request $request, int $id): Response
    {
        $purchase = SubscriptionPurchase::with('subscription.vendorProfile')->findOrFail($id);

        $isSuperadmin = Auth::user()->role === 'superadmin';
        $isOwner = $purchase->subscription?->vendorProfile?->user_id === Auth::id();

        abort_unless($isSuperadmin || $isOwner, 403, 'Anda tidak memiliki akses ke bukti pembayaran ini!');

        abort_unless($purchase->payment_proof_path, 404, 'Bukti pembayaran tidak ditemukan.');

        $disk = Storage::disk('proofs');

        abort_unless($disk->exists($purchase->payment_proof_path), 404, 'Bukti pembayaran tidak ditemukan.');

        $contents = $disk->get($purchase->payment_proof_path);
        $mimeType = $disk->mimeType($purchase->payment_proof_path) ?: 'image/jpeg';

        return response($contents, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="payment-proof"',
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}