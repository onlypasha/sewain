<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display the bookings & transactions page.
     */
    public function index(Request $request)
    {
        // TODO: Replace with actual booking model query
        $bookings = collect();

        return view('vendor.bookings', compact('bookings'));
    }
}
