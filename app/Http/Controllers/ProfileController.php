<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'    => 'required|string|max:255|min:2',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min'      => 'Nama minimal 2 karakter.',
        ]);

        $phone = $request->phone;
        if ($phone && str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $user->update([
            'name'    => trim($request->name),
            'phone'   => $phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'  => 'required',
            'password'          => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withFragment('password');
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah.')->withFragment('password');
    }
}
