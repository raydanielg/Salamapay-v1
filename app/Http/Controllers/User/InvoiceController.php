<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $invoices = Transaction::where('user_id', auth()->id())
            ->orderBy('processed_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Transaction::where('user_id', auth()->id())->count(),
            'paid' => Transaction::where('user_id', auth()->id())->where('status', 'success')->count(),
            'pending' => Transaction::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'totalAmount' => Transaction::where('user_id', auth()->id())->where('status', 'success')->sum('amount'),
        ];

        return view('user.invoices.index', compact('invoices', 'stats'));
    }
}
