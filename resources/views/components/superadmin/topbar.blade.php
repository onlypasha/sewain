<!-- SUPERADMIN TOPBAR -->
<header
    class="bg-white border-b border-slate-200/90 py-3.5 px-6 sticky top-0 z-20 shadow-xs flex items-center justify-between">
    <!-- Global Platform Search Bar -->
    <div class="flex items-center gap-3 flex-1 max-w-md">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" placeholder="Cari nama tenant, subdomain (.sewain.id), atau email pemilik..."
                class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 font-medium">
        </div>
    </div>

    <!-- Right Header Controls -->
    <div class="flex items-center gap-3">
        <!-- Live System Status Badge -->
        <div
            class="hidden sm:flex items-center gap-2 bg-indigo-50 border border-indigo-200 text-indigo-800 text-[11px] font-mono font-semibold px-3 py-1 rounded-full">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Cluster Response: 14ms • All Nodes Healthy</span>
        </div>

        <!-- Notification Bell -->
        <button
            onclick="Swal.fire({ title: 'System Alerts', html: '1. New Enterprise Tenant Provisioned: AutoFleet Bali<br>2. Monthly Billing Cycle Processed: Rp 482.5M Captured<br>3. Database Migration Completed for v2.4', icon: 'info' })"
            class="btn btn-ghost btn-circle btn-sm text-slate-600 hover:text-slate-900 relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-white"></span>
        </button>

        <!-- Primary Action: Create Tenant -->
        {{-- <button onclick="openCreateTenantModal()" class="btn btn-primary btn-sm font-bold text-white shadow-md shadow-indigo-500/20 gap-1.5 bg-indigo-600 hover:bg-indigo-700 border-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Provision Tenant Baru</span>
        </button> --}}
    </div>
</header>
