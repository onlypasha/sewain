@extends('storefront.layout')

@section('title', $vendor->name . ' | Sewain')
@section('description', 'Sewa barang dari ' . $vendor->name . ' di Sewain.')

@section('content')
    {{-- Header toko --}}
    <section class="bg-gradient-to-b from-brand-50 to-paper border-b border-ink/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row items-start gap-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-300 to-brand-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg shrink-0">
                    {{ strtoupper(substr($vendor->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-display font-bold tracking-tight">{{ $vendor->name }}</h1>
                    @if ($vendor->vendorProfiles?->owner_name)
                        <p class="text-ink-soft mt-1">oleh {{ $vendor->vendorProfiles->owner_name }}</p>
                    @endif
                    @if ($vendor->vendorProfiles?->address)
                        <p class="text-sm text-ink-soft mt-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $vendor->vendorProfiles->address }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Daftar item --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-baseline justify-between mb-6">
            <h2 class="text-xl font-display font-bold">Barang Tersedia</h2>
            <span class="text-sm text-ink-soft">{{ $items->total() }} item</span>
        </div>

        @if ($items->isEmpty())
            <div class="text-center py-16 bg-ink/5 rounded-2xl">
                <p class="text-ink-soft">Belum ada barang yang tersedia di toko ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($items as $item)
                    <a href="{{ route('storefront.item', $item->id) }}"
                        class="group bg-white rounded-2xl border border-ink/10 overflow-hidden hover:shadow-lg hover:border-brand-300 transition-all duration-200">
                        <div class="aspect-[4/3] bg-ink/5 overflow-hidden">
                            @if ($item->items_photo)
                                <img src="{{ route('image.proxy', $item->items_photo) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-ink-soft/40">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            @if ($item->category)
                                <span class="inline-block text-[11px] font-medium text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full mb-2">
                                    {{ $item->category->name }}
                                </span>
                            @endif
                            <h3 class="font-semibold text-ink group-hover:text-brand-600 transition-colors line-clamp-1">
                                {{ $item->name }}
                            </h3>
                            <p class="text-sm text-ink-soft line-clamp-2 mt-1">{{ $item->description }}</p>
                            <div class="mt-3 flex items-baseline gap-1">
                                <span class="text-lg font-bold text-ink">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                                <span class="text-xs text-ink-soft">/ hari</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @endif
    </section>
@endsection
