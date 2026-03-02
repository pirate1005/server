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
    Schema::table('users', function (Blueprint $table) {
        $table->string('bank_name')->nullable()->after('password');     // Nama Bank (BCA, DANA, dll)
        $table->string('account_number')->nullable()->after('bank_name'); // No Rekening
        $table->string('account_holder')->nullable()->after('account_number'); // Atas Nama
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['bank_name', 'account_number', 'account_holder']);
    });
}
};
