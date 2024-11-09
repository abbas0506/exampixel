<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Type::create(['sr' => 1, 'name' => 'MCQs', 'display_style' => 'mcq', 'default_title' => 'Choose the correct option']);
        Type::create(['sr' => 2, 'name' => 'Short', 'display_style' => 'partial', 'default_title' => 'Answer the following short questions']);
        Type::create(['sr' => 3, 'name' => 'Long', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 4, 'name' => 'Examples', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 5, 'name' => 'Theorems', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 6, 'name' => 'Numericals', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 7, 'name' => 'Programs', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 8, 'name' => 'Translation into Urdu', 'display_style' => 'simple', 'default_title' => 'Translate the following paragraph into Urdu']);
        Type::create(['sr' => 9, 'name' => 'Translation into English', 'display_style' => 'simple', 'default_title' => 'Translate the following paragraph into English']);
        Type::create(['sr' => 10, 'name' => 'Punctuation', 'display_style' => 'simple', 'default_title' => 'Punctuate the following']);
        Type::create(['sr' => 11, 'name' => 'Stanza', 'display_style' => 'stanza', 'default_title' => 'Explain the following with reference to context']);
        Type::create(['sr' => 12, 'name' => 'Letter', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 13, 'name' => 'Application', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 14, 'name' => 'Story', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 15, 'name' => 'Pair of Words', 'display_style' => 'partial-x', 'default_title' => "Use following pairs of words into sentences"]);
        Type::create(['sr' => 16, 'name' => 'Essays', 'display_style' => 'partial-x', 'default_title' => "Write an essay on any of the following"]);
        Type::create(['sr' => 17, 'name' => 'Idioms/Phrases', 'display_style' => 'partial-x', 'default_title' => "Use following idioms/phrases into your own sentences"]);
        Type::create(['sr' => 18, 'name' => 'Summary', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 19, 'name' => 'Comprehension', 'display_style' => 'comprehension', 'default_title' => "Read the following passage carefully and answer the quesitons given at the end"]);
        Type::create(['sr' => 20, 'name' => 'Sentences into English', 'display_style' => 'partial', 'default_title' => "Translate the following sentences into English"]);
        Type::create(['sr' => 21, 'name' => 'Active/passive', 'display_style' => 'partial', 'default_title' => "Change the narration of the following"]);
        Type::create(['sr' => 22, 'name' => 'Direct/indirect', 'display_style' => 'partial', 'default_title' => "Change the following into indirect"]);
        // urdu types
        Type::create(['sr' => 30, 'name' => 'معروضی', 'display_style' => 'partial', 'default_title' => "درست آپشن کا انتخاب کیجیے"]);
        Type::create(['sr' => 31, 'name' => 'مختصرسوالات', 'display_style' => 'partial', 'default_title' => "درج ذیل سوالات کے مختصر جوابات لکھیے"]);
        Type::create(['sr' => 32, 'name' => 'اشعار کی تشریح', 'display_style' => 'stanza', 'default_title' => "درج ذیل اشعار کی تشریح کیجیے"]);
        Type::create(['sr' => 33, 'name' => 'نثر پارہ کی تشریح', 'display_style' => 'simple', 'default_title' => "درج ذیل نثر پارہ کی تشریح کیجیے"]);
        Type::create(['sr' => 34, 'name' => 'خلاصہ', 'display_style' => 'partial-x', 'default_title' => "کسی ایک سبق کا خلاصہ لکھیے"]);
        Type::create(['sr' => 35, 'name' => 'مضمون', 'display_style' => 'partial-x', 'default_title' => "کسی ایک عنوان پہ مضمون لکھیے"]);
        Type::create(['sr' => 36, 'name' => ' عبارت سے سوالات', 'display_style' => 'comprehension', 'default_title' => "دی گئی عبارت کو غور سے پڑھیں اور آخر میں دیے گئے سوالات کے جوابات تحریر کیجیے"]);
        Type::create(['sr' => 37, 'name' => 'مرکزی خیال', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 38, 'name' => 'درخواست', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 39, 'name' => 'خط', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 40, 'name' => 'رسید', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 41, 'name' => 'رُوداد', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 42, 'name' => 'کہانی', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 43, 'name' => 'مکالمہ', 'display_style' => 'simple', 'default_title' => null]);
        Type::create(['sr' => 44, 'name' => 'جملوں کی درستگی', 'display_style' => 'partial', 'default_title' => "درج ذیل جملوں کیی درستگی کیجیے"]);
        Type::create(['sr' => 45, 'name' => 'ضرب الامثال', 'display_style' => 'partial', 'default_title' => "درج ذیل ضرب الامثال کی تکمیل کیجیے"]);



        // 
    }
}
