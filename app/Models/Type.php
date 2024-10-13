<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sr',
        'display_style',
        'default_title',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
