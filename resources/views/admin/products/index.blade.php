@extends('layouts.admin')
@section('title', 'Manajemen Produk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $products->total() }} produk terdaftar</p>
    <a href="{{ route('admin.products.create') }}"
       class="bg-primary-600 hover:bg-primary-700 text-white font-medium px-4 py-2 rounded-xl text-sm transition-colors">
        + Tambah Produk
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Produk</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Stok</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <span>🥬</span>
                                    @endif
                                </div>
                                <span class="font-medium text-gray-800">{{ $product->product_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $product->category->category_name }}</td>
                        <td class="px-6 py-4 font-semibold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}/{{ $product->unit }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $product->stock }} {{ $product->unit }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-blue-600 hover:underline text-xs font-medium">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
</div>
@endsection
