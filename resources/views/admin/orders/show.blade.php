@extends('layouts.admin')
@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-3xl">

    {{-- Back --}}
    <a href="{{ route('admin.orders.index') }}"
       class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-400 hover:text-slate-600 mb-5 transition-colors">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Pesanan
    </a>

    {{-- ── Order Header ─────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-4 flex items-center justify-between" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div>
            <div class="flex items-center gap-2.5 mb-1">
                <span class="font-mono text-sm font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                    #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                </span>
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
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $badge }}">
                    {{ $order->status_label }}
                </span>
            </div>
            <p class="text-xs text-slate-400">Dibuat {{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-slate-400 mb-0.5">Total Pembayaran</p>
            <p class="text-xl font-bold text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- ── Customer & Shipping ──────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="bg-white rounded-2xl border border-slate-100 p-5" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Info Pelanggan</h3>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">{{ $order->user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $order->user->email }}</p>
                    @if($order->user->phone)
                        <p class="text-xs text-slate-400">{{ $order->user->phone }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 p-5" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Alamat Pengiriman</h3>
            </div>
            <p class="text-sm text-slate-700 leading-relaxed">{{ $order->shipping_address }}</p>
        </div>
    </div>

    {{-- ── Order Items ──────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-4" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm">Item Pesanan</h3>
            <span class="ml-auto text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $order->items->count() }} item</span>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-3 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Qty</th>
                    <th class="px-6 py-3 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/70">
                        <td class="px-6 py-3.5 font-medium text-slate-700 text-sm">{{ $item->product->product_name }}</td>
                        <td class="px-6 py-3.5 text-right text-xs text-slate-400">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                        <td class="px-6 py-3.5 text-right text-xs text-slate-500">{{ $item->quantity }} {{ $item->product->unit }}</td>
                        <td class="px-6 py-3.5 text-right font-semibold text-slate-700 text-sm">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-50 border-t border-slate-100">
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-slate-600">Total Pembayaran</td>
                    <td class="px-6 py-4 text-right font-bold text-primary-600 text-base">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- ── Update Status ────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-7 h-7 rounded-lg bg-violet-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm">Update Status Pesanan</h3>
        </div>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="flex gap-3 items-center">
            @csrf @method('PATCH')
            <select name="status"
                    class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                @foreach([
                    'pending'    => 'Menunggu Konfirmasi',
                    'confirmed'  => 'Dikonfirmasi',
                    'processing' => 'Sedang Diproses',
                    'delivered'  => 'Sudah Dikirim',
                    'cancelled'  => 'Dibatalkan',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors"
                    style="box-shadow:0 4px 12px rgba(22,163,74,.3)">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Update
            </button>
        </form>
    </div>

</div>
@endsection
