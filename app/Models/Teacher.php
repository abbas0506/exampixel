<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
        'institution',
        'logo',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subjectRelatedQuestions()
    {
        // return Question::whereRelation('chapter', function ($query) {
        //     $query->whereRelation('book', function ($query) {
        //         $query->where('subject_id', $this->id);
        //     });
        // });
    }
}
