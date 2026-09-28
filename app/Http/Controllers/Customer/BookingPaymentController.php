<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BookingPaymentController extends Controller
{
    /**
     * Customer upload bukti bayar untuk booking miliknya.
     */
    public function store(Request $request, int $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        abort_unless($booking->customer_id === Auth::id(), 403, 'Anda tidak berhak mengunggah bukti untuk booking ini.');

        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $path = $request->file('payment_proof')->store('proofs', 'proofs');

        BookingPayment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_proof_path' => $path,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi vendor.');
    }

    /**
     * Serve bukti bayar untuk customer pemilik booking.
     */
    public function show(int $bookingId): Response
    {
        $booking = Booking::findOrFail($bookingId);

        abort_unless($booking->customer_id === Auth::id(), 403, 'Anda tidak berhak melihat bukti ini.');

        return $this->serveProof($booking);
    }

    protected function serveProof(Booking $booking): Response
    {
        $payment = $booking->payments()->latest()->first();

        abort_unless($payment && $payment->payment_proof_path, 404, 'Bukti pembayaran tidak ditemukan.');

        $disk = Storage::disk('proofs');
        abort_unless($disk->exists($payment->payment_proof_path), 404, 'Bukti pembayaran tidak ditemukan.');

        return response($disk->get($payment->payment_proof_path), 200, [
            'Content-Type' => $disk->mimeType($payment->payment_proof_path) ?: 'image/jpeg',
            'Content-Disposition' => 'inline; filename="bukti-bayar"',
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}