<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $links = PaymentLink::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => PaymentLink::where('user_id', auth()->id())->count(),
            'active' => PaymentLink::where('user_id', auth()->id())->where('is_active', true)->count(),
            'expired' => PaymentLink::where('user_id', auth()->id())->whereNotNull('expires_at')->where('expires_at', '<', now())->count(),
            'totalPayments' => PaymentLink::where('user_id', auth()->id())->sum('usage_count'),
        ];

        return view('user.payment-links.index', compact('links', 'stats'));
    }

    public function create()
    {
        return view('user.payment-links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'amount' => 'nullable|numeric|min:100',
            'currency' => 'required|string|max:3',
            'slug' => 'nullable|string|max:100|unique:payment_links,slug',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $slug = $request->slug ?: Str::slug($request->title) . '-' . Str::random(4);

        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (PaymentLink::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        PaymentLink::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency ?? 'TZS',
            'slug' => $slug,
            'is_active' => true,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('user.payment-links')->with('success', 'Payment link created successfully');
    }

    public function update(Request $request, $id)
    {
        $link = PaymentLink::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'amount' => 'nullable|numeric|min:100',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);

        $link->update($request->only(['title', 'description', 'amount', 'is_active', 'expires_at']));

        return back()->with('success', 'Payment link updated');
    }

    public function destroy($id)
    {
        $link = PaymentLink::where('user_id', auth()->id())->findOrFail($id);
        $link->delete();
        return back()->with('success', 'Payment link deleted');
    }
}
