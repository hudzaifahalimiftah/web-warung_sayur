<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature   = 'admin:create';
    protected $description = 'Buat akun admin pertama untuk Warung Sayur';

    public function handle(): void
    {
        $this->info('');
        $this->info('  🥬  Setup Admin Warung Sayur');
        $this->info('  ─────────────────────────────');

        $name = $this->ask('Nama Admin');
        $email = $this->ask('Email Admin (contoh: admin@gmail.com)');

        // Validasi email
        $validator = Validator::make(['email' => $email], ['email' => 'required|email|unique:users,email']);
        if ($validator->fails()) {
            $this->error('  ✗ ' . $validator->errors()->first('email'));
            return;
        }

        $password = $this->secret('Password (min. 8 karakter)');
        if (strlen($password) < 8) {
            $this->error('  ✗ Password minimal 8 karakter.');
            return;
        }

        $phone = $this->ask('No. WhatsApp (opsional, tekan Enter untuk skip)', '');

        $user = User::create([
            'name'     => $name,
            'email'    => strtolower(trim($email)),
            'password' => Hash::make($password),
            'phone'    => $phone ?: null,
            'role'     => 'admin',
        ]);

        $this->info('');
        $this->info("  ✅  Admin berhasil dibuat!");
        $this->table(
            ['Field', 'Value'],
            [
                ['Nama',  $user->name],
                ['Email', $user->email],
                ['Role',  $user->role],
            ]
        );
        $this->info('  Sekarang login di: /login');
        $this->info('');
    }
}
