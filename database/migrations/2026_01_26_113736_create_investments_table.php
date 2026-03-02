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
    Schema::create('investments', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_code')->unique(); // INV-20260126-001
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
        $table->date('start_date'); // Tanggal Mulai
        $table->date('end_date'); // Tanggal Berakhir
        $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
        
        // --- MISI VIDEO HARIAN ---
        $table->string('daily_video_url')->nullable(); // Link Video Tugas
        $table->string('daily_video_key')->nullable(); // Kunci Jawaban Video
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
