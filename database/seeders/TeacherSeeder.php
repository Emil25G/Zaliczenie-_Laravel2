<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'class_id' => 1,
                'fname' => 'Jan',
                'lname' => 'Kowalski',
                'email' => 'test@wp.pl',
                'password' => Hash::make('test'),
                'role' => 'nauczyciel',
                'image' => '1731176762.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => null,
                'fname' => 'Administrator',
                'lname' => '',
                'email' => 'admin@chat.pl',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'image' => '1731176763.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 1,
                'fname' => 'Piotr',
                'lname' => 'Nowak',
                'email' => 'test2@wp.pl',
                'password' => Hash::make('test1'),
                'role' => 'uczeń',
                'image' => '1731176762.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 1,
                'fname' => 'Paweł',
                'lname' => 'Gondor',
                'email' => 'test3@wp.pl',
                'password' => Hash::make('test'),
                'role' => 'uczeń',
                'image' => '1731176762.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
