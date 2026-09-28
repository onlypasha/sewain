<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function __construct(
        protected BookingStatusService $statusService
    ) {}

    /**
     * Display the bookings & transactions page.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::with(['item', 'customer'])
            ->where('vendor_id', Auth::id())
            ->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'active', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(20);

        return view('vendor.bookings', compact('bookings'));
    }

    /**
     * Konfirmasi booking (pending → confirmed).
     */
    public function confirm(int $id)
    {
        $booking = $this->findOwnedBooking($id);

        try {
            $this->statusService->transition($booking, 'confirmed', Auth::id());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Booking '.$booking->booking_code.' dikonfirmasi.');
    }

    /**
     * Tolak booking (pending → cancelled).
     */
    public function reject(int $id)
    {
        $booking = $this->findOwnedBooking($id);

        try {
            $this->statusService->transition($booking, 'cancelled', Auth::id());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Booking '.$booking->booking_code.' ditolak.');
    }

    /**
     * Batalkan booking yang sudah confirmed (confirmed → cancelled).
     */
    public function cancel(int $id)
    {
        $booking = $this->findOwnedBooking($id);

        try {
            $this->statusService->transition($booking, 'cancelled', Auth::id());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Booking '.$booking->booking_code.' dibatalkan.');
    }

    /**
     * Tandai booking selesai (active → completed).
     */
    public function complete(int $id)
    {
        $booking = $this->findOwnedBooking($id);

        try {
            $this->statusService->transition($booking, 'completed', Auth::id());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Booking '.$booking->booking_code.' ditandai selesai.');
    }

    /**
     * Verifikasi bukti bayar → booking jadi active.
     */
    public function verifyPayment(int $id)
    {
        $booking = $this->findOwnedBooking($id);

        $payment = $booking->payments()->latest()->first();

        if (! $payment || $payment->status !== 'pending') {
            return back()->withErrors(['payment' => 'Tidak ada bukti pembayaran yang menunggu verifikasi.']);
        }

        if ($booking->status !== 'confirmed') {
            return back()->withErrors(['status' => 'Booking belum dikonfirmasi.']);
        }

        $payment->update([
            'status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        $this->statusService->transition($booking, 'active', Auth::id());

        return back()->with('success', 'Pembayaran diverifikasi. Booking '.$booking->booking_code.' sekarang aktif.');
    }

    /**
     * Tolak bukti bayar (booking tetap confirmed).
     */
    public function rejectPayment(int $id)
    {
        $booking = $this->findOwnedBooking($id);

        $payment = $booking->payments()->latest()->first();

        if (! $payment || $payment->status !== 'pending') {
            return back()->withErrors(['payment' => 'Tidak ada bukti pembayaran yang menunggu verifikasi.']);
        }

        $payment->update([
            'status' => 'rejected',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran ditolak. Menunggu customer mengunggah ulang.');
    }

    /**
     * Serve bukti bayar untuk vendor pemilik booking.
     */
    public function showPaymentProof(int $id): \Symfony\Component\HttpFoundation\Response
    {
        $booking = $this->findOwnedBooking($id);

        $payment = $booking->payments()->latest()->first();

        abort_unless($payment && $payment->payment_proof_path, 404, 'Bukti pembayaran tidak ditemukan.');

        $disk = \Illuminate\Support\Facades\Storage::disk('proofs');
        abort_unless($disk->exists($payment->payment_proof_path), 404, 'Bukti pembayaran tidak ditemukan.');

        return response($disk->get($payment->payment_proof_path), 200, [
            'Content-Type' => $disk->mimeType($payment->payment_proof_path) ?: 'image/jpeg',
            'Content-Disposition' => 'inline; filename="bukti-bayar"',
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Cari booking milik vendor yang login, atau 403.
     */
    protected function findOwnedBooking(int $id): Booking
    {
        $booking = Booking::findOrFail($id);

        if ($booking->vendor_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses booking ini.');
        }

        return $booking;
    }
}