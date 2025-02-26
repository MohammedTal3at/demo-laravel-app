<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
       
        User::create([
            'first_name' => 'Ali',
            'last_name' => 'Ahmed',
            'email' => 'ali@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'first_name' => 'Mohamed',
            'last_name' => 'Gamal',
            'email' => 'm.gamal@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'first_name' => 'Jaichand',
            'last_name' => 'Singh',
            'email' => 'jai@example.com',
            'password' => Hash::make('password'),
        ]);
    }
} 