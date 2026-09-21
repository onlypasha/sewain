<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sewain | Toko sewa online dengan kalender stok anti-bentrok</title>
    <meta name="description"
        content="Sewain memberi toko rental Anda halaman sendiri (namatoko.sewain.id), kalender stok yang mengunci tanggal terpakai, verifikasi e-KTP, dan kontrak digital.">
    <script>
        document.documentElement.classList.add('js')
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;600;700;800&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert2::index')
</head>

<body
    class="landing font-body bg-paper text-ink antialiased selection:bg-langit selection:text-navy min-h-screen flex flex-col overflow-x-hidden">
    <x-landing.navbar />

    <main>
        <x-landing.hero :stats="$stats" />
        <x-landing.features :features="$stats['features']" />
        <x-landing.comparison />
        <x-landing.pricing :plans="$plans" />
        <x-landing.faq />
        <x-landing.cta-banner />
    </main>

    <x-landing.footer />

    <script>
        // Tenant switcher
        function switchTenantTab(tabKey) {
            document.querySelectorAll('.tenant-tab-btn').forEach(btn => {
                const isActive = btn.dataset.tab === tabKey;
                btn.classList.toggle('bg-ink', isActive);
                btn.classList.toggle('text-paper', isActive);
                btn.classList.toggle('border-ink', isActive);
                btn.classList.toggle('text-ink-soft', !isActive);
                btn.classList.toggle('border-ink-faint', !isActive);
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            document.querySelectorAll('.tenant-preview-content').forEach(el => {
                el.classList.toggle('hidden', el.id !== 'preview-' + tabKey);
            });

            const urlBar = document.getElementById('simulator-url-bar');
            if (urlBar) {
                const urls = {
                    kamera: 'lensamania.sewain.id',
                    otomotif: 'transjava.sewain.id',
                    outdoor: 'rimba-outdoor.sewain.id'
                };
                urlBar.innerText = urls[tabKey] || '';
            }
        }

        // Booking simulation
        let currentItemRate = 350000;

        function selectSimulatedItem(name, rate) {
            document.getElementById('sim-item-name').innerText = name;
            currentItemRate = rate;
            updateSimulatedBooking();
        }

        function updateSimulatedBooking() {
            const days = parseInt(document.getElementById('sim-days-range').value, 10);
            document.getElementById('sim-days-label').innerText = days + ' hari';

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
            Swal.fire({
                title: 'Pemesanan terkirim',
                text: 'Halo Admin! Saya ingin menyewa ' + itemName + ' selama ' + days + ' hari. Total ' +
                    totalPrice + '. e-KTP sudah terverifikasi.',
                icon: 'info'
            });
        }

        // Pricing cycle switcher
        function switchBillingCycle(cycle) {
            const btnMonthly = document.getElementById('btn-billing-monthly');
            const btnYearly = document.getElementById('btn-billing-yearly');
            const plansMonthly = document.getElementById('plans-monthly');
            const plansYearly = document.getElementById('plans-yearly');

            if (cycle === 'monthly') {
                btnMonthly.classList.add('bg-white', 'shadow-sm', 'text-ink');
                btnMonthly.classList.remove('text-ink-soft');
                btnYearly.classList.remove('bg-white', 'shadow-sm', 'text-ink');
                btnYearly.classList.add('text-ink-soft');
                plansMonthly.classList.remove('hidden');
                plansYearly.classList.add('hidden');
            } else {
                btnYearly.classList.add('bg-white', 'shadow-sm', 'text-ink');
                btnYearly.classList.remove('text-ink-soft');
                btnMonthly.classList.remove('bg-white', 'shadow-sm', 'text-ink');
                btnMonthly.classList.add('text-ink-soft');
                plansYearly.classList.remove('hidden');
                plansMonthly.classList.add('hidden');
            }
        }

        function selectPlan(planName, cycle) {
            const cycleLabel = cycle === 'monthly' ? 'Bulanan' : 'Tahunan';
            Swal.fire({
                title: 'Paket dipilih',
                text: 'Anda memilih paket ' + planName + ' (' + cycleLabel + ').',
                icon: 'success'
            });
        }

        // Hero orchestrated reveal
        (function() {
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const stamp = document.querySelector('.reveal-stamp');
            const rises = document.querySelectorAll('.reveal-rise');
            if (reduce) {
                if (stamp) stamp.classList.add('is-in');
                rises.forEach(el => el.classList.add('is-in'));
                return;
            }
            if (stamp) {
                setTimeout(() => stamp.classList.add('is-in'), 250);
            }
            rises.forEach((el, i) => {
                setTimeout(() => el.classList.add('is-in'), 120 + i * 90);
            });
        })();
    </script>
</body>

</html>
