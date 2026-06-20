<?php

namespace Database\Seeders;

use App\Models\Webhook;
use App\Models\User;
use Illuminate\Database\Seeder;

class WebhookSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        if (!$user) return;

        $webhooks = [
            [
                'user_id' => $user->id,
                'url' => 'https://merchant-site.com/webhooks/salamapay',
                'secret' => hash('sha256', 'webhook-secret-1'),
                'events' => json_encode(['payment.success', 'payment.failed', 'settlement.completed']),
                'is_active' => true,
                'success_count' => 245,
                'fail_count' => 3,
                'last_triggered_at' => now()->subHours(1),
            ],
            [
                'user_id' => $user->id,
                'url' => 'https://merchant-site.com/webhooks/payments',
                'secret' => hash('sha256', 'webhook-secret-2'),
                'events' => json_encode(['payment.success', 'payment.pending']),
                'is_active' => true,
                'success_count' => 120,
                'fail_count' => 0,
                'last_triggered_at' => now()->subHours(3),
            ],
            [
                'user_id' => $user->id,
                'url' => 'https://old-merchant-site.com/hook',
                'secret' => hash('sha256', 'webhook-secret-3'),
                'events' => json_encode(['payment.success']),
                'is_active' => false,
                'success_count' => 45,
                'fail_count' => 28,
                'last_triggered_at' => now()->subDays(10),
            ],
        ];

        foreach ($webhooks as $w) {
            Webhook::updateOrCreate(
                ['url' => $w['url'], 'user_id' => $user->id],
                $w
            );
        }
    }
}
