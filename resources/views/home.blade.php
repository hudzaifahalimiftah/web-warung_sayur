@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- HERO --}}
<section class="relative bg-gradient-to-br from-green-700 via-green-600 to-emerald-500 text-white overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/5 rounded-full translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-20 flex flex-col md:flex-row items-center gap-10">
        <div class="flex-1 text-center md:text-left">
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1.5 rounded-full mb-5 border border-white/20">
                <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                Pengiriman Aktif Setiap Hari
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4 tracking-tight">
                Sayur Segar<br>
                <span class="text-green-200">Langsung ke Rumah</span>
            </h1>
            <p class="text-green-100 text-base md:text-lg mb-8 max-w-md mx-auto md:mx-0 leading-relaxed">
                Belanja sayuran segar dari petani lokal. Kualitas terjamin, harga terjangkau, dikirim hari ini.
            </p>
            <div class="flex gap-3 flex-wrap justify-center md:justify-start">
                <a href="{{ route('products.index') }}"
                   class="bg-white text-green-700 hover:bg-green-50 font-bold px-6 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                    Belanja Sekarang
                </a>
                @guest
                <a href="{{ route('register') }}"
                   class="border-2 border-white/50 text-white hover:bg-white/10 font-semibold px-6 py-3 rounded-xl transition-all text-sm">
                    Daftar Gratis
                </a>
                @endguest
            </div>
        </div>

        {{-- Hero image --}}
        <div class="flex-1 flex justify-center">
            <div class="relative w-64 h-64 md:w-80 md:h-80 rounded-3xl overflow-hidden shadow-2xl border-4 border-white/20">
                <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?w=600&q=80"
                     alt="Sayur segar"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-green-900/30 to-transparent"></div>
                <div class="absolute bottom-3 left-3 bg-white text-green-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                    100% Segar
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center divide-x divide-gray-100">
            @foreach([
                ['value' => '100+',       'label' => 'Produk Segar'],
                ['value' => '500+',       'label' => 'Pelanggan Puas'],
                ['value' => 'Setiap Hari','label' => 'Pengiriman'],
                ['value' => '4.9/5',      'label' => 'Rating Toko'],
            ] as $stat)
            <div class="py-2">
                <div class="font-extrabold text-green-600 text-xl">{{ $stat['value'] }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- INFO BANNER --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm text-gray-800">Produk Segar</p>
                <p class="text-gray-500 text-xs mt-0.5">Langsung dari petani lokal</p>
            </div>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm text-gray-800">Pengiriman Cepat</p>
                <p class="text-gray-500 text-xs mt-0.5">Dipesan pagi, tiba siang</p>
            </div>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm text-gray-800">Konfirmasi via WA</p>
                <p class="text-gray-500 text-xs mt-0.5">Pembayaran mudah & aman</p>
            </div>
        </div>
    </div>
</section>

{{-- PRODUK PER KATEGORI --}}
<section id="categories" class="max-w-7xl mx-auto px-4 pb-16">
    @foreach($categories as $category)
        @if($category->products->count() > 0)
        <div class="mb-12">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-7 bg-green-600 rounded-full"></div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $category->category_name }}</h2>
                        <p class="text-xs text-gray-400">{{ $category->products->count() }} produk tersedia</p>
                    </div>
                </div>
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="text-sm text-green-600 hover:text-green-700 font-semibold hover:underline">
                    Lihat semua
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                @foreach($category->products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</section>

{{-- CTA --}}
<section class="bg-gradient-to-r from-green-600 to-emerald-600 text-white">
    <div class="max-w-4xl mx-auto px-4 py-14 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">Siap Belanja Sayur Segar?</h2>
        <p class="text-green-100 mb-8 text-base">Daftar sekarang dan nikmati kemudahan belanja sayur online langsung dari petani.</p>
        @guest
            <a href="{{ route('register') }}"
               class="inline-block bg-white text-green-700 hover:bg-green-50 font-bold px-8 py-3.5 rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Daftar Gratis Sekarang
            </a>
        @else
            <a href="{{ route('products.index') }}"
               class="inline-block bg-white text-green-700 hover:bg-green-50 font-bold px-8 py-3.5 rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Belanja Sekarang
            </a>
        @endguest
    </div>
</section>

@endsection
