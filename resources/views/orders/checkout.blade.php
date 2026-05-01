@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">📦 Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 text-lg mb-5">Informasi Pengiriman</h2>

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penerima</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" value="{{ auth()->user()->phone ?? '-' }}" disabled
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Pengiriman <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" rows="4" required
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 resize-none @error('shipping_address') border-red-400 @enderror"
                                  placeholder="Masukkan alamat lengkap pengiriman...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-primary-50 border border-primary-100 rounded-xl p-4 text-sm text-primary-800">
                        <p class="font-medium mb-1">💬 Konfirmasi via WhatsApp</p>
                        <p class="text-primary-600">Setelah checkout, Anda akan diarahkan ke WhatsApp Admin untuk konfirmasi pembayaran.</p>
                    </div>

                    <button type="submit"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl transition-colors">
                        Buat Pesanan & Konfirmasi via WA →
                    </button>
                </div>
            </form>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 text-lg mb-5">Ringkasan Pesanan</h2>
            <div class="space-y-3 mb-5">
                @foreach($cartItems as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-lg">🥬</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->product_name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->quantity }} {{ $item->product->unit }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-gray-100 pt-4">
                <div class="flex justify-between font-bold text-gray-800 text-xl">
                    <span>Total</span>
                    <span class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
