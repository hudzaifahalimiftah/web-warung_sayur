@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- ── Add Category (left, narrower) ──────────────────────────── --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800 text-sm">Tambah Kategori</h2>
                <p class="text-xs text-slate-400 mt-0.5">Buat kategori produk baru</p>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">Nama Kategori</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}" required
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('category_name') border-red-400 ring-2 ring-red-100 @enderror"
                                   placeholder="Contoh: Sayuran Hijau">
                            @error('category_name')
                                <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors"
                                style="box-shadow:0 4px 12px rgba(22,163,74,.25)">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Category List (right, wider) ────────────────────────────── --}}
    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-slate-800 text-sm">Daftar Kategori</h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $categories->count() }} kategori tersedia</p>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                    {{ $categories->count() }} total
                </span>
            </div>

            <div class="divide-y divide-slate-50">
                @forelse($categories as $category)
                    <div class="group">
                        {{-- Row --}}
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/70 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-700 text-sm">{{ $category->category_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $category->products_count }} produk</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="toggleEdit({{ $category->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori ini? Semua produk di kategori ini juga akan terhapus.')">
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
                        </div>

                        {{-- Inline Edit --}}
                        <div id="edit-{{ $category->id }}" class="hidden px-6 pb-4">
                            <form method="POST" action="{{ route('admin.categories.update', $category) }}"
                                  class="flex gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                @csrf @method('PUT')
                                <input type="text" name="category_name" value="{{ $category->category_name }}" required
                                       class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                                <button type="submit"
                                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Simpan
                                </button>
                                <button type="button" onclick="toggleEdit({{ $category->id }})"
                                        class="border border-slate-200 text-slate-500 hover:bg-slate-100 px-3 py-2 rounded-lg text-sm transition-colors">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <p class="text-sm text-slate-400">Belum ada kategori</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function toggleEdit(id) {
    const el = document.getElementById('edit-' + id);
    el.classList.toggle('hidden');
    if (!el.classList.contains('hidden')) {
        el.querySelector('input').focus();
    }
}
</script>
@endpush

@endsection
