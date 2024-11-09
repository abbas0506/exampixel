<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Subset;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',          //one two three
        'grade_no',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function chapters()
    {
        return $this->hasManyThrough(Chapter::class, Book::class);
    }

    public function questions()
    {

        $chapterIds = $this->chapters()->pluck('chapters.id');
        $questions = Question::whereIn('chapter_id', $chapterIds);
        return $questions;
    }

    // public function questions()
    // {
    //     return $this->whereRelation('books.chapters.questions', 'id');
    // }
}
