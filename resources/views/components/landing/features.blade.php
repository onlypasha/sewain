<section id="fitur" class="border-b border-ink/10 py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl">Semua yang dulu manual, sekarang beres
                sendiri</h2>
            <p class="text-ink-soft mt-3 text-base sm:text-lg">Tinggalkan rekap Excel dan obrolan WA yang menumpuk.
                Sewain mengurus jadwal, verifikasi, dan dokumen untuk Anda.</p>
        </div>

        <div class="mt-12 grid grid-cols-1 lg:grid-cols-5 gap-x-12 gap-y-8">
            <div class="lg:col-span-3 flex flex-col">
                @foreach ($features as $feature)
                    <div class="border-t border-ink/10 py-5 first:border-t-0 first:pt-0 last:pb-0">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="font-display font-semibold text-lg leading-snug text-ink">{{ $feature['name'] }}
                            </h3>
                        </div>
                        <p class="text-ink-soft text-sm leading-relaxed mt-1 max-w-md">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
