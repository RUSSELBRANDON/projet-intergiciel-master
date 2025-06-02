<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StudentSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(ExamSeeder::class);
        $this->call(CycleSeeder::class);
        $this->call(YearSeeder::class);
        $this->call(ClassroomSeeder::class);
    }
}
