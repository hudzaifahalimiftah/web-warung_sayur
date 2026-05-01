@extends('layouts.app')
@section('title', $product->product_name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-primary-600">Produk</a>
        <span>/</span>
        <span class="text-gray-800">{{ $product->product_name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            {{-- Image --}}
            <div class="bg-gray-100 flex items-center justify-center overflow-hidden min-h-72">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->product_name }}"
                     class="w-full h-full object-cover max-h-96"
                     onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=600&q=80'">
            </div>

            {{-- Info --}}
            <div class="p-8 flex flex-col justify-center">
                <span class="inline-block text-xs text-primary-600 font-medium bg-primary-50 px-3 py-1 rounded-full mb-3 w-fit">
                    {{ $product->category->category_name }}
                </span>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->product_name }}</h1>
                <div class="flex items-baseline gap-2 mb-4">
                    <span class="text-3xl font-bold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-gray-400">/ {{ $product->unit }}</span>
                </div>

                @if($product->description)
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $product->description }}</p>
                @endif

                <div class="flex items-center gap-2 mb-6">
                    @if($product->stock > 0)
                        <span class="inline-flex items-center gap-1 text-sm text-primary-700 bg-primary-50 px-3 py-1 rounded-full">
                            ✅ Stok tersedia ({{ $product->stock }} {{ $product->unit }})
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-sm text-red-700 bg-red-50 px-3 py-1 rounded-full">
                            ❌ Stok habis
                        </span>
                    @endif
                </div>

                @if($product->stock > 0)
                    @auth
                        <form action="{{ route('cart.add') }}" method="POST" class="flex gap-3 items-center">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                <button type="button" onclick="changeQty(-1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors font-bold">−</button>
                                <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                       class="w-14 text-center py-2 border-x border-gray-200 focus:outline-none text-sm font-medium">
                                <button type="button" onclick="changeQty(1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors font-bold">+</button>
                            </div>
                            <button type="submit" name="action" value="cart"
                                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-5 rounded-xl transition-colors">
                                🛒 Tambah ke Keranjang
                            </button>
                        </form>
                        <a href="{{ route('cart.index') }}"
                           class="mt-3 block text-center border-2 border-primary-600 text-primary-600 hover:bg-primary-50 font-semibold py-2.5 px-5 rounded-xl transition-colors">
                            Lihat Keranjang
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="block text-center bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl transition-colors">
                            Masuk untuk Membeli
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Produk Serupa</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($related as $product)
                    @include('partials.product-card', ['product' => $product])
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
}
</script>
@endpush
@endsection
