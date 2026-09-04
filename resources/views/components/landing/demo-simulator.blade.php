<!-- INTERACTIVE TENANT STOREFRONT SIMULATOR (SIGNATURE FEATURE) -->
<section id="demo-simulator" class="py-20 bg-slate-100 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="badge badge-primary badge-outline text-emerald-700 bg-emerald-50 font-semibold px-3 py-1 mb-3">
                ⚡ SIMULATOR INTERAKTIF MULTI-TENANT
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading tracking-tight mb-4">
                Satu Platform, Pengalaman Toko Unik Untuk Setiap Niche Rental
            </h2>
            <p class="text-slate-600 text-base sm:text-lg">
                Klik tab di bawah untuk mensimulasikan bagaimana tampilan toko rental, manajemen ketersediaan kalender, dan otomatisasi deposit berjalan untuk berbagai kategori bisnis.
            </p>
        </div>

        <!-- SIMULATOR CONTAINER -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
            <!-- Simulator Header / Tenant Selector Tabs -->
            <div class="bg-slate-900 p-4 border-b border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Browser Window Dots -->
                <div class="flex items-center gap-2 hidden md:flex">
                    <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                    <span class="text-xs font-mono text-slate-400 ml-2">Sewain Multi-Tenant Engine v2.4</span>
                </div>

                <!-- Tenant Niche Selector Buttons -->
                <div class="flex items-center gap-2 overflow-x-auto max-w-full pb-1 md:pb-0 w-full md:w-auto">
                    <button onclick="switchTenantTab('kamera')" id="tab-kamera" class="tenant-tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all flex items-center gap-2 bg-emerald-600 text-white shadow-sm">
                        <span>📸 Camera & Studio</span>
                        <span class="badge badge-xs bg-emerald-400 border-none text-slate-950 font-bold">Live</span>
                    </button>
                    <button onclick="switchTenantTab('otomotif')" id="tab-otomotif" class="tenant-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all flex items-center gap-2 bg-slate-800 text-slate-300 hover:text-white">
                        <span>🚗 Car & Motor Fleet</span>
                    </button>
                    <button onclick="switchTenantTab('outdoor')" id="tab-outdoor" class="tenant-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all flex items-center gap-2 bg-slate-800 text-slate-300 hover:text-white">
                        <span>⛺ Outdoor & Event Gear</span>
                    </button>
                </div>
            </div>

            <!-- Simulator Mock Browser Bar -->
            <div class="bg-slate-100 px-6 py-3 border-b border-slate-200 flex items-center gap-3 text-xs font-mono text-slate-600">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span class="font-bold text-slate-700">SSL Encrypted Tenant Storefront</span>
                </div>
                <div class="flex-1 bg-white border border-slate-300 px-4 py-1 rounded-lg text-slate-700 font-semibold truncate flex items-center justify-between shadow-inner">
                    <span id="simulator-url-bar" class="text-emerald-700 font-bold">https://lensamania.sewain.id</span>
                    <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-bold">TENANT #841</span>
                </div>
            </div>

            <!-- Simulator Live Storefront View -->
            <div class="p-6 md:p-8 bg-slate-50 min-h-[500px]">
                <div id="tenant-preview-container" class="transition-all duration-300">
                    
                    <!-- CONTENT FOR TENANT 1: KAMERA (DEFAULT) -->
                    <div id="preview-kamera" class="tenant-preview-content space-y-6">
                        <!-- Tenant Header Banner -->
                        <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-6 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 font-bold text-2xl">
                                    📷
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-xl font-bold text-white font-heading">LensaMania Studio & Rental</h3>
                                        <span class="badge badge-success badge-sm text-white font-semibold">Verified Tenant</span>
                                    </div>
                                    <p class="text-slate-300 text-xs mt-0.5">Sewa Kamera Mirrorless, Lensa Cinema, & Lighting Professional Jakarta Selatan</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-xl text-xs backdrop-blur-xs border border-white/10">
                                <div>
                                    <div class="text-slate-400">Total Stok Aset</div>
                                    <div class="font-bold text-emerald-400 text-sm">48 Unit Ready</div>
                                </div>
                                <div class="h-6 w-px bg-white/20"></div>
                                <div>
                                    <div class="text-slate-400">Verifikasi Penyewa</div>
                                    <div class="font-bold text-white text-sm">E-KTP + Selfie</div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid Preview: Inventory & Interactive Reservation Card -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left 2 Cols: Inventory Catalogue -->
                            <div class="lg:col-span-2 space-y-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-slate-800 text-base font-heading">Katalog Barang Populer</h4>
                                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">Realtime Calendar Sync Active</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Item 1 -->
                                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs hover:border-emerald-500 transition-all flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start mb-2">
                                                <span class="badge badge-emerald text-[11px] font-semibold bg-emerald-100 text-emerald-800 border-none">Ready Today</span>
                                                <span class="text-xs text-slate-400 font-mono">ID: SNY-A7IV</span>
                                            </div>
                                            <h5 class="font-bold text-slate-900 text-sm mb-1">Sony Alpha 7 IV Body Only</h5>
                                            <p class="text-xs text-slate-500 mb-3">33MP Full-frame, 4K 60p, Dual Slot CFexpress/SD</p>
                                        </div>
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                            <div>
                                                <span class="text-slate-400 text-[11px]">Tarif Sewa:</span>
                                                <div class="font-extrabold text-slate-900 text-base">Rp 350.000 <span class="text-xs font-normal text-slate-500">/hari</span></div>
                                            </div>
                                            <button onclick="selectSimulatedItem('Sony Alpha 7 IV', 350000)" class="btn btn-sm btn-emerald btn-primary text-xs">Pilih Tanggal</button>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs hover:border-emerald-500 transition-all flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start mb-2">
                                                <span class="badge badge-emerald text-[11px] font-semibold bg-emerald-100 text-emerald-800 border-none">Ready Today</span>
                                                <span class="text-xs text-slate-400 font-mono">ID: LNS-2470GM</span>
                                            </div>
                                            <h5 class="font-bold text-slate-900 text-sm mb-1">Sony FE 24-70mm f/2.8 GM II</h5>
                                            <p class="text-xs text-slate-500 mb-3">Lensa zoom standar flagship profesional ultra-sharp</p>
                                        </div>
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                            <div>
                                                <span class="text-slate-400 text-[11px]">Tarif Sewa:</span>
                                                <div class="font-extrabold text-slate-900 text-base">Rp 250.000 <span class="text-xs font-normal text-slate-500">/hari</span></div>
                                            </div>
                                            <button onclick="selectSimulatedItem('Sony 24-70mm GM II', 250000)" class="btn btn-sm btn-outline text-xs border-slate-300">Pilih Tanggal</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tenant Feature Highlights Pills -->
                                <div class="bg-emerald-900/5 p-4 rounded-2xl border border-emerald-900/10 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-700">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Verifikasi WA & E-KTP Otomatis</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>PDF Kontrak Sewa Tanda Tangan Digital</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Deposit Otomatis Kembali</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right 1 Col: Interactive Booking Calculation Card -->
                            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-500/80 shadow-lg flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                                        <div>
                                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-700">Simulasi Pemesanan</span>
                                            <h5 id="sim-item-name" class="font-extrabold text-slate-900 text-sm">Sony Alpha 7 IV Body Only</h5>
                                        </div>
                                        <span class="badge badge-sm badge-warning font-semibold">Durasi Flexible</span>
                                    </div>

                                    <div class="space-y-3 text-xs mb-4">
                                        <div>
                                            <label class="block font-medium text-slate-600 mb-1">Pilih Durasi Sewa (Hari):</label>
                                            <div class="flex items-center gap-2">
                                                <input type="range" id="sim-days-range" min="1" max="7" value="3" 
                                                    class="range range-emerald range-xs flex-1" oninput="updateSimulatedBooking()">
                                                <span id="sim-days-label" class="font-bold text-slate-900 text-sm bg-slate-100 px-2 py-1 rounded border border-slate-200">3 Hari</span>
                                            </div>
                                        </div>

                                        <div class="bg-slate-50 p-3 rounded-xl space-y-2 border border-slate-100">
                                            <div class="flex justify-between text-slate-600">
                                                <span>Biaya Sewa (3x Rp 350k)</span>
                                                <span id="sim-rental-subtotal" class="font-semibold text-slate-900">Rp 1.050.000</span>
                                            </div>
                                            <div class="flex justify-between text-slate-600">
                                                <span>Jaminan Deposit (Refundable)</span>
                                                <span class="font-semibold text-amber-700">Rp 300.000</span>
                                            </div>
                                            <div class="flex justify-between text-slate-600">
                                                <span>Proteksi Alat & Insurance</span>
                                                <span class="font-semibold text-slate-900">Rp 25.000</span>
                                            </div>
                                            <div class="border-t border-slate-200 pt-2 flex justify-between font-bold text-sm text-slate-900">
                                                <span>Total Pembayaran</span>
                                                <span id="sim-total-price" class="text-emerald-600 font-extrabold text-base">Rp 1.375.000</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Simulated Action Button -->
                                    <button onclick="triggerSimulatedCheckout()" class="btn btn-emerald btn-primary w-full text-white font-bold text-xs gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span>Kirim Link Booking ke WA Tenant</span>
                                    </button>
                                </div>

                                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 text-center flex items-center justify-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Powered by Sewain Multi-Tenant Core</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT FOR TENANT 2: OTOMOTIF -->
                    <div id="preview-otomotif" class="tenant-preview-content hidden space-y-6">
                        <div class="bg-gradient-to-r from-blue-950 to-slate-900 rounded-2xl p-6 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-400 font-bold text-2xl">
                                    🚘
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-xl font-bold text-white font-heading">TransJava Auto Fleet Rent</h3>
                                        <span class="badge badge-info badge-sm text-white font-semibold">Subdomain Verified</span>
                                    </div>
                                    <p class="text-slate-300 text-xs mt-0.5">Sewa Mobil Lepas Kunci / Dengan Driver & Motor Matic Surabaya - Bali</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-xl text-xs backdrop-blur-xs border border-white/10">
                                <div>
                                    <div class="text-slate-400">Armada Mobil</div>
                                    <div class="font-bold text-blue-400 text-sm">24 Mobil Ready</div>
                                </div>
                                <div class="h-6 w-px bg-white/20"></div>
                                <div>
                                    <div class="text-slate-400">GPS Tracker</div>
                                    <div class="font-bold text-emerald-400 text-sm">Live Sync</div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                                <div>
                                    <span class="badge badge-sm badge-success text-white">Lepas Kunci / Driver</span>
                                    <h5 class="font-bold text-slate-900 text-base mt-1">Toyota Innova Zenix Hybrid 2024</h5>
                                    <p class="text-xs text-slate-500">Transmisi Matic, Full AC, Kapasitas 7 Seat</p>
                                    <div class="font-extrabold text-emerald-700 text-lg mt-2">Rp 750.000 <span class="text-xs text-slate-500 font-normal">/24 Jam</span></div>
                                </div>
                                <button onclick="Swal.fire({ title: 'Demo Simulator', text: 'Demo: Fitur Sewa Mobil dengan Opsi Driver Terpilih!', icon: 'info' })" class="btn btn-sm btn-primary btn-emerald">Booking Mobil</button>
                            </div>

                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                                <div>
                                    <span class="badge badge-sm badge-info text-white">Motor Touring</span>
                                    <h5 class="font-bold text-slate-900 text-base mt-1">Vespa Primavera 150 i-Get</h5>
                                    <p class="text-xs text-slate-500">Free 2 Helm + Jas Hujan + Holder HP</p>
                                    <div class="font-extrabold text-emerald-700 text-lg mt-2">Rp 175.000 <span class="text-xs text-slate-500 font-normal">/24 Jam</span></div>
                                </div>
                                <button onclick="Swal.fire({ title: 'Demo Simulator', text: 'Demo: Fitur Sewa Motor Terpilih!', icon: 'info' })" class="btn btn-sm btn-outline border-slate-300">Booking Motor</button>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT FOR TENANT 3: OUTDOOR -->
                    <div id="preview-outdoor" class="tenant-preview-content hidden space-y-6">
                        <div class="bg-gradient-to-r from-amber-950 to-slate-900 rounded-2xl p-6 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-400 font-bold text-2xl">
                                    ⛺
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-xl font-bold text-white font-heading">Rimba Outdoor & Event Supply</h3>
                                        <span class="badge badge-warning badge-sm text-slate-950 font-semibold">Tenant Bandung</span>
                                    </div>
                                    <p class="text-slate-300 text-xs mt-0.5">Sewa Alat Camping, Tenda Glamping, Sound System Event & Generator Set</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-xl text-xs backdrop-blur-xs border border-white/10">
                                <div>
                                    <div class="text-slate-400">Paket Camping</div>
                                    <div class="font-bold text-amber-400 text-sm">12 Paket Ready</div>
                                </div>
                                <div class="h-6 w-px bg-white/20"></div>
                                <div>
                                    <div class="text-slate-400">Pengiriman</div>
                                    <div class="font-bold text-white text-sm">Kurir Toko / Takeaway</div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                                <div>
                                    <span class="badge badge-sm badge-warning text-slate-950 font-bold">Paket Hemat 4 Orang</span>
                                    <h5 class="font-bold text-slate-900 text-base mt-1">Paket Camping Tenda Eiger 4P</h5>
                                    <p class="text-xs text-slate-500">Termasuk 4 Matras + 2 Sleeping Bag + Kompor Propan</p>
                                    <div class="font-extrabold text-emerald-700 text-lg mt-2">Rp 120.000 <span class="text-xs text-slate-500 font-normal">/malam</span></div>
                                </div>
                                <button onclick="Swal.fire({ title: 'Demo Simulator', text: 'Demo: Paket Camping Terpilih!', icon: 'info' })" class="btn btn-sm btn-primary btn-emerald">Sewa Alat</button>
                            </div>

                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                                <div>
                                    <span class="badge badge-sm badge-neutral text-white">Event Equipment</span>
                                    <h5 class="font-bold text-slate-900 text-base mt-1">Genset Silent 5000 Watt</h5>
                                    <p class="text-xs text-slate-500">Bensin Penuh + Kabel Roll 50 Meter</p>
                                    <div class="font-extrabold text-emerald-700 text-lg mt-2">Rp 450.000 <span class="text-xs text-slate-500 font-normal">/hari</span></div>
                                </div>
                                <button onclick="Swal.fire({ title: 'Demo Simulator', text: 'Demo: Genset Terpilih!', icon: 'info' })" class="btn btn-sm btn-outline border-slate-300">Sewa Genset</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>