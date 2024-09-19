<?php

namespace Database\Seeders;

use App\Models\Subtype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //English subtypes: MCQ subtypes
        Subtype::create(['name' => 'Correct form of verb', 'position' => 1,]);
        Subtype::create(['name' => 'Correct spelling', 'position' => 1,]);
        Subtype::create(['name' => 'Meaning of words', 'position' => 1,]);
        Subtype::create(['name' => 'Correct grammar', 'position' => 1,]);
        Subtype::create(['name' => 'Correction of Proposition', 'position' => 1,]);
        Subtype::create(['name' => 'Correction of sentence', 'position' => 1,]);

        // long subtypes 
        Subtype::create(['name' => 'English to Urdu (Para)', 'position' => 1,]);
        Subtype::create(['name' => 'Urdu to English (Para)', 'position' => 1,]);
        Subtype::create(['name' => 'Summary of Poem', 'position' => 1,]);
        Subtype::create(['name' => 'Paraphrasing of poetry', 'tagname' => 'paraphrasing', 'position' => 1,]);
        Subtype::create(['name' => 'Comprehension', 'tagname' => 'comprehension', 'position' => 1,]);
        Subtype::create(['name' => 'Letter', 'position' => 1,]);
        Subtype::create(['name' => 'Story', 'position' => 1,]);
        Subtype::create(['name' => 'Dialogue', 'position' => 1,]);
        Subtype::create([
            'name' => 'Essay',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);
        Subtype::create([
            'name' => 'Paragraph writing',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);
        Subtype::create([
            'name' => 'Idioms/Phrases',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);
        Subtype::create([
            'name' => 'Active/Passive',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);
        Subtype::create([
            'name' => 'Direct/indirect',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);
        Subtype::create([
            'name' =>
            'Pair of words',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);
        Subtype::create([
            'name' => 'Urdu sentences to english',
            'position' => 1,
            'question_nature' => 'horizontal'
        ]);

        Subtype::create(['name' => 'Synonyms/Antonyms', 'position' => 1,]);
        Subtype::create(['name' => 'Application', 'position' => 1,]);
        Subtype::create(['name' => 'Punctuation', 'position' => 1,]);
        Subtype::create(['name' => 'Pargaraph explanation', 'position' => 1,]);



        // urdu subtypes
        Subtype::create(['name' => ' نصابی کثیرالانتخاب ', 'position' => 1,]);
        Subtype::create(['name' => 'تشبیہ', 'position' => 1,]);
        Subtype::create(['name' => 'استعارہ', 'position' => 1,]);
        Subtype::create(['name' => 'تلمیح', 'position' => 1,]);
        Subtype::create(['name' => 'مطلع', 'position' => 1,]);
        Subtype::create(['name' => 'قافیہ', 'position' => 1,]);
        Subtype::create(['name' => 'ردیف', 'position' => 1,]);
        Subtype::create(['name' => 'تذکیرو تانیث', 'position' => 1,]);
        Subtype::create(['name' => 'امدادی فعل', 'position' => 1,]);
        Subtype::create(['name' => 'رموزاوقاف', 'position' => 1,]);
        Subtype::create(['name' => 'جملہ کی درستی', 'position' => 1,]);

        Subtype::create(['name' => 'اشعار کی تشریح:نظم', 'position' => 1,]);
        Subtype::create(['name' => 'اشعار کی تشریح:غزل', 'position' => 1,]);
        Subtype::create(['name' => 'سبقی پیرا گراف کی تشریح', 'position' => 1,]);
        Subtype::create(['name' => 'سبق کا خلاصہ', 'position' => 1,]);
        Subtype::create(['name' => 'نظم کا خلاصہ', 'position' => 1,]);
        Subtype::create(['name' => 'روداد', 'position' => 1,]);
        Subtype::create(['name' => 'روزنامچہ', 'position' => 1,]);
        Subtype::create(['name' => 'مکالمہ نگاری', 'position' => 1,]);
        Subtype::create(['name' => 'خط', 'position' => 1,]);
        Subtype::create(['name' => 'درخواست', 'position' => 1,]);
        Subtype::create(['name' => 'آپ بیتی', 'position' => 1,]);
        Subtype::create(['name' => 'مضمون', 'position' => 1,]);
    }
}
