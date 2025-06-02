<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Dongmo Russel',
            "email"=>'russeldongmo05@gmail.com',
            'password'=> '1234',
            'email_verified_at' => now(),
            'role'=>'admin'
        ]);
    }
}
