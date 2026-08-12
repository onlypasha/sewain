<!-- PRICING SECTION -->
<section id="harga" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-xs font-mono font-bold uppercase tracking-widest text-emerald-600 mb-3">PAKET SUBSCRIPTION TRANSPARAN</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading tracking-tight">Investasi Kecil untuk Efisiensi Bisnis Maksimal</h3>
            <p class="text-slate-600 mt-2 text-base">Tanpa potongan komisi per transaksi sewa. Semua keuntungan milik toko Anda 100%.</p>

            <!-- Billing Cycle Toggle -->
            <div class="mt-8 inline-flex items-center gap-3 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                <button onclick="toggleBilling('monthly')" id="btn-billing-monthly" class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white text-slate-900 shadow-xs">
                    Ditagih Bulanan
                </button>
                <button onclick="toggleBilling('yearly')" id="btn-billing-yearly" class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 hover:text-slate-900 flex items-center gap-1.5">
                    <span>Tahunan</span>
                    <span class="badge badge-success text-[10px] text-white font-bold">HEMAT 20%</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <!-- Starter Plan -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                <div>
                    <div class="text-xs font-bold font-mono text-slate-500 uppercase tracking-wider mb-2">STARTER TENANT</div>
                    <h4 class="text-xl font-bold text-slate-900 font-heading mb-2">Untuk Rental Pemula</h4>
                    <p class="text-xs text-slate-500 mb-6">Cocok untuk pemilik bisnis rental perorangan yang baru mulai go-digital.</p>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading" id="price-starter">Rp 99.000</span>
                            <span class="text-xs text-slate-500 font-medium">/ bulan</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-mono block mt-1" id="subtext-starter">Ditagih bulanan</span>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-700 mb-8 border-t border-slate-200/80 pt-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Hingga <strong>40 Unit Aset Rental</strong></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Subdomain <code class="text-slate-800 font-mono">namatoko.sewain.id</code></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Kalender Ketersediaan Realtime</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Verifikasi E-KTP Penyewa</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>1 Akun Admin Operator</span>
                        </li>
                    </ul>
                </div>

                <button onclick="selectPlan('Starter')" class="btn btn-outline border-slate-300 hover:bg-slate-900 hover:text-white w-full text-slate-800 font-bold">
                    Coba 5 Hari Gratis
                </button>
            </div>

            <!-- PRO BUSINESS Plan (POPULAR) -->
            <div class="bg-slate-900 p-8 rounded-3xl border-2 border-emerald-500 shadow-2xl flex flex-col justify-between text-white relative transform md:-translate-y-2">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-emerald-500 text-slate-950 font-extrabold text-[11px] uppercase tracking-wider px-4 py-1 rounded-full shadow-md">
                    🔥 PALING POPULER & DIREKOMENDASIKAN
                </div>

                <div>
                    <div class="text-xs font-bold font-mono text-emerald-400 uppercase tracking-wider mb-2 mt-2">PRO BUSINESS</div>
                    <h4 class="text-xl font-bold text-white font-heading mb-2">Untuk Rental Scalable</h4>
                    <p class="text-xs text-slate-300 mb-6">Untuk bisnis rental berkembang yang membutuhkan custom domain & kontrak digital.</p>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white font-heading" id="price-pro">Rp 299.000</span>
                            <span class="text-xs text-slate-400 font-medium">/ bulan</span>
                        </div>
                        <span class="text-[11px] text-emerald-400 font-mono block mt-1" id="subtext-pro">Ditagih bulanan</span>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-200 mb-8 border-t border-slate-800 pt-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>UNLIMITED Unit Aset Rental</strong></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Custom Domain milik sendiri (<code class="text-emerald-300">namatoko.com</code>)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>PDF Kontrak Digital</strong> + Tanda Tangan</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Bot WhatsApp Notification Auto Reminder</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Payment Gateway QRIS, Virtual Account, Credit Card</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Hingga 5 Akun Admin & Staf Operasional</span>
                        </li>
                    </ul>
                </div>

                <button onclick="selectPlan('Pro Business')" class="btn btn-emerald btn-primary w-full text-white font-bold shadow-lg shadow-emerald-500/20">
                    Coba 14 Hari Gratis Pro
                </button>
            </div>
        </div>
    </div>
</section>