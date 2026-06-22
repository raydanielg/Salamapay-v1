<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $period = (int) ($request->query('period', 30));
        $from   = now()->subDays($period)->startOfDay();

        $transactions = Transaction::where('user_id', $request->user()->id)
            ->where('created_at', '>=', $from)
            ->latest()
            ->get()
            ->map(fn($tx) => [
                'id'            => $tx->id,
                'tx_id'         => $tx->tx_id ?? '#' . $tx->id,
                'customer_name' => $tx->customer_name,
                'amount'        => $tx->amount,
                'method'        => $tx->payment_method ?? 'cash',
                'status'        => $tx->status,
                'source_type'   => $tx->source_type ?? null,
                'source_name'   => $tx->source_name ?? null,
                'processed_at'  => $tx->created_at?->toIso8601String(),
            ]);

        return response()->json(['data' => $transactions]);
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        $transaction->delete();

        return response()->json(['message' => 'Muamala umefutwa.']);
    }
}
