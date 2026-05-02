@extends('layouts.admin')
@section('title', 'Manajemen Produk')

@section('content')

{{-- ── Header ──────────────────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <p class="text-xs text-slate-400 mt-0.5">{{ $products->total() }} produk terdaftar</p>
    </div>
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm"
       style="box-shadow:0 4px 12px rgba(22,163,74,.3)">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
</div>

{{-- ── Table ────────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 flex items-center justify-center">
                                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="font-semibold text-slate-700 text-sm">{{ $product->product_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-600">
                                {{ $product->category->category_name }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="font-semibold text-slate-800 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-slate-400">/{{ $product->unit }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            @php
                                $stockClass = $product->stock > 10
                                    ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                    : ($product->stock > 0
                                        ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200'
                                        : 'bg-red-50 text-red-600 ring-1 ring-red-200');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $stockClass }}">
                                {{ $product->stock }} {{ $product->unit }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-500 bg-red-50 hover:bg-red-100 transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <p class="text-sm text-slate-400">Belum ada produk</p>
                                <a href="{{ route('admin.products.create') }}" class="text-xs text-primary-600 hover:underline font-medium">Tambah produk pertama</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
