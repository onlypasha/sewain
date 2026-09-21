<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Items;
use App\Models\ItemsCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Tampilkan linimasa kalender stok barang rental vendor.
     * Mendukung 2 mode tampilan:
     * - 'timeline': Linimasa Gantt seluruh aset (Opsi B)
     * - 'grid': Kalender kotak bulanan per barang (Opsi A)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Tampilan mode: 'timeline' (default) atau 'grid'
        $viewMode = $request->input('view', 'timeline');
        if (! in_array($viewMode, ['timeline', 'grid'])) {
            $viewMode = 'timeline';
        }

        // Validasi dan set bulan & tahun
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        if ($month < 1 || $month > 12) {
            $month = now()->month;
        }

        if ($year < 2020 || $year > 2035) {
            $year = now()->year;
        }

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();
        $daysInMonth = $startDate->daysInMonth;

        // Offset hari pertama dalam minggu untuk kalender kotak (Senin = 0, Minggu = 6)
        // dayOfWeekIso: 1 (Senin) s/d 7 (Minggu)
        $firstDayOffset = $startDate->dayOfWeekIso - 1;

        // Navigasi bulan
        $prevMonthDate = $startDate->copy()->subMonth();
        $nextMonthDate = $startDate->copy()->addMonth();

        $prevMonth = $prevMonthDate->month;
        $prevYear = $prevMonthDate->year;
        $nextMonth = $nextMonthDate->month;
        $nextYear = $nextMonthDate->year;

        // Daftar nama hari dan bulan bahasa Indonesia
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $dayNamesShort = [
            0 => 'Min', 1 => 'Sen', 2 => 'Sel', 3 => 'Rab',
            4 => 'Kam', 5 => 'Jum', 6 => 'Sab',
        ];

        $currentMonthLabel = ($monthNames[$month] ?? $startDate->format('F')).' '.$year;

        // Kategori untuk filter
        $categories = ItemsCategory::where('vendor_id', $user->id)->orderBy('name')->get();

        // Query seluruh aset milik vendor
        $selectedCategoryId = $request->input('category_id');

        $itemsQuery = Items::with(['category', 'bookings' => function ($q) use ($startDate, $endDate) {
            $q->where('rental_start', '<=', $endDate->toDateString())
                ->where('rental_end', '>=', $startDate->toDateString())
                ->where('status', '!=', 'cancelled')
                ->orderBy('rental_start');
        }])->where('vendor_id', $user->id);

        if ($selectedCategoryId) {
            $itemsQuery->where('items_category_id', $selectedCategoryId);
        }

        $items = $itemsQuery->orderBy('name')->get();

        // Pilih item aktif untuk tampilan kalender kotak (Opsi A)
        $selectedItemId = $request->input('item_id');
        $selectedItem = null;

        if ($items->isNotEmpty()) {
            if ($selectedItemId) {
                $selectedItem = $items->firstWhere('id', $selectedItemId) ?? $items->first();
            } else {
                $selectedItem = $items->first();
            }
            $selectedItemId = $selectedItem->id;
        }

        // Siapkan struktur hari dalam bulan
        $days = [];
        $todayDate = now()->toDateString();
        $selectedItemBookings = $selectedItem ? $selectedItem->bookings : collect();

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $currentDay = Carbon::createFromDate($year, $month, $d);
            $dayOfWeek = $currentDay->dayOfWeek; // 0 = Minggu, 6 = Sabtu
            $dateStr = $currentDay->toDateString();

            // Cek booking untuk item terpilih (untuk Opsi A)
            $bookingOnDay = $selectedItemBookings->first(function ($b) use ($dateStr) {
                $bStart = Carbon::parse($b->rental_start)->toDateString();
                $bEnd = Carbon::parse($b->rental_end)->toDateString();

                return $bStart <= $dateStr && $bEnd >= $dateStr;
            });

            $days[] = [
                'day' => $d,
                'date' => $dateStr,
                'day_name' => $dayNamesShort[$dayOfWeek],
                'is_weekend' => ($dayOfWeek === 0 || $dayOfWeek === 6),
                'is_today' => ($dateStr === $todayDate),
                'is_booked' => ! is_null($bookingOnDay),
                'booking' => $bookingOnDay,
            ];
        }

        // Hitung metrik ringkasan
        $totalItemsCount = $items->count();

        // Booking yang aktif hari ini
        $activeBookingsToday = Booking::where('vendor_id', $user->id)
            ->where('rental_start', '<=', $todayDate)
            ->where('rental_end', '>=', $todayDate)
            ->where('status', '!=', 'cancelled')
            ->count();

        // Total booking bulan ini
        $totalBookingsThisMonth = Booking::where('vendor_id', $user->id)
            ->where('rental_start', '<=', $endDate->toDateString())
            ->where('rental_end', '>=', $startDate->toDateString())
            ->where('status', '!=', 'cancelled')
            ->count();

        // Ambil semua booking untuk rendering modal detail
        $allMonthBookings = $items->pluck('bookings')->flatten()->unique('id');

        return view('vendor.calendar', compact(
            'items',
            'categories',
            'days',
            'daysInMonth',
            'firstDayOffset',
            'month',
            'year',
            'prevMonth',
            'prevYear',
            'nextMonth',
            'nextYear',
            'currentMonthLabel',
            'selectedCategoryId',
            'selectedItemId',
            'selectedItem',
            'viewMode',
            'totalItemsCount',
            'activeBookingsToday',
            'totalBookingsThisMonth',
            'allMonthBookings'
        ));
    }
}
