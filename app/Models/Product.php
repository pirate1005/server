<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'daily_income',
        'contract_days',
        'bonus_reward',
        'is_owner_product',
        'is_exclusive_for_owner',
        'is_active',
    ];

    // Mengubah tipe data otomatis (Casting)
    protected $casts = [
        'price' => 'decimal:2',
        'daily_income' => 'decimal:2',
        'is_owner_product' => 'boolean',
        'is_exclusive_for_owner' => 'boolean',
        'is_active' => 'boolean',
    ];
}