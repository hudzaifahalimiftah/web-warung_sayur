@extends('layouts.app')
@section('title', $product->product_name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-green-600">Beranda</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-green-600">Produk</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-800 font-medium">{{ $product->product_name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- Gambar produk asli --}}
            <div class="bg-gray-100 overflow-hidden" style="min-height: 360px;">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->product_name }}"
                     class="w-full h-full object-cover"
                     style="max-height: 480px;"
                     onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=600&q=80'">
            </div>

            {{-- Info --}}
            <div class="p-8 flex flex-col justify-center">
                <span class="inline-block text-xs text-green-600 font-semibold bg-green-50 px-3 py-1 rounded-full mb-3 w-fit">
                    {{ $product->category->category_name }}
                </span>

                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->product_name }}</h1>

                <div class="flex items-baseline gap-2 mb-4">
                    <span class="text-3xl font-extrabold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-gray-400 text-base">/ {{ $product->unit }}</span>
                </div>

                @if($product->description)
                    <p class="text-gray-500 mb-5 leading-relaxed text-sm">{{ $product->description }}</p>
                @endif

                {{-- Stok --}}
                <div class="mb-6">
                    @if($product->stock > 0)
                        <span class="inline-flex items-center gap-1.5 text-sm text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-xl font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Stok tersedia — {{ $product->stock }} {{ $product->unit }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-sm text-red-700 bg-red-50 border border-red-200 px-3 py-1.5 rounded-xl font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Stok habis
                        </span>
                    @endif
                </div>

                @if($product->stock > 0)
                    @auth
                        @if(auth()->user()->isAdmin())
                            {{-- Admin tidak bisa beli --}}
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-700 flex items-center gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Admin tidak dapat melakukan pembelian produk.
                            </div>
                        @else
                            {{-- Qty selector --}}
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-sm font-medium text-gray-600">Jumlah:</span>
                                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                    <button type="button" onclick="changeQty(-1)"
                                            class="w-10 h-10 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors font-bold text-lg">−</button>
                                    <input type="number" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                           class="w-14 text-center h-10 border-x border-gray-200 focus:outline-none text-sm font-semibold">
                                    <button type="button" onclick="changeQty(1)"
                                            class="w-10 h-10 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors font-bold text-lg">+</button>
                                </div>
                            </div>

                            {{-- 2 Tombol: Keranjang + Beli Sekarang --}}
                            <div class="flex gap-3">
                                {{-- Tambah ke Keranjang --}}
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1" id="cartForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="cartQty" value="1">
                                    <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 border-2 border-green-600 text-green-600 hover:bg-green-50 font-bold py-3 rounded-xl transition-all text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Keranjang
                                    </button>
                                </form>

                                {{-- Beli Sekarang --}}
                                <form action="{{ route('buy.now') }}" method="POST" class="flex-1" id="buyForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="buyQty" value="1">
                                    <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-all shadow-sm hover:shadow-md text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        Beli Sekarang
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="block text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-sm">
                            Masuk untuk Membeli
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    {{-- Produk Serupa --}}
    @if($related->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Produk Serupa</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($related as $relProduct)
                    @include('partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
    // Sync ke kedua form
    document.getElementById('cartQty').value = val;
    document.getElementById('buyQty').value = val;
}
// Sync manual input
document.getElementById('qty').addEventListener('input', function() {
    document.getElementById('cartQty').value = this.value;
    document.getElementById('buyQty').value = this.value;
});
</script>
@endpush
@endsection
