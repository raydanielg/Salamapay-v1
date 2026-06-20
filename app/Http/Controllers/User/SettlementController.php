<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Settlement;

class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settlements = Settlement::where('user_id', auth()->id())
            ->with('bankAccount')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Settlement::where('user_id', auth()->id())->count(),
            'pending' => Settlement::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'completed' => Settlement::where('user_id', auth()->id())->where('status', 'completed')->count(),
            'totalAmount' => Settlement::where('user_id', auth()->id())->where('status', 'completed')->sum('amount'),
        ];

        return view('user.settlements.index', compact('settlements', 'stats'));
    }
}
