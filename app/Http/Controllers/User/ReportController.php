<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $period = $request->get('period', '30');
        $from = now()->subDays((int) $period)->startOfDay();
        $to = now()->endOfDay();

        $transactions = Transaction::where('user_id', auth()->id())
            ->whereBetween('processed_at', [$from, $to])
            ->orderBy('processed_at', 'desc')
            ->get();

        $daily = [];
        for ($i = (int) $period; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $daily[$date] = [
                'revenue' => 0,
                'count' => 0,
                'success' => 0,
                'failed' => 0,
            ];
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
        ];

        $methods = $transactions->where('status', 'success')->groupBy('method')->map(fn($g) => [
            'count' => $g->count(),
            'amount' => $g->sum('amount'),
        ]);

        return view('user.reports.index', compact('transactions', 'daily', 'summary', 'methods', 'period'));
    }
}
