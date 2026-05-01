<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . auth()->user()->name . '!');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang kembali, ' . auth()->user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255', 'min:2'],
            'email'    => ['required', 'email:rfc', 'unique:users,email', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:20', 'regex:/^[0-9\-\+\s]+$/'],
            'address'  => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.min'           => 'Nama minimal 2 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid. Gunakan email seperti nama@gmail.com.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'phone.regex'        => 'Format nomor telepon tidak valid.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        // Normalisasi nomor telepon (tambah 62 jika diawali 0)
        $phone = $request->phone;
        if ($phone && str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $user = User::create([
            'name'     => trim($request->name),
            'email'    => strtolower(trim($request->email)),
            'phone'    => $phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . ' 🎉');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda berhasil keluar.');
    }
}
