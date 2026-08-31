<!-- TAB 1: MASTER OVERVIEW SUPERADMIN -->
@php
    use App\Models\Subscription;
    use App\Models\User;
    use App\Models\SubscriptionPlan;
@endphp

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
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tenant Platform</span>
                <div
                    class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">
                    🏬
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">
                    {{ User::where('role', 'vendor')->count() }} Tenant</div>
                <div class="flex items-center gap-1.5 text-xs text-indigo-600 font-semibold mt-1">
                    <span>{{ User::where('role', 'vendor')->get()->where('status', 'active')->count() }} tenan
                        aktif</span>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">jumlah Berlangganan</span>
                <div
                    class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">
                    🏬
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">
                    {{ Subscription::count() }} berlangganan</div>
                <div class="flex items-center gap-1.5 text-xs text-indigo-600 font-semibold mt-1">
                    <span>{{ Subscription::where('status', 'active')->count() }} langganan aktif</span>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">jumlah plan langganan</span>
                <div
                    class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">
                    🏬
                </div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">
                    {{ SubscriptionPlan::count() }} paket</div>
                <div class="flex items-center gap-1.5 text-xs text-indigo-600 font-semibold mt-1">
                    <span>{{ SubscriptionPlan::where('is_active', '1')->count() }} paket aktif</span>
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
                <a href="{{ route('superadmin-vendor-management.index') }}"
                    class="text-xs font-bold text-indigo-600 hover:underline">Kelola Semua Tenant &rarr;</a>
            </div>

            <div class="space-y-3">
                <!-- Tenant Item 1 -->
                @forelse($latestVendors as $vendor)
                    <div
                        class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-indigo-500 transition-all">
                        <div class="flex items-center gap-3">

                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-900 text-sm">{{ $vendor->name }}</span>
                                    |
                                    <span class="text-sm">
                                        {{ $vendor->vendorProfiles?->subscriptions->first()?->subscriptionPlan?->name ?? 'tidak berlangganan' }}</span>
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">Subdomain: <code
                                        class="text-emerald-700 font-mono font-bold">{{ $vendor->slug }}.sewain.id</code>
                                    •
                                    Pemilik:
                                    <strong>{{ $vendor->vendorProfiles->owner_name }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <x-util.alert variant="danger">
                        Tidak ada tenant terdaftar
                    </x-util.alert>
                @endforelse
            </div>
        </div>

        <!-- Right 1 Col: Subscription Plan Revenue Mix -->
        <div
            class="bg-slate-900 text-white p-6 rounded-3xl border border-slate-800 shadow-lg flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                    <span class="text-xs font-mono text-indigo-400 font-bold uppercase tracking-wider">Distribusi Paket
                        Langganan</span>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="space-y-1">
                        <div class="flex justify-between font-bold text-slate-200">
                            <span>Paket PRO</span>
                            <span
                                class="text-emerald-400 font-mono">{{ Subscription::whereHas('subscriptionPlan', fn($q) => $q->where('slug', 'like', '%basic%'))->count() }}
                                Tenant</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between font-bold text-slate-200">
                            <span>Paket PRO</span>
                            <span
                                class="text-amber-400 font-mono">{{ Subscription::whereHas('subscriptionPlan', fn($q) => $q->where('slug', 'like', '%pro%'))->count() }}
                                Tenant</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between font-bold text-slate-200">
                            <span>Paket ENTERPRISE</span>
                            <span
                                class="text-indigo-400 font-mono">{{ Subscription::whereHas('subscriptionPlan', fn($q) => $q->where('slug', 'like', '%enterprise%'))->count() }}
                                Tenant</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
