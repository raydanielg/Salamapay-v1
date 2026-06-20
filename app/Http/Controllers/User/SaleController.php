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

    public function index()
    {
        $sales = Transaction::where('user_id', auth()->id())
            ->where('status', 'success')
            ->orderBy('processed_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Transaction::where('user_id', auth()->id())->where('status', 'success')->count(),
            'today' => Transaction::where('user_id', auth()->id())->where('status', 'success')->whereDate('processed_at', today())->count(),
            'week' => Transaction::where('user_id', auth()->id())->where('status', 'success')->whereBetween('processed_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month' => Transaction::where('user_id', auth()->id())->where('status', 'success')->whereBetween('processed_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'totalAmount' => Transaction::where('user_id', auth()->id())->where('status', 'success')->sum('amount'),
        ];

        return view('user.sales.index', compact('sales', 'stats'));
    }
}
