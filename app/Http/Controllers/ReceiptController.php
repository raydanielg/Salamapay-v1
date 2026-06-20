<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Show a public shareable receipt (no auth required).
     */
    public function show($txId)
    {
        $transaction = Transaction::where('tx_id', $txId)->firstOrFail();
        $merchantName = $transaction->user?->business_name ?? ($transaction->user?->first_name . ' ' . $transaction->user?->last_name);

        return view('receipt.public', compact('transaction', 'merchantName'));
    }
}
