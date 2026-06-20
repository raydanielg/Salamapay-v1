@extends('layouts.user')

@section('title', 'Withdraw Funds - SalamaPay')
@section('page_title', 'Withdraw')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Withdraw Funds', 'subtitle' => 'Transfer money to your bank account or mobile money'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Withdrawal Details</h3>
            <form action="{{ route('user.wallet.withdraw.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Available Balance</label>
                    <div class="px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-100 text-sm font-semibold text-gray-900">TZS {{ number_format($balance->available) }}</div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Destination Account</label>
                    <select name="bank_account_id" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white" required>
                        <option value="">Select account...</option>
                        @foreach($bankAccounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->bank_name }} - {{ $acc->account_name }} ({{ substr($acc->account_number, -4) }})</option>
                        @endforeach
                    </select>
                    @if($bankAccounts->isEmpty())
                    <p class="text-xs text-amber-600 mt-1">No bank accounts found. <a href="{{ route('user.business.banks') }}" class="underline">Add one</a></p>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Amount (TZS)</label>
                    <input type="number" name="amount" min="1000" max="{{ $balance->available }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="Enter amount" required>
                    <p class="text-xs text-gray-400 mt-1">Minimum withdrawal: TZS 1,000. Fee: 0.5%</p>
                </div>
                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Submit Withdrawal</button>
                    <a href="{{ route('user.wallet') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-emerald-900 rounded-xl p-5 text-white">
            <h3 class="text-sm font-semibold mb-2">Withdrawal Info</h3>
            <ul class="space-y-2 text-xs text-emerald-200">
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">&#10003;</span>Processing time: 1-2 business days</li>
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">&#10003;</span>Fee: 0.5% per withdrawal</li>
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">&#10003;</span>Minimum: TZS 1,000</li>
            </ul>
        </div>
    </div>
</div>
@endsection
