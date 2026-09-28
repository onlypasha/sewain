@extends('storefront.layout')

@section('title', 'Booking Saya | Sewain')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-display font-bold">Booking Saya</h1>
                <p class="text-sm text-ink-soft mt-1">Riwayat penyewaan Anda di Sewain.</p>
            </div>
            <a href="{{ route('landing') }}" class="text-sm text-ink-soft hover:text-ink">Cari barang lain</a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($bookings->isEmpty())
            <div class="text-center py-16 bg-ink/5 rounded-2xl">
                <p class="text-ink-soft mb-4">Anda belum punya booking.</p>
                <a href="{{ route('landing') }}"
                    class="inline-flex items-center justify-center bg-stempel text-paper font-semibold px-5 py-2.5 rounded-xl hover:bg-stempel-deep transition-all">
                    Mulai cari barang
                </a>
            </div>
        @else
            @php
                $statusMap = [
                    'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                    'confirmed' => ['label' => 'Dikonfirmasi', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                    'active' => ['label' => 'Sedang Disewa', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                    'completed' => ['label' => 'Selesai', 'class' => 'bg-slate-100 text-slate-600 border-slate-200'],
                    'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-50 text-red-700 border-red-200'],
                ];
            @endphp

            <div class="space-y-4">
                @foreach ($bookings as $booking)
                    @php $status = $statusMap[$booking->status] ?? ['label' => ucfirst($booking->status), 'class' => 'bg-slate-100 text-slate-600 border-slate-200']; @endphp
                    <div class="bg-white rounded-2xl border border-ink/10 p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-sm font-semibold text-ink">{{ $booking->booking_code }}</span>
                                <span class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 rounded-full border {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </div>
                            <span class="text-sm text-ink-soft">{{ $booking->created_at->format('d M Y') }}</span>
                        </div>

                        @if (session('success') && $loop->first)
                            <div class="mb-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                            <div>
                                <p class="text-ink-soft text-xs mb-0.5">Item</p>
                                <p class="font-medium">{{ $booking->item->name ?? '-' }}</p>
                                @if ($booking->vendor)
                                    <p class="text-xs text-ink-soft">{{ $booking->vendor->name }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-ink-soft text-xs mb-0.5">Periode</p>
                                <p class="font-medium">
                                    {{ $booking->rental_start->format('d M') }} – {{ $booking->rental_end->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-ink-soft text-xs mb-0.5">Total</p>
                                <p class="font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        @php
                            $latestPayment = $booking->payments()->latest()->first();
                        @endphp

                        @if (in_array($booking->status, ['confirmed', 'active', 'completed']) || $latestPayment)
                            <div class="mt-4 pt-4 border-t border-ink/10 flex flex-wrap items-center gap-2">
                                @if ($latestPayment)
                                    <a href="{{ route('customer.bookings.payment.proof', $booking->id) }}" target="_blank"
                                        class="text-xs font-semibold text-brand-600 hover:underline">
                                        Lihat bukti bayar
                                    </a>
                                    <span class="text-xs text-ink-soft">
                                        @if ($latestPayment->status === 'pending')
                                            · Menunggu verifikasi vendor
                                        @elseif ($latestPayment->status === 'verified')
                                            · <span class="text-emerald-600 font-semibold">Terverifikasi</span>
                                        @elseif ($latestPayment->status === 'rejected')
                                            · <span class="text-red-600 font-semibold">Ditolak — silakan unggah ulang</span>
                                        @endif
                                    </span>
                                @endif

                                @if ($booking->status === 'confirmed' && (! $latestPayment || $latestPayment->status === 'rejected'))
                                    <form method="POST" action="{{ route('customer.bookings.payment.store', $booking->id) }}"
                                        enctype="multipart/form-data" class="flex items-center gap-2 ml-auto">
                                        @csrf
                                        <input type="file" name="payment_proof" accept="image/*" required
                                            class="text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold bg-stempel text-paper hover:bg-stempel-deep transition-colors">
                                            Unggah Bukti
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection