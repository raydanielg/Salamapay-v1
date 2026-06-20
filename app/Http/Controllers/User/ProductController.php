<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Product::forUser(auth()->id());

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Product::forUser(auth()->id())->select('category')->distinct()->pluck('category')->filter();

        $stats = [
            'total' => Product::forUser(auth()->id())->count(),
            'active' => Product::forUser(auth()->id())->active()->count(),
            'draft' => Product::forUser(auth()->id())->where('status', 'draft')->count(),
            'lowStock' => Product::forUser(auth()->id())->where('stock', '<=', 5)->count(),
        ];

        return view('user.products.index', compact('products', 'stats', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'status' => 'required|in:active,draft,archived',
        ]);

        $validated['user_id'] = auth()->id();
        Product::create($validated);

        return redirect()->route('user.products')->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'status' => 'required|in:active,draft,archived',
        ]);

        $product->update($validated);

        return redirect()->route('user.products')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $product->delete();
        return redirect()->route('user.products')->with('success', 'Product deleted successfully.');
    }
}
