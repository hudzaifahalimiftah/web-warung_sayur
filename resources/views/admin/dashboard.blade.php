@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
        $cards = [
            ['label' => 'Total Pesanan',    'value' => $stats['total_orders'],   'icon' => '📦', 'color' => 'blue'],
            ['label' => 'Menunggu',         'value' => $stats['pending_orders'], 'icon' => '⏳', 'color' => 'yellow'],
            ['label' => 'Total Produk',     'value' => $stats['total_products'], 'icon' => '🥬', 'color' => 'green'],
            ['label' => 'Total Pelanggan',  'value' => $stats['total_users'],    'icon' => '👤', 'color' => 'purple'],
            ['label' => 'Pendapatan',       'value' => 'Rp ' . number_format($stats['revenue'], 0, ',', '.'), 'icon' => '💰', 'color' => 'emerald'],
        ];
    @endphp
    @foreach($cards as $card)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="text-2xl mb-2">{{ $card['icon'] }}</div>
            <div class="text-xl font-bold text-gray-800">{{ $card['value'] }}</div>
            <div class="text-sm text-gray-500 mt-0.5">{{ $card['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-gray-800">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary-600 hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">No.</th>
                    <th class="px-6 py-3 text-left">Pelanggan</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-700">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 font-semibold text-primary-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($order->status === 'delivered') bg-green-100 text-green-700
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:underline text-xs font-medium">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
