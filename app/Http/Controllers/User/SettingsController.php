<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(auth()->id());
        return view('user.settings.index', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:100',
        ]);

        $user = User::find(auth()->id());
        $user->update($request->only(['first_name', 'last_name', 'phone', 'business_name', 'business_type']));

        return back()->with('success', 'Account settings updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::find(auth()->id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully');
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'preferred_method' => 'nullable|string|max:50',
            'auto_withdraw' => 'boolean',
            'withdraw_threshold' => 'nullable|numeric|min:0',
        ]);

        $user = User::find(auth()->id());
        $settings = json_decode($user->settings ?? '{}', true);
        $settings['payment'] = $request->only(['preferred_method', 'auto_withdraw', 'withdraw_threshold']);
        $user->update(['settings' => json_encode($settings)]);

        return back()->with('success', 'Payment settings updated');
    }
}
