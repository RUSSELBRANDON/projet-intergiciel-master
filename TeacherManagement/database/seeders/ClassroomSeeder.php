<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::create([
            'label'=>'6eme',
            'capacity'=>'50',
        ]);

        Classroom::create([
            'label'=>'5eme',
            'capacity'=>'50',
        ]);

        Classroom::create([
            'label'=>'4eme',
            'capacity'=>'50',
        ]);

        Classroom::create([
            'label'=>'3eme',
            'capacity'=>'50',
        ]);
    }
}
