<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentLink;
use App\Models\PaymentProfile;
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
        $profiles = PaymentProfile::where('user_id', auth()->id())->orderBy('is_default', 'desc')->orderBy('name')->get();
        return view('user.payment-links.create', compact('profiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'profile_id' => 'nullable|exists:payment_profiles,id',
            'amount' => 'nullable|numeric|min:100',
            'currency' => 'required|string|max:3',
            'slug' => 'nullable|string|max:100|unique:payment_links,slug',
            'expires_at' => 'nullable|date|after:now',
            'custom_fields' => 'nullable|string|max:2000',
        ]);

        $slug = $request->slug ?: Str::slug($request->title) . '-' . Str::random(4);

        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (PaymentLink::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Parse custom fields from JSON string
        $customFields = null;
        if ($request->filled('custom_fields')) {
            $customFields = json_decode($request->custom_fields, true);
        }

        // Validate profile ownership
        $profileId = $request->profile_id;
        if ($profileId) {
            $validProfile = PaymentProfile::where('id', $profileId)->where('user_id', auth()->id())->exists();
            if (!$validProfile) {
                $profileId = null;
            }
        }

        PaymentLink::create([
            'user_id' => auth()->id(),
            'profile_id' => $profileId,
            'title' => $request->title,
            'description' => $request->description,
            'custom_fields' => $customFields,
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

    public function show($id)
    {
        $link = PaymentLink::with('profile')->where('user_id', auth()->id())->findOrFail($id);
        return view('user.payment-links.show', compact('link'));
    }

    public function destroy($id)
    {
        $link = PaymentLink::where('user_id', auth()->id())->findOrFail($id);
        $link->delete();
        return back()->with('success', 'Payment link deleted');
    }
}
