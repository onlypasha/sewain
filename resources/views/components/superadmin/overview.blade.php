<!-- TAB 1: MASTER OVERVIEW SUPERADMIN -->
<div id="super-tab-content-overview" class="superadmin-tab-pane space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div
                class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-indigo-600 uppercase tracking-wider mb-1">
                <span>⚡ PLATFORM ENGINE METRICS</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Konsol Eksekutif Superadmin</h1>
            <p class="text-slate-500 text-xs mt-0.5">Ringkasan performa finansial MRR, pertumbuhan tenant, dan kesehatan
                server platform Sewain.</p>
        </div>
        {{-- <div class="flex items-center gap-2">
            <span class="text-xs text-slate-400 font-mono">Tahun Fiskal:</span>
            <select class="select select-bordered select-xs text-xs font-semibold text-slate-700 bg-white">
                <option selected>2026 (Q3 Active)</option>
                <option>2025 (Audited)</option>
            </select>
        </div> --}}
    </div>

    <!-- STAT CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat 1: MRR -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Monthly Recurring Revenue</span>
                <div
                    class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                    📈
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">Rp 482.500.000</div>
                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>+18.4% MRR GrowthMoM</span>
                </div>
            </div>
        </div>

        <!-- Stat 2: Active Tenants -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tenant Aktif Platform</span>
                <div
                    class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">
                    🏬
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">1,428 Tenant</div>
                <div class="flex items-center gap-1.5 text-xs text-indigo-600 font-semibold mt-1">
                    <span>1,240 Pro • 38 Enterprise</span>
                </div>
            </div>
        </div>

        <!-- Stat 3: Platform GMV -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Nilai Transaksi GMV</span>
                <div
                    class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                    💎
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">Rp 68.4 Miliar</div>
                <div class="flex items-center gap-1.5 text-xs text-amber-700 font-semibold mt-1">
                    <span>Total Sewa Diproses Tenant</span>
                </div>
            </div>
        </div>

        <!-- Stat 4: Cluster Health -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Uptime Database Server</span>
                <div
                    class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-sm">
                    ⚡
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">99.98% SLA</div>
                <div class="flex items-center gap-1.5 text-xs text-teal-600 font-semibold mt-1">
                    <span>Latency Rata-rata 14ms</span>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT TENANTS PROVISIONED & SUBSCRIPTION PLAN BREAKDOWN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Tenant Provisioning Log -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-base font-heading">Tenant Baru Bergabung</h3>
                    <p class="text-xs text-slate-500">Pendaftaran akun toko sewa terbaru di platform Sewain.</p>
                </div>
                <button onclick="switchSuperadminTab('tenants')"
                    class="text-xs font-bold text-indigo-600 hover:underline">Kelola Semua Tenant &rarr;</button>
            </div>

            <div class="space-y-3">
                <!-- Tenant Item 1 -->
                <div
                    class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-indigo-500 transition-all">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-xs">
                            LM
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm">LensaMania Studio & Rental</span>
                                <span class="badge badge-xs badge-success text-white font-mono font-bold">PRO
                                    BUSINESS</span>
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">Subdomain: <code
                                    class="text-emerald-700 font-mono font-bold">lensamania.sewain.id</code> • Pemilik:
                                <strong>Andi Pratama</strong>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button onclick="alert('Membuka konsol impersonate tenant LensaMania Studio...');"
                            class="btn btn-xs btn-outline border-slate-300 font-semibold text-slate-700">Impersonate
                            Admin</button>
                        <button onclick="alert('Detail konfigurasi tenant LensaMania Studio.');"
                            class="btn btn-xs btn-primary bg-indigo-600 hover:bg-indigo-700 border-none font-bold">Detail
                            Tenant</button>
                    </div>
                </div>

                <!-- Tenant Item 2 -->
                <div
                    class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-indigo-500 transition-all">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center text-xs">
                            TJ
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm">TransJava Auto Fleet</span>
                                <span
                                    class="badge badge-xs bg-slate-900 text-white font-mono font-bold">ENTERPRISE</span>
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">Custom Domain: <code
                                    class="text-emerald-700 font-mono font-bold">www.transjavafleet.com</code> •
                                Pemilik: <strong>Deni Wijaya</strong></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button onclick="alert('Membuka konsol impersonate tenant TransJava Fleet...');"
                            class="btn btn-xs btn-outline border-slate-300 font-semibold text-slate-700">Impersonate
                            Admin</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Subscription Plan Revenue Mix -->
        <div
            class="bg-slate-900 text-white p-6 rounded-3xl border border-slate-800 shadow-lg flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                    <span class="text-xs font-mono text-indigo-400 font-bold uppercase tracking-wider">Distribusi Paket
                        Langganan</span>
                    <span class="badge badge-xs badge-info text-white font-mono">DISTRIBUTION</span>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="space-y-1">
                        <div class="flex justify-between font-bold text-slate-200">
                            <span>Pro Business Plan (Rp 349k/bln)</span>
                            <span class="text-emerald-400 font-mono">1,240 Tenant (86.8%)</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full w-[86%] rounded-full"></div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between font-bold text-slate-200">
                            <span>Starter Plan (Rp 149k/bln)</span>
                            <span class="text-amber-400 font-mono">150 Tenant (10.5%)</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full w-[10%] rounded-full"></div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between font-bold text-slate-200">
                            <span>Enterprise Multi-Branch (Rp 799k/bln)</span>
                            <span class="text-indigo-400 font-mono">38 Tenant (2.7%)</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-indigo-500 h-full w-[2.7%] rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-6 pt-4 border-t border-slate-800 text-[11px] text-slate-400 flex items-center justify-between">
                <span>Billing Gateway: Midtrans / Xendit Sync</span>
                <a href="#subscriptions" onclick="switchSuperadminTab('subscriptions')"
                    class="text-indigo-400 hover:underline">Kelola Billing</a>
            </div>
        </div>
    </div>
</div>
