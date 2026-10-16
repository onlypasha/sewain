@extends('storefront.layout')

@section('title', $item->name . ' | Sewain')
@section('description', Str::limit($item->description, 150))

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-ink-soft mb-6">
            <a href="{{ route('landing') }}" class="hover:text-ink transition-colors">Beranda</a>
            <span>/</span>
            @if ($item->vendor?->slug)
                <a href="{{ route('storefront.vendor', $item->vendor->slug) }}" class="hover:text-ink transition-colors">
                    {{ $item->vendor->name }}
                </a>
                <span>/</span>
            @endif
            <span class="text-ink font-medium line-clamp-1">{{ $item->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Foto --}}
            <div class="aspect-[4/3] bg-ink/5 rounded-2xl overflow-hidden border border-ink/10">
                @if ($item->items_photo)
                    <img src="{{ route('image.proxy', $item->items_photo) }}" alt="{{ $item->name }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-ink-soft/40">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div>
                @php
                    $statusMap = [
                        'available' => ['label' => 'Tersedia', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                        'rented' => ['label' => 'Disewa', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                        'maintenance' => ['label' => 'Maintenance', 'class' => 'bg-slate-100 text-slate-600 border-slate-200'],
                    ];
                    $status = $statusMap[$item->status] ?? ['label' => ucfirst($item->status), 'class' => 'bg-slate-100 text-slate-600 border-slate-200'];
                @endphp

                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full border {{ $status['class'] }}">
                        {{ $status['label'] }}
                    </span>
                    @if ($item->category)
                        <span class="text-xs font-medium text-brand-600 bg-brand-50 px-2.5 py-1 rounded-full">
                            {{ $item->category->name }}
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl font-display font-bold tracking-tight">{{ $item->name }}</h1>

                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                    <span class="text-sm text-ink-soft">/ hari</span>
                </div>

                <div class="mt-6 prose prose-sm max-w-none text-ink-soft">
                    <p>{{ $item->description }}</p>
                </div>

                {{-- Info toko --}}
                @if ($item->vendor)
                    <div class="mt-6 p-4 bg-ink/5 rounded-xl">
                        <p class="text-xs text-ink-soft mb-1">Disewakan oleh</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-300 to-brand-500 flex items-center justify-center text-white font-bold shrink-0">
                                {{ strtoupper(substr($item->vendor->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-ink">{{ $item->vendor->name }}</p>
                                @if ($item->vendor->slug)
                                    <a href="{{ route('storefront.vendor', $item->vendor->slug) }}"
                                        class="text-xs text-brand-600 hover:underline">Lihat toko</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="mt-6">
                    @if (! config('sewain.modules.customer'))
                        <button type="button" disabled
                            class="w-full inline-flex items-center justify-center bg-ink/20 text-ink-soft font-semibold px-6 py-3 rounded-xl cursor-not-allowed">
                            Booking online belum dibuka
                        </button>
                        <p class="text-xs text-ink-soft text-center mt-2">Untuk sementara, hubungi toko langsung untuk
                            menyewa.</p>
                    @elseif ($item->status === 'available')
                        @auth
                            @if (auth()->user()->role === 'customer')
                                <a href="{{ route('customer.bookings.create', $item->id) }}"
                                    class="w-full inline-flex items-center justify-center bg-stempel text-paper font-semibold px-6 py-3 rounded-xl hover:bg-stempel-deep transition-all active:scale-[0.99]">
                                    Pesan Sekarang
                                </a>
                                <p class="text-xs text-ink-soft text-center mt-2">Anda akan diarahkan ke form booking.</p>
                            @else
                                <button type="button" disabled
                                    class="w-full inline-flex items-center justify-center bg-ink/20 text-ink-soft font-semibold px-6 py-3 rounded-xl cursor-not-allowed">
                                    Hanya penyewa yang bisa booking
                                </button>
                                <p class="text-xs text-ink-soft text-center mt-2">Login sebagai customer untuk menyewa.</p>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="w-full inline-flex items-center justify-center bg-stempel text-paper font-semibold px-6 py-3 rounded-xl hover:bg-stempel-deep transition-all active:scale-[0.99]">
                                Masuk untuk menyewa
                            </a>
                        @endauth
                    @else
                        <button type="button" disabled
                            class="w-full inline-flex items-center justify-center bg-ink/20 text-ink-soft font-semibold px-6 py-3 rounded-xl cursor-not-allowed">
                            Tidak tersedia saat ini
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection