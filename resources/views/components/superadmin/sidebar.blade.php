@php
    use App\Models\User;
    use App\Models\Subscription;
    use App\Models\SubscriptionPlan;
    use App\Models\SubscriptionPurchase;
    use App\Models\Feature;
@endphp

<!-- SUPERADMIN SIDEBAR -->
<aside class="w-64 bg-brand-900 border-r border-brand-500/20 flex flex-col h-full sticky top-0 shadow-xl z-20">
    <div class="flex-1 overflow-y-auto no-scrollbar">
        <!-- LOGO & HEADER -->
        <div class="p-6 border-b border-brand-500/20 space-y-4">
            <a href="{{ route('superadmin.dashboard') }}"
                class="flex items-center gap-3 active:scale-95 transition-transform">
                <img src="{{ asset('image/sewain_logo.jpg') }}" alt="" srcset=""
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-300 to-brand-500 shadow-lg shadow-brand-500/20 flex items-center justify-center">
                <div>
                    <span
                        class="font-extrabold text-xl tracking-tight text-white font-heading block leading-none">Sewain</span>
                    <span
                        class="text-[10px] text-brand-300 font-mono font-bold uppercase tracking-wider">Superadmin</span>
                </div>
            </a>
        </div>

        <!-- NAVIGATION MENU -->
        <nav class="p-4 space-y-1 text-xs font-medium">
            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-brand-300/70 px-3 pt-2 pb-1">
                Platform
                Control</div>

            <a href="{{ route('superadmin.dashboard') }}" id="super-nav-overview"
                class="super-nav-btn {{ request()->routeIs('superadmin.dashboard') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold border transition-all active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Master Overview</span>
            </a>

            <a href="{{ route('superadmin-vendor-management.index') }}" id="super-nav-tenants"
                class="super-nav-btn {{ request()->routeIs('superadmin-vendor-management.index') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V8a2 2 0 012-2h2a2 2 0 012 2v3m-6 0h6" />
                    </svg>
                    <span>Manajemen Tenant</span>
                </div>
                <span
                    class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ User::where('role', 'vendor')->count() }}</span>
            </a>

            <a href="{{ route('superadmin.subscription') }}" id="super-nav-subscriptions"
                class="super-nav-btn {{ request()->routeIs('superadmin.subscription') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Langganan</span>
                </div>
                <span
                    class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ Subscription::count() }}</span>
            </a>
            <a href="{{ route('superadmin.subscription-plan') }}" id="super-nav-subscription-plan"
                class="super-nav-btn {{ request()->routeIs('superadmin.subscription-plan') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Paket</span>
                </div>
                <span
                    class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ SubscriptionPlan::count() }}</span>
            </a>
            <a href="{{ route('superadmin.payments') }}" id="super-nav-payments"
                class="super-nav-btn {{ request()->routeIs('superadmin.payments') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Pembayaran</span>
                </div>
                <span
                    class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ SubscriptionPurchase::where('status', 'pending')->count() }}</span>
            </a>
            <a href="{{ route('superadmin.features.index') }}" id="super-nav-features"
                class="super-nav-btn {{ request()->routeIs('superadmin.features.*') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Pengaturan Fitur Global</span>
                </div>
                <span
                    class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ Feature::count() }}</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-brand-500/20 bg-brand-900">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('image/sewain_logo.jpg') }}" alt="" srcset=""
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-300 to-brand-500 shadow-lg shadow-brand-500/20 flex items-center justify-center">
                <div>
                    <div class="text-xs font-bold text-white leading-tight">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-brand-300 font-mono">{{ Auth::user()->role }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('POST')
                <button class="text-brand-300 hover:text-white p-1.5 transition-colors active:scale-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
