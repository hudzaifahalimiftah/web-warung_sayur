@extends('layouts.admin')
@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl">

    {{-- Back --}}
    <a href="{{ route('admin.products.index') }}"
       class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-400 hover:text-slate-600 mb-5 transition-colors">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Produk
    </a>

    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800 text-sm">Informasi Produk Baru</h2>
            <p class="text-xs text-slate-400 mt-0.5">Isi semua field yang diperlukan</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.products._form')
                <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors"
                            style="box-shadow:0 4px 12px rgba(22,163,74,.3)">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="inline-flex items-center gap-2 border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium px-5 py-2.5 rounded-xl text-sm transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
