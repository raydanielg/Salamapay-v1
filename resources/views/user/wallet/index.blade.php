@extends('layouts.user')

@section('title', 'Wallet - SalamaPay')
@section('page_title', 'Wallet')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', [
    'title' => 'Wallet',
    'subtitle' => 'Manage your balances and view transaction history',
    'action' => true,
    'actionUrl' => route('user.wallet.withdraw'),
    'actionLabel' => 'Withdraw'
])

@php
$fmt = fn($n) => $n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n));
@endphp

{{-- Balance Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-xl p-5 text-white relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-xs text-emerald-200 font-medium mb-1">Available Balance</p>
            <p class="text-2xl font-bold tracking-tight">TZS {{ number_format($balance->available) }}</p>
            <p class="text-xs text-emerald-300 mt-1">Ready to withdraw</p>
        </div>
        <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full bg-white/5"></div>
    </div>
    <div class="bg-white rounded-xl border p-5">
        <p class="text-xs text-gray-500 font-medium mb-1">Pending</p>
        <p class="text-2xl font-bold text-gray-900 tracking-tight">TZS {{ number_format($balance->pending) }}</p>
        <p class="text-xs text-amber-600 mt-1">Awaiting settlement</p>
    </div>
    <div class="bg-white rounded-xl border p-5">
        <p class="text-xs text-gray-500 font-medium mb-1">Reserved</p>
        <p class="text-2xl font-bold text-gray-900 tracking-tight">TZS {{ number_format($balance->reserved) }}</p>
        <p class="text-xs text-gray-400 mt-1">Held for disputes</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Transactions --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Recent Transactions</h3>
            <a href="{{ route('user.payments') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                        <th class="px-5 py-2.5 font-medium">ID</th>
                        <th class="px-5 py-2.5 font-medium">Amount</th>
                        <th class="px-5 py-2.5 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-2.5 font-mono text-xs text-gray-500">{{ $tx->tx_id }}</td>
                        <td class="px-5 py-2.5 font-semibold text-gray-900">TSh {{ number_format($tx->amount) }}</td>
                        <td class="px-5 py-2.5">
                            @if($tx->status === 'success')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Success</span>
                            @elseif($tx->status === 'pending')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-gray-400 text-xs">No transactions</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Settlements --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Recent Withdrawals</h3>
            <a href="{{ route('user.settlements') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                        <th class="px-5 py-2.5 font-medium">Reference</th>
                        <th class="px-5 py-2.5 font-medium">Amount</th>
                        <th class="px-5 py-2.5 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settlements as $st)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-2.5 font-mono text-xs text-gray-500">{{ $st->reference }}</td>
                        <td class="px-5 py-2.5 font-semibold text-gray-900">TSh {{ number_format($st->amount) }}</td>
                        <td class="px-5 py-2.5">
                            @if($st->status === 'completed')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Completed</span>
                            @elseif($st->status === 'pending')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-gray-400 text-xs">No withdrawals yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
