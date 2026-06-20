<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(auth()->id());
        return view('user.business.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_address' => 'nullable|string',
            'business_tin' => 'nullable|string|max:50',
        ]);

        $user = User::find(auth()->id());
        $user->update($request->only([
            'first_name', 'last_name', 'phone',
            'business_name', 'business_type', 'business_address', 'business_tin'
        ]));

        return back()->with('success', 'Business profile updated successfully');
    }

    public function banks()
    {
        $accounts = BankAccount::where('user_id', auth()->id())->orderBy('is_default', 'desc')->get();
        return view('user.business.banks', compact('accounts'));
    }

    public function storeBank(Request $request)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'type' => 'required|in:bank,mobile_money',
        ]);

        if ($request->boolean('is_default')) {
            BankAccount::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        BankAccount::create(array_merge($request->all(), [
            'user_id' => auth()->id(),
        ]));

        return back()->with('success', 'Bank account added successfully');
    }

    public function destroyBank($id)
    {
        $account = BankAccount::where('user_id', auth()->id())->findOrFail($id);
        $account->delete();
        return back()->with('success', 'Bank account removed');
    }
}
