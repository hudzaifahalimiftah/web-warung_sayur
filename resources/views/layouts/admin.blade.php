<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') · Warung Sayur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',
                            400:'#4ade80',500:'#22c55e',600:'#16a34a',700:'#15803d',
                            800:'#166534',900:'#14532d',950:'#052e16',
                        },
                        slate: {
                            750:'#293548',
                            850:'#172033',
                            950:'#0b1120',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    boxShadow: {
                        'card': '0 1px 3px 0 rgb(0 0 0 / 0.06), 0 1px 2px -1px rgb(0 0 0 / 0.04)',
                        'card-hover': '0 4px 12px 0 rgb(0 0 0 / 0.08), 0 2px 4px -1px rgb(0 0 0 / 0.04)',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }

        /* Sidebar active glow */
        .nav-active {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            box-shadow: 0 4px 14px 0 rgba(22,163,74,0.35);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Stat card gradient */
        .stat-blue   { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .stat-amber  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .stat-green  { background: linear-gradient(135deg, #22c55e 0%, #15803d 100%); }
        .stat-purple { background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%); }
        .stat-teal   { background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%); }

        /* Table row hover */
        tbody tr { transition: background 0.12s; }

        /* Sidebar transition */
        aside { transition: width 0.2s; }

        /* Flash animation */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .flash-msg { animation: slideDown 0.25s ease; }

        /* Badge pulse for pending */
        .badge-pending { animation: pulse 2s cubic-bezier(0.4,0,0.6,1) infinite; }
        @keyframes pulse {
            0%,100% { opacity: 1; }
            50%      { opacity: .7; }
        }
    </style>
</head>
<body>
<div class="flex h-screen overflow-hidden">

    {{-- ─── Sidebar ─────────────────────────────────────────────── --}}
    <aside class="w-64 flex-shrink-0 flex flex-col" style="background:linear-gradient(180deg,#0f172a 0%,#0b1120 100%);">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-white/[0.06]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#22c55e,#15803d);box-shadow:0 4px 12px rgba(22,163,74,.4)">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-white text-sm leading-tight">Warung Sayur</div>
                    <div class="text-[11px] text-slate-400 font-medium tracking-wide">Admin Panel</div>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest px-3 mb-2">Menu</p>
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',        'label' => 'Dashboard',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                    ['route' => 'admin.products.index',   'label' => 'Produk',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
                    ['route' => 'admin.categories.index', 'label' => 'Kategori',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
                    ['route' => 'admin.orders.index',     'label' => 'Pesanan',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'],
                    ['route' => 'admin.reports.index',    'label' => 'Laporan',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                ];
            @endphp
            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                          {{ $active ? 'nav-active text-white' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0 {{ $active ? 'text-white' : 'text-slate-500' }}"
                         style="width:18px;height:18px"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['label'] }}
                    @if($item['route'] === 'admin.orders.index' && isset($pendingCount) && $pendingCount > 0)
                        <span class="ml-auto bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full badge-pending">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Bottom --}}
        <div class="px-3 py-4 border-t border-white/[0.06] space-y-0.5">
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-slate-400 hover:bg-white/[0.06] hover:text-white transition-all">
                <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Lihat Toko
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all">
                    <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ─── Main Area ───────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-100 px-6 py-0 flex items-center justify-between flex-shrink-0" style="height:60px;">
            <div class="flex items-center gap-2">
                {{-- Breadcrumb-style title --}}
                <span class="text-slate-400 text-sm">Admin</span>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <h1 class="text-sm font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                {{-- Date --}}
                <span class="text-xs text-slate-400 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</span>
                {{-- Divider --}}
                <div class="w-px h-5 bg-slate-200"></div>
                {{-- User --}}
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                         style="background:linear-gradient(135deg,#22c55e,#15803d)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs font-semibold text-slate-700 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="flash-msg flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm mb-0">
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash-msg flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm mb-0">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
