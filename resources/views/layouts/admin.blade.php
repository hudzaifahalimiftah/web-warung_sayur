<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Dashboard') | Warung Sayur</title>
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
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="p-5 border-b border-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <span class="text-2xl">🥬</span>
                <div>
                    <div class="font-bold text-white">Warung Sayur</div>
                    <div class="text-xs text-gray-400">Panel Admin</div>
                </div>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',        'icon' => '📊', 'label' => 'Dashboard'],
                    ['route' => 'admin.products.index',   'icon' => '🥬', 'label' => 'Produk'],
                    ['route' => 'admin.categories.index', 'icon' => '🏷️', 'label' => 'Kategori'],
                    ['route' => 'admin.orders.index',     'icon' => '📦', 'label' => 'Pesanan'],
                ];
            @endphp
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs($item['route']) ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <span>{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-sm text-gray-400 hover:text-white mb-3 transition-colors">
                <span>🌐</span> Lihat Toko
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 text-sm text-red-400 hover:text-red-300 transition-colors">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top Bar --}}
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>👤</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </header>

        {{-- Flash --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-primary-50 border border-primary-200 text-primary-800 px-4 py-3 rounded-xl flex items-center gap-2 mb-4">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 mb-4">
                    <span>❌</span> {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
