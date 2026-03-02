<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama: "Server PVS IBM"
        $table->text('description')->nullable(); // Penjelasan
        $table->string('image')->nullable(); // Foto Server
        
        // --- DATA KEUANGAN ---
        $table->decimal('price', 15, 2); // Harga Modal: 18.682.000
        $table->decimal('daily_income', 15, 2); // Cuan Harian: 793.900
        $table->integer('contract_days'); // Durasi: 40 Hari
        
        // --- DATA BONUS ---
        $table->string('bonus_reward')->nullable(); // Teks: "8 Gram Logam Mulia"
        
        // --- LOGIKA OWNER VS MEMBER ---
        $table->boolean('is_owner_product')->default(false); // Jika TRUE = Beli ini Auto jadi OWNER
        $table->boolean('is_exclusive_for_owner')->default(false); // Jika TRUE = Member biasa gabisa beli
        
        $table->boolean('is_active')->default(true); // Untuk menyembunyikan produk jika habis
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
