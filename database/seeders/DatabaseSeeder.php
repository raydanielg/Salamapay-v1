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
        $this->call(AdminSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(PaymentLinkSeeder::class);
        $this->call(SystemSettingSeeder::class);
    }
}
