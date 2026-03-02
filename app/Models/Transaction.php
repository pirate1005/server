<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'type',        // deposit, withdraw, buy_product, daily_profit, referral_bonus
        'amount',
        'description',
        'status',      // pending, success, failed
        'payment_proof', // Foto bukti transfer (jika ada)
    ];

    /**
     * Ubah format angka desimal agar presisi
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi: Transaksi ini milik User siapa?
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ini di bawah
public function receiver()
{
    return $this->belongsTo(User::class, 'receiver_id');
}
}