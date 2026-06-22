<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportsApiController extends Controller
{
    public function index(Request $request)
    {
        $period = (int) ($request->query('period', 30));
        $from   = now()->subDays($period)->startOfDay();
        $user   = $request->user();

        $txQuery = Transaction::where('user_id', $user->id)
            ->where('created_at', '>=', $from);

        $total      = (clone $txQuery)->where('status', 'success')->sum('amount');
        $count      = (clone $txQuery)->count();
        $success    = (clone $txQuery)->where('status', 'success')->count();
        $rate       = $count > 0 ? round(($success / $count) * 100, 1) : 0;
        $avg        = $success > 0 ? round($total / $success, 2) : 0;

        // Daily revenue
        $daily = (clone $txQuery)
            ->where('status', 'success')
            ->selectRaw('DATE(created_at) as date, SUM(amount) as revenue, COUNT(*) as cnt')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'revenue' => $r->revenue, 'count' => $r->cnt]);

        // Payment methods
        $methods = (clone $txQuery)
            ->where('status', 'success')
            ->selectRaw('payment_method as method, SUM(amount) as amount, COUNT(*) as cnt')
            ->groupBy('payment_method')
            ->get()
            ->map(fn($r) => ['method' => $r->method ?? 'Cash', 'amount' => $r->amount, 'count' => $r->cnt]);

        // Top customers
        $topCustomers = (clone $txQuery)
            ->where('status', 'success')
            ->selectRaw('customer_name, SUM(amount) as total, COUNT(*) as cnt')
            ->groupBy('customer_name')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(fn($r) => ['name' => $r->customer_name, 'total' => $r->total, 'count' => $r->cnt]);

        return response()->json([
            'period'        => $period,
            'summary'       => [
                'total_revenue'  => round($total, 2),
                'total_count'    => $count,
                'success_count'  => $success,
                'success_rate'   => $rate,
                'avg_sale'       => $avg,
            ],
            'daily'         => $daily,
            'payment_methods' => $methods,
            'top_customers' => $topCustomers,
        ]);
    }
}
