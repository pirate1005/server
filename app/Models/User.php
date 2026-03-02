<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // --- TAMBAHAN SESUAI DATABASE ---
        'whatsapp',
        'role',          // admin, member, owner
        'photo_profile',
        'referral_code',
        'referred_by',   // ID upline
        'has_id_card',
        'is_active',
        'bank_name',
    'account_number',
    'account_holder',
    'photo_profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'has_id_card' => 'boolean', // Ubah 0/1 jadi true/false
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Dompet (Setiap User pasti punya 1 Dompet)
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    // Relasi ke Upline (Siapa yang mengajak user ini?)
    public function upline()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    // Relasi ke Downline (Siapa saja yang diajak user ini?)
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }
}
