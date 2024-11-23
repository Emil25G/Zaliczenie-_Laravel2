<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolClassSeeder extends Seeder
{
    public function run()
    {
        DB::table('school_class')->insert([
            [
                'teacher_id' => 1,
                'full_class_name' => '1A',
                'class_name' => 'A',
                'grade' => '1',
            ],
            [
                'teacher_id' => 2,
                'full_class_name' => '2A',
                'class_name' => 'A',
                'grade' => '2',
            ],
            [
                'teacher_id' => 3,
                'full_class_name' => '3A',
                'class_name' => 'A',
                'grade' => '3',
            ],
        ]);
    }
}
