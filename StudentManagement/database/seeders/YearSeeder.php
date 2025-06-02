<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Year;


class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::create([
            'school_year'=>'2022-2023',
        ]);

        Year::create([
            'school_year'=>'2023-2024',
        ]);

        Year::create([
            'school_year'=>'2024-2025',
        ]);
    }
}
