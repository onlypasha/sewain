<!DOCTYPE html>
<html lang="id" data-theme="emerald" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masuk ke Dashboard Tenant - Sewain Multi-Tenant OS</title>
    <meta name="description" content="Halaman masuk resmi pemilik bisnis rental Sewain Multi-Tenant OS. Kelola stok aset, kalender sewa, dan laporan keuangan dalam satu dashboard.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Gradient mesh matching landing page */
        .bg-mesh-pattern {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(13, 148, 136, 0.3) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.25) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(245, 158, 11, 0.12) 0px, transparent 50%);
        }

        .bg-hero-light {
            background: radial-gradient(circle at 50% 0%, rgba(204, 251, 241, 0.6) 0%, rgba(248, 250, 252, 1) 75%);
        }
    </style>
</head>

<body class="bg-hero-light min-h-screen text-slate-800 antialiased selection:bg-emerald-500 selection:text-white flex flex-col justify-between">

    {{-- <x-login.header /> --}}

    <!-- MAIN LOGIN SPLIT CONTAINER -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-10">
        <div class="w-full max-w-xl lg:grid-cols-12 bg-white rounded-3xl shadow-2xl border border-slate-200/90 overflow-hidden">
            {{-- <x-login.showcase /> --}}
            <x-login.form />
        </div>
    </main>

    <x-login.footer />

    <!-- INTERACTIVE LOGIC -->
    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
            } else {
                pwdInput.type = 'password';
            }
        }

        function updateTenantPreview(emailVal) {
            const pill = document.getElementById('tenant-preview-pill');
            const target = document.getElementById('detected-subdomain');
            
            if (emailVal.includes('@')) {
                const domainPart = emailVal.split('@')[1];
                if (domainPart.includes('.')) {
                    const subName = domainPart.split('.')[0];
                    target.innerText = subName.toLowerCase() + '.sewain.id';
                } else {
                    target.innerText = domainPart.toLowerCase() + '.sewain.id';
                }
                pill.classList.remove('hidden');
            } else {
                pill.classList.add('hidden');
            }
        }

        function fillDemoAccount(type) {
            if (type === 'kamera') {
                document.getElementById('email').value = 'admin@lensamania.sewain.id';
                document.getElementById('password').value = 'demo123456';
                updateTenantPreview('admin@lensamania.sewain.id');
            } else if (type === 'otomotif') {
                document.getElementById('email').value = 'fleet@transjava.sewain.id';
                document.getElementById('password').value = 'demo123456';
                updateTenantPreview('fleet@transjava.sewain.id');
            }
        }

        function handleLoginSubmit() {
            const email = document.getElementById('email').value;
            const btn = document.getElementById('btn-login-submit');
            btn.innerHTML = '<span>Memproses Authentikasi...</span>';
            btn.disabled = true;

            setTimeout(() => {
                alert('🎉 Login Berhasil!\n\nSelamat datang di Dashboard Operator Tenant: ' + email);
                btn.innerHTML = '<span>Masuk ke Dashboard Tenant</span> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
                btn.disabled = false;
            }, 800);
        }
    </script>
</body>

</html>
