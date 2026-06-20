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
        User::updateOrCreate(
            ['email' => 'admin@salamapay.com'],
            [
                'name' => 'Admin SalamaPay',
                'first_name' => 'Admin',
                'last_name' => 'SalamaPay',
                'phone' => '255712345678',
                'role' => 'admin',
                'password' => Hash::make('Admin@1234'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@salamapay.com'],
            [
                'name' => 'Ezra Daniel',
                'first_name' => 'Ezra',
                'last_name' => 'Daniel',
                'phone' => '255712345679',
                'role' => 'user',
                'password' => Hash::make('User@1234'),
                'business_name' => 'Daniel Ventures Ltd',
                'business_type' => 'limited_company',
                'business_address' => "123 Samora Avenue, 4th Floor\nDar es Salaam, Tanzania",
                'business_tin' => '123-456-789',
                'business_registration_number' => 'TZ1234567',
                'verification_status' => 'verified',
                'verified_at' => now()->subDays(30),
            ]
        );
    }
}
