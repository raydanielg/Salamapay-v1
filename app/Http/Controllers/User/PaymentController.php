<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PaymentLink;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $payments = Transaction::where('user_id', auth()->id())
            ->orderBy('processed_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Transaction::where('user_id', auth()->id())->count(),
            'success' => Transaction::where('user_id', auth()->id())->where('status', 'success')->count(),
            'pending' => Transaction::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'failed' => Transaction::where('user_id', auth()->id())->where('status', 'failed')->count(),
            'totalRevenue' => Transaction::where('user_id', auth()->id())->where('status', 'success')->sum('amount'),
        ];

        return view('user.payments.index', compact('payments', 'stats'));
    }

    public function create()
    {
        $links = PaymentLink::where('user_id', auth()->id())->where('is_active', true)->get();
        return view('user.payments.create', compact('links'));
    }

    public function show($id)
    {
        $payment = Transaction::where('user_id', auth()->id())->findOrFail($id);
        return view('user.payments.show', compact('payment'));
    }
}
