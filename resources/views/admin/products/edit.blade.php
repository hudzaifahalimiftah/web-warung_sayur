@extends('layouts.admin')
@section('title', 'Edit Produk')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-400 hover:text-gray-600 mb-6 inline-block">← Kembali</a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.products._form')
            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium px-6 py-2.5 rounded-xl transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
