@extends('layouts.user')

@section('title', 'Merchant Dashboard - SalamaPay')
@section('page_title', 'Dashboard')

@section('content')

@php
    $fn = function($n) {
        if ($n >= 1000000) return 'TZS ' . number_format($n / 1000000, 2) . 'M';
        if ($n >= 1000) return 'TZS ' . number_format($n / 1000, 1) . 'K';
        return 'TZS ' . number_format($n);
    };
@endphp

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5 mb-8">
    {{-- Total Balance --}}
    <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
        <div class="flex items-start justify-between mb-3 lg:mb-4">
            <div class="w-9 h-9 lg:w-12 lg:h-12 rounded-lg lg:rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 lg:w-6 lg:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                {{ $balanceChange > 0 ? '+' . $balanceChange : $balanceChange }}%
            </span>
        </div>
        <p class="text-lg lg:text-3xl font-extrabold text-gray-900 tracking-tight">{{ $fn($totalBalance) }}</p>
        <p class="text-xs lg:text-sm text-gray-500 mt-1 font-medium">Total Balance</p>
        <p class="hidden lg:block text-xs text-gray-400 mt-0.5">vs last week</p>
    </div>

    {{-- Total Transactions --}}
    <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
        <div class="flex items-start justify-between mb-3 lg:mb-4">
            <div class="w-9 h-9 lg:w-12 lg:h-12 rounded-lg lg:rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-4 h-4 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                {{ $txChange > 0 ? '+' . $txChange : $txChange }}%
            </span>
        </div>
        <p class="text-lg lg:text-3xl font-extrabold text-gray-900 tracking-tight">{{ number_format($totalTransactions) }}</p>
        <p class="text-xs lg:text-sm text-gray-500 mt-1 font-medium">Total Transactions</p>
        <p class="hidden lg:block text-xs text-gray-400 mt-0.5">vs last week</p>
    </div>

    {{-- Active Payment Links --}}
    <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
        <div class="flex items-start justify-between mb-3 lg:mb-4">
            <div class="w-9 h-9 lg:w-12 lg:h-12 rounded-lg lg:rounded-xl bg-gold-50 flex items-center justify-center">
                <svg class="w-4 h-4 lg:w-6 lg:h-6 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ $newPaymentLinks }} new
            </span>
        </div>
        <p class="text-lg lg:text-3xl font-extrabold text-gray-900 tracking-tight">{{ $activePaymentLinks }}</p>
        <p class="text-xs lg:text-sm text-gray-500 mt-1 font-medium">Payment Links</p>
        <p class="hidden lg:block text-xs text-gray-400 mt-0.5">vs last week</p>
    </div>

    {{-- Revenue Today --}}
    <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
        <div class="flex items-start justify-between mb-3 lg:mb-4">
            <div class="w-9 h-9 lg:w-12 lg:h-12 rounded-lg lg:rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="w-4 h-4 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                {{ $todayChange > 0 ? '+' . $todayChange : $todayChange }}%
            </span>
        </div>
        <p class="text-lg lg:text-3xl font-extrabold text-gray-900 tracking-tight">{{ $fn($revenueToday) }}</p>
        <p class="text-xs lg:text-sm text-gray-500 mt-1 font-medium">Revenue Today</p>
        <p class="hidden lg:block text-xs text-gray-400 mt-0.5">vs yesterday</p>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Revenue Chart --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Revenue</h3>
                <p class="text-xs text-gray-400 mt-0.5">Last 7 days</p>
            </div>
            <div class="text-right">
                <p class="text-xl font-extrabold text-gray-900">{{ $fn($weeklyRevenue) }}</p>
                <p class="text-xs font-medium text-emerald-600">{{ $weeklyRevenueChange > 0 ? '+' . $weeklyRevenueChange : $weeklyRevenueChange }}%</p>
            </div>
        </div>
        <div class="flex items-end gap-2 h-40">
            @foreach($revenueDays as $i => $rev)
                @php
                    $max = max($revenueDays) ?: 1;
                    $pct = ($rev / $max) * 100;
                    $isToday = $i === count($revenueDays) - 1;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-2 group">
                    <div class="w-full bg-gray-100 rounded-t-lg relative h-32 overflow-hidden">
                        <div class="absolute bottom-0 left-0 right-0 rounded-t-lg transition-all duration-500 {{ $isToday ? 'bg-emerald-500' : 'bg-emerald-200 group-hover:bg-emerald-300' }}" style="height: {{ $pct }}%"></div>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">{{ $dayLabels[$i] }}</span>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-2">
            <span>0</span>
            <span>{{ $fn($max / 4) }}</span>
            <span>{{ $fn($max / 2) }}</span>
            <span>{{ $fn($max * 0.75) }}</span>
            <span>{{ $fn($max) }}</span>
        </div>
    </div>

    {{-- Transaction Volume Chart --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Transaction volume</h3>
                <p class="text-xs text-gray-400 mt-0.5">Last 7 days</p>
            </div>
        </div>
        <div class="flex items-end gap-2 h-40">
            @foreach($volumeDays as $i => $vol)
                @php
                    $maxVol = max($volumeDays) ?: 1;
                    $pctVol = ($vol / $maxVol) * 100;
                    $isTodayVol = $i === count($volumeDays) - 1;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-2 group">
                    <div class="w-full bg-gray-100 rounded-t-lg relative h-32 overflow-hidden">
                        <div class="absolute bottom-0 left-0 right-0 rounded-t-lg transition-all duration-500 {{ $isTodayVol ? 'bg-gold-400' : 'bg-gold-200 group-hover:bg-gold-300' }}" style="height: {{ $pctVol }}%"></div>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">{{ $dayLabels[$i] }}</span>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-2">
            <span>0</span>
            <span>{{ round($maxVol / 4) }}</span>
            <span>{{ round($maxVol / 2) }}</span>
            <span>{{ round($maxVol * 0.75) }}</span>
            <span>{{ round($maxVol) }}</span>
        </div>
    </div>
</div>

{{-- Recent Activity Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Recent activity</h3>
            <p class="text-xs text-gray-400 mt-0.5">Latest transactions across all channels</p>
        </div>
        <a href="#" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentTransactions as $tx)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-mono font-semibold text-gray-700">{{ $tx->tx_id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white {{ $tx->status === 'success' ? 'bg-emerald-500' : ($tx->status === 'pending' ? 'bg-gold-400' : 'bg-red-400') }}">
                                {{ substr($tx->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $tx->customer_name }}</p>
                                <p class="text-xs text-gray-400">{{ $tx->customer_email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-800">TSh {{ number_format($tx->amount) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $tx->method }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $tx->status === 'success' ? 'bg-emerald-50 text-emerald-600' : ($tx->status === 'pending' ? 'bg-gold-50 text-gold-600' : 'bg-red-50 text-red-600') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $tx->status === 'success' ? 'bg-emerald-500' : ($tx->status === 'pending' ? 'bg-gold-400' : 'bg-red-400') }}"></span>
                            {{ ucfirst($tx->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $tx->processed_at?->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-sm font-medium">No transactions yet</p>
                        <p class="text-xs mt-1">Start accepting payments to see activity here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
