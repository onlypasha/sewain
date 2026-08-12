<!DOCTYPE html>
<html lang="id" data-theme="emerald" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Superadmin Master Console - Sewain Multi-Tenant OS</title>
    <meta name="description" content="Konsol kontrol utama Superadmin Platform Sewain. Kelola 1,400+ tenant, MRR billing, dan infrastruktur server.">

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
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white flex h-screen overflow-hidden">

    <!-- SUPERADMIN SIDEBAR -->
    <x-superadmin.sidebar />

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
        <!-- SUPERADMIN TOPBAR -->
        <x-superadmin.topbar />

        <!-- PAGE TAB PANES -->
        <main class="flex-1 p-4 sm:p-6 md:p-8">
            <x-superadmin.overview />
            <x-superadmin.tenants />
            <x-superadmin.subscriptions />
            <x-superadmin.system-health />
            <x-superadmin.settings />
        </main>
    </div>

    <!-- GLOBAL PROVISION TENANT MODAL -->
    <x-superadmin.create-tenant-modal />

    <!-- INTERACTIVE SUPERADMIN DASHBOARD LOGIC -->
    <script>
        function switchSuperadminTab(tabKey) {
            // Hide all panes
            document.querySelectorAll('.superadmin-tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });
            // Show target pane
            const targetPane = document.getElementById('super-tab-content-' + tabKey);
            if (targetPane) {
                targetPane.classList.remove('hidden');
            }

            // Update nav active states
            document.querySelectorAll('.super-nav-btn').forEach(btn => {
                btn.classList.remove('text-emerald-400', 'bg-emerald-500/10', 'font-bold', 'border', 'border-emerald-500/20');
                btn.classList.add('text-slate-400');
            });
            const activeBtn = document.getElementById('super-nav-' + tabKey);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-400');
                activeBtn.classList.add('text-emerald-400', 'bg-emerald-500/10', 'font-bold', 'border', 'border-emerald-500/20');
            }
        }

        function openCreateTenantModal() {
            const modal = document.getElementById('create-tenant-modal');
            if (modal) modal.showModal();
        }

        function closeCreateTenantModal() {
            const modal = document.getElementById('create-tenant-modal');
            if (modal) modal.close();
        }

        function handleCreateTenantSubmit() {
            const name = document.getElementById('new-tenant-name').value;
            const sub = document.getElementById('new-tenant-subdomain').value;
            alert('🚀 Berhasil Provisioning Tenant Baru:\n\nNama Toko: ' + name + '\nSubdomain: ' + sub + '.sewain.id\nDatabase SSL Isolated!');
            closeCreateTenantModal();
        }
    </script>
</body>

</html>
