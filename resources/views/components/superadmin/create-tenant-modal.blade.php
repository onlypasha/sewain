<!-- MODAL PROVISION TENANT BARU -->
<dialog id="create-tenant-modal" class="modal">
    <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
        </form>

        <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Provisioning Tenant Baru</h3>
        <p class="text-xs text-slate-500 mb-6">Daftarkan toko rental baru secara manual dan alokasikan subdomain eksklusif.</p>

        <form action="#" method="POST" onsubmit="event.preventDefault(); handleCreateTenantSubmit();" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Toko Rental</label>
                <input type="text" id="new-tenant-name" required placeholder="Contoh: AutoFleet Bali Rent" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Subdomain Sewain Dituju</label>
                <div class="flex items-center gap-2">
                    <input type="text" id="new-tenant-subdomain" required placeholder="autofleet-bali" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-emerald-700 font-mono font-bold focus:outline-none focus:border-indigo-600 text-sm flex-1">
                    <span class="font-mono text-slate-500 font-bold">.sewain.id</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Pemilik / Admin</label>
                    <input type="text" id="new-tenant-owner" required placeholder="Wayan Sudarma" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Email Utama</label>
                    <input type="email" id="new-tenant-email" required placeholder="admin@autofleet.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Paket SaaS</label>
                    <select id="new-tenant-plan" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold">
                        <option selected>Pro Business (Rp 349k/bln)</option>
                        <option>Enterprise Multi-Branch (Rp 799k/bln)</option>
                        <option>Starter Plan (Rp 149k/bln)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status Lisensi</label>
                    <select class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold">
                        <option selected>Trial 14 Hari Active</option>
                        <option>Direct Active Paid</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="closeCreateTenantModal()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm font-bold text-white shadow-md bg-indigo-600 hover:bg-indigo-700 border-none">
                    Provision Database & Storefront
                </button>
            </div>
        </form>
    </div>
</dialog>