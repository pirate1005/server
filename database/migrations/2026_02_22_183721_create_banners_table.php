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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Nama iklan (untuk pengingat admin)
            $table->string('image_path'); // Lokasi file gambar iklan yang diupload
            $table->string('target_url')->nullable(); // Link tujuan kalau iklan diklik (opsional)
            $table->boolean('is_active')->default(true); // Status iklan aktif atau tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};