<!DOCTYPE html>
<html lang="id" data-theme="emerald" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendor Dashboard Operator - Sewain Multi-Tenant OS</title>
    <meta name="description"
        content="Dashboard Operator Vendor Sewain untuk manajemen stok rental, kalender booking, dan verifikasi e-KTP penyewa.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>

<body
    class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white flex h-screen overflow-hidden">

    <!-- VENDOR SIDEBAR -->
    <x-vendor.sidebar />

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
        <!-- VENDOR TOPBAR -->
        {{-- <x-vendor.topbar /> --}}

        <!-- PAGE TAB PANES -->
        <main class="flex-1 p-4 sm:p-6 md:p-8">
            @yield('content')
        </main>
    </div>

    <!-- GLOBAL ADD ASSET MODAL -->
    <x-vendor.add-asset-modal />

    <!-- INTERACTIVE VENDOR DASHBOARD LOGIC -->
    <script>
        function switchAdminTab(tabKey) {
            // Hide all panes
            document.querySelectorAll('.admin-tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });
            // Show target pane
            const targetPane = document.getElementById('tab-content-' + tabKey);
            if (targetPane) {
                targetPane.classList.remove('hidden');
            }

            // Update nav active states
            document.querySelectorAll('.admin-nav-btn').forEach(btn => {
                btn.classList.remove('text-emerald-400', 'bg-emerald-500/10', 'font-bold', 'border',
                    'border-emerald-500/20');
                btn.classList.add('text-slate-400');
            });
            const activeBtn = document.getElementById('nav-' + tabKey);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-400');
                activeBtn.classList.add('text-emerald-400', 'bg-emerald-500/10', 'font-bold', 'border',
                    'border-emerald-500/20');
            }
        }

        function openAddAssetModal() {
            const modal = document.getElementById('add-asset-modal');
            if (modal) modal.showModal();
        }

        function closeAddAssetModal() {
            const modal = document.getElementById('add-asset-modal');
            if (modal) modal.close();
        }

        function handleAddAssetSubmit() {
            const name = document.getElementById('new-asset-name').value;
            alert('🎉 Aset Baru "' + name + '" berhasil ditambahkan ke katalog toko!');
            closeAddAssetModal();
        }
    </script>
</body>

</html>
