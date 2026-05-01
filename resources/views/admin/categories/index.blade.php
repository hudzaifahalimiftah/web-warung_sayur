@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Add Category --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-800 mb-4">Tambah Kategori Baru</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="flex gap-3">
                <input type="text" name="category_name" value="{{ old('category_name') }}" required
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 @error('category_name') border-red-400 @enderror"
                       placeholder="Nama kategori baru">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm transition-colors">
                    Tambah
                </button>
            </div>
            @error('category_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </form>
    </div>

    {{-- Category List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Daftar Kategori ({{ $categories->count() }})</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($categories as $category)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $category->category_name }}</p>
                        <p class="text-xs text-gray-400">{{ $category->products_count }} produk</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Edit inline --}}
                        <button onclick="document.getElementById('edit-{{ $category->id }}').classList.toggle('hidden')"
                                class="text-blue-500 hover:text-blue-700 text-xs font-medium">Edit</button>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori ini? Semua produk di kategori ini juga akan terhapus.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                        </form>
                    </div>
                </div>
                <div id="edit-{{ $category->id }}" class="hidden px-6 pb-4">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="category_name" value="{{ $category->category_name }}" required
                               class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
                        <button type="submit" class="bg-primary-600 text-white px-3 py-2 rounded-xl text-sm">Simpan</button>
                    </form>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-gray-400 text-sm">Belum ada kategori.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
