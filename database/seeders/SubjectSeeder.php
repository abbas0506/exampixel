<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Subject::create([
            'name_en' => 'Physics',
            'name_ur' => 'فزکس',
            'display_order' => 1,
        ]);
        Subject::create([
            'name_en' => 'Mathematics',
            'name_ur' => 'میتھ',
            'display_order' => 2,
        ]);
        Subject::create([
            'name_en' => 'Computer Science',
            'name_ur' => 'کمپیوٹر سائنس',
            'display_order' => 3,
        ]);
        Subject::create([
            'name_en' => 'Chemistry',
            'name_ur' => 'کیمسٹری',
            'display_order' => 4,
        ]);
        Subject::create([
            'name_en' => 'Biology',
            'name_ur' => 'بیالوجی',
            'display_order' => 5,
        ]);
        Subject::create([
            'name_en' => 'English',
            'name_ur' => 'انگلش',
            'display_order' => 6,
        ]);
        Subject::create([
            'name_en' => 'Urdu',
            'name_ur' => 'اردو',
            'display_order' => 7,
        ]);
        Subject::create([
            'name_en' => 'Islamic Studies',
            'name_ur' => 'اسلامیات لازمی',
            'display_order' => 8,
        ]);
        Subject::create([
            'name_en' => 'Pak Studies',
            'name_ur' => 'مطالعہ پاکستان',
            'display_order' => 9,
        ]);
        Subject::create([
            'name_en' => 'General Sc',
            'name_ur' => 'جنرل سائنس',
            'display_order' => 10,
        ]);
    }
}
