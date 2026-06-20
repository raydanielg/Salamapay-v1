<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // General
            ['key' => 'platform_name', 'value' => 'SalamaPay', 'group' => 'general', 'type' => 'string', 'description' => 'Platform Name'],
            ['key' => 'platform_email', 'value' => 'support@salamapay.com', 'group' => 'general', 'type' => 'string', 'description' => 'Support Email'],
            ['key' => 'platform_phone', 'value' => '+255 712 345 678', 'group' => 'general', 'type' => 'string', 'description' => 'Support Phone'],
            ['key' => 'maintenance_mode', 'value' => '0', 'group' => 'general', 'type' => 'boolean', 'description' => 'Maintenance Mode'],
            ['key' => 'maintenance_message', 'value' => 'We are currently performing scheduled maintenance. Please check back soon.', 'group' => 'general', 'type' => 'string', 'description' => 'Maintenance Message'],

            // Payments
            ['key' => 'currency_default', 'value' => 'TZS', 'group' => 'payments', 'type' => 'string', 'description' => 'Default Currency'],
            ['key' => 'min_transaction', 'value' => '100', 'group' => 'payments', 'type' => 'number', 'description' => 'Minimum Transaction Amount'],
            ['key' => 'max_transaction', 'value' => '10000000', 'group' => 'payments', 'type' => 'number', 'description' => 'Maximum Transaction Amount'],
            ['key' => 'payment_timeout', 'value' => '300', 'group' => 'payments', 'type' => 'number', 'description' => 'Payment Session Timeout (seconds)'],

            // Fees
            ['key' => 'fee_percentage', 'value' => '2.5', 'group' => 'fees', 'type' => 'number', 'description' => 'Platform Fee Percentage'],
            ['key' => 'fee_fixed', 'value' => '0', 'group' => 'fees', 'type' => 'number', 'description' => 'Fixed Fee per Transaction'],
            ['key' => 'withdrawal_fee', 'value' => '1000', 'group' => 'fees', 'type' => 'number', 'description' => 'Withdrawal Fee'],
            ['key' => 'settlement_fee', 'value' => '0', 'group' => 'fees', 'type' => 'number', 'description' => 'Settlement Fee'],

            // Security
            ['key' => 'require_2fa', 'value' => '0', 'group' => 'security', 'type' => 'boolean', 'description' => 'Require 2FA for Admins'],
            ['key' => 'login_attempts', 'value' => '5', 'group' => 'security', 'type' => 'number', 'description' => 'Max Login Attempts'],
            ['key' => 'session_lifetime', 'value' => '120', 'group' => 'security', 'type' => 'number', 'description' => 'Session Lifetime (minutes)'],
            ['key' => 'force_password_change', 'value' => '0', 'group' => 'security', 'type' => 'boolean', 'description' => 'Force Password Change'],

            // Notifications
            ['key' => 'email_notifications', 'value' => '1', 'group' => 'notifications', 'type' => 'boolean', 'description' => 'Enable Email Notifications'],
            ['key' => 'sms_notifications', 'value' => '1', 'group' => 'notifications', 'type' => 'boolean', 'description' => 'Enable SMS Notifications'],
            ['key' => 'webhook_retries', 'value' => '3', 'group' => 'notifications', 'type' => 'number', 'description' => 'Webhook Retry Count'],
        ];

        foreach ($defaults as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
