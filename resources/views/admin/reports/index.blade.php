@extends('layouts.admin')
@section('title', 'Laporan Penjualan')


@section('content')
@php
    $bulanNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $bulanFull  = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
@endphp

{{-- ── Filter Bar ───────────────────────────────────────────────────── --}}
<form method="GET" class="flex items-center gap-3 mb-6 flex-wrap">
    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-1.5">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <select name="month" class="text-sm text-slate-700 bg-transparent focus:outline-none pr-1">
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ $bulanFull[$m-1] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-1.5">
        <select name="year" class="text-sm text-slate-700 bg-transparent focus:outline-none pr-1">
            @foreach($availableYears as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit"
            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2 rounded-xl text-sm transition-colors"
            style="box-shadow:0 4px 12px rgba(22,163,74,.3)">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
        </svg>
        Tampilkan
    </button>
</form>

{{-- ── Summary Cards ────────────────────────────────────────────────── --}}
{{-- Urutan: Hari Ini | Bulan Ini | Total Pesanan | Pelanggan Baru --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- Card 1: Rekapan Hari Ini --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 relative overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-60"
             style="background:radial-gradient(circle,rgba(16,185,129,.15),transparent)"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 10px rgba(16,185,129,.35)">
                <svg style="width:18px;height:18px" class="text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                {{ now()->translatedFormat('l') }}
            </span>
        </div>
        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Pemasukan Hari Ini</p>
        <p class="text-xl font-extrabold text-slate-800 leading-tight">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $todayOrders }} pesanan masuk</p>
    </div>

    {{-- Card 2: Pemasukan Bulan Ini --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 relative overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-60"
             style="background:radial-gradient(circle,rgba(22,163,74,.15),transparent)"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#16a34a,#15803d);box-shadow:0 4px 10px rgba(22,163,74,.35)">
                <svg style="width:18px;height:18px" class="text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full border border-primary-100">
                {{ $bulanNames[$month-1] }} {{ $year }}
            </span>
        </div>
        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Pemasukan Bulan Ini</p>
        <p class="text-xl font-extrabold text-slate-800 leading-tight">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">dari {{ $daysInMonth }} hari</p>
    </div>

    {{-- Card 3: Total Pesanan --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 relative overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-60"
             style="background:radial-gradient(circle,rgba(99,102,241,.15),transparent)"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5);box-shadow:0 4px 10px rgba(99,102,241,.35)">
                <svg style="width:18px;height:18px" class="text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Total Pesanan</p>
        <p class="text-xl font-extrabold text-slate-800 leading-tight">{{ $monthlyOrders }}</p>
        <p class="text-xs text-slate-400 mt-1">bulan {{ $bulanNames[$month-1] }}</p>
    </div>

    {{-- Card 4: Pelanggan Baru --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 relative overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-60"
             style="background:radial-gradient(circle,rgba(245,158,11,.15),transparent)"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 4px 10px rgba(245,158,11,.35)">
                <svg style="width:18px;height:18px" class="text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
        </div>
        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Pelanggan Baru</p>
        <p class="text-xl font-extrabold text-slate-800 leading-tight">{{ $newCustomers }}</p>
        <p class="text-xs text-slate-400 mt-1">registrasi bulan ini</p>
    </div>

</div>

{{-- ── Chart: Pemasukan per Bulan ───────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Pemasukan per Bulan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Tren pendapatan sepanjang tahun {{ $year }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1.5 text-xs text-slate-500">
                <span class="w-3 h-3 rounded-sm inline-block" style="background:linear-gradient(135deg,#22c55e,#15803d)"></span>
                Pendapatan
            </span>
            <span class="flex items-center gap-1.5 text-xs text-slate-500">
                <span class="w-3 h-3 rounded-sm inline-block" style="background:rgba(22,163,74,0.15);border:1px solid rgba(22,163,74,0.3)"></span>
                Bulan lain
            </span>
        </div>
    </div>
    @php
        $chartLabels = json_encode($bulanNames);
        $chartData   = json_encode(array_map(fn($m) => (float)($yearlyData->get($m)?->revenue ?? 0), range(1,12)));
        $chartOrders = json_encode(array_map(fn($m) => (int)($yearlyData->get($m)?->total_orders ?? 0), range(1,12)));
        $activeMonth = (int)$month - 1;
    @endphp
    <div class="relative" style="height:260px">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

{{-- ── Pemasukan Harian ─────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-6" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Pemasukan Harian</h3>
            <p class="text-xs text-slate-400 mt-0.5">{{ $bulanFull[$month-1] }} {{ $year }}</p>
        </div>
        <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
            {{ $dailyRevenue->count() }} hari aktif
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pesanan</th>
                    <th class="px-6 py-3 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pemasukan</th>
                    <th class="px-6 py-3 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Proporsi</th>
                </tr>
            </thead>
            <tbody>
                @for($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $data = $dailyRevenue->get($d);
                        $rev  = $data?->revenue ?? 0;
                        $ord  = $data?->total_orders ?? 0;
                        $pct  = $monthlyRevenue > 0 ? round(($rev / $monthlyRevenue) * 100, 1) : 0;
                        $isToday = ($year == date('Y') && $month == date('n') && $d == date('j'));
                    @endphp
                    @if($data)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/70 transition-colors {{ $isToday ? 'bg-emerald-50/40' : '' }}">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2">
                                @if($isToday)
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0 animate-pulse"></span>
                                @endif
                                <span class="font-medium text-slate-700 text-xs">
                                    {{ \Carbon\Carbon::create($year, $month, $d)->translatedFormat('l, d F Y') }}
                                </span>
                                @if($isToday)
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-100 px-1.5 py-0.5 rounded-full">Hari ini</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-right text-xs text-slate-500">{{ $ord }} pesanan</td>
                        <td class="px-6 py-3.5 text-right font-semibold text-slate-800 text-sm">Rp {{ number_format($rev, 0, ',', '.') }}</td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" style="width:{{ $pct }}%;background:linear-gradient(90deg,#22c55e,#15803d)"></div>
                                </div>
                                <span class="text-xs text-slate-400 w-8 text-right">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endfor
                <tr class="border-t-2 border-slate-200 bg-slate-50">
                    <td class="px-6 py-3.5 font-bold text-slate-700 text-sm">Total</td>
                    <td class="px-6 py-3.5 text-right font-bold text-slate-700 text-sm">{{ $monthlyOrders }} pesanan</td>
                    <td class="px-6 py-3.5 text-right font-extrabold text-primary-600 text-sm">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</td>
                    <td class="px-6 py-3.5 text-right text-xs text-slate-400">100%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labels  = {!! $chartLabels !!};
    const data    = {!! $chartData !!};
    const orders  = {!! $chartOrders !!};
    const active  = {{ $activeMonth }};

    function fmtRp(v) {
        if (v >= 1000000) return 'Rp ' + (v / 1000000).toFixed(1).replace('.0','') + 'jt';
        if (v >= 1000)    return 'Rp ' + (v / 1000).toFixed(0) + 'rb';
        return 'Rp ' + v;
    }

    const ctx = document.getElementById('revenueChart').getContext('2d');

    const gradientActive = ctx.createLinearGradient(0, 0, 0, 260);
    gradientActive.addColorStop(0, 'rgba(34,197,94,1)');
    gradientActive.addColorStop(1, 'rgba(21,128,61,0.85)');

    const bgColors    = labels.map((_, i) => i === active ? gradientActive : 'rgba(22,163,74,0.12)');
    const hoverColors = labels.map((_, i) => i === active ? 'rgba(21,128,61,1)' : 'rgba(22,163,74,0.28)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Pendapatan',
                data,
                backgroundColor: bgColors,
                hoverBackgroundColor: hoverColors,
                borderRadius: 8,
                borderSkipped: false,
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        title: (items) => labels[items[0].dataIndex],
                        label: (item) => [
                            '  Pendapatan : ' + fmtRp(item.raw),
                            '  Pesanan    : ' + orders[item.dataIndex] + ' order',
                        ],
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11, family: 'Inter' } }
                },
                y: {
                    grid: { color: 'rgba(148,163,184,0.1)' },
                    border: { display: false, dash: [4,4] },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11, family: 'Inter' },
                        maxTicksLimit: 5,
                        callback: (v) => fmtRp(v),
                    }
                }
            },
            animation: { duration: 700, easing: 'easeOutQuart' }
        }
    });
})();
</script>
@endpush
