<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sewain')</title>
    <meta name="description" content="@yield('description', 'Sewa barang dari vendor terpercaya di Sewain.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;600;700;800&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-body bg-paper text-ink antialiased min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 bg-paper/90 backdrop-blur border-b border-ink/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('image/sewain_logo.jpg') }}" alt="Sewain"
                        class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-300 to-brand-500 shadow-lg shadow-brand-500/20">
                    <span class="font-display font-bold text-xl tracking-tight leading-none">Sewain</span>
                </a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/') }}"
                            class="text-sm text-ink-soft hover:text-ink px-3 py-2 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm text-ink-soft hover:text-ink px-3 py-2 transition-colors">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-ink/10 py-8 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-ink-soft">
            &copy; {{ date('Y') }} Sewain &middot; Platform sewa online
        </div>
    </footer>
</body>

</html>
