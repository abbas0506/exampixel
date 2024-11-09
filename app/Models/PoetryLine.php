<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoetryLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'line_a',
        'line_b',
        'sr',
    ];
}
