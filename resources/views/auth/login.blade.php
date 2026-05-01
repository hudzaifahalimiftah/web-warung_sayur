@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
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
                <h1 class="text-xl font-bold text-white">Selamat Datang Kembali 👋</h1>
                <p class="text-green-100 text-sm mt-0.5">Masuk untuk melanjutkan belanja</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="space-y-5">

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all
                                              {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}"
                                       placeholder="contoh@gmail.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password" required
                                       class="w-full pl-10 pr-12 py-3 border border-gray-200 bg-gray-50 focus:bg-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all"
                                       placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember --}}
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                                <input type="checkbox" name="remember"
                                       class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-400">
                                <span>Ingat saya</span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 text-sm">
                            Masuk ke Akun
                        </button>
                    </div>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs text-gray-400 bg-white px-3">
                        Belum punya akun?
                    </div>
                </div>

                <a href="{{ route('register') }}"
                   class="block w-full text-center border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-bold py-3 rounded-xl transition-all text-sm">
                    Daftar Sekarang — Gratis!
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            Dengan masuk, kamu menyetujui syarat & ketentuan Warung Sayur.
        </p>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
@endsection
