@extends('layouts.app')
@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">📦 Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="text-5xl mb-3">📦</div>
            <p class="text-gray-500">Belum ada pesanan.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-primary-600 hover:underline text-sm">Mulai belanja →</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="font-semibold text-gray-800">Pesanan #{{ $order->id }}</p>
                            <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if($order->status === 'delivered') bg-green-100 text-green-700
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-blue-100 text-blue-700 @endif">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    <div class="space-y-1 mb-4">
                        @foreach($order->items->take(3) as $item)
                            <p class="text-sm text-gray-600">• {{ $item->product->product_name }} ×{{ $item->quantity }} {{ $item->product->unit }}</p>
                        @endforeach
                        @if($order->items->count() > 3)
                            <p class="text-sm text-gray-400">+{{ $order->items->count() - 3 }} item lainnya</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="font-bold text-primary-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        <a href="{{ route('orders.show', $order) }}" class="text-sm text-primary-600 hover:underline font-medium">Lihat Detail →</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
