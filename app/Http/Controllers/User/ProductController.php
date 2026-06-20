<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = [
            ['name' => 'Premium Plan', 'price' => 50000, 'status' => 'active', 'sold' => 128],
            ['name' => 'Basic Plan', 'price' => 25000, 'status' => 'active', 'sold' => 340],
            ['name' => 'Enterprise Plan', 'price' => 120000, 'status' => 'active', 'sold' => 45],
            ['name' => 'Consultation', 'price' => 30000, 'status' => 'draft', 'sold' => 12],
            ['name' => 'Support Package', 'price' => 15000, 'status' => 'active', 'sold' => 89],
        ];

        $stats = [
            'total' => 5,
            'active' => 4,
            'draft' => 1,
            'totalSold' => 614,
        ];

        return view('user.products.index', compact('products', 'stats'));
    }
}
