<section id="demo" class="border-b border-ink/10 py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl">Lihat toko sewa Anda bekerja</h2>
            <p class="text-ink-soft mt-3 text-base sm:text-lg">Ganti-ganti jenis usaha untuk melihat toko, kalender, dan pemesanan berjalan untuk kamera, armada, atau alat outdoor.</p>
        </div>

        <div class="mt-10 bg-white border border-ink/10 rounded-lg overflow-hidden shadow-[0_24px_60px_-40px_rgba(9,21,64,0.5)]">
            <div class="border-b border-ink/10 px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-booked/70"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-ink/20"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-lunas/70"></span>
                </div>
                <div class="flex items-center gap-2 overflow-x-auto">
                    <button data-tab="kamera" onclick="switchTenantTab('kamera')" class="tenant-tab-btn shrink-0 text-sm font-medium px-3.5 py-1.5 rounded-full border transition-colors bg-ink text-paper border-ink" aria-selected="true">Kamera &amp; studio</button>
                    <button data-tab="otomotif" onclick="switchTenantTab('otomotif')" class="tenant-tab-btn shrink-0 text-sm font-medium px-3.5 py-1.5 rounded-full border transition-colors text-ink-soft border-ink-faint hover:text-ink" aria-selected="false">Mobil &amp; motor</button>
                    <button data-tab="outdoor" onclick="switchTenantTab('outdoor')" class="tenant-tab-btn shrink-0 text-sm font-medium px-3.5 py-1.5 rounded-full border transition-colors text-ink-soft border-ink-faint hover:text-ink" aria-selected="false">Outdoor &amp; acara</button>
                </div>
            </div>

            <div class="flex items-center gap-2 px-4 sm:px-6 py-2.5 bg-paper border-b border-ink/10 font-data text-xs text-ink-soft">
                <svg class="w-4 h-4 text-lunas" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span class="font-semibold text-ink">https://<span id="simulator-url-bar">lensamania.sewain.id</span></span>
                <span class="ml-auto hidden sm:inline text-lunas">Tersambung &amp; aman</span>
            </div>

            <div class="p-5 sm:p-7 grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div id="tenant-preview-container" class="lg:col-span-2">
                    <!-- KAMERA -->
                    <div id="preview-kamera" class="tenant-preview-content">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-display font-bold text-xl">LensaMania Studio &amp; Rental</h3>
                                    <span class="stempel text-lunas" style="transform:none">Terverifikasi</span>
                                </div>
                                <p class="text-ink-soft text-sm mt-0.5">Kamera mirrorless, lensa, dan lampu, Jakarta Selatan</p>
                            </div>
                            <div class="font-data text-sm text-ink-soft">
                                <span class="text-ink font-semibold">48 unit</span> siap disewa
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="border border-ink/10 rounded-md p-4 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-lunas bg-lunas-soft px-2 py-0.5 rounded-full">Siap hari ini</span>
                                    <span class="font-data text-xs text-ink-faint">SNY-A7IV</span>
                                </div>
                                <h4 class="font-display font-semibold">Sony Alpha 7 IV</h4>
                                <p class="text-sm text-ink-soft mt-1">33 MP full-frame, 4K 60p</p>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <div class="font-data font-semibold">Rp 350rb <span class="text-ink-faint font-normal text-xs">/hari</span></div>
                                    <button onclick="selectSimulatedItem('Sony Alpha 7 IV', 350000)" class="text-sm font-semibold text-stempel hover:text-stempel-deep transition-all duration-150 active:scale-[0.96]">Pilih</button>
                                </div>
                            </div>

                            <div class="border border-ink/10 rounded-md p-4 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-lunas bg-lunas-soft px-2 py-0.5 rounded-full">Siap hari ini</span>
                                    <span class="font-data text-xs text-ink-faint">LNS-2470GM</span>
                                </div>
                                <h4 class="font-display font-semibold">Sony 24-70mm f/2.8 GM II</h4>
                                <p class="text-sm text-ink-soft mt-1">Lensa zoom standar profesional</p>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <div class="font-data font-semibold">Rp 250rb <span class="text-ink-faint font-normal text-xs">/hari</span></div>
                                    <button onclick="selectSimulatedItem('Sony 24-70mm GM II', 250000)" class="text-sm font-semibold text-stempel hover:text-stempel-deep transition-all duration-150 active:scale-[0.96]">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OTOMOTIF -->
                    <div id="preview-otomotif" class="tenant-preview-content hidden">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-display font-bold text-xl">TransJava Auto Fleet</h3>
                                    <span class="stempel text-lunas" style="transform:none">Terverifikasi</span>
                                </div>
                                <p class="text-ink-soft text-sm mt-0.5">Mobil lepas kunci dan motor, Surabaya ke Bali</p>
                            </div>
                            <div class="font-data text-sm text-ink-soft">
                                <span class="text-ink font-semibold">24 unit</span> armada aktif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="border border-ink/10 rounded-md p-4 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-lunas bg-lunas-soft px-2 py-0.5 rounded-full">Lepas kunci</span>
                                    <span class="font-data text-xs text-ink-faint">INV-ZENIX</span>
                                </div>
                                <h4 class="font-display font-semibold">Toyota Innova Zenix Hybrid</h4>
                                <p class="text-sm text-ink-soft mt-1">Matic, 7 kursi, GPS</p>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <div class="font-data font-semibold">Rp 750rb <span class="text-ink-faint font-normal text-xs">/24 jam</span></div>
                                    <button onclick="selectSimulatedItem('Innova Zenix Hybrid', 750000)" class="text-sm font-semibold text-stempel hover:text-stempel-deep transition-all duration-150 active:scale-[0.96]">Pilih</button>
                                </div>
                            </div>

                            <div class="border border-ink/10 rounded-md p-4 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-lunas bg-lunas-soft px-2 py-0.5 rounded-full">Siap hari ini</span>
                                    <span class="font-data text-xs text-ink-faint">VSP-150</span>
                                </div>
                                <h4 class="font-display font-semibold">Vespa Primavera 150</h4>
                                <p class="text-sm text-ink-soft mt-1">2 helm + jas hujan</p>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <div class="font-data font-semibold">Rp 175rb <span class="text-ink-faint font-normal text-xs">/24 jam</span></div>
                                    <button onclick="selectSimulatedItem('Vespa Primavera 150', 175000)" class="text-sm font-semibold text-stempel hover:text-stempel-deep transition-all duration-150 active:scale-[0.96]">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OUTDOOR -->
                    <div id="preview-outdoor" class="tenant-preview-content hidden">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-display font-bold text-xl">Rimba Outdoor</h3>
                                    <span class="stempel text-lunas" style="transform:none">Terverifikasi</span>
                                </div>
                                <p class="text-ink-soft text-sm mt-0.5">Tenda, camping, dan sound system, Bandung</p>
                            </div>
                            <div class="font-data text-sm text-ink-soft">
                                <span class="text-ink font-semibold">12 paket</span> siap dipesan
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="border border-ink/10 rounded-md p-4 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-lunas bg-lunas-soft px-2 py-0.5 rounded-full">Paket 4 orang</span>
                                    <span class="font-data text-xs text-ink-faint">CP-EIGER4</span>
                                </div>
                                <h4 class="font-display font-semibold">Tenda Eiger 4P</h4>
                                <p class="text-sm text-ink-soft mt-1">4 matras + 2 sleeping bag</p>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <div class="font-data font-semibold">Rp 120rb <span class="text-ink-faint font-normal text-xs">/malam</span></div>
                                    <button onclick="selectSimulatedItem('Tenda Eiger 4P', 120000)" class="text-sm font-semibold text-stempel hover:text-stempel-deep transition-all duration-150 active:scale-[0.96]">Pilih</button>
                                </div>
                            </div>

                            <div class="border border-ink/10 rounded-md p-4 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-lunas bg-lunas-soft px-2 py-0.5 rounded-full">Siap hari ini</span>
                                    <span class="font-data text-xs text-ink-faint">GS-5000</span>
                                </div>
                                <h4 class="font-display font-semibold">Genset Silent 5000 W</h4>
                                <p class="text-sm text-ink-soft mt-1">Bensin penuh + kabel 50 m</p>
                                <div class="mt-auto pt-4 flex items-center justify-between">
                                    <div class="font-data font-semibold">Rp 450rb <span class="text-ink-faint font-normal text-xs">/hari</span></div>
                                    <button onclick="selectSimulatedItem('Genset Silent 5000 W', 450000)" class="text-sm font-semibold text-stempel hover:text-stempel-deep transition-all duration-150 active:scale-[0.96]">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-landing.booking-panel />
            </div>
        </div>
    </div>
</section>
