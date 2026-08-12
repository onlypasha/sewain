<!-- MODAL TAMBAH ASET BARU -->
<dialog id="add-asset-modal" class="modal">
    <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
        </form>

        <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Tambah Aset Rental Baru</h3>
        <p class="text-xs text-slate-500 mb-6">Daftarkan item barang baru ke dalam katalog toko rental Anda.</p>

        <form action="#" method="POST" onsubmit="event.preventDefault(); handleAddAssetSubmit();" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Barang / Aset</label>
                <input type="text" id="new-asset-name" required placeholder="Contoh: Sony FX3 Cinema Line Body" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium text-sm">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                    <select id="new-asset-category" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                        <option>Kamera & Body</option>
                        <option>Lensa Cinema</option>
                        <option>Lighting & Rig</option>
                        <option>Outdoor & Camping</option>
                        <option>Otomotif Fleet</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Stok Total Unit</label>
                    <input type="number" id="new-asset-stock" min="1" value="2" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tarif Sewa / Hari (Rp)</label>
                    <input type="number" id="new-asset-rate" step="10000" placeholder="350000" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jaminan Deposit (Rp)</label>
                    <input type="number" id="new-asset-deposit" step="10000" placeholder="300000" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi & Spesifikasi Ringkas</label>
                <textarea rows="2" placeholder="Spesifikasi teknis singkat unit sewa..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium"></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="closeAddAssetModal()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                <button type="submit" class="btn btn-emerald btn-primary btn-sm font-bold text-white shadow-md">
                    Simpan Item Baru
                </button>
            </div>
        </form>
    </div>
</dialog>