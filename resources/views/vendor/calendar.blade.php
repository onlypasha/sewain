@extends('vendor.layout')

@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Kalender Stok &amp; Jadwal Sewa</h1>
                <p class="text-slate-500 text-xs mt-0.5">
                    Pantau ketersediaan dan linimasa penyewaan aset toko Anda dalam dua pilihan tampilan.
                </p>
            </div>

            {{-- Controls: View Switcher, Category Filter, Month Navigation --}}
            <div class="flex flex-wrap items-center gap-2.5">
                {{-- VIEW SWITCH BUTTON (Gantt vs Kotak Bulanan) --}}
                <div class="inline-flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 shadow-2xs">
                    <button type="button" onclick="switchCalendarView('timeline')" id="btn-view-timeline"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 {{ $viewMode === 'timeline' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Linimasa Gantt</span>
                    </button>
                    <button type="button" onclick="switchCalendarView('grid')" id="btn-view-grid"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 {{ $viewMode === 'grid' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Kalender Kotak</span>
                    </button>
                </div>

                {{-- Category Filter (Hanya untuk Timeline) --}}
                <div id="filter-category-wrapper" class="{{ $viewMode === 'grid' ? 'hidden' : '' }}">
                    <form method="GET" action="{{ route('vendor.calendar') }}" id="form-category-filter">
                        <input type="hidden" name="view" value="{{ $viewMode }}">
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="year" value="{{ $year }}">

                        <select name="category_id" onchange="this.form.submit()"
                            class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-brand-500 shadow-xs cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $selectedCategoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                {{-- Month Controls --}}
                <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-xs">
                    <a href="{{ route('vendor.calendar', ['view' => $viewMode, 'month' => $prevMonth, 'year' => $prevYear, 'category_id' => $selectedCategoryId, 'item_id' => $selectedItemId]) }}"
                        class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                        title="Bulan sebelumnya" aria-label="Bulan sebelumnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>

                    <span class="px-3 text-xs font-bold text-slate-900 font-heading select-none min-w-[130px] text-center">
                        {{ $currentMonthLabel }}
                    </span>

                    <a href="{{ route('vendor.calendar', ['view' => $viewMode, 'month' => $nextMonth, 'year' => $nextYear, 'category_id' => $selectedCategoryId, 'item_id' => $selectedItemId]) }}"
                        class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                        title="Bulan berikutnya" aria-label="Bulan berikutnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- Today Quick Jump --}}
                @if ($month !== now()->month || $year !== now()->year)
                    <a href="{{ route('vendor.calendar', ['view' => $viewMode, 'month' => now()->month, 'year' => now()->year, 'category_id' => $selectedCategoryId, 'item_id' => $selectedItemId]) }}"
                        class="px-3 py-2 bg-brand-500 text-white rounded-xl text-xs font-bold hover:bg-brand-600 transition-all active:scale-[0.98] shadow-xs">
                        Hari Ini
                    </a>
                @endif
            </div>
        </div>

        {{-- Metrics Summary Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Total Aset</span>
                    <span
                        class="text-2xl font-extrabold text-slate-900 font-heading leading-none">{{ $totalItemsCount }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Dalam katalog toko</span>
                </div>
                <div
                    class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-brand-600 font-mono font-bold uppercase tracking-wider block mb-1">Disewa
                        Hari Ini</span>
                    <span
                        class="text-2xl font-extrabold text-brand-600 font-heading leading-none">{{ $activeBookingsToday }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Aset sedang di luar</span>
                </div>
                <div
                    class="w-11 h-11 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center border border-brand-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span
                        class="text-[10px] text-emerald-600 font-mono font-bold uppercase tracking-wider block mb-1">Booking
                        Bulan Ini</span>
                    <span
                        class="text-2xl font-extrabold text-emerald-600 font-heading leading-none">{{ $totalBookingsThisMonth }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Jadwal sewa tercatat</span>
                </div>
                <div
                    class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Aset Siap
                        Sewa</span>
                    <span class="text-2xl font-extrabold text-emerald-600 font-heading leading-none">
                        {{ max(0, $totalItemsCount - $activeBookingsToday) }}
                    </span>
                    <span class="text-xs text-slate-500 block mt-1">Tersedia di toko</span>
                </div>
                <div
                    class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center border border-slate-200 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Status Legend & Helper --}}
        <div
            class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex flex-wrap items-center gap-4 text-slate-600">
                <span class="font-bold text-slate-800">Petunjuk:</span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-md bg-brand-500"></span>
                    <span>Sedang Disewa (Aktif)</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-md bg-amber-500"></span>
                    <span>Menunggu (Pending)</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-md bg-emerald-600"></span>
                    <span>Selesai</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-md border border-dashed border-slate-300 bg-slate-50"></span>
                    <span>Slot Kosong (Tersedia)</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                    <span>Hari Ini</span>
                </span>
            </div>

            <div class="text-[11px] text-slate-400 font-mono">
                * Klik jadwal sewa untuk melihat rincian pemesanan.
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- VIEW MODE 1: LINIMASA GANTT (OPSI B) --}}
        {{-- ========================================================================= --}}
        <div id="container-view-timeline" class="{{ $viewMode === 'timeline' ? '' : 'hidden' }}">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                @if ($items->isEmpty())
                    <div class="py-16 px-6 text-center">
                        <div
                            class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Belum Ada Aset Terdaftar</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            Tambahkan barang rental Anda di menu Katalog &amp; Stok Aset untuk melihat linimasa jadwal sewa.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('vendor.items') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-xl text-xs font-bold hover:bg-brand-600 transition-all active:scale-[0.98]">
                                Kelola Katalog Aset
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <div class="min-w-[{{ 260 + $daysInMonth * 38 }}px]">

                            {{-- TIMELINE HEADER ROW --}}
                            <div class="flex border-b border-slate-200 bg-slate-50/90 sticky top-0 z-10 backdrop-blur">
                                {{-- Sticky Asset Header Column --}}
                                <div
                                    class="w-64 shrink-0 px-4 py-3.5 border-r border-slate-200 font-mono text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Aset Rental ({{ $items->count() }})
                                </div>

                                {{-- Date Columns --}}
                                <div class="flex-1 grid"
                                    style="grid-template-columns: repeat({{ $daysInMonth }}, minmax(38px, 1fr));">
                                    @foreach ($days as $dayInfo)
                                        <div
                                            class="py-2 px-1 text-center border-r border-slate-100 last:border-r-0 flex flex-col items-center justify-center {{ $dayInfo['is_today'] ? 'bg-rose-50/80 font-bold' : ($dayInfo['is_weekend'] ? 'bg-slate-100/60' : '') }}">
                                            <span
                                                class="text-[10px] font-mono leading-none {{ $dayInfo['is_today'] ? 'text-rose-600 font-bold' : ($dayInfo['is_weekend'] ? 'text-slate-400' : 'text-slate-400') }}">
                                                {{ $dayInfo['day_name'] }}
                                            </span>
                                            <span
                                                class="text-xs font-mono mt-1 leading-none {{ $dayInfo['is_today'] ? 'w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center' : ($dayInfo['is_weekend'] ? 'text-slate-600 font-semibold' : 'text-slate-800 font-semibold') }}">
                                                {{ sprintf('%02d', $dayInfo['day']) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- TIMELINE ITEM ROWS --}}
                            <div class="divide-y divide-slate-100">
                                @foreach ($items as $item)
                                    @php
                                        $itemBookings = $item->bookings ?? collect();
                                    @endphp

                                    <div class="flex hover:bg-slate-50/40 transition-colors group">
                                        {{-- Left Column: Asset Info --}}
                                        <div
                                            class="w-64 shrink-0 px-4 py-3.5 border-r border-slate-200 flex items-center gap-3 bg-white">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden">
                                                @if ($item->items_photo)
                                                    <img src="{{ Storage::disk('b2')->temporaryUrl($item->items_photo, now()->addMinutes(5)) }}"
                                                        alt="{{ $item->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="font-display font-bold text-slate-500 text-xs">
                                                        {{ strtoupper(substr($item->name, 0, 2)) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="truncate">
                                                <div class="font-bold text-slate-900 text-xs truncate leading-snug"
                                                    title="{{ $item->name }}">
                                                    {{ $item->name }}
                                                </div>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    @if ($item->category)
                                                        <span class="text-[10px] text-slate-500 font-medium truncate">
                                                            {{ $item->category->name }}
                                                        </span>
                                                        <span class="text-slate-300">&bull;</span>
                                                    @endif
                                                    <span class="text-[10px] font-mono text-emerald-600 font-semibold">
                                                        Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hr
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Right Column: Calendar Grid & Booking Bars --}}
                                        <div class="flex-1 relative min-h-[58px] flex items-center">
                                            {{-- Background Day Grid Lines --}}
                                            <div class="absolute inset-0 grid pointer-events-none"
                                                style="grid-template-columns: repeat({{ $daysInMonth }}, minmax(38px, 1fr));">
                                                @foreach ($days as $dayInfo)
                                                    <div
                                                        class="border-r border-slate-100 last:border-r-0 h-full {{ $dayInfo['is_today'] ? 'bg-rose-50/20' : ($dayInfo['is_weekend'] ? 'bg-slate-50/50' : '') }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Foreground Booking Tracks --}}
                                            <div class="w-full grid py-2 relative z-0"
                                                style="grid-template-columns: repeat({{ $daysInMonth }}, minmax(38px, 1fr));">
                                                @forelse ($itemBookings as $booking)
                                                    @php
                                                        $start = Carbon\Carbon::parse($booking->rental_start);
                                                        $end = Carbon\Carbon::parse($booking->rental_end);

                                                        $startDay =
                                                            $start->year < $year ||
                                                            ($start->year == $year && $start->month < $month)
                                                                ? 1
                                                                : (int) $start->day;

                                                        $endDay =
                                                            $end->year > $year ||
                                                            ($end->year == $year && $end->month > $month)
                                                                ? $daysInMonth
                                                                : (int) $end->day;

                                                        $startDay = max(1, min($daysInMonth, $startDay));
                                                        $endDay = max(1, min($daysInMonth, $endDay));

                                                        $barClasses = match ($booking->status) {
                                                            'pending' => 'bg-amber-500 text-white hover:bg-amber-600',
                                                            'completed'
                                                                => 'bg-emerald-600 text-white hover:bg-emerald-700',
                                                            'confirmed'
                                                                => 'bg-indigo-600 text-white hover:bg-indigo-700',
                                                            default => 'bg-brand-500 text-white hover:bg-brand-600',
                                                        };
                                                    @endphp

                                                    <div style="grid-column: {{ $startDay }} / {{ $endDay + 1 }};"
                                                        onclick="detail_booking_modal_{{ $booking->id }}.showModal()"
                                                        class="mx-1 h-8 rounded-lg px-2 flex items-center justify-between text-xs font-semibold cursor-pointer shadow-xs transition-all active:scale-[0.98] select-none {{ $barClasses }}"
                                                        title="Pesanan: {{ $booking->customer_name }} ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})">

                                                        <span
                                                            class="truncate text-[11px] font-medium flex items-center gap-1.5">
                                                            <svg class="w-3 h-3 shrink-0 opacity-80" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            <span class="truncate">{{ $booking->customer_name }}</span>
                                                        </span>

                                                        <span
                                                            class="text-[10px] font-mono opacity-80 shrink-0 ml-1 hidden sm:inline">
                                                            {{ $start->diffInDays($end) }} hr
                                                        </span>
                                                    </div>
                                                @empty
                                                    <div
                                                        class="col-span-full h-8 flex items-center px-4 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <span class="text-[11px] text-slate-400 font-mono">Slot siap
                                                            disewa</span>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- VIEW MODE 2: KALENDER KOTAK BULANAN (OPSI A PER BARANG) --}}
        {{-- ========================================================================= --}}
        <div id="container-view-grid" class="{{ $viewMode === 'grid' ? '' : 'hidden' }}">
            @if ($items->isEmpty())
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs py-16 px-6 text-center">
                    <div
                        class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Aset Terdaftar</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Tambahkan barang rental Anda terlebih dahulu untuk melihat kalender bulanan per unit.
                    </p>
                </div>
            @else
                {{-- Asset Selector Toolbar & Profile Card --}}
                <div
                    class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-4">
                    <div class="flex items-center gap-3.5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($selectedItem && $selectedItem->items_photo)
                                <img src="{{ Storage::disk('b2')->temporaryUrl($item->items_photo, now()->addMinutes(5)) }}"
                                    alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="font-display font-bold text-slate-500 text-sm">
                                    {{ strtoupper(substr($selectedItem?->name ?? 'A', 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-slate-900 text-sm font-heading">
                                    {{ $selectedItem?->name ?? 'Pilih Aset' }}</h3>
                                @if ($selectedItem?->category)
                                    <span
                                        class="badge badge-xs bg-slate-100 text-slate-600 border border-slate-200">{{ $selectedItem->category->name }}</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Tarif: <span class="font-mono font-bold text-emerald-600">Rp
                                    {{ number_format($selectedItem?->price_per_day ?? 0, 0, ',', '.') }} / hari</span>
                                &bull;
                                <span class="text-slate-400">Total sewa bulan ini:
                                    {{ $selectedItem?->bookings->count() ?? 0 }} jadwal</span>
                            </p>
                        </div>
                    </div>

                    {{-- Item Dropdown Switcher --}}
                    <div class="w-full md:w-auto flex items-center gap-2">
                        <label for="select-grid-item" class="text-xs font-bold text-slate-600 shrink-0">Pilih
                            Aset:</label>
                        <select id="select-grid-item" onchange="changeGridItem(this.value)"
                            class="w-full md:w-64 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-brand-500 cursor-pointer">
                            @foreach ($items as $itm)
                                <option value="{{ $itm->id }}" {{ $selectedItemId == $itm->id ? 'selected' : '' }}>
                                    {{ $itm->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Month Grid Box (7 Columns: Senin - Minggu) --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                    {{-- 7 Days Header --}}
                    <div
                        class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 text-center text-xs font-mono font-bold">
                        <div class="py-3 text-slate-600">Senin</div>
                        <div class="py-3 text-slate-600">Selasa</div>
                        <div class="py-3 text-slate-600">Rabu</div>
                        <div class="py-3 text-slate-600">Kamis</div>
                        <div class="py-3 text-slate-600">Jumat</div>
                        <div class="py-3 text-slate-400 bg-slate-100/50">Sabtu</div>
                        <div class="py-3 text-slate-400 bg-slate-100/50">Minggu</div>
                    </div>

                    {{-- Month Grid Cells --}}
                    <div class="grid grid-cols-7 divide-x divide-y divide-slate-100">
                        {{-- Offset blanks before day 1 --}}
                        @for ($i = 0; $i < $firstDayOffset; $i++)
                            <div class="min-h-[105px] p-2 bg-slate-50/40 text-slate-300"></div>
                        @endfor

                        {{-- Day Cells --}}
                        @foreach ($days as $dayInfo)
                            @php
                                $bkg = $dayInfo['booking'];
                                $isBooked = $dayInfo['is_booked'] && $bkg;
                            @endphp

                            <div
                                class="min-h-[105px] p-2.5 flex flex-col justify-between transition-colors relative {{ $dayInfo['is_today'] ? 'bg-rose-50/40' : ($dayInfo['is_weekend'] ? 'bg-slate-50/30' : 'bg-white hover:bg-slate-50/60') }}">
                                {{-- Date Number Row --}}
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-xs font-mono font-bold {{ $dayInfo['is_today'] ? 'w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center text-[11px]' : ($dayInfo['is_weekend'] ? 'text-slate-400' : 'text-slate-800') }}">
                                        {{ sprintf('%02d', $dayInfo['day']) }}
                                    </span>

                                    @if ($dayInfo['is_today'])
                                        <span class="text-[9px] font-mono font-bold text-rose-600 uppercase">Hari
                                            Ini</span>
                                    @endif
                                </div>

                                {{-- Date Content / Booking Card --}}
                                <div class="mt-2 flex-1 flex flex-col justify-end">
                                    @if ($isBooked)
                                        @php
                                            $cardBg = match ($bkg->status) {
                                                'pending' => 'bg-amber-50 border-amber-200 text-amber-900',
                                                'completed' => 'bg-emerald-50 border-emerald-200 text-emerald-900',
                                                'confirmed' => 'bg-indigo-50 border-indigo-200 text-indigo-900',
                                                default => 'bg-brand-50 border-brand-200 text-brand-900',
                                            };
                                            $indicatorBg = match ($bkg->status) {
                                                'pending' => 'bg-amber-500',
                                                'completed' => 'bg-emerald-600',
                                                'confirmed' => 'bg-indigo-600',
                                                default => 'bg-brand-500',
                                            };
                                        @endphp

                                        <div onclick="detail_booking_modal_{{ $bkg->id }}.showModal()"
                                            class="p-2 rounded-xl border text-[11px] font-semibold cursor-pointer shadow-2xs hover:shadow-xs transition-all active:scale-[0.98] {{ $cardBg }}"
                                            title="Klik untuk detail: {{ $bkg->customer_name }}">
                                            <div class="flex items-center gap-1.5">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full {{ $indicatorBg }} shrink-0"></span>
                                                <span class="truncate font-bold">{{ $bkg->customer_name }}</span>
                                            </div>
                                            <div class="text-[10px] opacity-75 font-mono mt-0.5 truncate">
                                                #{{ $bkg->booking_code }}
                                            </div>
                                        </div>
                                    @else
                                        {{-- Slot Kosong / Ready --}}
                                        <div
                                            class="py-1 px-1.5 rounded-lg text-[10px] font-mono text-slate-300 text-center select-none group">
                                            <span>Tersedia</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        {{-- Trailing empty cells to fill the row (if needed) --}}
                        @php
                            $totalCells = $firstDayOffset + $daysInMonth;
                            $trailing = (7 - ($totalCells % 7)) % 7;
                        @endphp
                        @for ($j = 0; $j < $trailing; $j++)
                            <div class="min-h-[105px] p-2 bg-slate-50/40 text-slate-300"></div>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

    </div>

    {{-- DETAIL BOOKING MODALS (READ ONLY) --}}
    @foreach ($allMonthBookings as $booking)
        <dialog id="detail_booking_modal_{{ $booking->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Rincian Booking</h3>
                <p class="text-xs text-slate-500 mb-6">Informasi jadwal dan detail penyewaan aset.</p>

                <div class="space-y-4 text-xs">
                    {{-- ID & Status --}}
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-3 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-mono uppercase tracking-wider text-[10px]">ID Booking</span>
                            <span class="font-mono font-bold text-slate-900">#{{ $booking->booking_code }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-mono uppercase tracking-wider text-[10px]">Status</span>
                            @switch($booking->status)
                                @case('pending')
                                    <x-util.badge variant="warning" size="xs" class="font-mono">Menunggu
                                        Konfirmasi</x-util.badge>
                                @break

                                @case('confirmed')
                                    <x-util.badge variant="info" size="xs" class="font-mono">Dikonfirmasi</x-util.badge>
                                @break

                                @case('completed')
                                    <x-util.badge variant="success" size="xs" class="font-mono">Selesai</x-util.badge>
                                @break

                                @case('cancelled')
                                    <x-util.badge variant="error" size="xs" class="font-mono">Dibatalkan</x-util.badge>
                                @break

                                @default
                                    <x-util.badge variant="primary" size="xs" class="font-mono">Sedang
                                        Berjalan</x-util.badge>
                            @endswitch
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-2.5 border border-slate-100">
                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] font-mono">Penyewa</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Nama</span>
                            <span class="font-bold text-slate-900">{{ $booking->customer_name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Nomor Telepon</span>
                            <span
                                class="font-mono font-bold text-slate-700">{{ $booking->customer_phone ?? 'Tidak dicantumkan' }}</span>
                        </div>
                        @if ($booking->customer_email)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Email</span>
                                <span class="font-mono text-slate-700">{{ $booking->customer_email }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Rental Item & Dates --}}
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-2.5 border border-slate-100">
                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] font-mono">Jadwal Sewa
                        </h4>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Barang</span>
                            <span class="font-bold text-slate-900">{{ $booking->item?->name ?? 'Aset' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Periode Sewa</span>
                            <span class="font-mono font-bold text-slate-700">
                                {{ Carbon\Carbon::parse($booking->rental_start)->format('d M Y') }} s/d
                                {{ Carbon\Carbon::parse($booking->rental_end)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Durasi</span>
                            <span class="font-mono font-bold text-brand-600">
                                {{ Carbon\Carbon::parse($booking->rental_start)->diffInDays(Carbon\Carbon::parse($booking->rental_end)) }}
                                Hari
                            </span>
                        </div>
                        <div class="border-t border-slate-200 pt-2.5 flex items-center justify-between">
                            <span class="font-bold text-slate-700">Total Biaya</span>
                            <span class="font-mono font-extrabold text-emerald-600 text-sm">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Notes if any --}}
                    @if ($booking->notes)
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] font-mono mb-1">
                                Catatan</h4>
                            <p class="text-slate-600 text-xs leading-relaxed">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- Close Button --}}
                <div class="pt-5 flex items-center justify-end border-t border-slate-100 mt-5">
                    <button type="button" onclick="detail_booking_modal_{{ $booking->id }}.close()"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </dialog>
    @endforeach

    {{-- JAVASCRIPT SWITCHER LOGIC --}}
    <script>
        function switchCalendarView(mode) {
            const containerTimeline = document.getElementById('container-view-timeline');
            const containerGrid = document.getElementById('container-view-grid');
            const btnTimeline = document.getElementById('btn-view-timeline');
            const btnGrid = document.getElementById('btn-view-grid');
            const categoryFilter = document.getElementById('filter-category-wrapper');

            if (mode === 'timeline') {
                containerTimeline.classList.remove('hidden');
                containerGrid.classList.add('hidden');
                if (categoryFilter) categoryFilter.classList.remove('hidden');

                btnTimeline.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
                btnTimeline.classList.remove('text-slate-500');

                btnGrid.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
                btnGrid.classList.add('text-slate-500');
            } else {
                containerGrid.classList.remove('hidden');
                containerTimeline.classList.add('hidden');
                if (categoryFilter) categoryFilter.classList.add('hidden');

                btnGrid.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
                btnGrid.classList.remove('text-slate-500');

                btnTimeline.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
                btnTimeline.classList.add('text-slate-500');
            }

            // Simpan status view di URL tanpa reload halaman penuh
            const url = new URL(window.location);
            url.searchParams.set('view', mode);
            window.history.replaceState({}, '', url);

            // Update form input hidden bila ada
            const hiddenViewInput = document.querySelector('input[name="view"]');
            if (hiddenViewInput) hiddenViewInput.value = mode;
        }

        function changeGridItem(itemId) {
            const url = new URL(window.location);
            url.searchParams.set('view', 'grid');
            url.searchParams.set('item_id', itemId);
            window.location.href = url.toString();
        }
    </script>
@endsection
