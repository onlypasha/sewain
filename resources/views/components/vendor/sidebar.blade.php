@php
    $isSubActive = Auth::user()?->isSubscriptionActive() ?? false;

    $hasAssetAccess = $isSubActive && Auth::user()?->hasFeatureAccess('asset_management');
    $assetErrorMsg = !$isSubActive
        ? 'Langganan Anda tidak aktif. Menu ini terkunci.'
        : 'Paket langganan Anda tidak mencakup fitur Katalog Aset.';

    $hasCategoryAccess = $isSubActive && Auth::user()?->hasFeatureAccess('category_management');
    $categoryErrorMsg = !$isSubActive
        ? 'Langganan Anda tidak aktif. Menu ini terkunci.'
        : 'Paket langganan Anda tidak mencakup fitur Kategori Aset.';

    $hasBookingAccess = $isSubActive && Auth::user()?->hasFeatureAccess('booking_system');
    $bookingErrorMsg = !$isSubActive
        ? 'Langganan Anda tidak aktif. Menu ini terkunci.'
        : 'Paket langganan Anda tidak mencakup fitur Transaksi & Booking.';

    $hasVerifikasiAccess = $isSubActive && Auth::user()?->hasFeatureAccess('verifikasi_ktp');
    $verifikasiErrorMsg = !$isSubActive
        ? 'Langganan Anda tidak aktif. Menu ini terkunci.'
        : 'Paket langganan Anda tidak mencakup fitur Verifikasi KTP.';
@endphp

<!-- VENDOR SIDEBAR -->
<aside class="w-64 bg-brand-900 border-r border-brand-500/20 flex flex-col h-full sticky top-0 shadow-xl z-20">
    <div class="flex-1 overflow-y-auto no-scrollbar">
        <!-- BRAND & TENANT IDENTIFIER -->
        <div class="p-6 border-b border-brand-500/20 space-y-4">
            <a href="/" class="flex items-center gap-3 active:scale-95 transition-transform">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-300 to-brand-500 p-0 shadow-lg shadow-brand-500/20 flex items-center justify-center overflow-hidden">
                    <img src="{{ Storage::url(Auth::user()->vendorProfiles->profiles_picture) }}" alt="Foto Profil Vendor" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="font-extrabold text-lg tracking-tight text-white font-heading block leading-none truncate w-32">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-brand-300 font-mono font-bold uppercase tracking-wider">Tenant Console</span>
                </div>
            </a>

            <!-- Active Store Subdomain Switcher Box -->
            <div class="bg-brand-900/50 p-2.5 rounded-xl border border-brand-500/20 flex items-center justify-between">
                <div class="truncate">
                    <div class="text-[10px] text-brand-300/70 font-mono uppercase font-semibold">TOKO AKTIF:</div>
                    <div class="text-xs font-bold text-white font-mono truncate">{{ Auth::user()->slug }}.sewain.id</div>
                </div>
                <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse shrink-0"></span>
            </div>
        </div>

        <!-- NAVIGATION MENU -->
        <nav class="p-4 space-y-1 text-xs font-medium">
            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-brand-300/70 px-3 pt-2 pb-1">Menu Utama</div>

            <a href="{{ route('vendor.dashboard') }}" id="nav-overview"
                class="admin-nav-btn {{ request()->routeIs('vendor.dashboard') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold border transition-all active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Ringkasan Dashboard</span>
            </a>

            @if ($hasAssetAccess)
                <a href="{{ route('vendor.items') }}" id="nav-inventory"
                    class="admin-nav-btn {{ request()->routeIs('vendor.items') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>Katalog & Stok Aset</span>
                    </div>
                    <span class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ Auth::user()->items->count() }}</span>
                </a>
            @else
                <a onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: '{{ $assetErrorMsg }}' });"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-brand-300/50 cursor-not-allowed">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>Katalog & Stok Aset</span>
                    </div>
                    <span>🔒</span>
                </a>
            @endif

            @if ($hasCategoryAccess)
                <a href="{{ route('vendor.category') }}" id="nav-categories"
                    class="admin-nav-btn {{ request()->routeIs('vendor.category') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Kategori Aset</span>
                    </div>
                    <span class="badge badge-xs bg-brand-500 border-none text-white font-mono font-bold">{{ Auth::user()->itemsCategories->count() }}</span>
                </a>
            @else
                <a onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: '{{ $categoryErrorMsg }}' });"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-brand-300/50 cursor-not-allowed">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Kategori Aset</span>
                    </div>
                    <span>🔒</span>
                </a>
            @endif

            @if ($hasBookingAccess)
                <a href="{{ route('vendor.bookings') }}" id="nav-bookings"
                    class="admin-nav-btn {{ request()->routeIs('vendor.bookings') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Transaksi & Booking</span>
                    </div>
                </a>
            @else
                <a onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: '{{ $bookingErrorMsg }}' });"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-brand-300/50 cursor-not-allowed">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Transaksi & Booking</span>
                    </div>
                    <span>🔒</span>
                </a>
            @endif

            @if ($hasVerifikasiAccess)
                <a href="{{ route('vendor.verifications') }}" id="nav-verifications"
                    class="admin-nav-btn {{ request()->routeIs('vendor.verifications') ? 'active text-white bg-brand-500/30 border-brand-500/40' : 'text-brand-300 hover:text-white hover:bg-brand-500/15 border-transparent' }} w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border transition-all active:scale-[0.98]">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Verifikasi E-KTP</span>
                    </div>
                </a>
            @else
                <a onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: '{{ $verifikasiErrorMsg }}' });"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-brand-300/50 cursor-not-allowed">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Verifikasi E-KTP</span>
                    </div>
                    <span>🔒</span>
                </a>
            @endif

            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-brand-300/70 px-3 pt-4 pb-1">Pengaturan & Toko</div>

            <details {{ (request()->routeIs('vendor.settings') || request()->routeIs('vendor.dangerzone') || request()->routeIs('vendor.subscription')) && $isSubActive ? 'open' : '' }}>
                <summary class="admin-nav-btn text-brand-300 hover:text-white hover:bg-brand-500/15 border border-transparent flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all active:scale-[0.98] {{ !$isSubActive ? 'opacity-50' : '' }} cursor-pointer">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Pengaturan Toko</span>
                    </div>
                    @if (!$isSubActive)
                        <span>🔒</span>
                    @endif
                </summary>
                <div class="space-y-1 mt-1 ml-4 border-l border-brand-500/20 pl-2">
                    @if ($isSubActive)
                        <a href="{{ route('vendor.settings') }}" class="text-brand-300 hover:text-white block py-2 px-3 rounded-lg hover:bg-brand-500/10 transition-colors {{ request()->routeIs('vendor.settings') ? 'bg-brand-500/10 text-white' : '' }}">
                            Profil Toko
                        </a>
                    @else
                        <a href="javascript:void(0)" onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: 'Langganan Anda tidak aktif. Menu ini terkunci.' });" class="text-brand-300/50 cursor-not-allowed flex items-center justify-between block py-2 px-3">
                            <span>Profil Toko</span>
                            <span>🔒</span>
                        </a>
                    @endif

                    @if ($isSubActive)
                        <a href="{{ route('vendor.subscription') }}" class="text-brand-300 hover:text-white block py-2 px-3 rounded-lg hover:bg-brand-500/10 transition-colors {{ request()->routeIs('vendor.subscription') ? 'bg-brand-500/10 text-white' : '' }}">
                            Langganan Toko
                        </a>
                    @else
                        <a href="javascript:void(0)" onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: 'Langganan Anda tidak aktif. Menu ini terkunci.' });" class="text-brand-300/50 cursor-not-allowed flex items-center justify-between block py-2 px-3">
                            <span>Langganan Toko</span>
                            <span>🔒</span>
                        </a>
                    @endif

                    @if ($isSubActive)
                        <a href="{{ route('vendor.dangerzone') }}" class="text-rose-400 hover:text-rose-300 font-semibold block py-2 px-3 rounded-lg hover:bg-rose-500/10 transition-colors {{ request()->routeIs('vendor.dangerzone') ? 'bg-rose-500/10 text-rose-300' : '' }}">
                            Zona Merah
                        </a>
                    @else
                        <a href="javascript:void(0)" onclick="Swal.fire({ icon: 'error', title: 'Akses Dibatasi', text: 'Langganan Anda tidak aktif. Menu ini terkunci.' });" class="text-brand-300/50 cursor-not-allowed flex items-center justify-between block py-2 px-3">
                            <span>Zona Merah</span>
                            <span>🔒</span>
                        </a>
                    @endif
                </div>
            </details>
        </nav>
    </div>

    <!-- SIDEBAR FOOTER -->
    <div class="p-4 border-t border-brand-500/20 bg-brand-900">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-brand-500 text-white font-bold flex items-center justify-center font-heading text-xs">
                    <img src="{{ Storage::url(Auth::user()->vendorProfiles->profiles_picture) }}" alt="Foto Profil Vendor" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="truncate w-32">
                    <div class="text-xs font-bold text-white leading-tight truncate">{{ Auth::user()->email }}</div>
                    <div class="text-[10px] text-brand-300 truncate">Vendor / Sewain</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('POST')
                <button class="text-brand-300 hover:text-white p-1.5 transition-colors active:scale-90 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
