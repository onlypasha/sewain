<!-- ADMIN SIDEBAR -->
<aside
    class="w-64 bg-slate-900 text-white flex flex-col justify-between shrink-0 h-screen sticky top-0 border-r border-slate-800 z-30 transition-all">
    <div>
        <!-- BRAND & TENANT IDENTIFIER -->
        <div class="p-5 border-b border-slate-800">
            <a href="/" class="flex items-center gap-3 group mb-3">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-emerald-400 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V8a2 2 0 012-2h2a2 2 0 012 2v3m-6 0h6">
                        </path>
                    </svg>
                </div>
                <div>
                    <span
                        class="font-extrabold text-lg tracking-tight text-white font-heading block leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-emerald-400 font-mono">Tenant Operator Console</span>
                </div>
            </a>

            <!-- Active Store Subdomain Switcher Box -->
            <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800 flex items-center justify-between">
                <div class="truncate">
                    <div class="text-[10px] text-slate-400 font-mono uppercase font-semibold">TOKO AKTIF:</div>
                    <div class="text-xs font-bold text-white font-mono truncate">lensamania.sewain.id</div>
                </div>
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
            </div>
        </div>

        <!-- NAVIGATION MENU -->
        <nav class="p-4 space-y-1 text-xs font-medium">
            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500 px-3 pt-2 pb-1">Menu
                Utama</div>

            <button onclick="switchAdminTab('overview')" id="nav-overview"
                class="admin-nav-btn active w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-400 bg-emerald-500/10 font-bold border border-emerald-500/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Ringkasan Dashboard</span>
            </button>

            <button onclick="switchAdminTab('inventory')" id="nav-inventory"
                class="admin-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Katalog & Stok Aset</span>
                </div>
                <span class="badge badge-xs bg-slate-800 border border-slate-700 text-slate-300 font-mono">48</span>
            </button>

            <button onclick="switchAdminTab('bookings')" id="nav-bookings"
                class="admin-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Transaksi & Booking</span>
                </div>
                <span class="badge badge-xs bg-emerald-500 border-none text-white font-mono font-bold">5 Baru</span>
            </button>

            <button onclick="switchAdminTab('verifications')" id="nav-verifications"
                class="admin-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Verifikasi E-KTP</span>
                </div>
                <span class="badge badge-xs bg-amber-500 border-none text-slate-950 font-bold">2 Pend</span>
            </button>

            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500 px-3 pt-4 pb-1">
                Pengaturan & Toko</div>

            <button onclick="switchAdminTab('settings')" id="nav-settings"
                class="admin-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan Storefront</span>
            </button>

            <a href="/" target="_blank"
                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-emerald-400 hover:bg-slate-800 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Lihat Toko Live</span>
                </div>
                <span class="text-[10px] text-slate-500 font-mono">↗</span>
            </a>
        </nav>
    </div>

    <!-- SIDEBAR FOOTER & PLAN STATS -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/60">
        <div class="bg-slate-900 p-3 rounded-xl border border-slate-800 mb-3">
            <div class="flex items-center justify-between text-[11px] font-mono mb-1">
                <span class="text-slate-400">Kuota Aset</span>
                <span class="text-emerald-400 font-bold">48 / 100</span>
            </div>
            <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full w-[48%] rounded-full"></div>
            </div>
            <div class="text-[10px] text-slate-500 mt-1.5 flex items-center justify-between">
                <span>Paket Pro Business</span>
                <a href="/#harga" class="text-emerald-400 underline font-semibold">Upgrade</a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center font-heading text-xs">
                    LM
                </div>
                <div>
                    <div class="text-xs font-bold text-white leading-tight">{{ Auth::user()->email }}</div>
                    <div class="text-[10px] text-slate-400">Vendor / Sewain</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('POST')
                <button class="text-slate-400 hover:text-rose-400 p-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
