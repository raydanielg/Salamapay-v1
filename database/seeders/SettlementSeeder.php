<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Database\Seeder;

class SettlementSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        if (!$user) return;

        // Create bank accounts first
        $bank1 = BankAccount::updateOrCreate(
            ['user_id' => $user->id, 'account_number' => '1234567890'],
            [
                'account_name' => 'Ezra Daniel',
                'bank_name' => 'CRDB Bank',
                'branch_name' => 'Dar es Salaam',
                'type' => 'bank',
                'is_default' => true,
                'is_verified' => true,
            ]
        );

        $bank2 = BankAccount::updateOrCreate(
            ['user_id' => $user->id, 'account_number' => '0712345678'],
            [
                'account_name' => 'Ezra Daniel',
                'bank_name' => 'Vodacom M-Pesa',
                'branch_name' => null,
                'type' => 'mobile_money',
                'is_default' => false,
                'is_verified' => true,
            ]
        );

        // Create settlements
        $settlements = [
            [
                'user_id' => $user->id,
                'reference' => 'STL-2026-001',
                'bank_account_id' => $bank1->id,
                'amount' => 500000,
                'currency' => 'TZS',
                'fee' => 5000,
                'status' => 'completed',
                'method' => 'bank',
                'notes' => 'Weekly settlement',
                'processed_at' => now()->subDays(3),
            ],
            [
                'user_id' => $user->id,
                'reference' => 'STL-2026-002',
                'bank_account_id' => $bank2->id,
                'amount' => 250000,
                'currency' => 'TZS',
                'fee' => 2500,
                'status' => 'completed',
                'method' => 'mobile_money',
                'notes' => 'Instant withdrawal',
                'processed_at' => now()->subDays(1),
            ],
            [
                'user_id' => $user->id,
                'reference' => 'STL-2026-003',
                'bank_account_id' => $bank1->id,
                'amount' => 1200000,
                'currency' => 'TZS',
                'fee' => 0,
                'status' => 'pending',
                'method' => 'bank',
                'notes' => 'Monthly settlement scheduled',
                'processed_at' => null,
            ],
            [
                'user_id' => $user->id,
                'reference' => 'STL-2026-004',
                'bank_account_id' => null,
                'amount' => 75000,
                'currency' => 'TZS',
                'fee' => 1000,
                'status' => 'failed',
                'method' => 'bank',
                'notes' => 'Bank account verification failed',
                'processed_at' => now()->subDays(5),
            ],
            [
                'user_id' => $user->id,
                'reference' => 'STL-2026-005',
                'bank_account_id' => $bank2->id,
                'amount' => 450000,
                'currency' => 'TZS',
                'fee' => 4500,
                'status' => 'processing',
                'method' => 'mobile_money',
                'notes' => 'Processing mobile money transfer',
                'processed_at' => now()->subHours(2),
            ],
        ];

        foreach ($settlements as $s) {
            Settlement::updateOrCreate(
                ['reference' => $s['reference']],
                $s
            );
        }
    }
}
