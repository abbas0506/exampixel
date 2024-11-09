<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //physics 1-4

        Book::create(['name' => 'Physics 9', 'subject_id' => 1, 'grade_id' => 1]);
        Book::create(['name' => 'Physics 10', 'subject_id' => 1, 'grade_id' => 2]);
        Book::create(['name' => 'Physics 11', 'subject_id' => 1, 'grade_id' => 3]);
        Book::create(['name' => 'Physics 12', 'subject_id' => 1, 'grade_id' => 4]);

        //math 5-8
        Book::create(['name' => 'Mathematics 9', 'subject_id' => 2, 'grade_id' => 1]);
        Book::create(['name' => 'Mathematics 10', 'subject_id' => 2, 'grade_id' => 2]);
        Book::create(['name' => 'Mathematics 11', 'subject_id' => 2, 'grade_id' => 3]);
        Book::create(['name' => 'Mathematics 12', 'subject_id' => 2, 'grade_id' => 4]);

        //computer sc 9-12
        Book::create(['name' => 'Computer Sc 9', 'subject_id' => 3, 'grade_id' => 1]);
        Book::create(['name' => 'Computer Sc 10', 'subject_id' => 3, 'grade_id' => 2]);
        Book::create(['name' => 'Computer Sc 11', 'subject_id' => 3, 'grade_id' => 3]);
        Book::create(['name' => 'Computer Sc 12', 'subject_id' => 3, 'grade_id' => 4]);

        //chemistry 13-16
        Book::create(['name' => 'Chemistry 9', 'subject_id' => 4, 'grade_id' => 1]);
        Book::create(['name' => 'Chemistry 10', 'subject_id' => 4, 'grade_id' => 2]);
        Book::create(['name' => 'Chemistry 11', 'subject_id' => 4, 'grade_id' => 3]);
        Book::create(['name' => 'Chemistry 12', 'subject_id' => 4, 'grade_id' => 4]);

        //biology 17-20
        Book::create(['name' => 'Biology 9', 'subject_id' => 5, 'grade_id' => 1]);
        Book::create(['name' => 'Biology 10', 'subject_id' => 5, 'grade_id' => 2]);
        Book::create(['name' => 'Biology 11', 'subject_id' => 5, 'grade_id' => 3]);
        Book::create(['name' => 'Biology 12', 'subject_id' => 5, 'grade_id' => 4]);

        //english 21-24
        Book::create(['name' => 'English 9', 'subject_id' => 6, 'grade_id' => 1]);
        Book::create(['name' => 'English 10', 'subject_id' => 6, 'grade_id' => 2]);
        Book::create(['name' => 'English 11', 'subject_id' => 6, 'grade_id' => 3]);
        Book::create(['name' => 'English 12', 'subject_id' => 6, 'grade_id' => 4]);

        //urdu 25-28
        Book::create(['name' => 'Urdu 9', 'subject_id' => 7, 'grade_id' => 1]);
        Book::create(['name' => 'Urdu 10', 'subject_id' => 7, 'grade_id' => 2]);
        Book::create(['name' => 'Urdu 11', 'subject_id' => 7, 'grade_id' => 3]);
        Book::create(['name' => 'Urdu 12', 'subject_id' => 7, 'grade_id' => 4]);

        //islamic studies 29-32
        Book::create(['name' => 'Islamic Studies 9', 'subject_id' => 8, 'grade_id' => 1]);
        Book::create(['name' => 'Islamic Studies 10', 'subject_id' => 8, 'grade_id' => 2]);
        Book::create(['name' => 'Islamic Studies 11', 'subject_id' => 8, 'grade_id' => 3]);
        Book::create(['name' => 'Islamic Studies 12', 'subject_id' => 8, 'grade_id' => 4]);

        //pak studies 33-36
        Book::create(['name' => 'Pak Studies 9', 'subject_id' => 9, 'grade_id' => 1]);
        Book::create(['name' => 'Pak Studies 10', 'subject_id' => 9, 'grade_id' => 2]);
        Book::create(['name' => 'Pak Studies 11', 'subject_id' => 9, 'grade_id' => 3]);
        Book::create(['name' => 'Pak Studies 12', 'subject_id' => 9, 'grade_id' => 4]);

        //gen science
        Book::create(['name' => 'General Sc 9', 'subject_id' => 10, 'grade_id' => 1]);
        Book::create(['name' => 'General Sc 10', 'subject_id' => 10, 'grade_id' => 2]);
    }
}
