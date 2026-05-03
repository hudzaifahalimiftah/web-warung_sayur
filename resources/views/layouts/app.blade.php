<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Warung Sayur') - Sayur Segar Setiap Hari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',
                            400:'#4ade80',500:'#22c55e',600:'#16a34a',700:'#15803d',
                            800:'#166534',900:'#14532d',
                        }
                    },
                    fontFamily: { sans: ['Inter','sans-serif'] }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        html, body { overflow-x: hidden; }
        .line-clamp-2 { display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
        .line-clamp-1 { display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

{{-- TOP BAR --}}
<div class="bg-green-700 text-green-100 text-xs py-1.5 hidden md:block">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <span>Sayur segar dari petani lokal — dikirim setiap hari!</span>
        <span>0812-3456-7890 &nbsp;|&nbsp; Senin–Sabtu 06.00–18.00</span>
    </div>
</div>

{{-- NAVBAR --}}
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 h-16">

            {{-- Logo: teks saja, clean --}}
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-1">
                <span class="text-2xl font-extrabold text-green-700 tracking-tight">Warung</span>
                <span class="text-2xl font-extrabold text-green-500 tracking-tight">Sayur</span>
            </a>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('products.index') }}" class="flex-1 max-w-xl hidden md:flex">
                <div class="flex w-full rounded-xl overflow-hidden border-2 border-green-600 focus-within:border-green-700 transition-colors">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari sayuran, bumbu, buah..."
                           class="flex-1 px-4 py-2 text-sm focus:outline-none bg-white">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-5 text-sm font-semibold transition-colors">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Right --}}
            <div class="flex items-center gap-2 ml-auto">
                @auth
                    {{-- Cart — hanya untuk user biasa --}}
                    @if(!auth()->user()->isAdmin())
                    <a href="{{ route('cart.index') }}"
                       class="relative flex items-center gap-1.5 text-gray-600 hover:text-green-600 transition-colors px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:block">Keranjang</span>
                        @php $cartCount = auth()->user()->cart()->count(); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 left-4 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @endif

                    {{-- User Dropdown --}}
                    <div class="relative" id="userDropdownWrap">
                        <button onclick="toggleDropdown()"
                                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white pl-3 pr-3 py-2 rounded-xl font-semibold transition-colors text-sm">
                            <div class="w-6 h-6 bg-white/25 rounded-full flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block max-w-[90px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="userDropdown"
                             class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                            <div class="px-4 py-3 bg-green-50 border-b border-green-100">
                                <p class="text-xs text-green-600 font-medium">Masuk sebagai</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                            </div>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                    Panel Admin
                                </a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                Profil Saya
                            </a>
                            @if(!auth()->user()->isAdmin())
                            <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                Riwayat Pesanan
                            </a>
                            @endif
                            <div class="border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-green-600 font-medium transition-colors text-sm px-3 py-2 rounded-lg hover:bg-green-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-semibold text-sm transition-colors shadow-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>

        {{-- Mobile Search --}}
        <div class="pb-3 md:hidden">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="flex rounded-xl overflow-hidden border-2 border-green-600">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari sayuran..."
                           class="flex-1 px-3 py-2 text-sm focus:outline-none">
                    <button type="submit" class="bg-green-600 text-white px-4 text-sm font-semibold">Cari</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Category Nav — hanya untuk non-admin --}}
    @if(!auth()->check() || !auth()->user()->isAdmin())
    <div class="border-t border-gray-100 bg-white hidden md:block">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center gap-1 py-2 overflow-x-auto">
                <a href="{{ route('products.index') }}"
                   class="flex-shrink-0 text-xs font-medium px-3 py-1.5 rounded-lg transition-colors
                          {{ !request('category') && request()->routeIs('products.*') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    Semua Produk
                </a>
                @php $navCategories = \App\Models\Category::all(); @endphp
                @foreach($navCategories as $nc)
                    <a href="{{ route('products.index', ['category' => $nc->slug]) }}"
                       class="flex-shrink-0 text-xs font-medium px-3 py-1.5 rounded-lg transition-colors
                              {{ request('category') === $nc->slug ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        {{ $nc->category_name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div id="flash-success" class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div id="flash-error" class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    </div>
@endif

<main>@yield('content')</main>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-400 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-1 mb-4">
                    <span class="text-xl font-extrabold text-white">Warung</span>
                    <span class="text-xl font-extrabold text-green-400">Sayur</span>
                </div>
                <p class="text-sm text-gray-500 leading-relaxed max-w-xs">
                    Sayur segar berkualitas langsung dari petani lokal. Dipesan hari ini, dikirim besok pagi ke pintu rumah Anda.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm">Navigasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-green-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-green-400 transition-colors">Semua Produk</a></li>
                    @auth
                    @if(!auth()->user()->isAdmin())
                    <li><a href="{{ route('orders.history') }}" class="hover:text-green-400 transition-colors">Riwayat Pesanan</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm">Kontak</h4>
                <ul class="space-y-2.5 text-sm">
                    <li>0812-3456-7890</li>
                    <li>info@warungs ayur.id</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-600">
            <span>© {{ date('Y') }} Warung Sayur. Semua hak dilindungi.</span>
            <span>Untuk petani lokal Indonesia</span>
        </div>
    </div>
</footer>

@stack('scripts')
<script>
// Dropdown toggle
function toggleDropdown() {
    var dd = document.getElementById('userDropdown');
    if (dd) dd.classList.toggle('hidden');
}
// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    var wrap = document.getElementById('userDropdownWrap');
    var dd   = document.getElementById('userDropdown');
    if (wrap && dd && !wrap.contains(e.target)) {
        dd.classList.add('hidden');
    }
});

// Auto remove flash messages setelah 4 detik
['flash-success','flash-error'].forEach(function(id) {
    var el = document.getElementById(id);
    if (el) {
        setTimeout(function() {
            el.style.transition = 'opacity 0.4s ease';
            el.style.opacity = '0';
            setTimeout(function() { el.remove(); }, 400);
        }, 4000);
    }
});
</script>
</body>
</html>
