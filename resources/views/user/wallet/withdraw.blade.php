@extends('layouts.user')

@section('title', 'Withdraw Funds - SalamaPay')
@section('page_title', 'Withdraw')

@section('content')
<style>
    .form-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .form-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -12px rgba(2,73,56,0.15); }
    .form-input:focus { box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
    .balance-card { background: linear-gradient(135deg, #024938 0%, #013028 100%); }
    .info-card { background: linear-gradient(135deg, #f9ac00 0%, #d49700 100%); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Withdraw Funds', 'subtitle' => 'Transfer money to your bank account or mobile money'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="form-card animate-slide-up bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Withdrawal Details</h3>
                    <p class="text-xs text-gray-400">Transfer funds to your account</p>
                </div>
            </div>

            {{-- Balance Display --}}
            <div class="balance-card rounded-2xl p-5 mb-6 text-white shadow-lg shadow-emerald-900/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-emerald-200 font-medium mb-1">Available Balance</p>
                        <p class="text-2xl font-bold text-white">TZS {{ number_format($balance->available ?? 0, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <form action="{{ route('user.wallet.withdraw.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Destination Account</label>
                    <select name="bank_account_id" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all" required>
                        <option value="">Select account...</option>
                        @foreach($bankAccounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->bank_name }} - {{ $acc->account_name }} ({{ substr($acc->account_number, -4) }})</option>
                        @endforeach
                    </select>
                    @if($bankAccounts->isEmpty())
                    <p class="text-xs text-amber-600 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>No bank accounts. <a href="{{ route('user.business.banks') }}" class="underline font-semibold">Add one</a></p>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Amount (TZS)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">TZS</span>
                        <input type="number" name="amount" min="1000" max="{{ $balance->available ?? 0 }}" class="form-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="Enter amount" required>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Minimum: TZS 1,000 &middot; Fee: 0.5%</p>
                </div>
                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5">Submit Withdrawal</button>
                    <a href="{{ route('user.wallet') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium px-3 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-4">
        <div class="info-card animate-slide-up delay-1 rounded-2xl p-6 text-white shadow-lg shadow-gold-500/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-white">Withdrawal Info</h3>
            </div>
            <ul class="space-y-3 text-xs text-white/90">
                <li class="flex items-start gap-2"><span class="text-white font-bold mt-0.5">&#10003;</span><span>Processing time: 1-2 business days</span></li>
                <li class="flex items-start gap-2"><span class="text-white font-bold mt-0.5">&#10003;</span><span>Fee: 0.5% per withdrawal</span></li>
                <li class="flex items-start gap-2"><span class="text-white font-bold mt-0.5">&#10003;</span><span>Minimum: TZS 1,000</span></li>
                <li class="flex items-start gap-2"><span class="text-white font-bold mt-0.5">&#10003;</span><span>Maximum: Full available balance</span></li>
            </ul>
        </div>

        <div class="form-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Recent Withdrawals</h3>
                </div>
            </div>
            <p class="text-sm text-gray-400 text-center py-4">View all withdrawals on your <a href="{{ route('user.settlements') }}" class="text-emerald-600 font-semibold hover:text-emerald-700">settlements page</a>.</p>
        </div>
    </div>
</div>
@endsection
