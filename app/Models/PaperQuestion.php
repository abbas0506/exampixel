<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_id',
        'question_type',
        'question_title',
        'frequency',
        'choices',
        'number_style',
        'display_cols',
        'sr',

    ];

    public function  paper()
    {
        return $this->belongsTo(Paper::class);
    }
    public function  type()
    {
        return $this->belongsTo(Type::class);
    }

    public function  paperQuestionParts()
    {
        return $this->hasMany(PaperQuestionPart::class);
    }
    public function scopeMcqs($query)
    {
        return $query->where('question_type', 1);
    }
    public function scopeShorts($query)
    {
        return $query->where('question_type', 2);
    }
    public function scopeLongs($query)
    {
        return $query->where('question_type', '>=', 3);
    }

    public function compulsoryParts()
    {
        if ($this->question_type == 1 || $this->question_type == 2) //mcqs , short
            return $this->paperQuestionParts->count() - $this->choices;
        else return 0;
    }
}
