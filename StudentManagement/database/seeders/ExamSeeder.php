<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exam::create([
            'label'=>'Informatique',
        ]);

        Exam::create([
            'label'=>'Mathematique',
        ]);

        Exam::create([
            'label'=>'Physique',
        ]);

        Exam::create([
            'label'=>'chimie',
        ]);
    }
}
