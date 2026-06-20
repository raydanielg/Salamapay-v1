<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentLink;
use App\Models\Product;
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
}
