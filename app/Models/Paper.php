<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\isEmpty;

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
        'chapter_ids', //comma separted list of source chapters
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

    public function chapterIdsArray()
    {
        return explode(',', $this->chapter_ids);
    }

    public function suggestedTime()
    {
        $sumOfMarks = $this->paperQuestions->sum('marks');
        $m = round($sumOfMarks * 1.5, 0);   //1.5 time the total marks
        $hr = intdiv($m, 60);
        if(App::currentLocale() == 'ur'){
            return $hr . "گھنٹہ " . $m % 60 . "منٹ";
        }

        if ($hr > 0)
            return $hr . "h " . $m % 60 . "m";
        else
            return $m . "m";
    }
}
