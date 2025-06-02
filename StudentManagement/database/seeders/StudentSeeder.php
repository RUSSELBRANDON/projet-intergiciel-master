<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Dongmo Russel',
            'sex'=>'M',
            'age'=>'20',
            'Address'=>'Ngui',
            'Email'=>'russeldongmo96@gmail.com'
        ]);

        User::create([
            'name'=>'Dongmo Russel Brandon',
            'sex'=>'M',
            'age'=>'21',
            'Address'=>'foreke',
            'Email'=>'russeldongmo05@gmail.com'
        ]);
    }
}
