<?php

namespace Database\Seeders;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Database\Seeder;

class BalanceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        if (!$user) return;

        Balance::updateOrCreate(
            ['user_id' => $user->id, 'currency' => 'TZS'],
            [
                'available' => 48920500,
                'pending' => 1250000,
                'reserved' => 500000,
            ]
        );

        // Admin balance (system)
        Balance::updateOrCreate(
            ['user_id' => null, 'currency' => 'TZS'],
            [
                'available' => 0,
                'pending' => 0,
                'reserved' => 0,
            ]
        );
    }
}
