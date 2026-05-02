@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')

@section('content')

{{-- ── Status Filter Tabs ───────────────────────────────────────────── --}}
<div class="flex items-center gap-2 mb-5 flex-wrap">
    @php
        $statuses = [
            ''           => ['label' => 'Semua',      'color' => ''],
            'pending'    => ['label' => 'Menunggu',   'color' => 'amber'],
            'confirmed'  => ['label' => 'Dikonfirmasi','color' => 'blue'],
            'processing' => ['label' => 'Diproses',   'color' => 'violet'],
            'delivered'  => ['label' => 'Dikirim',    'color' => 'emerald'],
            'cancelled'  => ['label' => 'Dibatalkan', 'color' => 'red'],
        ];
        $current = request('status', '');
    @endphp
    @foreach($statuses as $val => $meta)
        <a href="{{ route('admin.orders.index', $val ? ['status' => $val] : []) }}"
           class="px-4 py-2 rounded-xl text-xs font-semibold transition-all
                  {{ $current === $val
                      ? 'bg-slate-800 text-white shadow-sm'
                      : 'bg-white border border-slate-200 text-slate-500 hover:border-slate-300 hover:text-slate-700' }}">
            {{ $meta['label'] }}
        </a>
    @endforeach
</div>

{{-- ── Table ────────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-3.5">
                            <span class="font-mono text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">
                                #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0"
                                     style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-700 text-xs">{{ $order->user->name }}</p>
                                    @if($order->user->phone)
                                        <p class="text-[11px] text-slate-400">{{ $order->user->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800 text-xs">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
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
                        <td class="px-6 py-3.5 text-xs text-slate-400">
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3.5">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 transition-colors">
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
                                <p class="text-sm text-slate-400">Tidak ada pesanan</p>
                                @if($current)
                                    <a href="{{ route('admin.orders.index') }}" class="text-xs text-primary-600 hover:underline font-medium">Lihat semua pesanan</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
