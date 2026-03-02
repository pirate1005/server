<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'investment_id',
        'date',             // Tanggal jatah profit (misal: 2026-01-27)
        'is_claimed',       // true/false
        'claimed_at',
        'date',       // Jam berapa user input kode
        'amount',           // Jumlah uang yang didapat hari itu
        'status',           // pending, success, expired
    ];

    /**
     * Konversi tipe data otomatis
     */
    protected $casts = [
        'date' => 'date',
        'claimed_at' => 'datetime',
        'is_claimed' => 'boolean',
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi: Klaim ini milik Investasi (Sewa Server) yang mana?
     */
    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }
}