<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        if (!$user) return;

        $transactions = [
            ['tx_id' => 'TX-10293', 'customer_name' => 'Amani Mushi', 'customer_email' => 'amani@gmail.com', 'amount' => 248500, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-12 14:21'],
            ['tx_id' => 'TX-10292', 'customer_name' => 'Grace Mwakatobe', 'customer_email' => 'grace.m@outlook.com', 'amount' => 76000, 'method' => 'Tigo Pesa', 'status' => 'success', 'processed_at' => '2026-06-12 13:58'],
            ['tx_id' => 'TX-10291', 'customer_name' => 'Innocent Lyimo', 'customer_email' => 'i.lyimo@yahoo.com', 'amount' => 1200000, 'method' => 'Card', 'status' => 'pending', 'processed_at' => '2026-06-12 13:31'],
            ['tx_id' => 'TX-10290', 'customer_name' => 'Neema Kazoba', 'customer_email' => 'neema@salamapay.com', 'amount' => 45000, 'method' => 'Airtel Money', 'status' => 'success', 'processed_at' => '2026-06-12 12:09'],
            ['tx_id' => 'TX-10289', 'customer_name' => 'John Mahenge', 'customer_email' => 'john.m@gmail.com', 'amount' => 320000, 'method' => 'Bank', 'status' => 'failed', 'processed_at' => '2026-06-12 11:42'],
            ['tx_id' => 'TX-10288', 'customer_name' => 'Zainab Hassan', 'customer_email' => 'zainab@gmail.com', 'amount' => 89500, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-12 10:14'],
            ['tx_id' => 'TX-10287', 'customer_name' => 'Faraja Mdee', 'customer_email' => 'faraja@yahoo.com', 'amount' => 156000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-11 16:30'],
            ['tx_id' => 'TX-10286', 'customer_name' => 'Daniel Kavishe', 'customer_email' => 'dkavishe@gmail.com', 'amount' => 890000, 'method' => 'Tigo Pesa', 'status' => 'success', 'processed_at' => '2026-06-11 14:15'],
            ['tx_id' => 'TX-10285', 'customer_name' => 'Rose Ndossi', 'customer_email' => 'rose.n@outlook.com', 'amount' => 340000, 'method' => 'Card', 'status' => 'success', 'processed_at' => '2026-06-11 12:00'],
            ['tx_id' => 'TX-10284', 'customer_name' => 'Peter Maganga', 'customer_email' => 'peter@salamapay.com', 'amount' => 2100000, 'method' => 'Bank', 'status' => 'success', 'processed_at' => '2026-06-11 09:45'],
            ['tx_id' => 'TX-10283', 'customer_name' => 'Esther Mwero', 'customer_email' => 'esther@yahoo.com', 'amount' => 78000, 'method' => 'Airtel Money', 'status' => 'success', 'processed_at' => '2026-06-10 18:20'],
            ['tx_id' => 'TX-10282', 'customer_name' => 'Josephine Mwafyaka', 'customer_email' => 'j.mwafyaka@gmail.com', 'amount' => 450000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-10 15:10'],
            ['tx_id' => 'TX-10281', 'customer_name' => 'Charles Lyimo', 'customer_email' => 'charles@outlook.com', 'amount' => 980000, 'method' => 'Tigo Pesa', 'status' => 'success', 'processed_at' => '2026-06-10 11:30'],
            ['tx_id' => 'TX-10280', 'customer_name' => 'Mwanaisha Kombo', 'customer_email' => 'mwanaisha@gmail.com', 'amount' => 125000, 'method' => 'Card', 'status' => 'pending', 'processed_at' => '2026-06-10 09:00'],
            ['tx_id' => 'TX-10279', 'customer_name' => 'Benedict Ndosi', 'customer_email' => 'benedict@yahoo.com', 'amount' => 560000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-09 17:45'],
            ['tx_id' => 'TX-10278', 'customer_name' => 'Theresia Moshi', 'customer_email' => 'theresia@outlook.com', 'amount' => 32000, 'method' => 'Airtel Money', 'status' => 'success', 'processed_at' => '2026-06-09 14:20'],
            ['tx_id' => 'TX-10277', 'customer_name' => 'Frank Mbise', 'customer_email' => 'frank@gmail.com', 'amount' => 1800000, 'method' => 'Bank', 'status' => 'success', 'processed_at' => '2026-06-09 11:00'],
            ['tx_id' => 'TX-10276', 'customer_name' => 'Lydia Nyamhanga', 'customer_email' => 'lydia@salamapay.com', 'amount' => 95000, 'method' => 'Tigo Pesa', 'status' => 'success', 'processed_at' => '2026-06-08 16:15'],
            ['tx_id' => 'TX-10275', 'customer_name' => 'Abdul Mtoro', 'customer_email' => 'abdul@yahoo.com', 'amount' => 670000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-08 13:00'],
            ['tx_id' => 'TX-10274', 'customer_name' => 'Joyce Kilaka', 'customer_email' => 'joyce@outlook.com', 'amount' => 210000, 'method' => 'Card', 'status' => 'success', 'processed_at' => '2026-06-08 09:30'],
            ['tx_id' => 'TX-10273', 'customer_name' => 'Samuel Mwakalinga', 'customer_email' => 'samuel@gmail.com', 'amount' => 430000, 'method' => 'Airtel Money', 'status' => 'success', 'processed_at' => '2026-06-07 18:00'],
            ['tx_id' => 'TX-10272', 'customer_name' => 'Christina Baru', 'customer_email' => 'christina@yahoo.com', 'amount' => 150000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-07 14:45'],
            ['tx_id' => 'TX-10271', 'customer_name' => 'Emmanuel Warioba', 'customer_email' => 'emmanuel@outlook.com', 'amount' => 2800000, 'method' => 'Bank', 'status' => 'success', 'processed_at' => '2026-06-07 11:20'],
            ['tx_id' => 'TX-10270', 'customer_name' => 'Happiness Mkama', 'customer_email' => 'happiness@gmail.com', 'amount' => 67000, 'method' => 'Tigo Pesa', 'status' => 'failed', 'processed_at' => '2026-06-07 09:10'],
            ['tx_id' => 'TX-10269', 'customer_name' => 'Patrick Mageni', 'customer_email' => 'patrick@salamapay.com', 'amount' => 340000, 'method' => 'Card', 'status' => 'success', 'processed_at' => '2026-06-06 16:50'],
            ['tx_id' => 'TX-10268', 'customer_name' => 'Margaret Segeja', 'customer_email' => 'margaret@yahoo.com', 'amount' => 1250000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-06 13:40'],
            ['tx_id' => 'TX-10267', 'customer_name' => 'Richard Kajuna', 'customer_email' => 'richard@outlook.com', 'amount' => 780000, 'method' => 'Airtel Money', 'status' => 'success', 'processed_at' => '2026-06-06 10:25'],
            ['tx_id' => 'TX-10266', 'customer_name' => 'Veronica Mushi', 'customer_email' => 'veronica@gmail.com', 'amount' => 95000, 'method' => 'Tigo Pesa', 'status' => 'success', 'processed_at' => '2026-06-05 17:00'],
            ['tx_id' => 'TX-10265', 'customer_name' => 'Ignas Milambo', 'customer_email' => 'ignas@yahoo.com', 'amount' => 540000, 'method' => 'Bank', 'status' => 'success', 'processed_at' => '2026-06-05 14:30'],
            ['tx_id' => 'TX-10264', 'customer_name' => 'Anna Kikoti', 'customer_email' => 'anna@outlook.com', 'amount' => 230000, 'method' => 'M-Pesa', 'status' => 'success', 'processed_at' => '2026-06-05 11:15'],
            ['tx_id' => 'TX-10263', 'customer_name' => 'George Malisa', 'customer_email' => 'george@gmail.com', 'amount' => 1600000, 'method' => 'Card', 'status' => 'success', 'processed_at' => '2026-06-05 08:50'],
        ];

        foreach ($transactions as $tx) {
            Transaction::updateOrCreate(
                ['tx_id' => $tx['tx_id']],
                array_merge($tx, [
                    'user_id' => $user->id,
                    'currency' => 'TZS',
                    'processed_at' => Carbon::parse($tx['processed_at']),
                ])
            );
        }
    }
}
