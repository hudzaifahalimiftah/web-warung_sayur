@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h1>
            @if(!$cartItems->isEmpty())
                <p class="text-sm text-gray-400">{{ $cartItems->count() }} produk dipilih</p>
            @endif
        </div>
    </div>

    @if($cartItems->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-700 mb-2">Keranjang Masih Kosong</h2>
            <p class="text-gray-400 mb-8 text-sm">Yuk, mulai pilih sayuran segar favoritmu!</p>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Mulai Belanja
            </a>
        </div>

    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-3">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">

                        {{-- Gambar produk asli --}}
                        <a href="{{ route('products.show', $item->product) }}" class="flex-shrink-0">
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100">
                                <img src="{{ $item->product->image_url }}"
                                     alt="{{ $item->product->product_name }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-200"
                                     onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=200&q=80'">
                            </div>
                        </a>

                        {{-- Info produk --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item->product) }}">
                                <h3 class="font-semibold text-gray-800 hover:text-green-600 transition-colors truncate">
                                    {{ $item->product->product_name }}
                                </h3>
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->product->category->category_name }}</p>
                            <p class="text-sm text-green-600 font-semibold mt-1">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}<span class="text-gray-400 font-normal">/{{ $item->product->unit }}</span>
                            </p>
                        </div>

                        {{-- Qty + Hapus --}}
                        <div class="flex items-center gap-3 flex-shrink-0">
                            {{-- Qty control --}}
                            <form action="{{ route('cart.update', $item) }}" method="POST"
                                  class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                @csrf
                                @method('PATCH')
                                <button type="button"
                                        onclick="this.form.quantity.value=Math.max(1,parseInt(this.form.quantity.value)-1);this.form.submit()"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors font-bold text-lg leading-none">
                                    −
                                </button>
                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                       min="1" max="{{ $item->product->stock }}"
                                       class="w-10 text-center h-8 border-x border-gray-200 focus:outline-none text-sm font-semibold"
                                       onchange="this.form.submit()">
                                <button type="button"
                                        onclick="this.form.quantity.value=Math.min({{ $item->product->stock }},parseInt(this.form.quantity.value)+1);this.form.submit()"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors font-bold text-lg leading-none">
                                    +
                                </button>
                            </form>

                            {{-- Subtotal --}}
                            <span class="text-sm font-bold text-gray-800 w-24 text-right hidden sm:block">
                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                            </span>

                            {{-- Hapus --}}
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus dari keranjang">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="font-bold text-gray-800 text-base mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Ringkasan Pesanan
                    </h2>

                    <div class="space-y-2.5 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                    <img src="{{ $item->product->image_url }}"
                                         alt="{{ $item->product->product_name }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=100&q=80'">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-600 truncate">{{ $item->product->product_name }}</p>
                                    <p class="text-xs text-gray-400">×{{ $item->quantity }} {{ $item->product->unit }}</p>
                                </div>
                                <span class="text-xs font-semibold text-gray-700 flex-shrink-0">
                                    Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-5">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-extrabold text-green-600 text-xl">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('orders.checkout') }}"
                       class="flex items-center justify-center gap-2 w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-sm hover:shadow-md">
                        Checkout Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="flex items-center justify-center gap-1.5 w-full text-gray-400 hover:text-gray-600 text-sm mt-3 transition-colors py-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Lanjut Belanja
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection
