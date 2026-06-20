@extends('layouts.user')

@section('title', 'Dashboard - SalamaPay')
@section('page_title', 'Dashboard')

@section('content')

@php
    $fmt = function($n) {
        if ($n >= 1000000) return number_format($n / 1000000, 2) . 'M';
        if ($n >= 1000) return number_format($n / 1000, 1) . 'K';
        return number_format($n);
    };
    $fmtTz = function($n) {
        if ($n >= 1000000) return 'TZS ' . number_format($n / 1000000, 2) . 'M';
        if ($n >= 1000) return 'TZS ' . number_format($n / 1000, 1) . 'K';
        return 'TZS ' . number_format($n);
    };
@endphp

<style>
    .card-sm { transition: all 0.2s cubic-bezier(0.4,0,0.2,1); }
    .card-sm:hover { transform: translateY(-2px); box-shadow: 0 8px 30px -8px rgba(0,0,0,0.1); }
    .bar-rev { background: linear-gradient(180deg, #10b981 0%, #059669 100%); }
    .bar-rev-past { background: linear-gradient(180deg, #d1fae5 0%, #a7f3d0 100%); }
    .bar-rev-past:hover { background: linear-gradient(180deg, #34d399 0%, #10b981 100%); }
    .bar-vol { background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); }
    .bar-vol-past { background: linear-gradient(180deg, #fef3c7 0%, #fde68a 100%); }
    .bar-vol-past:hover { background: linear-gradient(180deg, #fbbf24 0%, #f59e0b 100%); }
    .mini-spark { stroke-dasharray: 60; stroke-dashoffset: 60; animation: spark 1s ease forwards; }
    @keyframes spark { to { stroke-dashoffset: 0; } }
</style>

{{-- Welcome --}}
<div class="mb-6">
    <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->first_name ?? 'Merchant' }}</h1>
    <p class="text-sm text-gray-500 mt-0.5">Here's what's happening with your payments today.</p>
</div>

{{-- Compact Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <div class="card-sm bg-white rounded-lg border p-3 lg:p-4">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-7 h-7 rounded-md bg-emerald-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">+{{ $balanceChange }}%</span>
        </div>
        <p class="text-base lg:text-xl font-bold text-gray-900">{{ $fmtTz($totalBalance) }}</p>
        <p class="text-[11px] text-gray-500 mt-0.5">Total Balance</p>
    </div>

    <div class="card-sm bg-white rounded-lg border p-3 lg:p-4">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-7 h-7 rounded-md bg-blue-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded">+{{ $txChange }}%</span>
        </div>
        <p class="text-base lg:text-xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</p>
        <p class="text-[11px] text-gray-500 mt-0.5">Transactions</p>
    </div>

    <div class="card-sm bg-white rounded-lg border p-3 lg:p-4">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-7 h-7 rounded-md bg-amber-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded">+{{ $newPaymentLinks }}</span>
        </div>
        <p class="text-base lg:text-xl font-bold text-gray-900">{{ $activePaymentLinks }}</p>
        <p class="text-[11px] text-gray-500 mt-0.5">Payment Links</p>
    </div>

    <div class="card-sm bg-white rounded-lg border p-3 lg:p-4">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-7 h-7 rounded-md bg-violet-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-[10px] font-semibold text-violet-700 bg-violet-50 px-1.5 py-0.5 rounded">+{{ $todayChange }}%</span>
        </div>
        <p class="text-base lg:text-xl font-bold text-gray-900">{{ $fmtTz($revenueToday) }}</p>
        <p class="text-[11px] text-gray-500 mt-0.5">Revenue Today</p>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    {{-- Revenue Chart --}}
    <div class="bg-white rounded-xl border p-4 lg:p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Revenue</h3>
                <p class="text-xs text-gray-400">Last 7 days</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-bold text-gray-900">{{ $fmtTz($weeklyRevenue) }}</p>
                <p class="text-[10px] font-medium text-emerald-600">{{ $weeklyRevenueChange > 0 ? '+' . $weeklyRevenueChange : $weeklyRevenueChange }}%</p>
            </div>
        </div>
        <div class="flex items-end gap-[6px] h-32">
            @foreach($revenueDays as $i => $rev)
                @php
                    $max = max($revenueDays) ?: 1;
                    $pct = ($rev / $max) * 100;
                    $isToday = $i === count($revenueDays) - 1;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1.5 group cursor-pointer">
                    <div class="w-full bg-gray-50 rounded-t-md relative h-24 overflow-hidden">
                        <div class="absolute bottom-0 left-0 right-0 rounded-t-md transition-all duration-300 {{ $isToday ? 'bar-rev' : 'bar-rev-past' }}" style="height: {{ max($pct, 4) }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium">{{ $dayLabels[$i] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Transaction Volume Chart --}}
    <div class="bg-white rounded-xl border p-4 lg:p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Transaction volume</h3>
                <p class="text-xs text-gray-400">Last 7 days</p>
            </div>
        </div>
        <div class="flex items-end gap-[6px] h-32">
            @foreach($volumeDays as $i => $vol)
                @php
                    $maxVol = max($volumeDays) ?: 1;
                    $pctVol = ($vol / $maxVol) * 100;
                    $isTodayVol = $i === count($volumeDays) - 1;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1.5 group cursor-pointer">
                    <div class="w-full bg-gray-50 rounded-t-md relative h-24 overflow-hidden">
                        <div class="absolute bottom-0 left-0 right-0 rounded-t-md transition-all duration-300 {{ $isTodayVol ? 'bar-vol' : 'bar-vol-past' }}" style="height: {{ max($pctVol, 4) }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium">{{ $dayLabels[$i] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Recent Activity Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-4 lg:px-5 py-4 border-b flex items-center justify-between">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Recent activity</h3>
            <p class="text-[11px] text-gray-400 mt-0.5">Latest transactions across all channels</p>
        </div>
        <a href="#" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b bg-gray-50/50">
                    <th class="px-4 lg:px-5 py-2.5 text-[11px] font-semibold text-gray-500 uppercase">ID</th>
                    <th class="px-4 lg:px-5 py-2.5 text-[11px] font-semibold text-gray-500 uppercase">Customer</th>
                    <th class="px-4 lg:px-5 py-2.5 text-[11px] font-semibold text-gray-500 uppercase">Amount</th>
                    <th class="px-4 lg:px-5 py-2.5 text-[11px] font-semibold text-gray-500 uppercase">Method</th>
                    <th class="px-4 lg:px-5 py-2.5 text-[11px] font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 lg:px-5 py-2.5 text-[11px] font-semibold text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentTransactions as $tx)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-4 lg:px-5 py-3 text-xs font-mono font-medium text-gray-700">{{ $tx->tx_id }}</td>
                    <td class="px-4 lg:px-5 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white {{ $tx->status === 'success' ? 'bg-emerald-500' : ($tx->status === 'pending' ? 'bg-amber-400' : 'bg-red-400') }}">
                                {{ substr($tx->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-800">{{ $tx->customer_name }}</p>
                                <p class="text-[10px] text-gray-400">{{ $tx->customer_email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 lg:px-5 py-3 text-xs font-semibold text-gray-800">TSh {{ number_format($tx->amount) }}</td>
                    <td class="px-4 lg:px-5 py-3 text-xs text-gray-600">{{ $tx->method }}</td>
                    <td class="px-4 lg:px-5 py-3">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $tx->status === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($tx->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-red-50 text-red-700 border border-red-100') }}">
                            <span class="w-1 h-1 rounded-full {{ $tx->status === 'success' ? 'bg-emerald-500' : ($tx->status === 'pending' ? 'bg-amber-400' : 'bg-red-400') }}"></span>
                            {{ ucfirst($tx->status) }}
                        </span>
                    </td>
                    <td class="px-4 lg:px-5 py-3 text-xs text-gray-400">{{ $tx->processed_at?->format('M d, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-xs font-medium">No transactions yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Mobile Bottom Nav --}}
<div class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur border-t border-gray-200 lg:hidden">
    <div class="flex items-center justify-around py-1.5 px-2 max-w-lg mx-auto">
        <a href="#" class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-lg active:scale-95 transition-transform">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span class="text-[9px] font-medium text-gray-500">Pay</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-lg active:scale-95 transition-transform">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            <span class="text-[9px] font-medium text-gray-500">Withdraw</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-lg active:scale-95 transition-transform">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            <span class="text-[9px] font-medium text-gray-500">Link</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-lg active:scale-95 transition-transform">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span class="text-[9px] font-medium text-gray-500">Reports</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-lg active:scale-95 transition-transform">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-[9px] font-medium text-gray-500">Settings</span>
        </a>
    </div>
</div>

<div class="h-16 lg:hidden"></div>

@endsection
