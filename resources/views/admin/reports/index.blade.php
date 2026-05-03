@extends('layouts.admin')
@section('title', 'Laporan Penjualan')

@section('content')

{{-- Filter --}}
<form method="GET" class="flex items-center gap-3 mb-6 flex-wrap">
    <select name="year" class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        @foreach($availableYears as $y)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endforeach
    </select>
    <select name="month" class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-xl text-sm transition-colors">
        Tampilkan
    </button>
</form>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <p class="text-xs text-slate-400 font-medium mb-1">Pemasukan Bulan Ini</p>
        <p class="text-xl font-extrabold text-green-600">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <p class="text-xs text-slate-400 font-medium mb-1">Total Pesanan</p>
        <p class="text-xl font-extrabold text-slate-800">{{ $monthlyOrders }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <p class="text-xs text-slate-400 font-medium mb-1">Pelanggan Baru</p>
        <p class="text-xl font-extrabold text-blue-600">{{ $newCustomers }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <p class="text-xs text-slate-400 font-medium mb-1">Rata-rata/Hari</p>
        <p class="text-xl font-extrabold text-slate-800">
            Rp {{ $monthlyOrders > 0 ? number_format($monthlyRevenue / $daysInMonth, 0, ',', '.') : '0' }}
        </p>
    </div>
</div>

{{-- Grafik Bulanan (bar sederhana CSS) --}}
<div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
    <h3 class="font-bold text-slate-800 text-sm mb-5">Pemasukan per Bulan — {{ $year }}</h3>
    @php
        $maxRevenue = $yearlyData->max('revenue') ?: 1;
        $bulanNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    @endphp
    <div class="flex items-end gap-2 h-40">
        @foreach(range(1,12) as $m)
            @php
                $rev = $yearlyData->get($m)?->revenue ?? 0;
                $pct = ($rev / $maxRevenue) * 100;
                $isActive = $m == $month;
            @endphp
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[9px] text-slate-400 font-medium">
                    {{ $rev > 0 ? number_format($rev/1000, 0) . 'k' : '' }}
                </span>
                <div class="w-full rounded-t-lg transition-all {{ $isActive ? 'bg-green-500' : 'bg-green-200 hover:bg-green-300' }}"
                     style="height: {{ max(4, $pct * 0.9) }}%"></div>
                <span class="text-[9px] text-slate-400">{{ $bulanNames[$m-1] }}</span>
            </div>
        @endforeach
    </div>
</div>

{{-- Pemasukan Harian --}}
<div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
    <h3 class="font-bold text-slate-800 text-sm mb-4">
        Pemasukan Harian —
        {{ $bulanNames[$month-1] }} {{ $year }}
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="py-2 text-left text-xs text-slate-400 font-semibold">Tanggal</th>
                    <th class="py-2 text-right text-xs text-slate-400 font-semibold">Pesanan</th>
                    <th class="py-2 text-right text-xs text-slate-400 font-semibold">Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalHarian = 0; @endphp
                @for($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $data = $dailyRevenue->get($d);
                        $rev  = $data?->revenue ?? 0;
                        $ord  = $data?->total_orders ?? 0;
                        $totalHarian += $rev;
                    @endphp
                    @if($data)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="py-2.5 text-slate-700 font-medium">
                            {{ str_pad($d, 2, '0', STR_PAD_LEFT) }} {{ $bulanNames[$month-1] }} {{ $year }}
                        </td>
                        <td class="py-2.5 text-right text-slate-500">{{ $ord }} pesanan</td>
                        <td class="py-2.5 text-right font-semibold text-green-600">
                            Rp {{ number_format($rev, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endif
                @endfor
                <tr class="border-t-2 border-slate-200 bg-slate-50">
                    <td class="py-3 font-bold text-slate-700">Total</td>
                    <td class="py-3 text-right font-bold text-slate-700">{{ $monthlyOrders }} pesanan</td>
                    <td class="py-3 text-right font-extrabold text-green-600">
                        Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Daftar Pesanan Bulan Ini --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-sm">Semua Pesanan — {{ $bulanNames[$month-1] }} {{ $year }}</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-3 text-left text-xs text-slate-400 font-semibold">No.</th>
                    <th class="px-6 py-3 text-left text-xs text-slate-400 font-semibold">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs text-slate-400 font-semibold">Total</th>
                    <th class="px-6 py-3 text-left text-xs text-slate-400 font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-xs text-slate-400 font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs text-slate-400 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="px-6 py-3">
                            <span class="font-mono text-xs bg-slate-100 px-2 py-0.5 rounded">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-3 font-medium text-slate-700 text-xs">{{ $order->user->name }}</td>
                        <td class="px-6 py-3 font-semibold text-green-600 text-xs">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            @php
                                $badge = match($order->status) {
                                    'completed'  => 'bg-green-100 text-green-700',
                                    'delivered'  => 'bg-cyan-100 text-cyan-700',
                                    'cancelled'  => 'bg-red-100 text-red-600',
                                    'pending'    => 'bg-amber-100 text-amber-700',
                                    'confirmed'  => 'bg-blue-100 text-blue-700',
                                    'processing' => 'bg-violet-100 text-violet-700',
                                    default      => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold {{ $badge }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-green-600 hover:underline font-medium">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada pesanan bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $orders->links() }}</div>
    @endif
</div>

@endsection
