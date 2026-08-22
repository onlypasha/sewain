<!-- MODAL PROVISION TENANT BARU -->
<dialog id="create-tenant-modal" class="modal">
    <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
        <form method="dialog">
            <button
                class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
        </form>

        <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Provisioning Tenant Baru</h3>
        <p class="text-xs text-slate-500 mb-6">Daftarkan toko rental baru secara manual dan alokasikan subdomain
            eksklusif.</p>

        <form action="{{ route('superadmin-vendor-management.create') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Toko Rental</label>
                <input type="text" id="new-tenant-name" required placeholder="Contoh: AutoFleet Bali Rent"
                    name="name"
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Subdomain Sewain
                    Dituju</label>
                <div class="flex items-center gap-2">
                    <input type="text" id="new-tenant-subdomain" placeholder="otomatis dari nama toko" name="slug"
                        class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-emerald-700 font-mono font-bold focus:outline-none text-sm flex-1">
                    <span class="font-mono text-slate-500 font-bold">.sewain.id</span>
                </div>
                <p id="subdomain-preview" class="mt-1.5 font-mono text-[11px] min-h-[16px] text-slate-400"></p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor telepon</label>
                    <div class="relative mt-2 max-w-xs text-gray-500">
                        <div class="absolute inset-y-0 left-3 my-auto h-6 flex items-center border-r pr-2">
                            <select class="text-sm outline-none rounded-lg h-full">
                                <option>ID</option>
                            </select>
                        </div>
                        <input type="number" placeholder="+1 (555) 000-000" name="phone"
                            class="w-full pl-[4.5rem] pr-3 py-2 appearance-none bg-transparent outline-none border focus:border-slate-600 shadow-sm rounded-lg">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Email Utama</label>
                    <input type="email" id="new-tenant-email" required placeholder="admin@autofleet.com"
                        name="email"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="closeCreateTenantModal()"
                    class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                <button type="submit"
                    class="btn btn-primary btn-sm font-bold text-white shadow-md bg-indigo-600 hover:bg-indigo-700 border-none">
                    Provision Database & Storefront
                </button>
            </div>
        </form>
    </div>
</dialog>

<script>
    (function() {
        /**
         * Mereplikasi logika Str::slug($value, '-') milik Laravel:
         * 1. Trim whitespace
         * 2. Normalisasi NFD & hapus combining marks (aksen)
         * 3. Lowercase
         * 4. Karakter selain [a-z0-9] diganti dengan '-'
         * 5. Hapus dash berlebih di awal/akhir
         */
        function toSlug(value) {
            return value
                .trim()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        const nameInput = document.getElementById('new-tenant-name');
        const subdomainInput = document.getElementById('new-tenant-subdomain');
        const preview = document.getElementById('subdomain-preview');

        if (!nameInput || !subdomainInput || !preview) return;

        nameInput.addEventListener('input', function() {
            const slug = toSlug(this.value);

            subdomainInput.value = slug;

            if (slug) {
                preview.textContent = '🌐 ' + slug + '.sewain.id';
                preview.classList.replace('text-slate-400', 'text-emerald-600');
            } else {
                preview.textContent = '';
                preview.classList.replace('text-emerald-600', 'text-slate-400');
            }
        });
    })();
</script>
