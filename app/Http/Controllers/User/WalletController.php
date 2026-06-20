<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\BankAccount;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $balance = Balance::firstOrCreate(
            ['user_id' => auth()->id()],
            ['available' => 0, 'pending' => 0, 'reserved' => 0]
        );

        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('processed_at', 'desc')
            ->take(10)
            ->get();

        $settlements = Settlement::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.wallet.index', compact('balance', 'transactions', 'settlements'));
    }

    public function withdraw()
    {
        $balance = Balance::firstOrCreate(
            ['user_id' => auth()->id()],
            ['available' => 0, 'pending' => 0, 'reserved' => 0]
        );

        $bankAccounts = BankAccount::where('user_id', auth()->id())->get();

        return view('user.wallet.withdraw', compact('balance', 'bankAccounts'));
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $balance = Balance::where('user_id', auth()->id())->first();
        if (!$balance || $balance->available < $request->amount) {
            return back()->with('error', 'Insufficient balance');
        }

        $bankAccount = BankAccount::where('user_id', auth()->id())->findOrFail($request->bank_account_id);

        Settlement::create([
            'user_id' => auth()->id(),
            'reference' => 'STL-' . strtoupper(Str::random(8)),
            'bank_account_id' => $bankAccount->id,
            'amount' => $request->amount,
            'currency' => 'TZS',
            'fee' => $request->amount * 0.005,
            'status' => 'pending',
            'method' => $bankAccount->type,
        ]);

        $balance->available -= $request->amount;
        $balance->save();

        return redirect()->route('user.settlements')->with('success', 'Withdrawal request submitted successfully');
    }
}
