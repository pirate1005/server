<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];

    /**
     * Konversi tipe data saldo agar akurat.
     */
    protected $casts = [
        'balance' => 'decimal:2',
    ];

    /**
     * Relasi: Dompet ini milik User siapa?
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}