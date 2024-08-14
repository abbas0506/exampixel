<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Individual;
use App\Models\Institution;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $admin=Admin::create(['name'=>'Muhammad Abbas']);
        $user = User::create([
            'name' => 'Muhammad Abbas',
            'email' => 'abbas.sscs@gmail.com',
            'password' => Hash::make('password'),

        ]);

        $user->assignRole(['admin', 'teacher']);

        $user = User::create([
            'name' => 'Azeem Rehan',
            'email' => 'mianazeemdaula@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Data Expert',
            'email' => 'data@exampixel.com',
            'password' => Hash::make('password'),

        ]);

        $user->assignRole('operator');

        // // physics
        // $user = User::create([
        //     'name' => 'Imran Khan',
        //     'email' => 'imran@exampixel.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 1,
        //     'phone' => '03227881266',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);

        // // math
        // $user = User::create([
        //     'name' => 'Shakeel Hussain',
        //     'email' => 'shakeel@exampixel.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 2,
        //     'phone' => '03001234567',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);

        // $user = User::create([
        //     'name' => 'Mubashar Maqbool',
        //     'email' => 'mubashar@exampixel.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 2,
        //     'phone' => '03001234567',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);

        // // computer science
        // $user = User::create([
        //     'name' => 'Atif Zohaib',
        //     'email' => 'atifzohaib@exampixel.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 3,
        //     'phone' => '03001234567',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);

        // //chemistry
        // $user = User::create([
        //     'name' => 'Muzammil Hussain',
        //     'email' => 'muzammilhussain@gmail.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 4,
        //     'phone' => '03167717963',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);

        // $user = User::create([
        //     'name' => 'Khan Muhammad',
        //     'email' => 'khan@exampixel.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 4,
        //     'phone' => '03001234567',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);

        // //    english
        // $user = User::create([
        //     'name' => 'Tahir Usman',
        //     'email' => 'tahir@exampixel.com',
        //     'password' => Hash::make('password'),

        // ]);
        // $user->teacher()->create([
        //     'subject_id' => 6,
        //     'phone' => '03001234567',
        // ]);

        // $user->assignRole(['collaborator', 'teacher']);
    }
}
