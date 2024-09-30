<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'title',
        'institution',
        'paper_date',
        'is_printed',
    ];

    protected $casts = [
        'paper_date' => 'date',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function paperQuestions()
    {
        return $this->hasMany(PaperQuestion::class);
    }
    public function paperQuestionParts()
    {
        return $this->hasManyThrough(PaperQuestionPart::class, PaperQuestion::class);
    }

    public function marks()
    {
        $marks = 0;
        foreach ($this->paperQuestions as $paperQuestion) {
            if ($paperQuestion->question_type == 1 || $paperQuestion->question_type == 2)
                $marks += $paperQuestion->compulsoryParts() * $paperQuestion->question_type;

            // simple long question
            elseif ($paperQuestion->question_type == 3 || $paperQuestion->question_type == 4)
                $marks += $paperQuestion->paperQuestionParts()->first()->marks;

            // partial question
            elseif ($paperQuestion->question_type > 4)
                $marks += $paperQuestion->paperQuestionParts()->sum('marks');
        }
        return $marks;
    }
}
