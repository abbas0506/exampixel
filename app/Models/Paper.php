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
        'font_size',
        'page_size',
        'page_layout',
        'page_rows',
        'page_cols',
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
}
