@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- ── Stat Cards ──────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 xl:grid-cols-5 gap-4 mb-6">
    @php
        $cards = [
            ['label' => 'Total Pesanan',   'value' => $stats['total_orders'],   'color' => 'stat-blue',
             'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'],
            ['label' => 'Menunggu',        'value' => $stats['pending_orders'], 'color' => 'stat-amber',
             'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            ['label' => 'Total Produk',    'value' => $stats['total_products'], 'color' => 'stat-green',
             'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
            ['label' => 'Total Pelanggan', 'value' => $stats['total_users'],    'color' => 'stat-purple',
             'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
            ['label' => 'Pendapatan',      'value' => 'Rp ' . number_format($stats['revenue'], 0, ',', '.'), 'color' => 'stat-teal',
             'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
        ];
    @endphp

    @foreach($cards as $card)
        <div class="{{ $card['color'] }} rounded-2xl p-5 text-white relative overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute -right-3 -top-3 w-20 h-20 rounded-full bg-white/10"></div>
            <div class="absolute -right-1 -bottom-5 w-14 h-14 rounded-full bg-white/[0.07]"></div>
            <div class="relative">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        {!! $card['icon'] !!}
                    </svg>
                </div>
                <div class="text-2xl font-bold leading-tight">{{ $card['value'] }}</div>
                <div class="text-xs text-white/70 mt-0.5 font-medium">{{ $card['label'] }}</div>
            </div>
        </div>
    @endforeach
</div>

{{-- ── Recent Orders ────────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-slate-800 text-sm">Pesanan Terbaru</h2>
            <p class="text-xs text-slate-400 mt-0.5">10 pesanan terakhir masuk</p>
        </div>
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">
            Lihat semua
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/70">
                        <td class="px-6 py-3.5">
                            <span class="font-mono text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0"
                                     style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-700 text-xs">{{ $order->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800 text-xs">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3.5">
                            @php
                                $badge = match($order->status) {
                                    'delivered'  => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'cancelled'  => 'bg-red-50 text-red-600 ring-1 ring-red-200',
                                    'pending'    => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                    'confirmed'  => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                    'processing' => 'bg-violet-50 text-violet-700 ring-1 ring-violet-200',
                                    default      => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $badge }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-xs text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3.5">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-flex items-center gap-1 text-xs font-medium text-primary-600 hover:text-primary-700">
                                Detail
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm text-slate-400">Belum ada pesanan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
