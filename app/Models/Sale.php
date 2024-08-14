<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coins',
        'price',
        'expiry_at',
        'remarks',
        'is_verified',
    ];

    protected $casts = [
        'expiry_at' => 'date',

    ];
}
