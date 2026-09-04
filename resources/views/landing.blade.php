<!DOCTYPE html>
<html lang="id" data-theme="emerald" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sewain - Platform Multi-Tenant Operating System untuk Bisnis Rental & Sewa</title>
    <meta name="description" content="Sewain adalah platform SaaS rental multi-tenant tercepat di Indonesia. Kelola stok aset, otomatisasi kalender ketersediaan, buat subdomain toko eksklusif, dan buat kontrak digital otomatis dalam satu dashboard.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert2::index')

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

        /* Glassmorphism custom styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .dark-glass-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Gradient mesh accent */
        .bg-mesh-pattern {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(13, 148, 136, 0.25) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(245, 158, 11, 0.1) 0px, transparent 50%);
        }

        .bg-hero-light {
            background: radial-gradient(circle at 50% 0%, rgba(204, 251, 241, 0.5) 0%, rgba(248, 250, 252, 1) 70%);
        }

        /* Custom scrollbar for simulator */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden">
    <x-landing.navbar />

    <!-- MAIN CONTENT -->
    <main>
        <x-landing.hero />
        {{-- <x-landing.subdomain-checker /> --}}
        <x-landing.demo-simulator />
        <x-landing.features />
        <x-landing.comparison />
        {{-- <x-landing.roi-calculator /> --}}
        <x-landing.pricing :plans="$plans" />
        {{-- <x-landing.testimonials /> --}}
        <x-landing.faq />
        <x-landing.cta-banner />
    </main>

    <x-landing.footer />

    <!-- INTERACTIVE JAVASCRIPT LOGIC -->
    <script>
        // 1. DOMAIN CHECKER REALTIME FUNCTION
        function updateDomainChecker(val) {
            const cleanVal = val.toLowerCase().replace(/[^a-z0-9-]/g, '');
            const previewText = document.getElementById('domain-preview-text');
            if (cleanVal.length > 0) {
                previewText.innerText = cleanVal + '.sewain.id';
                document.getElementById('simulator-url-bar').innerText = 'https://' + cleanVal + '.sewain.id';
            } else {
                previewText.innerText = 'namatoko.sewain.id';
            }
        }

        function claimDomainNow() {
            const inputVal = document.getElementById('tenant-domain-input').value;
            if(!inputVal) {
                Swal.fire({ title: 'Peringatan', text: 'Silakan masukkan nama calon toko rental Anda!', icon: 'warning' });
                return;
            }
            Swal.fire({ title: 'Subdomain Tersedia', text: '🎉 Selamat! Subdomain "' + inputVal + '.sewain.id" tersedia. Anda akan diarahkan ke formulir pendaftaran 14 Hari Trial.', icon: 'success' });
        }

        // 2. SIMULATOR TENANT SWITCHER
        function switchTenantTab(tabKey) {
            document.querySelectorAll('.tenant-tab-btn').forEach(btn => {
                btn.classList.remove('bg-emerald-600', 'text-white', 'shadow-sm');
                btn.classList.add('bg-slate-800', 'text-slate-300');
            });
            const activeBtn = document.getElementById('tab-' + tabKey);
            activeBtn.classList.remove('bg-slate-800', 'text-slate-300');
            activeBtn.classList.add('bg-emerald-600', 'text-white', 'shadow-sm');

            document.querySelectorAll('.tenant-preview-content').forEach(el => {
                el.classList.add('hidden');
            });
            const activePreview = document.getElementById('preview-' + tabKey);
            activePreview.classList.remove('hidden');

            const urlBar = document.getElementById('simulator-url-bar');
            if(tabKey === 'kamera') urlBar.innerText = 'https://lensamania.sewain.id';
            if(tabKey === 'otomotif') urlBar.innerText = 'https://transjava.sewain.id';
            if(tabKey === 'outdoor') urlBar.innerText = 'https://rimba-outdoor.sewain.id';
        }

        // SIMULATOR BOOKING INTERACTION
        let currentItemRate = 350000;
        function selectSimulatedItem(name, rate) {
            document.getElementById('sim-item-name').innerText = name;
            currentItemRate = rate;
            updateSimulatedBooking();
        }

        function updateSimulatedBooking() {
            const days = parseInt(document.getElementById('sim-days-range').value);
            document.getElementById('sim-days-label').innerText = days + ' Hari';
            
            const subtotal = currentItemRate * days;
            const deposit = 300000;
            const insurance = 25000;
            const total = subtotal + deposit + insurance;

            document.getElementById('sim-rental-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('sim-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function triggerSimulatedCheckout() {
            const itemName = document.getElementById('sim-item-name').innerText;
            const days = document.getElementById('sim-days-range').value;
            const totalPrice = document.getElementById('sim-total-price').innerText;
            Swal.fire({ title: 'Simulasi WA Notification', text: 'Halo Admin LensaMania! Saya bermaksud sewa ' + itemName + ' untuk ' + days + ' hari. Total Estimasi: ' + totalPrice + '. E-KTP telah terverifikasi.', icon: 'info' });
        }

        // 3. ROI CALCULATOR LOGIC
        function calculateROI() {
            const assets = parseInt(document.getElementById('roi-slider-assets').value);
            const trans = parseInt(document.getElementById('roi-slider-trans').value);
            const price = parseInt(document.getElementById('roi-slider-price').value);

            document.getElementById('roi-asset-count').innerText = assets + ' Unit';
            document.getElementById('roi-trans-count').innerText = trans + ' Transaksi';
            document.getElementById('roi-avg-price').innerText = 'Rp ' + price.toLocaleString('id-ID');

            const hoursSaved = Math.round(trans * 0.75);
            const lossPrevented = Math.round(trans * price * 0.15);
            const extraRevenue = Math.round(trans * price * 0.25);

            document.getElementById('roi-res-hours').innerText = hoursSaved + ' Jam / Bulan';
            document.getElementById('roi-res-loss').innerText = 'Rp ' + lossPrevented.toLocaleString('id-ID');
            document.getElementById('roi-res-revenue').innerText = '+ Rp ' + extraRevenue.toLocaleString('id-ID');
        }



        // 5. LIVE ACTIVITY TICKER SIMULATOR
        const tickerEvents = [
            { tenant: 'LensaMania Studio', action: ' baru saja menerima pemesanan Sony A7 IV (3 Hari)', time: 'Baru saja • Via QRIS' },
            { tenant: 'TransJava Auto Fleet', action: ' mengkonfirmasi sewa Innova Zenix (Lepas Kunci)', time: '2 menit lalu • E-KTP Verified' },
            { tenant: 'Rimba Outdoor Bandung', action: ' mendaftarkan subdomain `rimba.sewain.id`', time: '5 menit lalu • New Tenant' },
            { tenant: 'Studio Kamera Bali', action: ' otomatis menerbitkan PDF Kontrak Digital #892', time: '7 menit lalu • Signed PDF' }
        ];

        let tickerIdx = 0;
        setInterval(() => {
            tickerIdx = (tickerIdx + 1) % tickerEvents.length;
            const ev = tickerEvents[tickerIdx];
            const tickerEl = document.getElementById('live-activity-ticker');
            
            tickerEl.style.opacity = '0';
            setTimeout(() => {
                document.getElementById('ticker-tenant').innerText = ev.tenant;
                document.getElementById('ticker-action').innerText = ev.action;
                document.getElementById('ticker-time').innerText = ev.time;
                tickerEl.style.opacity = '1';
            }, 300);
        }, 5500);
    </script>
</body>

</html>
