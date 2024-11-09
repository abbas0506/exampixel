<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ur',
        'display_order',
        'thumbnail',
        'text_direction',
    ];

    public function subtypes()
    {
        // if subject english:6, or urdu:7, return subject related subtypes
        // else return general subtypes
        return Subtype::all();
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function questions() {}
}
