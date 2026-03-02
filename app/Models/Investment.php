<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'status',          // active, completed, cancelled
        'daily_video_url', // Link video misi harian (jika ada)
        'daily_video_key', // Kunci jawaban misi
    ];

    /**
     * Ubah tipe data tanggal agar bisa dibaca Carbon (manipulasi tanggal)
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi: Investasi ini milik User siapa?
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Investasi ini menyewa Produk (Server) apa?
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi: Investasi ini punya banyak klaim harian (Log Absen)
     * (Model DailyClaim akan kita buat nanti jika belum ada)
     */
    public function dailyClaims(): HasMany
    {
        return $this->hasMany(DailyClaim::class);
    }
}