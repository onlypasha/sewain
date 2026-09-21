@props(['plans'])

@php
    $monthlyPlans = $plans->where('billing_cycle', 'monthly');
    $yearlyPlans = $plans->where('billing_cycle', 'yearly');
@endphp

<section id="harga" class="border-b border-ink/10 py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
            <div class="max-w-xl">
                <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl">Harga tetap, tanpa potongan komisi
                </h2>
                <p class="text-ink-soft mt-3 text-base sm:text-lg">Bayar langganan, bukan potongan transaksi. Seluruh
                    hasil sewa jadi milik toko Anda 100%.</p>
            </div>

            <div class="inline-flex items-center gap-1 bg-paper-deep border border-ink/10 p-1 rounded-md">
                <button onclick="switchBillingCycle('monthly')" id="btn-billing-monthly"
                    class="px-4 py-1.5 rounded text-sm font-semibold bg-white text-ink shadow-sm transition-colors duration-200">Bulanan</button>
                <button onclick="switchBillingCycle('yearly')" id="btn-billing-yearly"
                    class="px-4 py-1.5 rounded text-sm font-semibold text-ink-soft hover:text-ink flex items-center gap-1.5 transition-colors duration-200">
                    Tahunan
                    <span class="text-[10px] font-data bg-lunas-soft text-lunas px-1.5 py-0.5 rounded">-20%</span>
                </button>
            </div>
        </div>

        <div id="plans-monthly" class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($monthlyPlans as $plan)
                <div class="bg-white border border-ink/10 rounded-md p-7 flex flex-col">
                    <div class="font-data text-sm font-semibold text-ink">{{ $plan->name }}</div>
                    <div class="flex items-baseline gap-1 mt-3">
                        <span class="font-display font-bold text-4xl tracking-tight text-ink">Rp
                            {{ number_format($plan->price, 0, ',', '.') }}</span>
                        <span class="text-ink-soft text-sm">/bulan</span>
                    </div>

                    <ul class="mt-6 space-y-2.5 text-sm text-ink-soft border-t border-ink/10 pt-6 flex-1">
                        @forelse ($plan->features ?? [] as $feature)
                            <li
                                class="flex items-center gap-2 {{ empty($feature['is_included']) ? 'opacity-50 line-through' : '' }}">
                                @if (!empty($feature['is_included']))
                                    <svg class="w-4 h-4 text-lunas shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-ink-faint shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                                <span>{{ $feature['text'] ?? '' }}</span>
                            </li>
                        @empty
                            <li class="text-ink-faint">Belum ada fitur tercantum</li>
                        @endforelse
                    </ul>

                    <a href="http://wa.me/085695118600/?text=Saya%20memilih%20paket%20 {{ $plan->name }}"
                        class="mt-7 w-full border border-ink/20 text-center text-ink font-semibold py-3 rounded-md hover:border-stempel hover:text-stempel transition-all duration-200 active:scale-[0.98]">
                        Pilih paket ini
                    </a>
                </div>
            @empty
                <div class="col-span-full">
                    <x-util.alert variant="warning">Tidak ada paket bulanan tersedia.</x-util.alert>
                </div>
            @endforelse
        </div>

        <div id="plans-yearly" class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
            @forelse($yearlyPlans as $plan)
                <div class="bg-white border border-ink/10 rounded-md p-7 flex flex-col">
                    <div class="font-data text-sm font-semibold text-ink">{{ $plan->name }}</div>
                    <div class="flex items-baseline gap-1 mt-3">
                        <span class="font-display font-bold text-4xl tracking-tight text-ink">Rp
                            {{ number_format($plan->price, 0, ',', '.') }}</span>
                        <span class="text-ink-soft text-sm">/tahun</span>
                    </div>

                    <ul class="mt-6 space-y-2.5 text-sm text-ink-soft border-t border-ink/10 pt-6 flex-1">
                        @forelse ($plan->features ?? [] as $feature)
                            <li
                                class="flex items-center gap-2 {{ empty($feature['is_included']) ? 'opacity-50 line-through' : '' }}">
                                @if (!empty($feature['is_included']))
                                    <svg class="w-4 h-4 text-lunas shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-ink-faint shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                                <span>{{ $feature['text'] ?? '' }}</span>
                            </li>
                        @empty
                            <li class="text-ink-faint">Belum ada fitur tercantum</li>
                        @endforelse
                    </ul>

                    <button onclick="selectPlan('{{ $plan->name }}', 'yearly')"
                        class="mt-7 w-full border border-ink/20 text-ink font-semibold py-3 rounded-md hover:border-stempel hover:text-stempel transition-all duration-200 active:scale-[0.98]">
                        Pilih paket ini
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
