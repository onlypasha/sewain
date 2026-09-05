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
            @if ($subscription && $subscription->status === 'active')
                <div class="bg-emerald-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white/70 text-[10px] font-mono uppercase tracking-wider">Paket Anda</div>
                            <div class="text-white font-extrabold text-lg font-heading leading-tight">
                                {{ $subscription->subscriptionPlan?->name ?? 'Tidak Ada' }}</div>
                        </div>
                    </div>
                    <x-util.badge variant="success" size="sm" class="bg-white/20 text-white border-white/30 font-mono">
                        {{ $subscription->status }}
                    </x-util.badge>
                </div>
            @else
                <div class="bg-red-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white/70 text-[10px] font-mono uppercase tracking-wider">Paket Anda</div>
                            <div class="text-white font-extrabold text-lg font-heading leading-tight">
                                {{ $subscription?->subscriptionPlan?->name ?? 'Belum Berlangganan' }}</div>
                        </div>
                    </div>
                    <x-util.badge variant="neutral" size="sm" class="bg-white/20 text-white border-white/30 font-mono">
                        {{ $subscription?->status ?? 'inactive' }}
                    </x-util.badge>
                </div>
            @endif

            <div class="px-6 py-5 grid grid-cols-2 sm:grid-cols-4 gap-6">
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Harga</div>
                    <div class="font-extrabold text-slate-900 font-heading">
                        Rp. {{ number_format($subscription?->subscriptionPlan?->price ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-500">
                        / {{ ($subscription?->subscriptionPlan?->billing_cycle ?? 'monthly') === 'monthly' ? 'bulan' : 'tahun' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Siklus</div>
                    <div class="font-extrabold text-slate-900 font-heading">
                        {{ ($subscription?->subscriptionPlan?->billing_cycle ?? 'monthly') === 'monthly' ? 'Bulanan' : 'Tahunan' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Mulai</div>
                    <div class="font-bold text-slate-900 font-mono text-sm">
                        {{ $subscription?->start_date?->format('d M Y') ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-0.5">Berakhir</div>
                    <div class="font-bold text-slate-900 font-mono text-sm">
                        {{ $subscription?->end_date?->format('d M Y') ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Metrics Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Sisa Waktu --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="text-[10px] text-slate-400 uppercase tracking-wider mb-3">Sisa Masa Aktif</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-extrabold text-emerald-600 font-heading leading-none">
                        {{ $subscription?->remaining_days ?? 0 }}
                    </span>
                    <span class="text-slate-500 font-medium text-sm">hari lagi</span>
                </div>
                <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, max(0, ($subscription?->remaining_days ?? 0) * 3)) }}%"></div>
                </div>
            </div>

            {{-- Penggunaan Aset --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-3">Penggunaan Kuota Aset</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-extrabold text-slate-900 font-heading leading-none">{{ Auth::user()->vendorProfiles->assets ?? 0 }}</span>
                    <span class="text-slate-400 font-medium text-sm">/ {{ $maxAsset ?? 0 }}</span>
                </div>
                <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $maxAsset > 0 ? min(100, round(((Auth::user()->vendorProfiles->assets ?? 0) / $maxAsset) * 100)) : 0 }}%"></div>
                </div>
                <div class="text-[11px] text-slate-400 mt-1.5 font-mono">Slot Kuota: {{ $maxAsset ?? 0 }}</div>
            </div>
        </div>

        {{-- Fitur Paket --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="text-[10px] text-slate-400 font-mono uppercase tracking-wider mb-4">Fitur Termasuk</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2.5">
                @foreach ($subscription?->subscriptionPlan?->features ?? [] as $feature)
                    <div class="flex items-center gap-2 text-sm text-slate-700">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ is_array($feature) ? ($feature['name'] ?? '') . ': ' . ($feature['value'] ?? '') : $feature }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Section Perbarui & Upgrade Langganan --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold border border-emerald-100 shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base font-heading">Perbarui atau Upgrade Langganan</h3>
                        <p class="text-xs text-slate-500">Pilih opsi perpanjangan paket aktif atau tingkatkan kuota operasional toko Anda.</p>
                    </div>
                </div>
                <x-util.badge variant="emerald" size="sm" class="bg-emerald-50 text-emerald-700 border-emerald-200 font-mono">
                    Perpanjangan Instan
                </x-util.badge>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($plans as $plan)
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-between space-y-4 hover:border-emerald-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                @if ($subscription && $subscription->subscriptionPlan?->slug === $plan->slug)
                                    <span class="text-[10px] text-slate-500 font-mono uppercase font-bold tracking-wider">langganan saat ini</span>
                                    <x-util.badge variant="neutral" size="xs" soft>{{ $plan->slug }}</x-util.badge>
                                @else
                                    <span class="text-[10px] text-slate-500 font-mono uppercase font-bold tracking-wider">langganan ke {{ $plan->name }}</span>
                                    <x-util.badge variant="neutral" size="xs" soft>{{ $plan->slug }}</x-util.badge>
                                @endif
                            </div>
                            <h4 class="font-extrabold text-slate-900 text-lg font-heading">{{ $plan->name }}</h4>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="text-2xl font-extrabold text-emerald-600 font-heading">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                                <span class="text-xs text-slate-500 font-medium">/ {{ $plan->billing_cycle === 'yearly' ? 'tahun' : 'bulan' }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Menambah masa aktif 1 {{ $plan->billing_cycle === 'yearly' ? 'tahun' : 'bulan' }} dari tanggal berakhir saat ini.</p>
                        </div>

                        <x-util.button
                            variant="{{ ($subscription && $subscription->subscriptionPlan?->slug === $plan->slug) ? 'success' : 'primary' }}"
                            size="sm"
                            class="w-full"
                            onclick="purchase_modal_{{ $plan->id }}.showModal()">
                            {{ ($subscription && $subscription->subscriptionPlan?->slug === $plan->slug) ? 'Perpanjang langganan' : 'Langganan Sekarang' }}
                        </x-util.button>
                    </div>

                    {{-- Modal Pembelian / Perpanjangan Paket --}}
                    <dialog id="purchase_modal_{{ $plan->id }}" class="modal">
                        <div class="modal-box bg-white rounded-3xl max-w-md p-6">
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                            </form>

                            <div class="w-12 h-12 rounded-2xl {{ ($subscription && $subscription->subscriptionPlan?->slug === $plan->slug) ? 'bg-emerald-100 text-emerald-600' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>

                            <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">
                                {{ ($subscription && $subscription->subscriptionPlan?->slug === $plan->slug) ? 'Perbarui Paket ' . $plan->name : 'Langganan Paket ' . $plan->name }}
                            </h3>
                            <p class="text-xs text-slate-500 mb-5">Masa aktif akan diperbarui setelah bukti pembayaran diverifikasi oleh Admin.</p>

                            <form action="{{ route('vendor.subscription-purchases.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">

                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Paket Terpilih:</span>
                                        <span class="font-bold text-slate-900">{{ $plan->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Nominal Tagihan:</span>
                                        <span class="font-extrabold text-emerald-600 font-mono text-sm">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-slate-200 pt-3 mt-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Upload bukti transfer (screenshot)</label>
                                        <input type="file" name="payment_proof" required accept="image/*" class="file-input file-input-bordered w-full text-xs" />
                                        <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP. Maksimal 2MB.</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                                    <button type="button" onclick="purchase_modal_{{ $plan->id }}.close()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                                    <button type="submit" class="btn btn-emerald btn-sm text-white bg-emerald-600 hover:bg-emerald-700 border-none">
                                        Konfirmasi & Bayar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
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
                            <th class="py-2.5 px-4">Bukti</th>
                            <th class="py-2.5 px-4 text-right">Nominal</th>
                            <th class="py-2.5 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($purchases as $purchase)
                            <tr class="hover:bg-slate-50/60">
                                <td class="py-3 px-6 font-mono text-slate-700">
                                    {{ $purchase->submitted_at ? $purchase->submitted_at->format('d M Y H:i') : $purchase->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="py-3 px-4 text-slate-900 font-medium">
                                    {{ $purchase->subscription?->subscriptionPlan?->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-slate-500">
                                    @if ($purchase->payment_proof_path)
                                        <a href="{{ Storage::url($purchase->payment_proof_path) }}" target="_blank" class="text-emerald-600 hover:underline font-mono">Lihat Bukti</a>
                                    @else
                                        <span class="text-slate-400 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">
                                    Rp {{ number_format($purchase->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if (in_array($purchase->status, ['success', 'approved', 'verified']))
                                        <x-util.badge variant="success" size="xs" soft>Lunas</x-util.badge>
                                    @elseif ($purchase->status === 'pending')
                                        <x-util.badge variant="warning" size="xs" soft>Menunggu Verifikasi</x-util.badge>
                                    @else
                                        <x-util.badge variant="error" size="xs" soft>{{ ucfirst($purchase->status) }}</x-util.badge>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-slate-400 font-mono">
                                    Belum ada riwayat pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
