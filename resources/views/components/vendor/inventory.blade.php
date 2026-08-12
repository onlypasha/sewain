<!-- TAB 2: KATALOG & MANAJEMEN INVENTARIS ASET -->
<div id="tab-content-inventory" class="admin-tab-pane hidden space-y-6">
    <!-- Header & Action Controls -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Katalog & Stok Aset Rental</h1>
            <p class="text-slate-500 text-xs mt-0.5">Kelola seluruh item sewa, ketersediaan stok, dan tarif harian toko Anda.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <button onclick="openAddAssetModal()" class="btn btn-emerald btn-primary btn-sm font-bold text-white shadow-md">
                + Tambah Item Baru
            </button>
        </div>
    </div>

    <!-- Inventory Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Category Filter Tabs -->
        <div class="flex items-center gap-1 overflow-x-auto max-w-full pb-1 sm:pb-0">
            <button class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white">Semua Aset (48)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Kamera & Body (18)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Lensa Cinema (16)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Lighting & Rig (14)</button>
        </div>

        <!-- Quick Table Search -->
        <div class="w-full sm:w-64">
            <input type="text" placeholder="Filter nama barang..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-emerald-600">
        </div>
    </div>

    <!-- ASSETS INVENTORY TABLE -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table w-full text-xs">
                <!-- Table Head -->
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                    <tr>
                        <th class="py-3 px-4">KODE / ID ASET</th>
                        <th class="py-3 px-4">NAMA ITEM & SPESIFIKASI</th>
                        <th class="py-3 px-4">KATEGORI</th>
                        <th class="py-3 px-4 text-center">STOK (TOTAL/READY)</th>
                        <th class="py-3 px-4">TARIF SEWA / HARI</th>
                        <th class="py-3 px-4">DEPOSIT (REFUNDABLE)</th>
                        <th class="py-3 px-4 text-center">STATUS HARI INI</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-slate-100 font-medium">
                    <!-- Item 1 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="font-mono font-bold text-slate-900">SNY-A7IV-01</td>
                        <td>
                            <div class="font-bold text-slate-900 text-sm">Sony Alpha 7 IV Body Only</div>
                            <div class="text-[11px] text-slate-500">33MP Full-frame 4K 60p Dual Slot CFexpress</div>
                        </td>
                        <td><span class="badge badge-sm badge-neutral">Kamera & Body</span></td>
                        <td class="text-center font-mono font-bold">5 / <span class="text-emerald-600">3 Ready</span></td>
                        <td class="font-bold text-slate-900">Rp 350.000</td>
                        <td class="text-amber-700 font-semibold">Rp 300.000</td>
                        <td class="text-center">
                            <span class="badge badge-sm badge-success text-white font-semibold">Disewa (2)</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="alert('Edit Aset Sony A7 IV');" class="btn btn-ghost btn-xs text-slate-600">Edit</button>
                                <button onclick="alert('Jadwal Kalender Stok');" class="btn btn-ghost btn-xs text-emerald-600">Kalender</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 2 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="font-mono font-bold text-slate-900">LNS-2470GM-02</td>
                        <td>
                            <div class="font-bold text-slate-900 text-sm">Sony FE 24-70mm f/2.8 GM II</div>
                            <div class="text-[11px] text-slate-500">Flagship Zoom Lens Filter Diameter 82mm</div>
                        </td>
                        <td><span class="badge badge-sm badge-neutral">Lensa Cinema</span></td>
                        <td class="text-center font-mono font-bold">4 / <span class="text-emerald-600">4 Ready</span></td>
                        <td class="font-bold text-slate-900">Rp 250.000</td>
                        <td class="text-amber-700 font-semibold">Rp 250.000</td>
                        <td class="text-center">
                            <span class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-semibold">Ready Stok</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="alert('Edit Aset Lensa');" class="btn btn-ghost btn-xs text-slate-600">Edit</button>
                                <button onclick="alert('Jadwal Kalender Stok');" class="btn btn-ghost btn-xs text-emerald-600">Kalender</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 3 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="font-mono font-bold text-slate-900">GDX-SL60W-01</td>
                        <td>
                            <div class="font-bold text-slate-900 text-sm">Godox SL60W LED Video Light Set</div>
                            <div class="text-[11px] text-slate-500">Bowens Mount + Softbox 80cm + Light Stand</div>
                        </td>
                        <td><span class="badge badge-sm badge-neutral">Lighting & Rig</span></td>
                        <td class="text-center font-mono font-bold">6 / <span class="text-amber-600">1 Buffer</span></td>
                        <td class="font-bold text-slate-900">Rp 120.000</td>
                        <td class="text-amber-700 font-semibold">Rp 100.000</td>
                        <td class="text-center">
                            <span class="badge badge-sm badge-warning font-semibold text-slate-950">Maintenance</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="alert('Edit Aset Lighting');" class="btn btn-ghost btn-xs text-slate-600">Edit</button>
                                <button onclick="alert('Jadwal Kalender Stok');" class="btn btn-ghost btn-xs text-emerald-600">Kalender</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>