<!-- SUBDOMAIN CHECKER WIDGET -->
<section id="subdomain-checker" class="py-10 bg-slate-900 text-white relative border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8 bg-slate-800/80 p-6 md:p-8 rounded-3xl border border-slate-700/80 shadow-2xl">
            <div class="lg:w-1/2">
                <div class="inline-flex items-center gap-2 text-emerald-400 font-semibold text-xs uppercase tracking-wider mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    Instant Multi-Tenant Provisioning
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-white mb-2">Cek Ketersediaan Subdomain Toko Anda</h2>
                <p class="text-slate-300 text-sm">Dapatkan alamat web eksklusif untuk katalog rental Anda dalam hitungan detik.</p>
            </div>

            <div class="lg:w-1/2 w-full">
                <div class="relative">
                    <div class="flex items-center bg-slate-950 border-2 border-slate-700 rounded-2xl p-1.5 focus-within:border-emerald-500 transition-all shadow-inner">
                        <span class="pl-4 pr-1 text-slate-500 font-mono text-sm hidden sm:inline">https://</span>
                        <input type="text" id="tenant-domain-input" value="lensamania" placeholder="nama-toko-anda" 
                            class="bg-transparent text-white font-mono font-semibold text-base sm:text-lg focus:outline-none flex-1 py-2 px-2"
                            oninput="updateDomainChecker(this.value)">
                        <span class="pr-3 text-emerald-400 font-mono font-bold text-sm sm:text-base">.sewain.id</span>
                        <button onclick="claimDomainNow()" class="btn btn-emerald btn-primary text-white font-bold px-5 rounded-xl shadow-md">
                            Klaim Toko
                        </button>
                    </div>
                    <!-- Dynamic Availability Status Indicator -->
                    <div id="domain-status-box" class="mt-3 flex items-center justify-between text-xs font-mono px-2">
                        <span class="text-emerald-400 flex items-center gap-1.5 font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span id="domain-preview-text">lensamania.sewain.id</span> TERSEDIA!
                        </span>
                        <span class="text-slate-400">Setup Instan • 100% Gratis Trial</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>