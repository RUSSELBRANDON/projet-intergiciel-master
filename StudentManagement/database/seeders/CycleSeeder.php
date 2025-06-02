<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cycle;


class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cycle::create([
            'label'=>'cycle 3',
        ]);

        Cycle::create([
            'label'=>'cycle 2',
        ]);

        Cycle::create([
            'label'=>'Cycle 1',
        ]);
    }
}
