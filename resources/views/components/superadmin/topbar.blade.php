<!-- SUPERADMIN TOPBAR -->
@php
    $currentDate = \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y');
    $dbStatus = 'Terhubung';
    $dbColor = 'bg-emerald-500';
    $dbBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
    } catch (\Exception $e) {
        $dbStatus = 'Terputus';
        $dbColor = 'bg-rose-500';
        $dbBg = 'bg-rose-50 text-rose-700 border-rose-200';
    }
@endphp

<header
    class="bg-white border-b border-slate-200/90 py-3.5 px-6 sticky top-0 z-20 shadow-xs flex items-center justify-between">

    <!-- Left Section: Date & Time -->
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2 text-slate-700 text-sm font-semibold font-heading">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ $currentDate }}
        </div>
    </div>

    <!-- Right Section: Database Status -->
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-1.5 text-slate-600 text-lg font-bold font-mono px-2.5 py-1">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="superadmin-live-clock">{{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
            <span class="text-[10px] text-slate-400 font-sans ml-0.5">WIB</span>
        </div>
        <div
            class="flex items-center gap-2 {{ $dbBg }} border text-xs font-mono font-bold px-3 py-1.5 rounded-full shadow-sm">
            <span class="w-2 h-2 rounded-full {{ $dbColor }} animate-pulse shadow-sm"></span>
            <span>DB Status: {{ strtoupper($dbStatus) }}</span>
        </div>
    </div>
</header>

<script>
    setInterval(function() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockElement = document.getElementById('superadmin-live-clock');
        if (clockElement) {
            clockElement.textContent = hours + ':' + minutes + ':' + seconds;
        }
    }, 1000);
</script>
