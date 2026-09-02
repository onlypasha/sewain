@extends('vendor.layout')
@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Langganan</h1>
            <p class="text-slate-500 text-xs mt-0.5">Detail paket dan masa aktif langganan toko Anda.</p>
        </div>

        {{-- Status Card --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-emerald-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-white/70 text-[10px] font-mono uppercase tracking-wider">Paket Aktif</div>
                        <div class="text-white font-extrabold text-lg font-heading leading-tight">
                            {{ $subscription->subscriptionPlan->name }}</div>
                    </div>
                </div>
                <x-util.badge variant="success" size="sm" class="bg-white/20 text-white border-white/30 font-mono">
                    {{ $subscription->status }}
                </x-util.badge>
            </div>

            <div class="px-6 py-5 grid grid-cols-2 sm:grid-cols-4 gap-6">
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Harga</div>
                    <div class="font-extrabold text-slate-900 font-heading">
                        Rp. {{ number_format($subscription->subscriptionPlan->price, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500">
                        / {{ $subscription->subscriptionPlan->billing_cycle === 'monthly' ? 'bulan' : 'tahun' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Siklus</div>
                    <div class="font-extrabold text-slate-900 font-heading">
                        {{ $subscription->subscriptionPlan->billing_cycle === 'monthly' ? 'Bulanan' : 'Tahunan' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Mulai</div>
                    <div class="font-bold text-slate-900 font-mono text-sm">{{ $subscription->start_date?->format('d M Y') ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Berakhir</div>
                    <div class="font-bold text-slate-900 font-mono text-sm">{{ $subscription->end_date?->format('d M Y') ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Metrics Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Sisa Waktu --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-3">Sisa Masa Aktif</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-extrabold text-emerald-600 font-heading leading-none">
                        {{ $subscription->remaining_days ?? 0 }}
                    </span>
                    <span class="text-slate-500 font-medium text-sm">hari lagi</span>
                </div>
                <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: 22%"></div>
                </div>
                <div class="text-[11px] text-slate-400 mt-1.5 font-mono">7 dari 31 hari terpakai</div>
            </div>

            {{-- Penggunaan Aset --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-3">Penggunaan Kuota Aset</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-extrabold text-slate-900 font-heading leading-none">48</span>
                    <span class="text-slate-400 font-medium text-sm">/ 100 unit</span>
                </div>
                <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-full rounded-full" style="width: 48%"></div>
                </div>
                <div class="text-[11px] text-slate-400 mt-1.5 font-mono">52 slot tersisa</div>
            </div>
        </div>

        {{-- Fitur Paket --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-4">Fitur Termasuk</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2.5">
                @php
                    $features = [
                        'Maksimal 100 unit aset',
                        'Subdomain .sewain.id',
                        'Custom domain pribadi',
                        'WhatsApp reminder otomatis',
                        'Verifikasi e-KTP penyewa',
                        'Laporan pendapatan bulanan',
                        'Dukungan prioritas',
                        'Multi-operator akses',
                    ];
                @endphp
                @foreach ($features as $feature)
                    <div class="flex items-center gap-2 text-sm text-slate-700">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ $feature }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Riwayat Pembayaran --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 pt-5 pb-3">
                <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider">Riwayat Pembayaran Terakhir</div>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-y border-slate-100 text-slate-500 font-mono">
                        <tr>
                            <th class="py-2.5 px-6">Tanggal</th>
                            <th class="py-2.5 px-4">Paket</th>
                            <th class="py-2.5 px-4">Metode</th>
                            <th class="py-2.5 px-4 text-right">Nominal</th>
                            <th class="py-2.5 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr class="hover:bg-slate-50/60">
                            <td class="py-3 px-6 font-mono text-slate-700">01 Agt 2026</td>
                            <td class="py-3 px-4 text-slate-900 font-medium">Pro Business</td>
                            <td class="py-3 px-4 text-slate-500">QRIS</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">Rp 279.000</td>
                            <td class="py-3 px-4 text-center">
                                <x-util.badge variant="success" size="xs" soft>Lunas</x-util.badge>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/60">
                            <td class="py-3 px-6 font-mono text-slate-700">01 Jul 2026</td>
                            <td class="py-3 px-4 text-slate-900 font-medium">Pro Business</td>
                            <td class="py-3 px-4 text-slate-500">Transfer Bank</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">Rp 279.000</td>
                            <td class="py-3 px-4 text-center">
                                <x-util.badge variant="success" size="xs" soft>Lunas</x-util.badge>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/60">
                            <td class="py-3 px-6 font-mono text-slate-700">01 Jun 2026</td>
                            <td class="py-3 px-4 text-slate-900 font-medium">Starter</td>
                            <td class="py-3 px-4 text-slate-500">QRIS</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">Rp 149.000</td>
                            <td class="py-3 px-4 text-center">
                                <x-util.badge variant="success" size="xs" soft>Lunas</x-util.badge>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
