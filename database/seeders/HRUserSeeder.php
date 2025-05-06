<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HRUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'HR Manager',
            'email' => 'hrputra@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'hr',
        ]);
    }
}