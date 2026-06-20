<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin SalamaPay',
            'first_name' => 'Admin',
            'last_name' => 'SalamaPay',
            'email' => 'admin@salamapay.com',
            'phone' => '255712345678',
            'role' => 'admin',
            'password' => Hash::make('Admin@1234'),
        ]);

        User::create([
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'user@salamapay.com',
            'phone' => '255712345679',
            'role' => 'user',
            'password' => Hash::make('User@1234'),
        ]);
    }
}
