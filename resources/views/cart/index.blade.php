@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">🛒 Keranjang Belanja</h1>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Kosong</h2>
            <p class="text-gray-400 mb-6">Belum ada produk di keranjang Anda.</p>
            <a href="{{ route('products.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors inline-block">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-3">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
                        <div class="w-16 h-16 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if($item->product->image && file_exists(public_path('storage/' . $item->product->image)))
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <span class="text-3xl">🥬</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $item->product->product_name }}</h3>
                            <p class="text-sm text-primary-600 font-medium">Rp {{ number_format($item->product->price, 0, ',', '.') }}/{{ $item->product->unit }}</p>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Update Qty --}}
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                @csrf
                                @method('PATCH')
                                <button type="button" onclick="this.form.quantity.value=Math.max(1,parseInt(this.form.quantity.value)-1);this.form.submit()"
                                        class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors font-bold text-sm">−</button>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                       class="w-10 text-center py-1.5 border-x border-gray-200 focus:outline-none text-sm font-medium"
                                       onchange="this.form.submit()">
                                <button type="button" onclick="this.form.quantity.value=Math.min({{ $item->product->stock }},parseInt(this.form.quantity.value)+1);this.form.submit()"
                                        class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors font-bold text-sm">+</button>
                            </form>

                            <span class="text-sm font-semibold text-gray-700 w-24 text-right">
                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                            </span>

                            {{-- Remove --}}
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-1" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-20">
                    <h2 class="font-bold text-gray-800 text-lg mb-5">Ringkasan Pesanan</h2>
                    <div class="space-y-3 mb-5">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm text-gray-600">
                                <span class="truncate mr-2">{{ $item->product->product_name }} ×{{ $item->quantity }}</span>
                                <span class="flex-shrink-0">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between font-bold text-gray-800 text-lg">
                            <span>Total</span>
                            <span class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('orders.checkout') }}"
                       class="block w-full text-center bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl transition-colors">
                        Lanjut ke Checkout →
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="block w-full text-center text-gray-500 hover:text-gray-700 text-sm mt-3 transition-colors">
                        ← Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
