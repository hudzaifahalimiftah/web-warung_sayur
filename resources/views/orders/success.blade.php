@extends('layouts.app')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
        <div class="text-6xl mb-4">🎉</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-500 mb-2">No. Pesanan: <span class="font-semibold text-gray-700">#{{ $order->id }}</span></p>
        <p class="text-gray-500 mb-8">Total: <span class="font-bold text-primary-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>

        {{-- Order Items --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-8 text-left">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm">Detail Pesanan:</h3>
            <div class="space-y-2">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $item->product->product_name }} ×{{ $item->quantity }} {{ $item->product->unit }}</span>
                        <span class="font-medium text-gray-700">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-8 text-left">
            <p class="text-sm text-green-800 font-medium mb-1">📱 Langkah Selanjutnya</p>
            <p class="text-sm text-green-700">Klik tombol di bawah untuk mengirim detail pesanan ke WhatsApp Admin dan konfirmasi pembayaran Anda.</p>
        </div>

        <a href="{{ $waUrl }}" target="_blank"
           class="block w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition-colors text-lg mb-4">
            💬 Konfirmasi via WhatsApp
        </a>

        <div class="flex gap-3">
            <a href="{{ route('orders.history') }}"
               class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl transition-colors text-sm">
                Riwayat Pesanan
            </a>
            <a href="{{ route('products.index') }}"
               class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 rounded-xl transition-colors text-sm">
                Belanja Lagi
            </a>
        </div>
    </div>
</div>
@endsection
