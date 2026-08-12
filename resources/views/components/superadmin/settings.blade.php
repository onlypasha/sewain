<!-- TAB 5: PENGATURAN PLATFORM SUPERADMIN -->
<div id="super-tab-content-settings" class="superadmin-tab-pane hidden space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Pengaturan Global Platform Engine</h1>
            <p class="text-slate-500 text-xs mt-0.5">Konfigurasi parameter global multi-tenant, durasi trial, dan integrasi payment gateway utama.</p>
        </div>
        <button onclick="alert('Pengaturan Global Platform Berhasil Disimpan!');" class="btn btn-primary btn-sm font-bold shadow-md bg-indigo-600 border-none">Simpan Pengaturan Platform</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Card 1: Multi-Tenant Provisioning Defaults -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-base font-heading border-b border-slate-100 pb-3">Parameter Multi-Tenant Provisioning</h3>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Domain TLD Default Tenant:</label>
                    <input type="text" value=".sewain.id" class="input input-bordered input-sm font-mono w-full text-emerald-700 font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Durasi Free Trial Default (Hari):</label>
                    <input type="number" value="14" class="input input-bordered input-sm font-mono w-full">
                </div>
            </div>
        </div>

        <!-- Card 2: Master Payment Gateway Keys -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-base font-heading border-b border-slate-100 pb-3">Master Payment Gateway Keys (Xendit / Midtrans)</h3>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Xendit Secret Server Key (Production):</label>
                    <input type="password" value="xnd_production_master_894812398" class="input input-bordered input-sm font-mono w-full">
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span>Izinkan Pendaftaran Tenant Baru (Public Sign Up)</span>
                    <input type="checkbox" checked class="toggle toggle-indigo toggle-sm">
                </div>
            </div>
        </div>
    </div>
</div>