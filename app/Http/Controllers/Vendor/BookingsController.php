<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    /**
     * Display the bookings & transactions page.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::with('item')
            ->where('vendor_id', Auth::id())
            ->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'active', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $bookings = $query->get();

        return view('vendor.bookings', compact('bookings'));
    }
}
