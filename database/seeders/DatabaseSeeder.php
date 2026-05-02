<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '09123456789'
        ]);

        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'supervisor',
            'status' => 'active',
            'phone' => '09987654321'
        ]);

        User::create([
            'name' => 'Housekeeper',
            'email' => 'housekeeper@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'housekeeper',
            'status' => 'active',
            'phone' => '09111111111'
        ]);
    }
}
