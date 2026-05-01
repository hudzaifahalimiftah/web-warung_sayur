<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        // Foto dari Unsplash — URL langsung, tidak perlu download
        $data = [
            [
                'name' => 'Sayuran Hijau',
                'products' => [
                    [
                        'name'  => 'Bayam Segar',
                        'price' => 5000, 'unit' => 'ikat', 'stock' => 50,
                        'desc'  => 'Bayam segar pilihan, kaya zat besi dan vitamin A. Cocok untuk tumis, sup, atau lalapan.',
                        'image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&q=80',
                    ],
                    [
                        'name'  => 'Kangkung',
                        'price' => 4000, 'unit' => 'ikat', 'stock' => 60,
                        'desc'  => 'Kangkung segar, cocok untuk tumis dengan bumbu bawang dan cabai.',
                        'image' => 'https://images.unsplash.com/photo-1622206151226-18ca2c9ab4a1?w=400&q=80',
                    ],
                    [
                        'name'  => 'Sawi Hijau',
                        'price' => 6000, 'unit' => 'ikat', 'stock' => 40,
                        'desc'  => 'Sawi hijau segar, renyah dan lezat. Cocok untuk tumis dan sup.',
                        'image' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&q=80',
                    ],
                    [
                        'name'  => 'Selada',
                        'price' => 8000, 'unit' => 'ikat', 'stock' => 30,
                        'desc'  => 'Selada segar dan renyah, sempurna untuk salad, burger, atau lalapan.',
                        'image' => 'https://images.unsplash.com/photo-1622205313162-be1d5712a43f?w=400&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Umbi & Akar',
                'products' => [
                    [
                        'name'  => 'Wortel',
                        'price' => 12000, 'unit' => 'kg', 'stock' => 80,
                        'desc'  => 'Wortel segar, manis dan renyah. Kaya beta-karoten dan vitamin A.',
                        'image' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&q=80',
                    ],
                    [
                        'name'  => 'Kentang',
                        'price' => 15000, 'unit' => 'kg', 'stock' => 100,
                        'desc'  => 'Kentang lokal berkualitas tinggi, cocok untuk berbagai masakan.',
                        'image' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=400&q=80',
                    ],
                    [
                        'name'  => 'Singkong',
                        'price' => 8000, 'unit' => 'kg', 'stock' => 70,
                        'desc'  => 'Singkong segar, cocok untuk direbus, digoreng, atau dibuat kue.',
                        'image' => 'https://images.unsplash.com/photo-1594282486552-05b4d80fbb9f?w=400&q=80',
                    ],
                    [
                        'name'  => 'Ubi Jalar',
                        'price' => 10000, 'unit' => 'kg', 'stock' => 60,
                        'desc'  => 'Ubi jalar manis, kaya serat dan antioksidan. Cocok untuk kolak atau digoreng.',
                        'image' => 'https://images.unsplash.com/photo-1596097635121-14b63b7a0c19?w=400&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Buah Sayur',
                'products' => [
                    [
                        'name'  => 'Tomat',
                        'price' => 10000, 'unit' => 'kg', 'stock' => 90,
                        'desc'  => 'Tomat merah segar, kaya vitamin C dan likopen. Cocok untuk sambal dan masakan.',
                        'image' => 'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?w=400&q=80',
                    ],
                    [
                        'name'  => 'Cabai Merah',
                        'price' => 35000, 'unit' => 'kg', 'stock' => 40,
                        'desc'  => 'Cabai merah segar, pedas berkualitas untuk sambal dan masakan Indonesia.',
                        'image' => 'https://images.unsplash.com/photo-1583119022894-919a68a3d0e3?w=400&q=80',
                    ],
                    [
                        'name'  => 'Terong Ungu',
                        'price' => 8000, 'unit' => 'kg', 'stock' => 55,
                        'desc'  => 'Terong ungu segar, cocok untuk balado, tumis, atau dipanggang.',
                        'image' => 'https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=400&q=80',
                    ],
                    [
                        'name'  => 'Timun',
                        'price' => 6000, 'unit' => 'kg', 'stock' => 75,
                        'desc'  => 'Timun segar dan renyah, cocok untuk lalapan, acar, atau jus.',
                        'image' => 'https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=400&q=80',
                    ],
                ],
            ],
            [
                'name' => 'Bumbu Dapur',
                'products' => [
                    [
                        'name'  => 'Bawang Merah',
                        'price' => 28000, 'unit' => 'kg', 'stock' => 100,
                        'desc'  => 'Bawang merah segar, harum dan berkualitas. Bumbu wajib masakan Indonesia.',
                        'image' => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=400&q=80',
                    ],
                    [
                        'name'  => 'Bawang Putih',
                        'price' => 32000, 'unit' => 'kg', 'stock' => 80,
                        'desc'  => 'Bawang putih segar, aroma kuat dan khas. Kaya manfaat untuk kesehatan.',
                        'image' => 'https://images.unsplash.com/photo-1540148426945-6cf22a6b2383?w=400&q=80',
                    ],
                    [
                        'name'  => 'Jahe',
                        'price' => 20000, 'unit' => 'kg', 'stock' => 60,
                        'desc'  => 'Jahe segar, hangat dan menyehatkan. Cocok untuk minuman dan masakan.',
                        'image' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400&q=80',
                    ],
                    [
                        'name'  => 'Kunyit',
                        'price' => 15000, 'unit' => 'kg', 'stock' => 50,
                        'desc'  => 'Kunyit segar, kaya antioksidan dan anti-inflamasi. Warna alami masakan.',
                        'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&q=80',
                    ],
                ],
            ],
        ];

        foreach ($data as $cat) {
            $category = Category::create([
                'category_name' => $cat['name'],
                'slug'          => Str::slug($cat['name']),
            ]);

            foreach ($cat['products'] as $p) {
                Product::create([
                    'category_id'  => $category->id,
                    'product_name' => $p['name'],
                    'description'  => $p['desc'],
                    'price'        => $p['price'],
                    'unit'         => $p['unit'],
                    'stock'        => $p['stock'],
                    'image'        => $p['image'], // URL Unsplash langsung
                ]);
            }
        }
    }
}
