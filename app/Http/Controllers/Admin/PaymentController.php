<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('tx_id', 'like', '%' . $request->search . '%');
        }

        $payments = $query->orderBy('processed_at', 'desc')->paginate(25);

        $stats = [
            'total' => Transaction::count(),
            'success' => Transaction::where('status', 'success')->count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'failed' => Transaction::where('status', 'failed')->count(),
            'totalRevenue' => Transaction::where('status', 'success')->sum('amount'),
        ];

        $methods = Transaction::selectRaw('method, COUNT(*) as count, SUM(amount) as total')
            ->where('status', 'success')
            ->groupBy('method')
            ->get();

        return view('admin.payments.index', compact('payments', 'stats', 'methods'));
    }

    public function show($id)
    {
        $payment = Transaction::with('user')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }
}
