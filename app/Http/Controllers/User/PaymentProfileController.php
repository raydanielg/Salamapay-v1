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

    public function index()
    {
        $profiles = PaymentProfile::where('user_id', auth()->id())->orderBy('name')->get();
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
            'is_default' => 'boolean',
        ]);

        $isFirst = !PaymentProfile::where('user_id', auth()->id())->exists();

        PaymentProfile::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'business_tin' => $request->business_tin,
            'phone' => $request->phone,
            'email' => $request->email,
            'description' => $request->description,
            'color' => $request->color ?? '#024938',
            'is_default' => $request->boolean('is_default', false) || $isFirst,
        ]);

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
            'is_default' => 'boolean',
        ]);

        $profile->update($request->only(['name', 'business_name', 'business_type', 'business_tin', 'phone', 'email', 'description', 'color', 'is_default']));

        return back()->with('success', 'Profile updated');
    }

    public function destroy($id)
    {
        $profile = PaymentProfile::where('user_id', auth()->id())->findOrFail($id);
        $profile->delete();
        return back()->with('success', 'Profile deleted');
    }
}
