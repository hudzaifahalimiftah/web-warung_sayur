@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('orders.history') }}" class="text-gray-400 hover:text-gray-600 transition-colors">← Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-sm text-gray-400">Tanggal Pesanan</p>
                <p class="font-medium text-gray-700">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium
                @if($order->status === 'delivered') bg-green-100 text-green-700
                @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                @else bg-blue-100 text-blue-700 @endif">
                {{ $order->status_label }}
            </span>
        </div>

        <div class="mb-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Alamat Pengiriman</p>
            <p class="text-gray-700">{{ $order->shipping_address }}</p>
        </div>

        <div class="border-t border-gray-100 pt-5">
            <h3 class="font-semibold text-gray-700 mb-4">Item Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-lg">🥬</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">{{ $item->product->product_name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->quantity }} {{ $item->product->unit }} × Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-gray-100 mt-4 pt-4 flex justify-between font-bold text-gray-800 text-lg">
                <span>Total</span>
                <span class="text-primary-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if($order->status === 'pending')
        <a href="{{ $waUrl }}" target="_blank"
           class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition-colors">
            💬 Konfirmasi Pembayaran via WhatsApp
        </a>
    @endif
</div>
@endsection
