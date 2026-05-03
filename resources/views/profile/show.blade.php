@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-sm text-gray-400">Kelola informasi akun dan alamat pengiriman</p>
        </div>
    </div>

    {{-- Info Akun --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center text-white text-2xl font-extrabold flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-gray-800 text-lg">{{ $user->name }}</p>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold
                    {{ $user->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                    {{ $user->isAdmin() ? 'Admin' : 'Pelanggan' }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition
                                  {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. WhatsApp</label>
                    <div class="flex gap-2">
                        <span class="flex items-center px-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 font-medium flex-shrink-0">+62</span>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ? ltrim($user->phone, '62') : '') }}"
                               class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                               placeholder="812-3456-7890">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Digunakan untuk konfirmasi pesanan via WhatsApp.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Pengiriman Default</label>
                    <textarea name="address" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none"
                              placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota...">{{ old('address', $user->address) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Akan otomatis terisi saat checkout.</p>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2.5 rounded-xl transition-all shadow-sm hover:shadow-md text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Ganti Password --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" id="password">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Ganti Password
        </h2>

        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Lama <span class="text-red-500">*</span></label>
                    <input type="password" name="current_password" required
                           class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition
                                  {{ $errors->has('current_password') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                           placeholder="Password saat ini">
                    @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                           placeholder="Minimal 8 karakter, huruf & angka">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                           placeholder="Ulangi password baru">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-6 py-2.5 rounded-xl transition-all shadow-sm text-sm">
                        Ganti Password
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
