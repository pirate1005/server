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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Jenis transaksi
        $table->enum('type', [
            'deposit',          // Topup Saldo
            'withdraw',         // Tarik Uang
            'buy_product',      // Beli Server
            'daily_profit',     // Hasil Nonton Video
            'referral_bonus'    // Komisi ajak teman
        ]);
        
        $table->decimal('amount', 15, 2); // Jumlah uang
        $table->string('description')->nullable(); // Keterangan tambahan
        $table->enum('status', ['pending', 'success', 'failed'])->default('success');
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
