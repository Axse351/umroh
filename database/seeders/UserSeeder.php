<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@umroh.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Kasir
        User::create([
            'name'     => 'Kasir Posyandu',
            'email'    => 'kasir@umroh.com',
            'password' => Hash::make('password'),
            'role'     => 'kasir',
        ]);

        // User
        User::create([
            'name'     => 'User Biasa',
            'email'    => 'user@umroh.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);
    }
}
