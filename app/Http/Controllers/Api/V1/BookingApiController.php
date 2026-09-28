<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\Items;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingApiController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function index(Request $request)
    {
        $bookings = Booking::query()
            ->where('customer_id', $request->user()->id)
            ->with(['item', 'vendor'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $bookings->map(fn ($b) => [
                'id' => $b->id,
                'booking_code' => $b->booking_code,
                'status' => $b->status,
                'rental_start' => $b->rental_start,
                'rental_end' => $b->rental_end,
                'total_price' => $b->total_price,
                'item' => $b->item ? ['id' => $b->item->id, 'name' => $b->item->name] : null,
            ]),
            'meta' => [
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'total' => $bookings->total(),
            ],
        ]);
    }

    public function show(Request $request, int $id)
    {
        $booking = Booking::with(['item', 'vendor', 'payments'])->findOrFail($id);
        abort_unless($booking->customer_id === $request->user()->id, 403, 'Bukan booking Anda.');

        return response()->json([
            'data' => [
                'id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'status' => $booking->status,
                'rental_start' => $booking->rental_start,
                'rental_end' => $booking->rental_end,
                'total_price' => $booking->total_price,
                'customer_name' => $booking->customer_name,
                'item' => $booking->item ? ['id' => $booking->item->id, 'name' => $booking->item->name] : null,
                'payments' => $booking->payments->map(fn ($p) => [
                    'id' => $p->id, 'status' => $p->status, 'amount' => $p->amount,
                ]),
            ],
        ]);
    }

    public function store(Request $request, int $id)
    {
        $item = Items::findOrFail($id);

        if ($request->user()->id === $item->vendor_id) {
            abort(403, 'Anda tidak bisa menyewa barang milik sendiri.');
        }

        if ($item->status !== 'available') {
            return response()->json(['message' => 'Item tidak tersedia.'], 422);
        }

        $request->validate([
            'rental_start' => ['required', 'date', 'after_or_equal:today'],
            'rental_end' => ['required', 'date', 'after_or_equal:rental_start'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();

        $booking = $this->bookingService->create([
            'item_id' => $item->id,
            'customer_id' => $user->id,
            'customer_name' => $request->filled('customer_name') ? $request->customer_name : $user->name,
            'customer_phone' => $request->filled('customer_phone') ? $request->customer_phone : $user->phone,
            'customer_email' => $user->email,
            'rental_start' => $request->rental_start,
            'rental_end' => $request->rental_end,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'data' => [
                'id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'status' => $booking->status,
                'rental_start' => $booking->rental_start,
                'rental_end' => $booking->rental_end,
                'total_price' => $booking->total_price,
            ],
        ], 201);
    }

    public function uploadPayment(Request $request, int $id)
    {
        $booking = Booking::findOrFail($id);
        abort_unless($booking->customer_id === $request->user()->id, 403, 'Bukan booking Anda.');

        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $path = $request->file('payment_proof')->store('proofs', 'proofs');

        $payment = BookingPayment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_proof_path' => $path,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return response()->json([
            'data' => ['id' => $payment->id, 'status' => $payment->status],
            'message' => 'Bukti pembayaran berhasil diunggah.',
        ], 201);
    }
}
