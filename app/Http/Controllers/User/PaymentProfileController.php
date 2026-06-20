<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentProfile;
use Illuminate\Http\Request;

class PaymentProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = PaymentProfile::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%");
            });
        }

        $profiles = $query->with('paymentLinks')->orderBy('name')->get();
        return view('user.payment-profiles.index', compact('profiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_tin' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'logo' => 'nullable|image|max:5120',
            'page_type' => 'required|in:catalog,fixed',
            'allow_custom_amount' => 'boolean',
            'products' => 'nullable|array',
            'website_url' => 'nullable|url|max:255',
            'language' => 'nullable|string|max:10',
            'success_url' => 'nullable|url|max:255',
            'webhook_url' => 'nullable|url|max:255',
            'require_email' => 'boolean',
            'accepted_methods' => 'nullable|array',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'name' => $request->name,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'business_tin' => $request->business_tin,
            'phone' => $request->phone,
            'email' => $request->email,
            'website_url' => $request->website_url,
            'description' => $request->description,
            'color' => $request->color ?? '#024938',
            'language' => $request->language ?? 'en',
            'page_type' => $request->page_type,
            'allow_custom_amount' => $request->boolean('allow_custom_amount', false),
            'products' => $request->products ?? null,
            'success_url' => $request->success_url,
            'webhook_url' => $request->webhook_url,
            'require_email' => $request->boolean('require_email', true),
            'accepted_methods' => $request->accepted_methods ?? ['mobile_money','card'],
            'is_default' => $request->boolean('is_default', false),
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profile-logos', 'public');
        }

        $isFirst = !PaymentProfile::where('user_id', auth()->id())->exists();
        if ($isFirst) {
            $data['is_default'] = true;
        }

        PaymentProfile::create($data);

        return redirect()->route('user.payment-profiles')->with('success', 'Profile created successfully');
    }

    public function update(Request $request, $id)
    {
        $profile = PaymentProfile::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_tin' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'logo' => 'nullable|image|max:5120',
            'page_type' => 'required|in:catalog,fixed',
            'allow_custom_amount' => 'boolean',
            'products' => 'nullable|array',
            'website_url' => 'nullable|url|max:255',
            'language' => 'nullable|string|max:10',
            'success_url' => 'nullable|url|max:255',
            'webhook_url' => 'nullable|url|max:255',
            'require_email' => 'boolean',
            'accepted_methods' => 'nullable|array',
            'is_default' => 'boolean',
        ]);

        $data = $request->only([
            'name', 'business_name', 'business_type', 'business_tin',
            'phone', 'email', 'website_url', 'description', 'color', 'language',
            'page_type', 'allow_custom_amount', 'products', 'success_url',
            'webhook_url', 'require_email', 'accepted_methods', 'is_default'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profile-logos', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Profile updated');
    }

    public function destroy($id)
    {
        $profile = PaymentProfile::where('user_id', auth()->id())->findOrFail($id);
        $profile->delete();
        return back()->with('success', 'Profile deleted');
    }
}
