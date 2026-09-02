@extends('vendor.layout')
@section('content')
    <!-- TAB 1: OVERVIEW DASHBOARD -->
    <div id="tab-content-overview" class="admin-tab-pane space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Ringkasan Operasional Toko</h1>
                <p class="text-slate-500 text-xs mt-0.5">Pantau pendapatan, ketersediaan unit sewa, dan antrean verifikasi
                    secara realtime.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-mono">Filter Periode:</span>
                <select class="select select-bordered select-xs text-xs font-semibold text-slate-700 bg-white">
                    <option selected>Agustus 2026 (Bulan Ini)</option>
                    <option>Juli 2026</option>
                    <option>Juni 2026</option>
                </select>
            </div>
        </div>

        <!-- STAT CARDS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Stat 1 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Omset Sewa</span>
                    <div
                        class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        💰
                    </div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900 font-heading">Rp 28.450.000</div>
                    <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>+14.2% dibanding bulan lalu</span>
                    </div>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aset Sedang Disewa</span>
                    <div
                        class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                        📷
                    </div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900 font-heading">32 / 48 Unit</div>
                    <div class="flex items-center gap-1.5 text-xs text-blue-600 font-semibold mt-1">
                        <span>Utilisasi Stok 66.7% Ready</span>
                    </div>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kontrak Digital PDF</span>
                    <div
                        class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                        📄
                    </div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900 font-heading">142 Dokumen</div>
                    <div class="flex items-center gap-1.5 text-xs text-amber-700 font-semibold mt-1">
                        <span>Terverifikasi Tanda Tangan</span>
                    </div>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Deposit Dipegang</span>
                    <div
                        class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-sm">
                        🛡️
                    </div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900 font-heading">Rp 9.600.000</div>
                    <div class="flex items-center gap-1.5 text-xs text-teal-600 font-semibold mt-1">
                        <span>Otomatis Refund saat Kembali</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT TRANSACTIONS & PENDING VERIFICATIONS DUAL GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Active Bookings Queue -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base font-heading">Pemesanan Terbaru yang Membutuhkan Aksi
                        </h3>
                        <p class="text-xs text-slate-500">Konfirmasi serah terima unit atau penerbitan PDF Perjanjian Sewa.
                        </p>
                    </div>
                    <button onclick="switchAdminTab('bookings')"
                        class="text-xs font-bold text-emerald-600 hover:underline">Lihat Semua &rarr;</button>
                </div>

                <div class="space-y-3">
                    <!-- Order Item 1 -->
                    <div
                        class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-emerald-500 transition-all">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-xs">
                                #948
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-900 text-sm">Sony Alpha 7 IV + Lensa 24-70mm</span>
                                    <span class="badge badge-xs badge-success text-white font-mono">QRIS PAID</span>
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">Penyewa: <strong>Budi Pratama</strong> (3 Hari) •
                                    <code class="text-slate-700 font-mono">12-15 Aug 2026</code>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button onclick="alert('PDF Kontrak Digital #SEW-94812 berhasil diterbitkan!');"
                                class="btn btn-xs btn-outline border-slate-300 font-semibold text-slate-700">📄 PDF
                                Kontrak</button>
                            <button
                                onclick="alert('Serah terima barang dikonfirmasi! Notifikasi WA terkirim ke pelanggan.');"
                                class="btn btn-xs btn-emerald btn-primary font-bold">Serahkan Unit</button>
                        </div>
                    </div>

                    <!-- Order Item 2 -->
                    <div
                        class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-emerald-500 transition-all">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-xs">
                                #947
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-900 text-sm">Godox SL60W Lighting Studio Set</span>
                                    <span class="badge badge-xs badge-warning font-mono font-bold text-slate-950">PERLU
                                        VERIFIKASI</span>
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">Penyewa: <strong>Siti Rahmawati</strong> (1 Hari)
                                    • <code class="text-slate-700 font-mono">12 Aug 2026</code></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button onclick="switchAdminTab('verifications')"
                                class="btn btn-xs btn-warning font-bold text-slate-950">Verifikasi E-KTP</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 1 Col: Tenant Health & Automation Widget -->
            <div
                class="bg-slate-900 text-white p-6 rounded-3xl border border-slate-800 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <span class="text-xs font-mono text-emerald-400 font-bold uppercase tracking-wider">Status
                            Otomatisasi Tenant</span>
                        <span class="badge badge-xs badge-success text-white font-mono">OPERATIONAL</span>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div
                            class="flex justify-between items-center bg-slate-800/80 p-3 rounded-xl border border-slate-700">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Bot WhatsApp Auto-Reminder</span>
                            </div>
                            <span class="text-emerald-400 font-bold">Aktif</span>
                        </div>

                        <div
                            class="flex justify-between items-center bg-slate-800/80 p-3 rounded-xl border border-slate-700">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Payment Gateway QRIS / VA</span>
                            </div>
                            <span class="text-emerald-400 font-bold">Connected</span>
                        </div>

                        <div
                            class="flex justify-between items-center bg-slate-800/80 p-3 rounded-xl border border-slate-700">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>SSL Subdomain SSL Cert</span>
                            </div>
                            <span class="text-emerald-400 font-bold">Valid</span>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-6 pt-4 border-t border-slate-800 text-[11px] text-slate-400 flex items-center justify-between">
                    <span>Versi Engine: v2.4 Multi-Tenant</span>
                    <a href="/#faq" class="text-emerald-400 hover:underline">Bantuan CS</a>
                </div>
            </div>
        </div>
    </div>
@endsection
