@props(['plans'])

@php
    $monthlyPlans = $plans->where('billing_cycle', 'monthly');
    $yearlyPlans = $plans->where('billing_cycle', 'yearly');
@endphp

<!-- PRICING SECTION -->
<section id="harga" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-xs font-mono font-bold uppercase tracking-widest text-emerald-600 mb-3">PAKET SUBSCRIPTION
                TRANSPARAN</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading tracking-tight">Investasi Kecil
                untuk Efisiensi Bisnis Maksimal</h3>
            <p class="text-slate-600 mt-2 text-base">Tanpa potongan komisi per transaksi sewa. Semua keuntungan milik
                toko Anda 100%.</p>

            <!-- Billing Cycle Toggle -->
            <div class="mt-8 inline-flex items-center gap-3 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                <button onclick="switchBillingCycle('monthly')" id="btn-billing-monthly"
                    class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white text-slate-900 shadow-xs">
                    Ditagih Bulanan
                </button>
                <button onclick="switchBillingCycle('yearly')" id="btn-billing-yearly"
                    class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 hover:text-slate-900 flex items-center gap-1.5">
                    <span>Tahunan</span>
                    <span class="badge badge-success text-[10px] text-white font-bold">HEMAT 20%</span>
                </button>
            </div>
        </div>

        <!-- MONTHLY PLANS -->
        <div id="plans-monthly" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
            @forelse($monthlyPlans as $plan)
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                    <div>
                        <div class="text-xs font-bold font-mono text-slate-500 uppercase tracking-wider mb-2">
                            {{ $plan->name }}
                        </div>
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading">{{ 'Rp ' . number_format($plan->price, 0, ',', '.') }}</span>
                                <span class="text-xs text-slate-500 font-medium">/bulan</span>
                            </div>
                            <span class="text-[11px] text-slate-400 font-mono block mt-1">Ditagih Bulanan</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-700 mb-8 border-t border-slate-200/80 pt-6">
                            @forelse ($plan->features ?? [] as $feature)
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>{{ $feature['name'] }}</strong>: {{ $feature['value'] }}</span>
                                </li>
                            @empty
                                <li class="text-slate-500 italic">Belum ada fitur tercantum</li>
                            @endforelse
                        </ul>
                    </div>

                    <button onclick="selectPlan('{{ $plan->name }}', '{{ $plan->billing_cycle }}')"
                        class="btn btn-outline border-slate-300 hover:bg-slate-900 hover:text-white w-full text-slate-800 font-bold">
                        Coba 14 Hari Gratis
                    </button>
                </div>
            @empty
                <div class="col-span-full">
                    <x-util.alert variant="warning">Tidak ada paket bulanan tersedia.</x-util.alert>
                </div>
            @endforelse
        </div>

        <!-- YEARLY PLANS -->
        <div id="plans-yearly" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch hidden">
            @forelse($yearlyPlans as $plan)
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                    <div>
                        <div class="text-xs font-bold font-mono text-slate-500 uppercase tracking-wider mb-2">
                            {{ $plan->name }}
                        </div>
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading">{{ 'Rp ' . number_format($plan->price, 0, ',', '.') }}</span>
                                <span class="text-xs text-slate-500 font-medium">/tahun</span>
                            </div>
                            <span class="text-[11px] text-slate-400 font-mono block mt-1">Ditagih Tahunan</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-700 mb-8 border-t border-slate-200/80 pt-6">
                            @forelse ($plan->features ?? [] as $feature)
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>{{ $feature['name'] }}</strong>: {{ $feature['value'] }}</span>
                                </li>
                            @empty
                                <li class="text-slate-500 italic">Belum ada fitur tercantum</li>
                            @endforelse
                        </ul>
                    </div>

                    <button onclick="selectPlan('{{ $plan->name }}', '{{ $plan->billing_cycle }}')"
                        class="btn btn-outline border-slate-300 hover:bg-slate-900 hover:text-white w-full text-slate-800 font-bold">
                        Coba 14 Hari Gratis
                    </button>
                </div>
            @empty
                <div class="col-span-full">
                    <x-util.alert variant="warning">Tidak ada paket tahunan tersedia.</x-util.alert>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    function switchBillingCycle(cycle) {
        const btnM = document.getElementById('btn-billing-monthly');
        const btnY = document.getElementById('btn-billing-yearly');
        const plansM = document.getElementById('plans-monthly');
        const plansY = document.getElementById('plans-yearly');

        if (cycle === 'yearly') {
            btnY.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
            btnY.classList.remove('text-slate-600');
            btnM.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
            btnM.classList.add('text-slate-600');

            plansY.classList.remove('hidden');
            plansM.classList.add('hidden');
        } else {
            btnM.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
            btnM.classList.remove('text-slate-600');
            btnY.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
            btnY.classList.add('text-slate-600');

            plansM.classList.remove('hidden');
            plansY.classList.add('hidden');
        }
    }

    function selectPlan(planName, cycle) {
        const cycleText = cycle === 'yearly' ? 'Tahunan' : 'Bulanan';
        alert(`🎉 Anda memilih Paket ${planName} (${cycleText}). Membuka pendaftaran Trial 14 Hari...`);
    }
</script>
