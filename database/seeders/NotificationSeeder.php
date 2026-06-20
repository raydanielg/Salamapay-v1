<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        // Admin notifications
        $adminNotifications = [
            [
                'user_id' => null,
                'title' => 'New Merchant Signup',
                'message' => 'Ezra Daniel registered as a new merchant. Awaiting KYC submission.',
                'type' => 'info',
                'category' => 'system',
                'action_url' => '/admin/users',
                'action_text' => 'View Merchant',
            ],
            [
                'user_id' => null,
                'title' => 'KYC Submitted',
                'message' => 'Daniel Ventures Ltd has submitted KYC documents for review.',
                'type' => 'warning',
                'category' => 'kyc',
                'action_url' => '/admin/kyc',
                'action_text' => 'Review KYC',
            ],
            [
                'user_id' => null,
                'title' => 'High Value Transaction',
                'message' => 'Transaction TX-10293 for TSh 1,200,000 flagged for review.',
                'type' => 'warning',
                'category' => 'payment',
                'action_url' => '/admin/payments',
                'action_text' => 'Review',
            ],
            [
                'user_id' => null,
                'title' => 'Settlement Requested',
                'message' => 'New settlement request STL-2026-003 for TSh 1,200,000.',
                'type' => 'info',
                'category' => 'settlement',
                'action_url' => '/admin/settlements',
                'action_text' => 'Process',
            ],
            [
                'user_id' => null,
                'title' => 'Business Verified',
                'message' => 'Daniel Ventures Ltd has been verified successfully.',
                'type' => 'success',
                'category' => 'kyc',
                'is_read' => true,
                'read_at' => now()->subHours(2),
            ],
            [
                'user_id' => null,
                'title' => 'System Backup Complete',
                'message' => 'Automated daily backup completed successfully. Size: 1.2GB.',
                'type' => 'info',
                'category' => 'system',
                'is_read' => true,
                'read_at' => now()->subHours(5),
            ],
        ];

        foreach ($adminNotifications as $n) {
            Notification::create($n);
        }

        // User notifications
        if ($user) {
            $userNotifications = [
                [
                    'user_id' => $user->id,
                    'title' => 'Payment Received',
                    'message' => 'You received TSh 248,500 from Amani Mushi via M-Pesa.',
                    'type' => 'success',
                    'category' => 'payment',
                    'action_url' => '/dashboard/payments',
                    'action_text' => 'View Payment',
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Settlement Completed',
                    'message' => 'Your settlement STL-2026-001 of TSh 500,000 has been processed.',
                    'type' => 'success',
                    'category' => 'settlement',
                    'action_url' => '/dashboard/settlements',
                    'action_text' => 'View Settlement',
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Business Verified',
                    'message' => 'Your business profile has been verified. All features are now unlocked.',
                    'type' => 'success',
                    'category' => 'kyc',
                    'is_read' => true,
                    'read_at' => now()->subDays(2),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'New API Key Created',
                    'message' => 'Production API Key was generated for your account.',
                    'type' => 'info',
                    'category' => 'system',
                    'action_url' => '/dashboard/api',
                    'action_text' => 'Manage Keys',
                ],
            ];

            foreach ($userNotifications as $n) {
                Notification::create($n);
            }
        }
    }
}
