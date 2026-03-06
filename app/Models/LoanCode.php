<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCode extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'loan_codes';

    // Mengizinkan mass assignment untuk kolom-kolom ini
    protected $fillable = [
        'code',
        'limit_amount',
        'is_used',
        'used_by',
        'used_at',
    ];

    // Memastikan tipe data saat diambil dari database
    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    // (Opsional) Relasi untuk mengetahui siapa user yang memakai kode ini
    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}