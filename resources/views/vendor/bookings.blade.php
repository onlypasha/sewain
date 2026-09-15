@extends('vendor.layout')
@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Transaksi & Booking</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola pesanan masuk, lacak status penyewaan, dan pantau
                    riwayat transaksi toko Anda.</p>
            </div>
        </div>

        {{-- Metrics Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Booking --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Total
                        Booking</span>
                    <span
                        class="text-3xl font-extrabold text-slate-900 font-heading leading-none">{{ $bookings->count() }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Seluruh pesanan</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>

            {{-- Menunggu Konfirmasi --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span
                        class="text-[10px] text-amber-600 font-mono font-bold uppercase tracking-wider block mb-1">Menunggu
                        Konfirmasi</span>
                    <span
                        class="text-3xl font-extrabold text-amber-600 font-heading leading-none">{{ $bookings->where('status', 'pending')->count() }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Perlu ditindaklanjuti</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Sedang Berjalan --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span
                        class="text-[10px] text-indigo-600 font-mono font-bold uppercase tracking-wider block mb-1">Sedang
                        Berjalan</span>
                    <span
                        class="text-3xl font-extrabold text-indigo-600 font-heading leading-none">{{ $bookings->where('status', 'active')->count() }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Barang sedang disewa</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span
                        class="text-[10px] text-emerald-600 font-mono font-bold uppercase tracking-wider block mb-1">Selesai</span>
                    <span
                        class="text-3xl font-extrabold text-emerald-600 font-heading leading-none">{{ $bookings->where('status', 'completed')->count() }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Transaksi sukses</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Bookings Table Container --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-slate-900 font-heading text-sm">Daftar Pesanan</h3>
                    <p class="text-[11px] text-slate-500">Riwayat seluruh booking dan transaksi penyewaan barang.</p>
                </div>

                {{-- Filter Tabs --}}
                <div class="flex items-center gap-1.5 bg-slate-100 rounded-xl p-1">
                    <a href="{{ route('vendor.bookings') }}"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-colors {{ !request('status') ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                        Semua
                    </a>
                    <a href="{{ route('vendor.bookings', ['status' => 'pending']) }}"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-colors {{ request('status') === 'pending' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                        Pending
                    </a>
                    <a href="{{ route('vendor.bookings', ['status' => 'active']) }}"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-colors {{ request('status') === 'active' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                        Aktif
                    </a>
                    <a href="{{ route('vendor.bookings', ['status' => 'completed']) }}"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-colors {{ request('status') === 'completed' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                        Selesai
                    </a>
                    <a href="{{ route('vendor.bookings', ['status' => 'cancelled']) }}"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-colors {{ request('status') === 'cancelled' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                        Batal
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-5 text-left w-12">NO.</th>
                            <th class="py-3.5 px-4 text-left">ID Booking</th>
                            <th class="py-3.5 px-4 text-left">Penyewa</th>
                            <th class="py-3.5 px-4 text-left">Barang</th>
                            <th class="py-3.5 px-4 text-center">Durasi</th>
                            <th class="py-3.5 px-4 text-right">Total</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- NO --}}
                                <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $loop->iteration }}</td>

                                {{-- ID Booking --}}
                                <td class="py-4 px-4">
                                    <span
                                        class="font-mono font-bold text-slate-900 text-xs">#{{ $booking->booking_code ?? str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                {{-- Penyewa --}}
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($booking->customer_name ?? 'N', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-xs">
                                                {{ $booking->customer_name ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono">
                                                {{ $booking->customer_phone ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Barang --}}
                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-900 text-xs">{{ $booking->item_name ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono">
                                        {{ $booking->rental_start ? \Carbon\Carbon::parse($booking->rental_start)->format('d M') : '-' }}
                                        →
                                        {{ $booking->rental_end ? \Carbon\Carbon::parse($booking->rental_end)->format('d M Y') : '-' }}
                                    </div>
                                </td>

                                {{-- Durasi --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($booking->rental_start && $booking->rental_end)
                                        <span
                                            class="font-mono font-bold text-slate-700 text-xs">{{ \Carbon\Carbon::parse($booking->rental_start)->diffInDays(\Carbon\Carbon::parse($booking->rental_end)) }}
                                            hari</span>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs">-</span>
                                    @endif
                                </td>

                                {{-- Total --}}
                                <td class="py-4 px-4 text-right font-mono font-extrabold text-emerald-600 text-sm">
                                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4 text-center">
                                    @switch($booking->status)
                                        @case('pending')
                                            <x-util.badge variant="warning" size="sm" class="font-mono">
                                                Pending
                                            </x-util.badge>
                                        @break

                                        @case('confirmed')
                                            <x-util.badge variant="info" size="sm" class="font-mono">
                                                Dikonfirmasi
                                            </x-util.badge>
                                        @break

                                        @case('active')
                                            <x-util.badge variant="primary" size="sm" class="font-mono">
                                                Berjalan
                                            </x-util.badge>
                                        @break

                                        @case('completed')
                                            <x-util.badge variant="success" size="sm" class="font-mono">
                                                Selesai
                                            </x-util.badge>
                                        @break

                                        @case('cancelled')
                                            <x-util.badge variant="error" size="sm" class="font-mono">
                                                Dibatalkan
                                            </x-util.badge>
                                        @break

                                        @default
                                            <x-util.badge variant="neutral" size="sm" class="font-mono">
                                                {{ ucfirst($booking->status ?? '-') }}
                                            </x-util.badge>
                                    @endswitch
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-util.button variant="primary" size="xs"
                                            onclick="detail_booking_modal_{{ $booking->id }}.showModal()">
                                            Detail
                                        </x-util.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-16 px-6 text-center">
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm">Belum Ada Pesanan</h4>
                                    <p class="text-xs text-slate-400 mt-1 font-mono max-w-sm mx-auto">
                                        Pesanan penyewaan dari pelanggan akan muncul di sini setelah mereka melakukan
                                        booking melalui platform.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Detail Booking Modals --}}
    @foreach ($bookings as $booking)
        <dialog id="detail_booking_modal_{{ $booking->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Detail Booking</h3>
                <p class="text-xs text-slate-500 mb-6">Informasi lengkap pesanan penyewaan.</p>

                <div class="space-y-4 text-xs">
                    {{-- Booking Info --}}
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-3 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-mono uppercase tracking-wider text-[10px]">ID
                                Booking</span>
                            <span
                                class="font-mono font-bold text-slate-900">#{{ $booking->booking_code ?? str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-mono uppercase tracking-wider text-[10px]">Status</span>
                            @switch($booking->status)
                                @case('pending')
                                    <x-util.badge variant="warning" size="xs" class="font-mono">Pending</x-util.badge>
                                @break

                                @case('confirmed')
                                    <x-util.badge variant="info" size="xs" class="font-mono">Dikonfirmasi</x-util.badge>
                                @break

                                @case('active')
                                    <x-util.badge variant="primary" size="xs" class="font-mono">Berjalan</x-util.badge>
                                @break

                                @case('completed')
                                    <x-util.badge variant="success" size="xs" class="font-mono">Selesai</x-util.badge>
                                @break

                                @case('cancelled')
                                    <x-util.badge variant="error" size="xs" class="font-mono">Dibatalkan</x-util.badge>
                                @break

                                @default
                                    <x-util.badge variant="neutral" size="xs" class="font-mono">
                                        {{ ucfirst($booking->status ?? '-') }}</x-util.badge>
                                @endswitch
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-mono uppercase tracking-wider text-[10px]">Tanggal
                                Booking</span>
                            <span
                                class="font-mono font-bold text-slate-700">{{ $booking->created_at?->format('d M Y, H:i') ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Penyewa --}}
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-3 border border-slate-100">
                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] font-mono">Info
                            Penyewa</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Nama</span>
                            <span class="font-bold text-slate-900">{{ $booking->customer_name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Telepon</span>
                            <span
                                class="font-mono font-bold text-slate-700">{{ $booking->customer_phone ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Detail Sewa --}}
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-3 border border-slate-100">
                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] font-mono">Detail
                            Sewa</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Barang</span>
                            <span class="font-bold text-slate-900">{{ $booking->item_name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Periode</span>
                            <span class="font-mono font-bold text-slate-700">
                                {{ $booking->rental_start ? \Carbon\Carbon::parse($booking->rental_start)->format('d M') : '-' }}
                                →
                                {{ $booking->rental_end ? \Carbon\Carbon::parse($booking->rental_end)->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Durasi</span>
                            <span class="font-mono font-bold text-slate-700">
                                @if ($booking->rental_start && $booking->rental_end)
                                    {{ \Carbon\Carbon::parse($booking->rental_start)->diffInDays(\Carbon\Carbon::parse($booking->rental_end)) }}
                                    hari
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="border-t border-slate-200 pt-3 flex items-center justify-between">
                            <span class="font-bold text-slate-700">Total Biaya</span>
                            <span class="font-mono font-extrabold text-emerald-600 text-sm">
                                Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    @if ($booking->notes)
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] font-mono mb-2">
                                Catatan</h4>
                            <p class="text-slate-600 text-xs leading-relaxed">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="pt-5 flex items-center justify-end border-t border-slate-100 mt-5">
                    <button type="button" onclick="detail_booking_modal_{{ $booking->id }}.close()"
                        class="btn btn-ghost btn-sm text-slate-600">Tutup</button>
                </div>
            </div>
        </dialog>
    @endforeach
@endsection
