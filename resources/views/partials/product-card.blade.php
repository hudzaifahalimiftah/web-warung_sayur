@php
    $isLowStock  = $product->stock > 0 && $product->stock <= 10;
    $isOutOfStock = $product->stock === 0;
@endphp

<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100 overflow-hidden group relative">

    {{-- Badge stok --}}
    @if($isOutOfStock)
        <div class="absolute top-2 left-2 z-10 bg-gray-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
            Habis
        </div>
    @elseif($isLowStock)
        <div class="absolute top-2 left-2 z-10 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
            Stok Terbatas
        </div>
    @endif

    {{-- Gambar --}}
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="aspect-square overflow-hidden bg-gray-100">
            <img src="{{ $product->image_url }}"
                 alt="{{ $product->product_name }}"
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ $isOutOfStock ? 'opacity-50 grayscale' : '' }}"
                 onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400&q=80'">
        </div>
    </a>

    {{-- Info --}}
    <div class="p-3">
        <span class="text-[10px] text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full">
            {{ $product->category->category_name }}
        </span>

        <a href="{{ route('products.show', $product) }}">
            <h3 class="font-semibold text-gray-800 mt-1.5 mb-1 hover:text-green-600 transition-colors line-clamp-2 text-sm leading-snug">
                {{ $product->product_name }}
            </h3>
        </a>

        <div class="flex items-baseline gap-1 mb-2.5">
            <span class="font-bold text-green-600 text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            <span class="text-xs text-gray-400">/{{ $product->unit }}</span>
        </div>

        {{-- Stok bar --}}
        @if(!$isOutOfStock)
            @php $stockPct = min(100, ($product->stock / 50) * 100); @endphp
            <div class="mb-2.5">
                <div class="flex justify-between text-[10px] text-gray-400 mb-1">
                    <span>Stok</span>
                    <span>{{ $product->stock }} {{ $product->unit }}</span>
                </div>
                <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $isLowStock ? 'bg-orange-400' : 'bg-green-400' }}"
                         style="width: {{ $stockPct }}%"></div>
                </div>
            </div>
        @endif

        {{-- Tombol --}}
        @if($isOutOfStock)
            <button disabled class="w-full bg-gray-100 text-gray-400 text-xs font-medium py-2 rounded-xl cursor-not-allowed">
                Stok Habis
            </button>
        @elseif(auth()->check() && !auth()->user()->isAdmin())
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 active:scale-95 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    + Keranjang
                </button>
            </form>
            <form action="{{ route('buy.now') }}" method="POST" class="mt-1.5">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="w-full border border-green-600 text-green-600 hover:bg-green-50 text-xs font-semibold py-2 rounded-xl transition-all">
                    Beli Sekarang
                </button>
            </form>
        @elseif(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('products.show', $product) }}"
               class="block w-full text-center bg-gray-100 text-gray-500 text-xs font-medium py-2 rounded-xl">
                Lihat Detail
            </a>
        @else
            <a href="{{ route('login') }}"
               class="block w-full text-center bg-green-600 hover:bg-green-700 text-white text-xs font-semibold py-2 rounded-xl transition-colors">
                + Keranjang
            </a>
        @endif
    </div>
</div>
