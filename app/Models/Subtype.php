<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'tagname',
        'question_nature',
    ];
    public function subtype_mappings()
    {
        return $this->hasMany(SubtypeMapping::class);
    }
}
