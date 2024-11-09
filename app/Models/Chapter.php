<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'title', //title
        'sr',

        'tag_id',

    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function  scopeFilterByTag($query, $tagId)
    {
        return $query->where('tag_id', $tagId);
    }
}
