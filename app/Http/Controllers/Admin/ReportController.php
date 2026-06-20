<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $period = (int) $request->get('period', 30);
        $from = now()->subDays($period)->startOfDay();
        $to = now()->endOfDay();

        $transactions = Transaction::whereBetween('processed_at', [$from, $to])->get();

        $daily = [];
        for ($i = $period; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $daily[$date] = ['revenue' => 0, 'count' => 0, 'success' => 0, 'failed' => 0];
        }

        foreach ($transactions as $tx) {
            $d = $tx->processed_at?->format('Y-m-d');
            if ($d && isset($daily[$d])) {
                $daily[$d]['count']++;
                if ($tx->status === 'success') {
                    $daily[$d]['revenue'] += $tx->amount;
                    $daily[$d]['success']++;
                } elseif ($tx->status === 'failed') {
                    $daily[$d]['failed']++;
                }
            }
        }

        $summary = [
            'total_revenue' => $transactions->where('status', 'success')->sum('amount'),
            'total_count' => $transactions->count(),
            'success_count' => $transactions->where('status', 'success')->count(),
            'failed_count' => $transactions->where('status', 'failed')->count(),
            'avg_transaction' => $transactions->where('status', 'success')->avg('amount') ?: 0,
            'total_merchants' => User::where('role', 'user')->whereBetween('created_at', [$from, $to])->count(),
            'total_settlements' => Settlement::whereBetween('created_at', [$from, $to])->where('status', 'completed')->sum('amount'),
        ];

        $methods = $transactions->where('status', 'success')->groupBy('method')->map(fn($g) => [
            'count' => $g->count(),
            'amount' => $g->sum('amount'),
        ]);

        return view('admin.reports.index', compact('transactions', 'daily', 'summary', 'methods', 'period'));
    }
}
