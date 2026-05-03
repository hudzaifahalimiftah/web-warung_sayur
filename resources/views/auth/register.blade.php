@extends('layouts.app')
@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-1">
                <div class="flex items-center gap-1">
                    <span class="text-3xl font-extrabold text-green-700 tracking-tight">Warung</span>
                    <span class="text-3xl font-extrabold text-green-500 tracking-tight">Sayur</span>
                </div>
                <div class="text-xs text-gray-400 font-medium">Segar & Terpercaya</div>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-5">
                <h1 class="text-xl font-bold text-white">Buat Akun Baru</h1>
                <p class="text-green-100 text-sm mt-0.5">Bergabung dan mulai belanja sayur segar</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-4">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="w-full px-4 py-3 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all
                                          {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}"
                                   placeholder="Nama lengkap Anda">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all
                                          {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}"
                                   placeholder="contoh@gmail.com">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. WhatsApp</label>
                            <div class="flex gap-2">
                                <span class="flex items-center px-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 font-medium">+62</span>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="flex-1 px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all"
                                       placeholder="812-3456-7890">
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Digunakan untuk konfirmasi pesanan via WhatsApp</p>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Pengiriman</label>
                            <textarea name="address" rows="2"
                                      class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all resize-none"
                                      placeholder="Jl. Contoh No. 1, Kota...">{{ old('address') }}</textarea>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="w-full px-4 pr-12 py-3 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all
                                              {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}"
                                       placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePass('password')"
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full px-4 pr-12 py-3 border border-gray-200 bg-gray-50 focus:bg-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all"
                                       placeholder="Ulangi password">
                                <button type="button" onclick="togglePass('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 text-sm mt-2">
                            Buat Akun Sekarang 🚀
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 mt-5">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePass(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
@endsection
