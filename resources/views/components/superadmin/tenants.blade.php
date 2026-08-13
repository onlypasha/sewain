<!-- TAB 2: MANAJEMEN TENANT PLATFORM -->
<div id="super-tab-content-tenants" class="superadmin-tab-pane hidden space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Direktori & Manajemen Seluruh Tenant</h1>
            <p class="text-slate-500 text-xs mt-0.5">Kelola akses 1,428+ toko sewa terdaftar, alokasi subdomain, dan
                lisensi langganan.</p>
        </div>

        <button onclick="openCreateTenantModal()"
            class="btn btn-primary btn-sm font-bold text-white shadow-md bg-indigo-600 border-none">
            + Provision Tenant Baru
        </button>
    </div>

    <!-- Filter & Search Bar -->
    <div
        class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-1 overflow-x-auto max-w-full pb-1 sm:pb-0">
            <button class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white">Semua Tenant
                (1,428)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Pro Business
                (1,240)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Enterprise
                (38)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Starter
                (150)</button>
        </div>

        <div class="w-full sm:w-64">
            <input type="text" placeholder="Filter nama toko atau domain..."
                class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-indigo-600">
        </div>
    </div>

    <!-- TENANTS MASTER TABLE -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                    <tr>
                        <th class="py-3 px-4">TENANT ID</th>
                        <th class="py-3 px-4">NAMA TOKO & PEMILIK</th>
                        <th class="py-3 px-4">SUBDOMAIN / CUSTOM DOMAIN</th>
                        <th class="py-3 px-4">PAKET SAAS</th>
                        <th class="py-3 px-4 text-center">TOTAL ASET</th>
                        <th class="py-3 px-4 text-center">STATUS AKUN</th>
                        <th class="py-3 px-4 text-right">AKSI SUPERADMIN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <!-- Tenant 1 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="font-mono font-bold text-slate-900">#TNT-841</td>
                        <td>
                            <div class="font-bold text-slate-900 text-sm">LensaMania Studio & Rental</div>
                            <div class="text-[11px] text-slate-500">Andi Pratama • <code
                                    class="text-slate-700">andi@lensamania.com</code></div>
                        </td>
                        <td class="font-mono text-emerald-700 font-bold">lensamania.sewain.id</td>
                        <td><span class="badge badge-sm badge-success text-white font-bold font-mono">Pro
                                Business</span></td>
                        <td class="text-center font-mono font-bold">48 Unit</td>
                        <td class="text-center"><span
                                class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-bold">Aktif</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="/admin" target="_blank"
                                    class="btn btn-ghost btn-xs text-indigo-600 font-bold">Impersonate</a>
                                <button onclick="alert('Kelola Lisensi Tenant #TNT-841');"
                                    class="btn btn-ghost btn-xs text-slate-600">Edit Tier</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
