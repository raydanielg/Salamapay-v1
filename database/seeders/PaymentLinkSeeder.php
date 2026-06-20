<?php

namespace Database\Seeders;

use App\Models\PaymentLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentLinkSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        if (!$user) return;

        $links = [
            ['title' => 'School Fees Payment', 'description' => 'Pay your school fees online', 'amount' => 150000, 'is_active' => true],
            ['title' => 'Product Purchase', 'description' => 'Pay for your order', 'amount' => null, 'is_active' => true],
            ['title' => 'Donation', 'description' => 'Support our cause', 'amount' => null, 'is_active' => true],
            ['title' => 'Event Ticket', 'description' => 'Buy event ticket', 'amount' => 50000, 'is_active' => true],
            ['title' => 'Consultation Fee', 'description' => 'Pay for consultation', 'amount' => 100000, 'is_active' => true],
            ['title' => 'Subscription', 'description' => 'Monthly subscription', 'amount' => 45000, 'is_active' => true],
            ['title' => 'Service Payment', 'description' => 'Pay for services rendered', 'amount' => null, 'is_active' => false],
            ['title' => 'Membership Fee', 'description' => 'Annual membership', 'amount' => 250000, 'is_active' => true],
            ['title' => 'Booking Deposit', 'description' => 'Pay booking deposit', 'amount' => 75000, 'is_active' => true],
            ['title' => 'Custom Payment', 'description' => 'Custom payment link', 'amount' => null, 'is_active' => true],
        ];

        foreach ($links as $index => $link) {
            PaymentLink::create(array_merge($link, [
                'user_id' => $user->id,
                'slug' => Str::slug($link['title']) . '-' . Str::random(6),
                'usage_count' => rand(0, 50),
            ]));
        }
    }
}
