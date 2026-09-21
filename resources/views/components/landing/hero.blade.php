@php
    $offset = 1;
    $locked = [4, 5, 8, 15, 16, 22, 25, 26];
    $today = 21;
    $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
@endphp

<section class="relative border-b border-ink/10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-6">
                <div class="reveal-rise">
                    <span class="inline-flex items-center gap-2 text-sm text-ink-soft font-data">
                        <span class="inline-block w-2 h-2 rounded-full bg-lunas"></span>
                        Untuk usaha rental barang, kendaraan, dan alat
                    </span>
                </div>

                <h1 class="reveal-rise font-display font-bold tracking-tight leading-[1.05] text-4xl sm:text-5xl md:text-6xl mt-6">
                    Toko sewa online.<br>Jadwal tak pernah bentrok.
                </h1>

                <p class="reveal-rise text-base sm:text-lg text-ink-soft leading-relaxed mt-6 max-w-lg">
                    Halaman toko sendiri di <span class="font-data text-ink bg-paper-deep px-1.5 py-0.5 rounded">namatoko.sewain.id</span>, kalender stok yang mengunci tanggal terpakai, verifikasi e-KTP, dan kontrak digital.
                </p>

                <div class="reveal-rise flex flex-col sm:flex-row gap-3 mt-8">
                    <a href="#harga" class="inline-flex items-center justify-center gap-2 bg-stempel text-paper font-semibold px-6 py-3.5 rounded-md hover:bg-stempel-deep transition-colors active:scale-[0.98]">
                        Buka toko gratis
                    </a>
                    <a href="#demo" class="inline-flex items-center justify-center gap-2 border border-ink/20 text-ink font-semibold px-6 py-3.5 rounded-md hover:border-ink/50 transition-colors active:scale-[0.98]">
                        Lihat demo
                    </a>
                </div>

                <div class="reveal-rise mt-10 grid grid-cols-3 divide-x divide-ink/10 border-t border-ink/10 pt-6">
                    <div class="pr-4">
                        <div class="font-data text-2xl sm:text-3xl font-semibold tracking-tight">{{ $stats['vendors'] ?? 0 }}</div>
                        <div class="text-sm text-ink-soft mt-1">toko terdaftar</div>
                    </div>
                    <div class="px-4">
                        <div class="font-data text-2xl sm:text-3xl font-semibold tracking-tight">{{ $stats['active_subscriptions'] ?? 0 }}</div>
                        <div class="text-sm text-ink-soft mt-1">langganan aktif</div>
                    </div>
                    <div class="pl-4">
                        <div class="font-data text-2xl sm:text-3xl font-semibold tracking-tight">{{ $stats['total_items'] ?? 0 }}</div>
                        <div class="text-sm text-ink-soft mt-1">aset terdaftar</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="relative">
                    <div class="bg-white border border-ink/10 rounded-lg shadow-[0_24px_60px_-30px_rgba(9,21,64,0.35)] p-5 sm:p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <div class="font-data text-xs text-ink-faint">Kalender stok</div>
                                <div class="font-display font-bold text-lg mt-0.5">September 2026</div>
                            </div>
                            <div class="text-right">
                                <div class="font-data text-xs text-ink-faint">Sony A7 IV</div>
                                <div class="font-data text-sm font-semibold text-lunas">12 hari tersedia</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-1.5 mb-1.5">
                            @foreach ($days as $d)
                                <div class="text-center font-data text-[11px] text-ink-faint py-1">{{ $d }}</div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-7 gap-1.5">
                            @for ($i = 0; $i < $offset; $i++)
                                <span></span>
                            @endfor
                            @for ($day = 1; $day <= 30; $day++)
                                @php
                                    $col = ($offset + $day - 1) % 7;
                                    $isWeekend = $col >= 5;
                                    $isLocked = in_array($day, $locked);
                                    $isToday = $day === $today;
                                @endphp
                                <span class="cal-cell {{ $isLocked ? 'cal-cell--locked' : ($isToday ? 'cal-cell--today' : 'cal-cell--free') }} {{ $isWeekend && !$isLocked && !$isToday ? 'cal-cell--muted' : '' }}">{{ $day }}</span>
                            @endfor
                        </div>

                        <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-ink-soft border-t border-ink/10 pt-4">
                            <span class="inline-flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-sm bg-paper border border-ink/20"></span>Bisa dipesan</span>
                            <span class="inline-flex items-center gap-2"><span class="w-3 h-3 relative"><span class="absolute inset-0" style="background-image: linear-gradient(135deg, transparent 45%, #c14b33 48%, #c14b33 52%, transparent 55%);"></span></span>Terpakai</span>
                            <span class="inline-flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-sm outline outline-2 outline-stempel"></span>Hari ini</span>
                        </div>
                    </div>

                    <div class="reveal-stamp stempel stempel--solid absolute -top-4 -right-2 sm:-right-4 text-base sm:text-lg py-2 px-3 shadow-sm">
                        Anti&nbsp;bentrok
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
