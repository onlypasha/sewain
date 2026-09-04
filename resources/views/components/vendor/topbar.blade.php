<!-- ADMIN TOPBAR -->
<header
    class="bg-white border-b border-slate-200/90 py-3.5 px-6 sticky top-0 z-20 shadow-xs flex items-center justify-between">
    <!-- Right Header Controls -->
    <div class="flex items-center gap-3">
        <!-- Live System Status Badge -->
        <div
            class="hidden sm:flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-mono font-semibold px-3 py-1 rounded-full">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Realtime Calendar Sync</span>
        </div>

        <!-- Notification Bell -->
        <button
            onclick="Swal.fire({ title: 'Notifikasi Baru', html: '1. Transaksi #SEW-94812 memerlukan verifikasi KTP<br>2. Sony A7 IV dikembalikan hari ini<br>3. Pembayaran QRIS Rp 1.375.000 Berhasil', icon: 'info' })"
            class="btn btn-ghost btn-circle btn-sm text-slate-600 hover:text-slate-900 relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-rose-500 border-2 border-white"></span>
        </button>

        <!-- Primary CTA: Add Asset -->
        <button onclick="openAddAssetModal()"
            class="btn btn-emerald btn-primary btn-sm font-bold text-white shadow-md shadow-emerald-500/20 gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Aset Baru</span>
        </button>
    </div>
</header>
