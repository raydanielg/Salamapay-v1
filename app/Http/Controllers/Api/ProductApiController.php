<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    private function format(Product $p): array
    {
        return [
            'id'          => $p->id,
            'name'        => $p->name,
            'description' => $p->description,
            'price'       => $p->price,
            'stock'       => $p->stock ?? null,
            'sku'         => $p->sku ?? null,
            'type'        => $p->type ?? 'product',
            'is_active'   => $p->is_active ?? true,
            'image'       => $p->image ?? null,
        ];
    }

    public function index(Request $request)
    {
        $products = Product::where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(fn($p) => $this->format($p));

        return response()->json(['data' => $products]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'type'        => 'nullable|in:product,service',
        ]);

        $product = Product::create([
            'user_id'     => $request->user()->id,
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'stock'       => $validated['stock'] ?? null,
            'type'        => $validated['type'] ?? 'product',
            'is_active'   => true,
        ]);

        return response()->json(['data' => $this->format($product)], 201);
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'type'        => 'nullable|in:product,service',
            'is_active'   => 'nullable|boolean',
        ]);

        $product->update($validated);

        return response()->json(['data' => $this->format($product)]);
    }

    public function destroy(Request $request, Product $product)
    {
        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Bidhaa imefutwa.']);
    }
}
