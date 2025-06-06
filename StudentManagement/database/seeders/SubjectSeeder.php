<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;


class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'label'=>'Informatique',
        ]);

        Subject::create([
            'label'=>'Mathematique',
        ]);

        Subject::create([
            'label'=>'Physique',
        ]);

        Subject::create([
            'label'=>'chimie',
        ]);
    }
}
