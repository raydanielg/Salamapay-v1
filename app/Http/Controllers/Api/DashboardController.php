<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->startOfDay();
        $thirtyDaysAgo = now()->subDays(30)->startOfDay();

        // Today stats
        $todayTx = Transaction::where('user_id', $user->id)
            ->where('created_at', '>=', $today);

        $todayRevenue = (clone $todayTx)->where('status', 'success')->sum('amount');
        $todayCount   = (clone $todayTx)->count();
        $todaySuccess = (clone $todayTx)->where('status', 'success')->count();
        $successRate  = $todayCount > 0 ? round(($todaySuccess / $todayCount) * 100) : 0;

        // 30-day revenue
        $totalRevenue = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount');

        // Counts
        $invoiceCount = class_exists(Invoice::class)
            ? Invoice::where('user_id', $user->id)->count()
            : 0;

        $productCount = Product::where('user_id', $user->id)
            ->where('type', 'product')
            ->count();

        $customerCount = Transaction::where('user_id', $user->id)
            ->distinct('customer_name')
            ->count('customer_name');

        // Recent transactions (last 10)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($tx) => [
                'id'            => $tx->id,
                'tx_id'         => $tx->tx_id ?? '#' . $tx->id,
                'customer_name' => $tx->customer_name,
                'amount'        => $tx->amount,
                'method'        => $tx->payment_method ?? 'cash',
                'status'        => $tx->status,
                'source_type'   => $tx->source_type ?? null,
                'processed_at'  => $tx->created_at?->toIso8601String(),
            ]);

        return response()->json([
            'stats' => [
                'today_revenue'  => round($todayRevenue, 2),
                'today_count'    => $todayCount,
                'success_rate'   => $successRate,
                'total_revenue'  => round($totalRevenue, 2),
                'invoice_count'  => $invoiceCount,
                'product_count'  => $productCount,
                'customer_count' => $customerCount,
            ],
            'recent_transactions' => $recentTransactions,
        ]);
    }
}
