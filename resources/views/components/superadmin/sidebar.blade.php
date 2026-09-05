@php
    use App\Models\User;
    use App\Models\Subscription;
    use App\Models\SubscriptionPlan;
    use App\Models\SubscriptionPurchase;
@endphp

<!-- SUPERADMIN SIDEBAR -->
<aside
    class="w-64 bg-slate-950 text-white flex flex-col justify-between shrink-0 h-screen sticky top-0 border-r border-slate-800 z-30 transition-all">
    <div>
        <!-- MASTER PLATFORM BRAND -->
        <div class="p-5 border-b border-slate-800">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 group mb-3">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V8a2 2 0 012-2h2a2 2 0 012 2v3m-6 0h6">
                        </path>
                    </svg>
                </div>
                <div>
                    <span
                        class="font-extrabold text-xl tracking-tight text-white font-heading block leading-none">Sewain</span>
                    <span
                        class="text-[10px] text-indigo-400 font-mono font-bold uppercase tracking-wider">Superadmin</span>
                </div>
            </a>

            <!-- System Role Pill -->
            {{-- <div class="bg-slate-900 p-2.5 rounded-xl border border-slate-800 flex items-center justify-between">
                <div>
                    <div class="text-[10px] text-slate-400 font-mono uppercase font-semibold">ROLE AKSES:</div>
                    <div class="text-xs font-bold text-indigo-300 font-mono">Platform Root Superadmin</div>
                </div>
            </div> --}}
        </div>

        <!-- NAVIGATION MENU -->
        <nav class="p-4 space-y-1 text-xs font-medium">
            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500 px-3 pt-2 pb-1">Platform
                Control</div>

            <a href="{{ route('superadmin.dashboard') }}" id="super-nav-overview"
                class="super-nav-btn active w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-400 bg-emerald-500/10 font-bold border border-emerald-500/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Master Overview</span>
            </a>

            <a href="{{ route('superadmin-vendor-management.index') }}" id="super-nav-tenants"
                class="super-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V8a2 2 0 012-2h2a2 2 0 012 2v3m-6 0h6" />
                    </svg>
                    <span>Manajemen Tenant</span>
                </div>
                <span
                    class="badge badge-xs bg-emerald-500 border-none text-white font-mono font-bold">{{ User::where('role', 'vendor')->count() }}</span>
            </a>

            <a href="{{ route('superadmin.subscription') }}" id="super-nav-subscriptions"
                class="super-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Langganan</span>
                </div>
                <span
                    class="badge badge-xs bg-emerald-500 border-none text-white font-mono font-bold">{{ Subscription::count() }}</span>
            </a>
            <a href="{{ route('superadmin.subscription-plan') }}" id="super-nav-subscription-plan"
                class="super-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Paket</span>
                </div>
                <span
                    class="badge badge-xs bg-emerald-500 border-none text-white font-mono font-bold">{{ SubscriptionPlan::count() }}</span>
            </a>
            <a href="{{ route('superadmin.payments') }}" id="super-nav-subscription-plan"
                class="super-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Pembayaran</span>
                </div>
                <span
                    class="badge badge-xs bg-emerald-500 border-none text-white font-mono font-bold">{{ SubscriptionPurchase::where('status', 'pending')->count() }}</span>
            </a>
        </nav>
    </div>

    <!-- SIDEBAR FOOTER & USER PROFILE -->
    <div class="p-4 border-t border-slate-800 bg-slate-900/80">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center font-heading text-xs">
                    SA
                </div>
                <div>
                    <div class="text-xs font-bold text-white leading-tight">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-indigo-400 font-mono">{{ Auth::user()->role }}</div>
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
