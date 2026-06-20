<?php

namespace Database\Seeders;

use App\Models\AdminLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        $logs = [
            [
                'user_id' => $admin?->id,
                'action' => 'user.approved',
                'model_type' => 'User',
                'model_id' => $user?->id,
                'description' => 'Approved merchant account for Ezra Daniel',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'old_values' => json_encode(['status' => 'pending']),
                'new_values' => json_encode(['status' => 'active']),
            ],
            [
                'user_id' => $admin?->id,
                'action' => 'transaction.reviewed',
                'model_type' => 'Transaction',
                'model_id' => 1,
                'description' => 'Reviewed flagged transaction TX-10293',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'old_values' => json_encode(['status' => 'pending', 'flagged' => true]),
                'new_values' => json_encode(['status' => 'success', 'flagged' => false]),
            ],
            [
                'user_id' => $admin?->id,
                'action' => 'setting.updated',
                'model_type' => 'SystemSetting',
                'model_id' => 1,
                'description' => 'Updated platform fee from 2.0% to 2.5%',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'old_values' => json_encode(['fee_percentage' => 2.0]),
                'new_values' => json_encode(['fee_percentage' => 2.5]),
            ],
            [
                'user_id' => $admin?->id,
                'action' => 'settlement.processed',
                'model_type' => 'Settlement',
                'model_id' => 1,
                'description' => 'Processed settlement STL-2026-001 to CRDB Bank',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'old_values' => json_encode(['status' => 'pending']),
                'new_values' => json_encode(['status' => 'completed']),
            ],
            [
                'user_id' => null,
                'action' => 'system.backup',
                'model_type' => null,
                'model_id' => null,
                'description' => 'Automated database backup completed successfully',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'SalamaPay-Scheduler/1.0',
                'old_values' => null,
                'new_values' => json_encode(['backup_size' => '1.2GB', 'duration' => '45s']),
            ],
        ];

        foreach ($logs as $log) {
            AdminLog::create($log);
        }
    }
}
