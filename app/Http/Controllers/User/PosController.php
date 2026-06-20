<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentLink;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $quickLinks = PaymentLink::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $products = Product::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $categories = Product::where('user_id', $user->id)
            ->where('status', 'active')
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        $settings = [
            'tax_rate' => $user->tax_rate ?? 18,
            'currency' => $user->currency ?? 'TZS',
            'currency_symbol' => $user->currency === 'USD' ? '$' : ($user->currency === 'KES' ? 'KSh' : ($user->currency === 'UGX' ? 'USh' : 'TSh')),
            'receipt_footer' => $user->receipt_footer ?? 'Thank you for your business!',
        ];

        return view('user.pos.index', compact('quickLinks', 'products', 'categories', 'settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'method' => 'required|string|max:50',
            'amount_paid' => 'required|numeric|min:0',
            'change' => 'nullable|numeric|min:0',
        ]);

        $user = auth()->user();
        $discount = $validated['discount'] ?? 0;
        $tax = $validated['tax'] ?? 0;

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'tx_id' => 'POS-' . strtoupper(uniqid()),
            'customer_name' => $validated['customer_name'] ?? 'Guest',
            'customer_phone' => $validated['customer_phone'] ?? null,
            'amount' => $validated['total'],
            'discount' => $discount,
            'tax' => $tax,
            'currency' => $user->currency ?? 'TZS',
            'method' => strtoupper($validated['method']),
            'status' => 'success',
            'processed_at' => now(),
            'source_type' => 'product',
            'items' => $validated['items'],
        ]);

        // Reduce product stock
        foreach ($validated['items'] as $item) {
            $product = Product::where('id', $item['id'])->where('user_id', $user->id)->first();
            if ($product) {
                $product->stock = max(0, $product->stock - $item['qty']);
                $product->save();
            }
        }

        return response()->json([
            'success' => true,
            'tx_id' => $transaction->tx_id,
            'message' => 'Sale saved successfully.',
        ]);
    }
}
