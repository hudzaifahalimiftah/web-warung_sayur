@extends('layouts.app')
@section('title', 'Semua Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            @if(request('search'))
                Hasil pencarian: "<span class="text-green-600">{{ request('search') }}</span>"
            @elseif(request('category'))
                @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                {{ $activeCat?->category_name ?? 'Produk' }}
            @else
                Semua Produk
            @endif
        </h1>
        <p class="text-sm text-gray-400 mt-1">{{ $products->total() }} produk ditemukan</p>
    </div>

    <div class="flex flex-col md:flex-row gap-6">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-full md:w-52 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sticky top-24">
                <h3 class="font-bold text-gray-700 text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                    </svg>
                    Kategori
                </h3>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('products.index', request('search') ? ['search' => request('search')] : []) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-colors
                                  {{ !request('category') ? 'bg-green-600 text-white font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                            <span>Semua Produk</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products.index', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-colors
                                      {{ request('category') === $cat->slug ? 'bg-green-600 text-white font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                                <span>{{ $cat->category_name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- ===== PRODUCTS ===== --}}
        <div class="flex-1 min-w-0">

            {{-- Mobile Search --}}
            <form method="GET" action="{{ route('products.index') }}" class="mb-5 md:hidden">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari sayuran..."
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Sort / Filter bar --}}
            <div class="flex items-center justify-between mb-4 bg-white rounded-xl border border-gray-100 px-4 py-2.5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-700">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-gray-700">{{ $products->total() }}</span> produk
                </p>
                @if(request('search') || request('category'))
                    <a href="{{ route('products.index') }}"
                       class="text-xs text-red-500 hover:text-red-600 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset filter
                    </a>
                @endif
            </div>

            @if($products->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 py-20 text-center shadow-sm">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-700 mb-1">Produk tidak ditemukan</h3>
                    <p class="text-sm text-gray-400 mb-4">Coba kata kunci lain atau lihat semua produk</p>
                    <a href="{{ route('products.index') }}"
                       class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                        Lihat Semua Produk
                    </a>
                </div>
            @else
                {{-- Grid: 2 col mobile, 3 col tablet, 4 col desktop --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
