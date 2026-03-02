<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Server Basic (Pancingan untuk Member Baru)
        Product::create([
            'name' => 'Server Basic Starter',
            'description' => 'Server pemula untuk belajar investasi aset digital.',
            'image' => 'https://cdn-icons-png.flaticon.com/512/2620/2620563.png', 
            'price' => 500000,
            'daily_income' => 25000,
            'contract_days' => 30,
            'bonus_reward' => null,
            'is_owner_product' => false,
            'is_exclusive_for_owner' => false,
        ]);

        // 2. SERVER PVS IBM (PRODUK UTAMA - Auto Owner)
        Product::create([
            'name' => 'Server PVS IBM (Gold Edition)',
            'description' => 'Server High-End IBM. Sewa ini otomatis menjadi OWNER.',
            'image' => 'https://cdn-icons-png.flaticon.com/512/9676/9676678.png',
            'price' => 18682000,
            'daily_income' => 793900,
            'contract_days' => 40,
            'bonus_reward' => '8 Gram Logam Mulia',
            'is_owner_product' => true, // <-- PENTING: Beli ini jadi Owner
            'is_exclusive_for_owner' => false,
        ]);

        // 3. Server Sultan (Hanya bisa dilihat/dibeli Owner)
        Product::create([
            'name' => 'Server Platinum Owner',
            'description' => 'Server khusus para Owner. Profit maksimal.',
            'image' => 'https://cdn-icons-png.flaticon.com/512/3208/3208726.png',
            'price' => 50000000,
            'daily_income' => 2500000,
            'contract_days' => 60,
            'bonus_reward' => 'Macbook Pro M3',
            'is_owner_product' => false,
            'is_exclusive_for_owner' => true, // <-- PENTING: Dikunci untuk Member biasa
        ]);
    }
}