<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Grade::create(['name' => '9th', 'grade_no' => 9]);
        Grade::create(['name' => '10th', 'grade_no' => 10]);
        Grade::create(['name' => 'Part I', 'grade_no' => 11]);
        Grade::create(['name' => 'Part II', 'grade_no' => 12]);
    }
}
