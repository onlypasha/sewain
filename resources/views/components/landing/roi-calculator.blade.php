<!-- INTERACTIVE ROI & TIME SAVINGS CALCULATOR -->
<section id="kalkulator" class="py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="badge badge-emerald text-emerald-800 bg-emerald-100 font-semibold px-3 py-1 mb-2">SIMULATOR EFISIENSI & REVENUE</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading tracking-tight">Berapa Banyak Waktu & Biaya yang Bisa Anda Hemat?</h2>
            <p class="text-slate-600 mt-2 text-base">Geser slider di bawah untuk mensimulasikan dampak Sewain pada skala bisnis rental Anda saat ini.</p>
        </div>

        <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-xl max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Controls Left (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Slider 1 -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-800">Jumlah Unit Aset / Barang Rental:</label>
                        <span id="roi-asset-count" class="font-extrabold text-emerald-600 text-base font-mono bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">40 Unit</span>
                    </div>
                    <input type="range" min="5" max="200" value="40" class="range range-emerald range-sm" id="roi-slider-assets" oninput="calculateROI()">
                    <div class="flex justify-between text-[11px] text-slate-400 mt-1 font-mono">
                        <span>5 Unit</span>
                        <span>100 Unit</span>
                        <span>200 Unit</span>
                    </div>
                </div>

                <!-- Slider 2 -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-800">Rata-Rata Transaksi Sewa per Bulan:</label>
                        <span id="roi-trans-count" class="font-extrabold text-emerald-600 text-base font-mono bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">60 Transaksi</span>
                    </div>
                    <input type="range" min="10" max="300" value="60" class="range range-emerald range-sm" id="roi-slider-trans" oninput="calculateROI()">
                    <div class="flex justify-between text-[11px] text-slate-400 mt-1 font-mono">
                        <span>10 Sewa/bln</span>
                        <span>150 Sewa/bln</span>
                        <span>300 Sewa/bln</span>
                    </div>
                </div>

                <!-- Slider 3 -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-800">Harga Rata-Rata Sewa per Item:</label>
                        <span id="roi-avg-price" class="font-extrabold text-emerald-600 text-base font-mono bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Rp 250.000</span>
                    </div>
                    <input type="range" min="50000" max="1500000" step="25000" value="250000" class="range range-emerald range-sm" id="roi-slider-price" oninput="calculateROI()">
                    <div class="flex justify-between text-[11px] text-slate-400 mt-1 font-mono">
                        <span>Rp 50rb</span>
                        <span>Rp 750rb</span>
                        <span>Rp 1.5 Juta</span>
                    </div>
                </div>
            </div>

            <!-- Results Right (5 cols) -->
            <div class="lg:col-span-5 bg-slate-900 rounded-2xl p-6 text-white flex flex-col justify-between border border-slate-800 shadow-inner">
                <div>
                    <div class="text-xs font-mono text-emerald-400 font-semibold mb-4 uppercase tracking-wider">Hasil Proyeksi Efisiensi Monthly</div>

                    <div class="space-y-4">
                        <div class="border-b border-slate-800 pb-3">
                            <div class="text-xs text-slate-400">Waktu Admin Diterhemat</div>
                            <div id="roi-res-hours" class="text-2xl font-extrabold text-white font-heading mt-1">45 Jam / Bulan</div>
                            <div class="text-[11px] text-emerald-400 mt-0.5">Setara hemat 1 staf admin full-time</div>
                        </div>

                        <div class="border-b border-slate-800 pb-3">
                            <div class="text-xs text-slate-400">Pencegahan Omset Hilang (Double Booking)</div>
                            <div id="roi-res-loss" class="text-2xl font-extrabold text-emerald-400 font-heading mt-1">Rp 2.250.000</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Dari potensi kesalahan pencatatan manual</div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-400">Potensi Tambahan Revenue (Storefront 24/7)</div>
                            <div id="roi-res-revenue" class="text-3xl font-extrabold text-amber-400 font-heading mt-1">+ Rp 3.750.000</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Dari transaksi pemesanan di luar jam kerja toko</div>
                        </div>
                    </div>
                </div>

                <a href="#harga" class="btn btn-emerald btn-primary w-full mt-6 text-white font-bold">
                    Mulai Efisiensikan Toko Sekarang
                </a>
            </div>
        </div>
    </div>
</section>