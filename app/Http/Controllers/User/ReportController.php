<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $userId = auth()->id();

        // Sales transactions
        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('processed_at', [$from, $to])
            ->orderBy('processed_at', 'desc')
            ->get();

        // Daily chart data
        $daily = [];
        for ($i = (int) $period; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $daily[$date] = [
                'revenue' => 0,
                'count' => 0,
                'success' => 0,
                'failed' => 0,
                'product' => 0,
                'service' => 0,
            ];
        }

        foreach ($transactions as $tx) {
            $d = $tx->processed_at?->format('Y-m-d');
            if ($d && isset($daily[$d])) {
                $daily[$d]['count']++;
                if ($tx->status === 'success') {
                    $daily[$d]['revenue'] += $tx->amount;
                    $daily[$d]['success']++;
                    if ($tx->source_type === 'product') $daily[$d]['product'] += $tx->amount;
                    elseif ($tx->source_type === 'service') $daily[$d]['service'] += $tx->amount;
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
            'product_revenue' => $transactions->where('status', 'success')->where('source_type', 'product')->sum('amount'),
            'service_revenue' => $transactions->where('status', 'success')->where('source_type', 'service')->sum('amount'),
        ];

        // Payment methods
        $methods = $transactions->where('status', 'success')->groupBy('method')->map(fn($g) => [
            'count' => $g->count(),
            'amount' => $g->sum('amount'),
        ]);

        // Product vs Service split (all time)
        $productVsService = [
            'product' => Transaction::where('user_id', $userId)->where('status', 'success')->where('source_type', 'product')->sum('amount'),
            'service' => Transaction::where('user_id', $userId)->where('status', 'success')->where('source_type', 'service')->sum('amount'),
            'other' => Transaction::where('user_id', $userId)->where('status', 'success')->whereNotIn('source_type', ['product', 'service'])->sum('amount'),
        ];

        // Invoice stats
        $invoiceStats = [
            'total' => Invoice::forUser($userId)->count(),
            'paid' => Invoice::forUser($userId)->where('status', 'paid')->count(),
            'pending' => Invoice::forUser($userId)->whereIn('status', ['draft', 'sent'])->count(),
            'overdue' => Invoice::forUser($userId)->where('status', 'overdue')->count(),
            'paid_amount' => Invoice::forUser($userId)->where('status', 'paid')->sum('total'),
            'pending_amount' => Invoice::forUser($userId)->whereIn('status', ['draft', 'sent', 'overdue'])->sum('total'),
        ];

        // Product inventory
        $productStats = [
            'total' => Product::where('user_id', $userId)->count(),
            'active' => Product::where('user_id', $userId)->where('status', 'active')->count(),
            'low_stock' => Product::where('user_id', $userId)->whereColumn('stock', '<=', DB::raw('alert_stock'))->where('status', 'active')->count(),
            'out_of_stock' => Product::where('user_id', $userId)->where('stock', '<=', 0)->where('status', 'active')->count(),
        ];

        $servicesCount = Service::where('user_id', $userId)->count();

        // Top products sold (period)
        $topProducts = [];
        $allTxItems = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->whereBetween('processed_at', [$from, $to])
            ->get();
        $productSales = [];
        foreach ($allTxItems as $tx) {
            foreach ($tx->items ?? [] as $item) {
                if (($item['type'] ?? '') === 'product') {
                    $pid = $item['id'];
                    $pname = $item['name'];
                    if (!isset($productSales[$pid])) $productSales[$pid] = ['name' => $pname, 'qty' => 0, 'revenue' => 0];
                    $productSales[$pid]['qty'] += ($item['qty'] ?? 1);
                    $productSales[$pid]['revenue'] += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
                }
            }
        }
        usort($productSales, fn($a, $b) => $b['revenue'] - $a['revenue']);
        $topProducts = array_slice($productSales, 0, 5);

        // Top customers (period)
        $topCustomers = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->whereBetween('processed_at', [$from, $to])
            ->select('customer_name', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->whereNotNull('customer_name')
            ->groupBy('customer_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Recent transactions (for table)
        $recentTransactions = Transaction::where('user_id', $userId)
            ->whereBetween('processed_at', [$from, $to])
            ->orderBy('processed_at', 'desc')
            ->take(10)
            ->get();

        if ($request->ajax()) {
            return view('user.reports._table', compact('recentTransactions'))->render();
        }

        return view('user.reports.index', compact(
            'daily', 'summary', 'methods', 'period', 'productVsService',
            'invoiceStats', 'productStats', 'servicesCount', 'topProducts',
            'topCustomers', 'recentTransactions'
        ));
    }
}
