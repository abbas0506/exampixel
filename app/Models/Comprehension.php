<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprehension extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'sub_question',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
