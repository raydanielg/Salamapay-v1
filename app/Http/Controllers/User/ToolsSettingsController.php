<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolsSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $settings = [
            'pos_enabled' => $user->pos_enabled ?? true,
            'auto_receipt' => $user->auto_receipt ?? false,
            'tax_rate' => $user->tax_rate ?? 18.00,
            'currency' => $user->currency ?? 'TZS',
            'receipt_footer' => $user->receipt_footer ?? 'Thank you for your business!',
        ];

        return view('user.tools.settings', compact('user', 'settings'));
    }

    public function updateBusiness(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_tin' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'email' => 'required|email|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|max:2048']);
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $user->update($validated);

        return redirect()->route('user.tools.settings')
            ->with('success', 'Business information updated successfully.');
    }

    public function updateTools(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'pos_enabled' => 'boolean',
            'auto_receipt' => 'boolean',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|max:10',
            'receipt_footer' => 'nullable|string|max:255',
        ]);

        $validated['pos_enabled'] = $request->boolean('pos_enabled');
        $validated['auto_receipt'] = $request->boolean('auto_receipt');

        $user->update($validated);

        return redirect()->route('user.tools.settings')
            ->with('success', 'Tools settings updated successfully.');
    }
}
