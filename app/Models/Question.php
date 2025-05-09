<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', //owner id
        'chapter_id',
        'type_id',

        'statement',
        'exercise_no',
        'frequency',
        'is_conceptual',
        'approver_id',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function mcq()
    {
        return $this->hasOne(Mcq::class);
    }
    public function comprehensions()
    {
        return $this->hasMany(Comprehension::class);
    }
    public function poetryLines()
    {
        return $this->hasMany(PoetryLine::class);
    }
    public function scopeToday($query)
    {
        return $query->whereDate('questions.created_at', today());
    }
    public function scopeMcqs($query)
    {
        return $query->where('type_id', 1);
    }
    public function scopeShorts($query)
    {
        return $query->where('type_id', 2);
    }
    public function scopeLongs($query)
    {
        return $query->where('type_id', 3);
    }
    public function scopeObjective($query)
    {
        return $query->where('type_id', 1);
    }
    public function scopeSubjective($query)
    {
        return $query->whereBetween('type_id', [2, 3]);
    }
    public function scopeChapter($query, $sr)
    {
        return $query->where('sr', $sr);
    }
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approver_id');
    }
    public function scopeNotApproved($query)
    {
        return $query->whereNull('approver_id');
    }
    public function similarQuestions()
    {
        $statement = Str::lower($this->statement);
        $punctuationMarks = ['.', ',', '?', ':',];

        //too short automatically skippped words
        // 'who', 'how','is', 'am', 'are', 'was', 'can', 'of', 'the','has',  'had',
        // 'in', 'out', 'on', 'at', 'as', 'any', 'one', 'two', 'or''i', 'we', 'our', 'us', 'you', 
        // 'he', 'she', 'it', 'its', 'his', 'him', 'her', 

        $wordsToRemove = [
            'define',
            'explain',
            'describe',
            'write',
            'down',
            'what',
            'which',
            'where',
            'whose',
            'when',
            'were',
            'shall',
            'will',
            'would',
            'should',
            'could',
            'might',
            'here',
            'there',
            'have',
            'this',
            'that',
            'such',
            'with',
            'three',
            'four',
            'five',
            'seven',
            'eight',
            'nine',
            'your',
            'they',
            'their',
            'them',
            'differentiate',
            'between',
            'find'

        ];

        // remove puncutation marks
        foreach ($punctuationMarks as $punctuationMark) {
            $statement = Str::replace($punctuationMark, '', $statement);
        }
        // Optionally, trim extra spaces after removing words
        $statement = trim($statement);

        // skip  too short words, pick atleast 4 chracters word
        preg_match_all("/\b\w{4,}\b/", $statement, $wordsArray);

        $wordsArray = $wordsArray[0];

        // remove duplicated words
        $wordsArray = array_unique($wordsArray);

        // Remove specific words from the array
        $shortListedWordsArray = array_diff($wordsArray, $wordsToRemove);

        // reset the index values of array
        $shortListedWordsArray = array_values($shortListedWordsArray);

        if (count($shortListedWordsArray)) {
            $similarQuestions = Question::whereNot('id', $this->id)
                ->where('type_id', $this->type_id)
                ->where('statement', 'like', '%' . $shortListedWordsArray[0] . '%')
                ->whereRelation('chapter', function ($query) {
                    $query->where('book_id', $this->chapter->book_id)
                        ->whereRelation('book', function ($query) {
                            $query->where('subject_id', $this->chapter->book->subject_id);
                        });
                });

            if (count($shortListedWordsArray) > 1) {
                $similarQuestions = $similarQuestions->where('statement', 'like', '%' . $shortListedWordsArray[1] . '%');
            }
            // if (count($shortListedWordsArray) > 2) {
            //     $similarQuestions = $similarQuestions->where('statement', 'like', '%' . $shortListedWordsArray[2] . '%');
            // }

            return  $similarQuestions->get();
        }
    }
}
