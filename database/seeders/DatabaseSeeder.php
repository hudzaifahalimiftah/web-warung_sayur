<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@warungs ayur.com'],
            [
                'name'     => 'Admin Warung Sayur',
                'password' => Hash::make('admin123'),
                'phone'    => '081234567890',
                'address'  => 'Jl. Sayur Segar No. 1, Jakarta',
                'role'     => 'admin',
            ]
        );

        // Demo user
        User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'phone'    => '082345678901',
                'address'  => 'Jl. Melati No. 5, Bandung',
                'role'     => 'user',
            ]
        );

        $this->call(CategoryProductSeeder::class);
    }
}
