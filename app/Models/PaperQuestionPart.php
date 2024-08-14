<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperQuestionPart extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_question_id',
        'question_id',
    ];

    public function paperQuestion()
    {
        return $this->belongsTo(PaperQuestion::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
