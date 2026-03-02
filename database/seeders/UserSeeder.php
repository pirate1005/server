<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. AKUN ADMIN (Untuk Login ke Dashboard Admin)
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@cloudmax.com',
            'whatsapp' => '081234567890',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
            'referral_code' => 'ADMIN01',
            'has_id_card' => false,
        ]);
        // Buat Dompet Admin (Opsional, biar gak error)
        Wallet::create(['user_id' => $admin->id, 'balance' => 0]);


        // 2. AKUN OWNER (Contoh User yang sudah beli Server IBM)
        $owner = User::create([
            'name' => 'Sultan Owner',
            'email' => 'owner@cloudmax.com',
            'whatsapp' => '08987654321',
            'password' => Hash::make('password'),
            'role' => 'owner', // Status sudah Owner
            'referral_code' => 'SULTAN99',
            'has_id_card' => true, // Sudah punya ID Card
        ]);
        // Owner biasanya punya saldo banyak
        Wallet::create(['user_id' => $owner->id, 'balance' => 50000000]);


        // 3. AKUN MEMBER (User Biasa/Baru Daftar)
        $member = User::create([
            'name' => 'Member Baru',
            'email' => 'member@cloudmax.com',
            'whatsapp' => '08555555555',
            'password' => Hash::make('password'),
            'role' => 'member', // Status masih Member
            'referral_code' => 'MEMB001',
            'has_id_card' => false,
        ]);
        // Member baru saldo 0
        Wallet::create(['user_id' => $member->id, 'balance' => 0]);
    }
}