@extends('superadmin.layout')
@section('content')
    <div id="super-tab-content-payments" class="space-y-6 p-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200">
                        Financial Audit & Verification
                    </span>
                    @if ($pendingCount > 0)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            {{ $pendingCount }} Menunggu Verifikasi
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Verifikasi Pembayaran</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola bukti transfer pembayaran langganan dari para vendor dan aktifkan akses toko secara otomatis.</p>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Stat 1: Total Transaksi --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Total Permintaan</span>
                    <span class="text-3xl font-extrabold text-slate-900 font-heading leading-none">{{ count($purchases) }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Transaksi masuk</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>

            {{-- Stat 2: Pending --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-amber-600 font-mono font-bold uppercase tracking-wider block mb-1">Menunggu Verifikasi</span>
                    <span class="text-3xl font-extrabold text-amber-600 font-heading leading-none">{{ $pendingCount }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Perlu tindakan</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Stat 3: Diverifikasi --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-emerald-600 font-mono font-bold uppercase tracking-wider block mb-1">Disetujui / Lunas</span>
                    <span class="text-3xl font-extrabold text-emerald-600 font-heading leading-none">{{ $approvedCount }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Paket aktif</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Stat 4: Total Nominal Terverifikasi --}}
            <div class="bg-slate-900 rounded-3xl p-5 border border-slate-800 shadow-xs flex items-center justify-between text-white">
                <div>
                    <span class="text-[10px] text-emerald-400 font-mono uppercase font-bold tracking-wider block mb-1">Total Pendapatan</span>
                    <span class="text-xl font-extrabold font-mono text-emerald-400 leading-none block truncate">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </span>
                    <span class="text-[10px] text-slate-400 block mt-1 font-mono">Verified Revenue</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Main Table Container --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-slate-900 font-heading text-sm">Daftar Pengajuan Pembayaran</h3>
                    <p class="text-[11px] text-slate-500">Tinjau foto bukti transfer dan verifikasi pembayaran langganan toko.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-5 text-left w-12">NO.</th>
                            <th class="py-3.5 px-4 text-left">Vendor & Toko</th>
                            <th class="py-3.5 px-4 text-left">Paket Langganan</th>
                            <th class="py-3.5 px-4 text-left">Bukti Transfer</th>
                            <th class="py-3.5 px-4 text-right">Nominal</th>
                            <th class="py-3.5 px-4 text-left">Tanggal Upload</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($purchases as $purchase)
                            @php
                                $vendorUser = $purchase->subscription?->vendorProfile?->user;
                                $plan = $purchase->subscriptionPlan ?? $purchase->subscription?->subscriptionPlan;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- NO --}}
                                <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $loop->iteration }}</td>

                                {{-- Vendor & Toko --}}
                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-900 text-sm font-heading">
                                        {{ $vendorUser?->name ?? 'Vendor Tanpa Nama' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-mono">
                                        {{ $vendorUser?->email ?? '-' }}
                                    </div>
                                    @if ($vendorUser?->slug)
                                        <x-util.badge variant="neutral" size="xs" class="mt-1 font-mono">
                                            {{ $vendorUser->slug }}.sewain.id
                                        </x-util.badge>
                                    @endif
                                </td>

                                {{-- Paket Langganan --}}
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900">
                                        {{ $plan?->name ?? 'Paket Kustom' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-mono">
                                        Siklus: {{ ($plan?->billing_cycle ?? 'monthly') === 'yearly' ? 'Tahunan' : 'Bulanan' }}
                                    </div>
                                </td>

                                {{-- Bukti Transfer --}}
                                <td class="py-4 px-4">
                                    @if ($purchase->payment_proof_path)
                                        <button type="button" onclick="proof_modal_{{ $purchase->id }}.showModal()"
                                            class="group flex items-center gap-2 p-1.5 pr-3 bg-slate-100 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 rounded-xl transition-all text-left">
                                            <div class="w-8 h-8 rounded-lg overflow-hidden bg-slate-200 shrink-0 border border-slate-300">
                                                <img src="{{ Storage::url($purchase->payment_proof_path) }}" alt="Bukti Transfer" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-bold text-slate-700 group-hover:text-emerald-700">Lihat Bukti</span>
                                                <span class="block text-[9px] text-slate-400 font-mono uppercase">Klik Lightbox</span>
                                            </div>
                                        </button>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs italic">Tanpa File</span>
                                    @endif
                                </td>

                                {{-- Nominal --}}
                                <td class="py-4 px-4 text-right font-mono font-extrabold text-slate-900 text-sm">
                                    Rp {{ number_format($purchase->amount, 0, ',', '.') }}
                                </td>

                                {{-- Tanggal Upload --}}
                                <td class="py-4 px-4 font-mono text-slate-600 text-xs">
                                    {{ $purchase->submitted_at ? $purchase->submitted_at->format('d M Y, H:i') : $purchase->created_at->format('d M Y, H:i') }}
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4 text-center">
                                    @if (in_array($purchase->status, ['verified', 'approved', 'success']))
                                        <x-util.badge variant="success" size="sm" class="font-mono">
                                            ✓ Verified
                                        </x-util.badge>
                                    @elseif ($purchase->status === 'pending')
                                        <x-util.badge variant="warning" size="sm" class="font-mono animate-pulse">
                                            ⏳ Pending
                                        </x-util.badge>
                                    @else
                                        <x-util.badge variant="error" size="sm" class="font-mono">
                                            ✕ Ditolak
                                        </x-util.badge>
                                    @endif
                                </td>

                                {{-- Aksi Verifikasi --}}
                                <td class="py-4 px-6 text-center">
                                    @if ($purchase->status === 'pending')
                                        <div class="flex items-center justify-center gap-2">
                                            <x-util.button variant="success" size="xs" onclick="approve_modal_{{ $purchase->id }}.showModal()">
                                                Setujui
                                            </x-util.button>
                                            <x-util.button variant="error" size="xs" onclick="reject_modal_{{ $purchase->id }}.showModal()">
                                                Tolak
                                            </x-util.button>
                                        </div>
                                    @else
                                        <div class="text-[11px] text-slate-400 font-mono">
                                            Diverifikasi oleh:<br>
                                            <strong class="text-slate-700">{{ $purchase->verifiedBy?->name ?? 'System Admin' }}</strong>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1.112 1.112 0 01.707.293l5.414 5.414a1.112 1.112 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm">Belum Ada Transaksi Pembayaran</h4>
                                    <p class="text-xs text-slate-400 mt-1 font-mono">Pengajuan bukti transfer dari vendor akan muncul di tabel ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modals Loop --}}
    @foreach ($purchases as $purchase)
        @php
            $vendorUser = $purchase->subscription?->vendorProfile?->user;
            $plan = $purchase->subscriptionPlan ?? $purchase->subscription?->subscriptionPlan;
        @endphp

        {{-- Modal Lightbox Bukti Transfer --}}
        @if ($purchase->payment_proof_path)
            <dialog id="proof_modal_{{ $purchase->id }}" class="modal">
                <div class="modal-box bg-white rounded-3xl max-w-3xl p-6 sm:p-8">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                    </form>

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-lg text-slate-900 font-heading">Pratinjau Bukti Pembayaran</h3>
                            <p class="text-xs text-slate-500">Bukti transfer diunggah oleh <strong>{{ $vendorUser?->name ?? 'Vendor' }}</strong></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Full Image Preview --}}
                        <div class="md:col-span-2 bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 flex items-center justify-center p-2 min-h-[300px]">
                            <img src="{{ Storage::url($purchase->payment_proof_path) }}" alt="Bukti Transfer Detail" class="max-h-[450px] w-auto object-contain rounded-xl" />
                        </div>

                        {{-- Payment Summary Info --}}
                        <div class="flex flex-col justify-between bg-slate-50 p-5 rounded-2xl border border-slate-200 text-xs space-y-4">
                            <div class="space-y-3">
                                <div>
                                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block">Vendor</span>
                                    <span class="font-bold text-slate-900 text-sm block">{{ $vendorUser?->name ?? '-' }}</span>
                                    <span class="text-[11px] text-slate-500 font-mono">{{ $vendorUser?->email ?? '-' }}</span>
                                </div>
                                <div class="border-t border-slate-200 pt-2">
                                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block">Paket Langganan</span>
                                    <span class="font-bold text-slate-900 text-sm block">{{ $plan?->name ?? 'Paket Kustom' }}</span>
                                </div>
                                <div class="border-t border-slate-200 pt-2">
                                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block">Nominal Transfer</span>
                                    <span class="font-extrabold text-emerald-600 font-mono text-base block">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-slate-200 pt-2">
                                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block">Waktu Unggah</span>
                                    <span class="font-bold text-slate-700 font-mono block">{{ $purchase->submitted_at ? $purchase->submitted_at->format('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>

                            @if ($purchase->status === 'pending')
                                <div class="space-y-2 pt-3 border-t border-slate-200">
                                    <x-util.button variant="success" size="sm" class="w-full justify-center"
                                        onclick="proof_modal_{{ $purchase->id }}.close(); approve_modal_{{ $purchase->id }}.showModal();">
                                        ✓ Setujui Pembayaran
                                    </x-util.button>
                                    <x-util.button variant="error" size="sm" class="w-full justify-center"
                                        onclick="proof_modal_{{ $purchase->id }}.close(); reject_modal_{{ $purchase->id }}.showModal();">
                                        ✕ Tolak Pembayaran
                                    </x-util.button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </dialog>
        @endif

        {{-- Modal Konfirmasi Setujui Pembayaran --}}
        <dialog id="approve_modal_{{ $purchase->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 text-center">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4 border border-emerald-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Setujui Pembayaran?</h3>
                <p class="text-xs text-slate-500 mb-5">
                    Anda akan memverifikasi pembayaran sebesar <strong class="font-mono text-emerald-600 font-bold">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</strong> dari vendor <strong class="text-slate-700">{{ $vendorUser?->name ?? 'Vendor' }}</strong>. Langganan akan diaktifkan secara otomatis.
                </p>

                <form action="{{ route('superadmin.payments.approve', $purchase->id) }}" method="POST">
                    @csrf
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="approve_modal_{{ $purchase->id }}.close()" class="btn btn-ghost text-slate-600">Batal</button>
                        <x-util.button variant="success" type="submit" size="sm">
                            Ya, Setujui & Aktifkan
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        {{-- Modal Konfirmasi Tolak Pembayaran --}}
        <dialog id="reject_modal_{{ $purchase->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 text-center">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Tolak Pembayaran?</h3>
                <p class="text-xs text-slate-500 mb-5">
                    Apakah Anda yakin ingin menolak pembayaran dari <strong class="text-slate-700">{{ $vendorUser?->name ?? 'Vendor' }}</strong>? Status transaksi akan diubah menjadi Ditolak.
                </p>

                <form action="{{ route('superadmin.payments.reject', $purchase->id) }}" method="POST">
                    @csrf
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="reject_modal_{{ $purchase->id }}.close()" class="btn btn-ghost text-slate-600">Batal</button>
                        <x-util.button variant="error" type="submit" size="sm">
                            Ya, Tolak Pembayaran
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>
    @endforeach
@endsection
