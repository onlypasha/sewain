<header class="sticky top-0 z-50 bg-paper/90 backdrop-blur border-b border-ink/10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="#" class="flex items-center gap-2.5 group" aria-label="Beranda Sewain">
                <img src="{{ asset('image/sewain_logo.jpg') }}" alt="" srcset=""
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-300 to-brand-500 shadow-lg shadow-brand-500/20 flex items-center justify-center">
                <span class="font-display font-bold text-xl tracking-tight leading-none">Sewain</span>
            </a>

            <nav class="hidden md:flex items-center gap-7 text-sm text-ink-soft">
                <a href="#fitur" class="hover:text-ink transition-colors duration-200">Fitur</a>
                <a href="#cara-kerja" class="hover:text-ink transition-colors duration-200">Cara kerja</a>
                <a href="#harga" class="hover:text-ink transition-colors duration-200">Harga</a>
                <a href="#faq" class="hover:text-ink transition-colors duration-200">Tanya jawab</a>
            </nav>

            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="text-sm text-ink-soft hover:text-ink px-3 py-2 transition-colors duration-200">Masuk</a>
                <a href="#harga"
                    class="inline-flex items-center justify-center bg-stempel text-paper text-sm font-semibold px-4 py-2 rounded-md hover:bg-stempel-deep transition-all duration-200 active:scale-[0.98]">
                    Buka toko
                </a>
            </div>

            <button type="button" id="btn-mobile-menu" onclick="toggleMobileMenu()"
                class="md:hidden p-2 text-ink-soft hover:text-ink transition-colors duration-200" aria-expanded="false"
                aria-controls="mobile-menu" aria-label="Buka menu navigasi">
                <svg id="icon-menu-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg id="icon-menu-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-ink/10 bg-paper px-4 py-4 space-y-4">
        <nav class="flex flex-col gap-3 text-sm text-ink-soft">
            <a href="#fitur" class="py-1 hover:text-ink transition-colors duration-200"
                onclick="toggleMobileMenu()">Fitur</a>
            <a href="#demo" class="py-1 hover:text-ink transition-colors duration-200"
                onclick="toggleMobileMenu()">Demo</a>
            <a href="#cara-kerja" class="py-1 hover:text-ink transition-colors duration-200"
                onclick="toggleMobileMenu()">Cara kerja</a>
            <a href="#harga" class="py-1 hover:text-ink transition-colors duration-200"
                onclick="toggleMobileMenu()">Harga</a>
            <a href="#faq" class="py-1 hover:text-ink transition-colors duration-200"
                onclick="toggleMobileMenu()">Tanya jawab</a>
        </nav>
        <div class="flex flex-col gap-2 pt-3 border-t border-ink/10">
            <a href="{{ route('login') }}"
                class="text-sm text-center text-ink-soft hover:text-ink py-2 transition-colors duration-200">Masuk</a>
            <a href="#harga"
                class="inline-flex items-center justify-center bg-stempel text-paper text-sm font-semibold px-4 py-2.5 rounded-md hover:bg-stempel-deep transition-all duration-200 active:scale-[0.98]"
                onclick="toggleMobileMenu()">
                Buka toko
            </a>
        </div>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-menu-open');
        const iconClose = document.getElementById('icon-menu-close');
        const btn = document.getElementById('btn-mobile-menu');
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden');
        menu.classList.toggle('hidden', !isHidden);
        if (iconOpen) iconOpen.classList.toggle('hidden', isHidden);
        if (iconClose) iconClose.classList.toggle('hidden', !isHidden);
        if (btn) btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    }
</script>
