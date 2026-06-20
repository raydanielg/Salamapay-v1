<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Settlement;
use App\Models\PaymentLink;
use App\Models\Balance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = now()->startOfDay();
        $weekAgo = now()->subDays(7)->startOfDay();

        // Overview stats
        $stats = [
            'totalMerchants' => User::where('role', 'user')->count(),
            'newMerchantsThisWeek' => User::where('role', 'user')->where('created_at', '>=', $weekAgo)->count(),
            'totalVolume' => Transaction::where('status', 'success')->sum('amount'),
            'volumeThisWeek' => Transaction::where('status', 'success')->whereBetween('processed_at', [$weekAgo, $today->copy()->endOfDay()])->sum('amount'),
            'totalTransactions' => Transaction::count(),
            'transactionsThisWeek' => Transaction::whereBetween('processed_at', [$weekAgo, $today->copy()->endOfDay()])->count(),
            'pendingSettlements' => Settlement::where('status', 'pending')->count(),
            'successRate' => Transaction::count() > 0
                ? round(Transaction::where('status', 'success')->count() / Transaction::count() * 100, 1)
                : 0,
        ];

        // Recent transactions
        $recentTransactions = Transaction::with('user')
            ->orderBy('processed_at', 'desc')
            ->take(8)
            ->get();

        // Pending KYC (users without complete business info)
        $pendingKyc = User::where('role', 'user')
            ->whereNull('business_name')
            ->orWhere(function ($q) {
                $q->whereNull('business_tin');
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Daily revenue chart (last 14 days)
        $dailyRevenue = [];
        $dailyLabels = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('D d');
            $dailyRevenue[] = Transaction::where('status', 'success')
                ->whereDate('processed_at', $date)
                ->sum('amount');
        }

        // Payment method breakdown
        $methods = Transaction::where('status', 'success')
            ->selectRaw('method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('method')
            ->get();

        // Top merchants by volume
        $topMerchants = User::where('role', 'user')
            ->withSum(['transactions' => fn($q) => $q->where('status', 'success')], 'amount')
            ->orderByDesc('transactions_sum_amount')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentTransactions', 'pendingKyc',
            'dailyRevenue', 'dailyLabels', 'methods', 'topMerchants'
        ));
    }
}
