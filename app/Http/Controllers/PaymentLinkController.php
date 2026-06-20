<?php

namespace App\Http\Controllers;

use App\Models\PaymentLink;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentLinkController extends Controller
{
    public function show($slug)
    {
        $link = PaymentLink::with('user')->where('slug', $slug)->firstOrFail();

        if (!$link->isValid()) {
            return view('payment.expired', compact('link'));
        }

        $merchant = $link->user;

        return view('payment.checkout', compact('link', 'merchant'));
    }

    public function process(Request $request, $slug)
    {
        $link = PaymentLink::with('user')->where('slug', $slug)->firstOrFail();

        if (!$link->isValid()) {
            return back()->with('error', 'This payment link has expired or is no longer active.');
        }

        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'payment_method' => 'required|in:mpesa,tigopesa,airtelmoney,card,bank',
        ];

        if ($link->amount) {
            $rules['amount'] = 'nullable|numeric|min:100';
        } else {
            $rules['amount'] = 'required|numeric|min:100';
        }

        // Phone required for mobile money
        if (in_array($request->payment_method, ['mpesa', 'tigopesa', 'airtelmoney'])) {
            $rules['phone'] = 'required|string|regex:/^255[0-9]{9}$/';
        }

        $request->validate($rules);

        $amount = $link->amount ?? $request->amount;

        // Create transaction
        $transaction = Transaction::create([
            'user_id' => $link->user_id,
            'tx_id' => 'TX-' . strtoupper(Str::random(10)),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'amount' => $amount,
            'currency' => $link->currency ?? 'TZS',
            'method' => match ($request->payment_method) {
                'mpesa' => 'M-Pesa',
                'tigopesa' => 'Tigo Pesa',
                'airtelmoney' => 'Airtel Money',
                'card' => 'Card',
                'bank' => 'Bank Transfer',
                default => 'Unknown',
            },
            'status' => 'success', // Simulate success for demo
            'processed_at' => now(),
        ]);

        // Increment usage
        $link->increment('usage_count');

        return redirect()->route('payment.success', [
            'slug' => $slug,
            'tx' => $transaction->tx_id,
        ]);
    }

    public function success(Request $request, $slug)
    {
        $link = PaymentLink::with('user')->where('slug', $slug)->firstOrFail();
        $transaction = Transaction::where('tx_id', $request->get('tx'))->firstOrFail();

        return view('payment.success', compact('link', 'transaction'));
    }

    public function receipt(Request $request, $slug)
    {
        $link = PaymentLink::with('user')->where('slug', $slug)->firstOrFail();
        $transaction = Transaction::where('tx_id', $request->get('tx'))->firstOrFail();

        return view('payment.receipt', compact('link', 'transaction'));
    }
}
