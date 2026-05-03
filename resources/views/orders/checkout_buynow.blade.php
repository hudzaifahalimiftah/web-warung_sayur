@extends('layouts.app')
@section('title', 'Beli Sekarang')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Beli Sekarang</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Form Pengiriman --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 text-lg mb-5">Informasi Pengiriman</h2>
            <form method="POST" action="{{ route('orders.store.buynow') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penerima</label>
                        <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="recipient_phone" value="{{ old('recipient_phone', auth()->user()->phone) }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 transition"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Pengiriman <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" rows="4" required
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 resize-none @error('shipping_address') border-red-400 @enderror"
                                  placeholder="Masukkan alamat lengkap pengiriman...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-sm text-green-800">
                        Setelah checkout, Anda akan diarahkan ke WhatsApp Admin untuk konfirmasi pembayaran.
                    </div>
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-sm hover:shadow-md">
                        Pesan Sekarang
                    </button>
                </div>
            </form>
        </div>

        {{-- Ringkasan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 text-lg mb-5">Ringkasan Pesanan</h2>
            <div class="flex items-center gap-4 mb-5">
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->product_name }}"
                         class="w-full h-full object-cover"
                         onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=200&q=80'">
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $product->product_name }}</p>
                    <p class="text-sm text-gray-400">{{ $product->category->category_name }}</p>
                    <p class="text-sm text-green-600 font-semibold mt-1">
                        Rp {{ number_format($product->price, 0, ',', '.') }} / {{ $product->unit }}
                    </p>
                    <p class="text-sm text-gray-500 mt-0.5">Jumlah: {{ $quantity }} {{ $product->unit }}</p>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-4">
                <div class="flex justify-between font-bold text-gray-800 text-xl">
                    <span>Total</span>
                    <span class="text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
