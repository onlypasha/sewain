<!-- TAB 4: SERVER & PLATFORM HEALTH MONITOR -->
<div id="super-tab-content-system-health" class="superadmin-tab-pane hidden space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Server & Health Monitor Platform</h1>
            <p class="text-slate-500 text-xs mt-0.5">Pantau metrik infra, beban CPU node cluster, latensi database, dan status S3 Storage.</p>
        </div>
        <span class="badge badge-success text-white font-mono font-bold">ALL CLUSTERS HEALTHY (99.98% SLA)</span>
    </div>

    <!-- METRICS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Node 1 -->
        <div class="bg-slate-900 text-white p-6 rounded-3xl border border-slate-800 space-y-4 shadow-lg">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <span class="text-xs font-mono font-bold text-emerald-400">NODE CLUSTER #01 (PRIMARY DB)</span>
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <div class="flex justify-between text-slate-400 mb-1">
                        <span>CPU Utilization</span>
                        <span class="text-emerald-400 font-mono font-bold">24%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full w-[24%] rounded-full"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-slate-400 mb-1">
                        <span>RAM Memory (64 GB)</span>
                        <span class="text-emerald-400 font-mono font-bold">18.2 GB (28.4%)</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full w-[28%] rounded-full"></div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-800 flex justify-between font-mono text-[11px] text-slate-400">
                    <span>Database Latency: <strong class="text-white">12ms</strong></span>
                    <span>Conns: <strong class="text-white">412 / 2000</strong></span>
                </div>
            </div>
        </div>

        <!-- Node 2: Cache & Redis -->
        <div class="bg-slate-900 text-white p-6 rounded-3xl border border-slate-800 space-y-4 shadow-lg">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <span class="text-xs font-mono font-bold text-indigo-400">REDIS CACHE & SESSION</span>
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <div class="flex justify-between text-slate-400 mb-1">
                        <span>Redis Cache Hit Rate</span>
                        <span class="text-indigo-400 font-mono font-bold">98.6%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full w-[98.6%] rounded-full"></div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-800 space-y-1 font-mono text-[11px] text-slate-400">
                    <div class="flex justify-between"><span>Active Sockets:</span><strong class="text-white">1,842 WebSocket Connections</strong></div>
                    <div class="flex justify-between"><span>Memory Used:</span><strong class="text-white">4.1 GB / 16 GB</strong></div>
                </div>
            </div>
        </div>

        <!-- Node 3: Storage -->
        <div class="bg-slate-900 text-white p-6 rounded-3xl border border-slate-800 space-y-4 shadow-lg">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <span class="text-xs font-mono font-bold text-amber-400">S3 ASSET & PDF MEDIA BUCKET</span>
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <div class="flex justify-between text-slate-400 mb-1">
                        <span>Storage Terpakai</span>
                        <span class="text-amber-400 font-mono font-bold">148.4 GB / 2 TB</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full w-[7.4%] rounded-full"></div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-800 space-y-1 font-mono text-[11px] text-slate-400">
                    <div class="flex justify-between"><span>Total PDF Kontrak:</span><strong class="text-white">42,108 Files</strong></div>
                    <div class="flex justify-between"><span>E-KTP Photo Bucket:</span><strong class="text-white">18,920 Encrypted Files</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>