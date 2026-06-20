<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settlement;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Settlement::with('user', 'bankAccount');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $settlements = $query->orderBy('created_at', 'desc')->paginate(25);

        $stats = [
            'total' => Settlement::count(),
            'pending' => Settlement::where('status', 'pending')->count(),
            'processing' => Settlement::where('status', 'processing')->count(),
            'completed' => Settlement::where('status', 'completed')->count(),
            'failed' => Settlement::where('status', 'failed')->count(),
            'totalAmount' => Settlement::where('status', 'completed')->sum('amount'),
            'pendingAmount' => Settlement::where('status', 'pending')->sum('amount'),
        ];

        return view('admin.settlements.index', compact('settlements', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,completed,failed']);
        $settlement = Settlement::findOrFail($id);

        if ($request->status === 'completed' && $settlement->status !== 'completed') {
            $settlement->processed_at = now();
        }

        $settlement->status = $request->status;
        $settlement->save();

        return back()->with('success', 'Settlement status updated');
    }
}
