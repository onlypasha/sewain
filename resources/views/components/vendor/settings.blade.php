<!-- TAB 5: PENGATURAN STOREFRONT & DOMAIN -->
<div id="tab-content-settings" class="admin-tab-pane hidden space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Pengaturan Toko & Custom Domain</h1>
            <p class="text-slate-500 text-xs mt-0.5">Konfigurasi tampilan storefront, subdomain eksklusif, dan integrasi WhatsApp bot.</p>
        </div>
        <button onclick="alert('Pengaturan Toko Berhasil Disimpan!');" class="btn btn-emerald btn-primary btn-sm font-bold shadow-md">Simpan Perubahan</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Card 1: Domain & Subdomain -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-base font-heading border-b border-slate-100 pb-3">Konfigurasi Domain Toko</h3>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Subdomain Sewain Utama:</label>
                    <div class="flex items-center gap-2">
                        <input type="text" value="lensamania" class="input input-bordered input-sm font-mono text-emerald-700 font-bold flex-1">
                        <span class="font-mono text-slate-500 font-bold">.sewain.id</span>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Custom Domain Pribadi (Paket Pro):</label>
                    <input type="text" value="www.lensamaniastudio.com" class="input input-bordered input-sm font-mono w-full text-slate-800">
                    <span class="text-[11px] text-slate-400 mt-1 block">A-Record DNS: <code class="text-slate-700">103.152.118.42</code></span>
                </div>
            </div>
        </div>

        <!-- Card 2: WhatsApp Bot & Notifications -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-base font-heading border-b border-slate-100 pb-3">WhatsApp Auto Reminder Bot</h3>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor WA Admin Penerima Notifikasi:</label>
                    <input type="text" value="+6281234567890" class="input input-bordered input-sm font-mono w-full">
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span>Kirim Pengingat Pengembalian H-1</span>
                    <input type="checkbox" checked class="toggle toggle-emerald toggle-sm">
                </div>

                <div class="flex items-center justify-between">
                    <span>Otomatis Tagih Denda Keterlambatan</span>
                    <input type="checkbox" checked class="toggle toggle-emerald toggle-sm">
                </div>
            </div>
        </div>
    </div>
</div>