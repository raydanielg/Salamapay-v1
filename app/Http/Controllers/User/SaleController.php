<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
            ->where('status', 'success')
            ->orderBy('processed_at', 'desc');

        // Date range filter
        if ($request->filled('range')) {
            switch ($request->range) {
                case 'today':
                    $query->whereDate('processed_at', today());
                    break;
                case '3d':
                    $query->whereDate('processed_at', '>=', now()->subDays(3));
                    break;
                case '7d':
                    $query->whereDate('processed_at', '>=', now()->subDays(7));
                    break;
                case '30d':
                    $query->whereDate('processed_at', '>=', now()->subDays(30));
                    break;
                case '90d':
                    $query->whereDate('processed_at', '>=', now()->subDays(90));
                    break;
                case 'this_month':
                    $query->whereBetween('processed_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
            }
        }

        // Search
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('tx_id', 'like', "%{$term}%")
                  ->orWhere('customer_name', 'like', "%{$term}%")
                  ->orWhere('customer_email', 'like', "%{$term}%")
                  ->orWhere('method', 'like', "%{$term}%");
            });
        }

        $sales = $query->paginate(15)->withQueryString();

        // Dynamic stats based on filtered range
        $range = $request->input('range', 'all');
        $baseQuery = Transaction::where('user_id', auth()->id())->where('status', 'success');
        if ($range !== 'all') {
            switch ($range) {
                case 'today': $baseQuery->whereDate('processed_at', today()); break;
                case '3d': $baseQuery->whereDate('processed_at', '>=', now()->subDays(3)); break;
                case '7d': $baseQuery->whereDate('processed_at', '>=', now()->subDays(7)); break;
                case '30d': $baseQuery->whereDate('processed_at', '>=', now()->subDays(30)); break;
                case '90d': $baseQuery->whereDate('processed_at', '>=', now()->subDays(90)); break;
                case 'this_month': $baseQuery->whereBetween('processed_at', [now()->startOfMonth(), now()->endOfMonth()]); break;
            }
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'totalAmount' => (clone $baseQuery)->sum('amount'),
            'avgAmount' => (clone $baseQuery)->avg('amount') ?? 0,
            'productsCount' => (clone $baseQuery)->where('source_type', 'product')->count(),
            'servicesCount' => (clone $baseQuery)->where('source_type', 'service')->count(),
            'range' => $range,
        ];

        if ($request->ajax()) {
            return view('user.sales._table', compact('sales'))->render();
        }

        return view('user.sales.index', compact('sales', 'stats'));
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $transaction->delete();
        return redirect()->route('user.sales')->with('success', 'Sale deleted successfully.');
    }
}
