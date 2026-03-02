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
    Schema::create('daily_claims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('investment_id')->constrained()->onDelete('cascade');
        $table->date('date'); // Tanggal jatah profit (misal: 26 Jan)
        
        $table->boolean('is_claimed')->default(false); // Sudah diklaim/input kode?
        $table->dateTime('claimed_at')->nullable(); // Jam berapa klaimnya
        
        $table->decimal('amount', 15, 2); // Jumlah uang yang didapat
        
        $table->enum('status', ['pending', 'success', 'expired'])->default('pending');
        // Pending = Belum dikerjakan
        // Success = Berhasil input kode
        // Expired = Telat (Uang Hangus)
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_claims');
    }
};
