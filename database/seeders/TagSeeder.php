<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tag::create(['name' => 'Chapters', 'sr' => 1,]);
        Tag::create(['name' => 'Lessons', 'sr' => 2,]);
        Tag::create(['name' => 'Poems', 'sr' => 3,]);
        Tag::create(['name' => 'Ghazals', 'sr' => 4,]);
        Tag::create(['name' => 'Novels', 'sr' => 5,]);
    }
}
