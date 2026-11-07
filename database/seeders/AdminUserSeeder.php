<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@minimart.test',
            'password' => Hash::make('minimart123'),
            'role' => 'admin',
        ]);

        // Create sample customer
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@minimart.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
