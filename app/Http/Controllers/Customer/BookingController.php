<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Items;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Form booking untuk sebuah item.
     */
    public function create(int $itemId)
    {
        $item = Items::with(['vendor.vendorProfiles', 'category'])->findOrFail($itemId);

        return view('storefront.booking-form', compact('item'));
    }

    /**
     * Simpan booking baru.
     */
    public function store(StoreBookingRequest $request, int $itemId)
    {
        $item = Items::findOrFail($itemId);

        // Vendor tidak boleh booking barang sendiri.
        if (Auth::id() === $item->vendor_id) {
            abort(403, 'Anda tidak bisa menyewa barang milik sendiri.');
        }

        // Item harus tersedia.
        if ($item->status !== 'available') {
            return back()
                ->withErrors(['item' => 'Item ini sedang tidak tersedia.'])
                ->withInput();
        }

        $customer = $request->user();

        $booking = $this->bookingService->create([
            'item_id' => $item->id,
            'customer_id' => $customer->id,
            'customer_name' => $request->filled('customer_name') ? $request->customer_name : $customer->name,
            'customer_phone' => $request->filled('customer_phone') ? $request->customer_phone : $customer->phone,
            'customer_email' => $request->filled('customer_email') ? $request->customer_email : $customer->email,
            'rental_start' => $request->rental_start,
            'rental_end' => $request->rental_end,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('customer.bookings')
            ->with('success', 'Booking '.$booking->booking_code.' berhasil dibuat. Menunggu konfirmasi vendor.');
    }

    /**
     * Daftar booking milik customer yang login.
     */
    public function index()
    {
        $bookings = Booking::query()
            ->where('customer_id', Auth::id())
            ->with(['item.category', 'vendor'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings', compact('bookings'));
    }
}
