<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApiKeySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        if (!$user) return;

        $keys = [
            [
                'user_id' => $user->id,
                'name' => 'Production API Key',
                'key' => 'spk_live_' . Str::random(32),
                'secret' => hash('sha256', Str::random(64)),
                'permissions' => json_encode(['payments:create', 'payments:read', 'webhooks:manage']),
                'last_used_at' => now()->subHours(2),
                'is_active' => true,
            ],
            [
                'user_id' => $user->id,
                'name' => 'Test API Key',
                'key' => 'spk_test_' . Str::random(32),
                'secret' => hash('sha256', Str::random(64)),
                'permissions' => json_encode(['payments:create', 'payments:read']),
                'last_used_at' => now()->subDays(1),
                'is_active' => true,
            ],
            [
                'user_id' => $user->id,
                'name' => 'Old Integration',
                'key' => 'spk_live_' . Str::random(32),
                'secret' => hash('sha256', Str::random(64)),
                'permissions' => json_encode(['payments:read']),
                'last_used_at' => now()->subMonths(2),
                'expires_at' => now()->subMonth(),
                'is_active' => false,
            ],
        ];

        foreach ($keys as $k) {
            ApiKey::updateOrCreate(
                ['key' => $k['key']],
                $k
            );
        }
    }
}
