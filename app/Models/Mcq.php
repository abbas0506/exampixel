<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
