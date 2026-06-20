@extends('layouts.user')

@section('title', 'Dashboard - SalamaPay')
@section('page_title', 'Dashboard')

@section('content')

{{-- Skeleton Loading Overlay --}}
<div id="skeletonLoader" class="fixed inset-0 z-50 bg-gray-50" style="transition: opacity 0.4s ease;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-8">
        {{-- Header skeleton --}}
        <div class="mb-6 flex justify-between">
            <div>
                <div class="skeleton skeleton-text-lg w-48 mb-2 rounded-lg"></div>
                <div class="skeleton skeleton-text w-64 rounded-lg"></div>
            </div>
            <div class="flex gap-2">
                <div class="skeleton w-20 h-8 rounded-lg"></div>
                <div class="skeleton w-28 h-8 rounded-lg"></div>
            </div>
        </div>
        {{-- Stats skeleton --}}
        <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4 mb-6">
            @for($i=0; $i<4; $i++)
            <div class="bg-white rounded-xl border p-5">
                <div class="flex justify-between mb-3">
                    <div class="skeleton skeleton-text w-20 rounded-lg"></div>
                    <div class="skeleton w-7 h-7 rounded-lg"></div>
                </div>
                <div class="skeleton skeleton-text-lg w-32 mb-2 rounded-lg"></div>
                <div class="skeleton skeleton-text w-16 rounded-lg"></div>
            </div>
            @endfor
        </div>
        {{-- Charts skeleton --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 mb-6">
            <div class="lg:col-span-2 bg-white rounded-xl border p-5">
                <div class="skeleton skeleton-text w-24 mb-4 rounded-lg"></div>
                <div class="skeleton w-full h-48 rounded-lg"></div>
            </div>
            <div class="bg-white rounded-xl border p-5">
                <div class="skeleton skeleton-text w-24 mb-4 rounded-lg"></div>
                <div class="skeleton w-full h-48 rounded-lg"></div>
            </div>
        </div>
        {{-- Table skeleton --}}
        <div class="bg-white rounded-xl border overflow-hidden">
            <div class="p-4 border-b">
                <div class="skeleton skeleton-text w-32 rounded-lg"></div>
            </div>
            <div class="p-4 space-y-3">
                @for($i=0; $i<5; $i++)
                <div class="flex gap-3">
                    <div class="skeleton skeleton-text w-24 rounded-lg"></div>
                    <div class="skeleton skeleton-text w-32 rounded-lg"></div>
                    <div class="skeleton skeleton-text w-20 rounded-lg"></div>
                    <div class="skeleton skeleton-text w-16 rounded-lg"></div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    const loader = document.getElementById('skeletonLoader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(function() { loader.style.display = 'none'; }, 400);
    }
});
</script>

@php
    $fmt = function($n) {
        return number_format($n, 0);
    };
    $fmtTz = function($n) {
        return 'TZS ' . number_format($n, 0);
    };
    $fmtTzFull = function($n) {
        return 'TZS ' . number_format($n, 2);
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
    .skeleton { background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s infinite; }
    @keyframes skeleton-shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .api-key-hidden { filter: blur(4px); user-select: none; letter-spacing: 2px; }
    .api-key-visible { filter: none; user-select: text; letter-spacing: normal; }
</style>

{{-- Welcome + Actions --}}
<div class="mb-6 flex flex-row items-start sm:items-center justify-between gap-3 flex-wrap">
    <div class="min-w-0">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Hello {{ Auth::user()->first_name ?? 'Merchant' }} 👋</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Here's what's happening with your payments today.</p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <button onclick="exportTableToCSV('transactions.csv')" class="px-2 sm:px-3 py-1.5 text-[11px] sm:text-xs font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span class="hidden sm:inline">Export</span>
        </button>
        <a href="{{ route('user.payment-links.create') }}" class="px-2 sm:px-3 py-1.5 text-[11px] sm:text-xs font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="hidden sm:inline">Create payment link</span><span class="sm:hidden">New link</span>
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4 mb-6">
    {{-- Total Balance --}}
    <div class="card-sm bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl border border-emerald-500 p-3 sm:p-5 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        <div class="flex items-start justify-between relative z-10">
            <span class="text-[10px] sm:text-xs font-medium text-emerald-100">Total Balance</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-white relative z-10">{{ $fmtTzFull($totalBalance) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-200 font-medium relative z-10">+{{ $balanceChange }}% vs last week</div>
    </div>

    {{-- Total Transactions --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Total Transactions</span>
            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalTransactions) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $txChange }}% vs last week</div>
    </div>

    {{-- Active Payment Links --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Active Payment Links</span>
            <div class="w-7 h-7 rounded-lg bg-gold-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">{{ $activePaymentLinks }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $newPaymentLinks }} new this week</div>
    </div>

    {{-- Revenue Today --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Revenue Today</span>
            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">{{ $fmtTzFull($revenueToday) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $todayChange }}% vs yesterday</div>
    </div>
</div>

{{-- API Key Quick View --}}
@php
    $apiKey = \App\Models\ApiKey::where('user_id', auth()->id())->where('is_active', true)->latest()->first();
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="lg:col-span-2 card-sm bg-white rounded-xl border p-4 sm:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">API Key</h3>
                    <p class="text-[10px] text-gray-400">Quick access for integration</p>
                </div>
            </div>
            <a href="{{ route('user.api') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Manage</a>
        </div>
        @if($apiKey)
        <div class="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2.5 border border-gray-100">
            <code id="apiKeyDisplay" class="text-xs font-mono text-gray-700 flex-1 api-key-hidden">{{ $apiKey->key }}</code>
            <button onclick="toggleApiKey()" class="p-1.5 rounded-md hover:bg-gray-200 transition-colors" title="Show/Hide">
                <svg id="eyeIcon" class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
            <button onclick="copyApiKey()" class="p-1.5 rounded-md hover:bg-gray-200 transition-colors" title="Copy">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </button>
        </div>
        @else
        <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2.5 border border-gray-100">
            <span class="text-xs text-gray-400">No active API key</span>
            <a href="{{ route('user.api') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Create one</a>
        </div>
        @endif
    </div>

    <div class="card-sm bg-gradient-to-br from-gold-50 to-white rounded-xl border border-gold-100 p-4 sm:p-5">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-8 h-8 rounded-lg bg-gold-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Weekly Revenue</h3>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $fmtTzFull($weeklyRevenue) }}</div>
        <div class="mt-1 text-xs text-emerald-600 font-medium">+{{ $weeklyRevenueChange }}% from last week</div>
    </div>
</div>

@php
    $revMax = max($revenueDays) ?: 1;
    $revSvgPoints = [];
    foreach($revenueDays as $i => $rev) {
        $x = round($i * (100 / 6), 2);
        $y = round(40 - (($rev / $revMax) * 35), 2);
        $revSvgPoints[] = "{$x},{$y}";
    }
    $areaPath = "M" . $revSvgPoints[0] . " L" . implode(" L", array_slice($revSvgPoints, 1)) . " L100,40 L0,40 Z";
    $linePoints = implode(" ", $revSvgPoints);
@endphp

{{-- Charts Row --}}
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3 mb-6">
    {{-- Revenue Area Chart --}}
    <div class="bg-white rounded-xl border p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Revenue</h3>
                <p class="text-xs text-gray-400">Last 7 days</p>
            </div>
            <div class="text-right">
                <div class="text-lg font-semibold text-gray-900">{{ $fmtTz($weeklyRevenue) }}</div>
                <div class="text-xs text-emerald-600 font-medium">+{{ $weeklyRevenueChange }}%</div>
            </div>
        </div>
        <svg viewBox="0 0 100 40" class="w-full h-56" preserveAspectRatio="none">
            <defs>
                <linearGradient id="revGrad" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0%" stop-color="#10b981" stop-opacity="0.4"/>
                    <stop offset="100%" stop-color="#10b981" stop-opacity="0"/>
                </linearGradient>
            </defs>
            {{-- Grid lines --}}
            <line x1="0" y1="10" x2="100" y2="10" stroke="#f3f4f6" stroke-dasharray="2"/>
            <line x1="0" y1="20" x2="100" y2="20" stroke="#f3f4f6" stroke-dasharray="2"/>
            <line x1="0" y1="30" x2="100" y2="30" stroke="#f3f4f6" stroke-dasharray="2"/>
            {{-- Area fill --}}
            <path d="{{ $areaPath }}" fill="url(#revGrad)"/>
            {{-- Line --}}
            <polyline points="{{ $linePoints }}" fill="none" stroke="#10b981" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
            {{-- Data points --}}
            @foreach($revSvgPoints as $pt)
                @php list($px, $py) = explode(',', $pt); @endphp
                <circle cx="{{ $px }}" cy="{{ $py }}" r="0.8" fill="#10b981"/>
            @endforeach
        </svg>
        <div class="flex justify-between mt-2">
            @foreach($dayLabels as $label)
                <span class="text-[10px] text-gray-400 font-medium">{{ $label }}</span>
            @endforeach
        </div>
    </div>

    {{-- Transaction Volume Bar Chart --}}
    <div class="bg-white rounded-xl border p-5">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Transaction volume</h3>
            <p class="text-xs text-gray-400">Last 7 days</p>
        </div>
        <div class="flex items-end gap-2 h-56">
            @foreach($volumeDays as $i => $vol)
                @php
                    $maxVol = max($volumeDays) ?: 1;
                    $pct = ($vol / $maxVol) * 100;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1.5 group cursor-pointer">
                    <div class="w-full bg-gray-50 rounded-t-md relative h-48 overflow-hidden">
                        <div class="absolute bottom-0 left-0 right-0 rounded-t-md transition-all duration-300 bg-emerald-500" style="height: {{ max($pct, 4) }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium">{{ $dayLabels[$i] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Recent Activity Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b px-5 py-4 gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Recent activity</h3>
            <p class="text-xs text-gray-400">Latest transactions across all channels</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="flex items-center bg-gray-100 rounded-lg p-0.5" id="tx-filters">
                <button data-days="3" class="tx-filter-btn px-2.5 py-1 text-[11px] font-semibold rounded-md bg-emerald-600 text-white shadow-sm transition-all">3D</button>
                <button data-days="7" class="tx-filter-btn px-2.5 py-1 text-[11px] font-semibold rounded-md text-gray-600 hover:text-gray-900 transition-all">7D</button>
                <button data-days="30" class="tx-filter-btn px-2.5 py-1 text-[11px] font-semibold rounded-md text-gray-600 hover:text-gray-900 transition-all">30D</button>
                <button data-days="90" class="tx-filter-btn px-2.5 py-1 text-[11px] font-semibold rounded-md text-gray-600 hover:text-gray-900 transition-all">90D</button>
            </div>
            <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">View all</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500">
                    <th class="px-5 py-3 font-medium">ID</th>
                    <th class="px-5 py-3 font-medium">Customer</th>
                    <th class="px-5 py-3 font-medium">Amount</th>
                    <th class="px-5 py-3 font-medium">Method</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $tx)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors tx-row" data-timestamp="{{ $tx->processed_at?->timestamp }}">
                    <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $tx->tx_id }}</td>
                    <td class="px-5 py-3">
                        <div class="font-medium text-gray-900">{{ $tx->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $tx->customer_email }}</div>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-900">TSh {{ number_format($tx->amount) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $tx->method }}</td>
                    <td class="px-5 py-3">
                        @if($tx->status === 'success')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Success</span>
                        @elseif($tx->status === 'pending')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $tx->processed_at?->format('M d, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                        <p class="text-sm font-medium">No transactions yet</p>
                        <p class="text-xs mt-1">Start accepting payments to see activity here.</p>
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

<script>
(function() {
    const rows = Array.from(document.querySelectorAll('.tx-row'));
    const now = Math.floor(Date.now() / 1000);
    const MIN_ROWS = 5;

    function getTimestamp(r) {
        return parseInt(r.dataset.timestamp || '0', 10);
    }

    function sortByTime(a, b) {
        return getTimestamp(b) - getTimestamp(a);
    }

    function applyFilter(days) {
        const cutoff = now - (days * 86400);
        let visible = [];
        let hidden = [];

        rows.forEach(r => {
            const ts = getTimestamp(r);
            if (ts >= cutoff) {
                visible.push(r);
            } else {
                hidden.push(r);
            }
        });

        // Ensure at least MIN_ROWS are shown
        if (visible.length < MIN_ROWS && rows.length >= MIN_ROWS) {
            hidden.sort(sortByTime);
            const need = MIN_ROWS - visible.length;
            for (let i = 0; i < need && i < hidden.length; i++) {
                visible.push(hidden[i]);
            }
        }

        const visibleSet = new Set(visible);
        rows.forEach(r => {
            if (visibleSet.has(r)) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    document.querySelectorAll('.tx-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active styles
            document.querySelectorAll('.tx-filter-btn').forEach(b => {
                b.classList.remove('bg-emerald-600', 'text-white', 'shadow-sm');
                b.classList.add('text-gray-600');
            });
            this.classList.add('bg-emerald-600', 'text-white', 'shadow-sm');
            this.classList.remove('text-gray-600');

            const days = parseInt(this.dataset.days, 10);
            applyFilter(days);
        });
    });

    // Default: 3D
    applyFilter(3);
})();

// Export table to CSV
function exportTableToCSV(filename) {
    const table = document.querySelector('table');
    if (!table) return;
    const rows = Array.from(table.querySelectorAll('tr'));
    const csv = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('th, td'));
        return cells.map(cell => '"' + cell.innerText.replace(/"/g, '""') + '"').join(',');
    }).join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}

// Toggle API key visibility
function toggleApiKey() {
    const keyEl = document.getElementById('apiKeyDisplay');
    const iconEl = document.getElementById('eyeIcon');
    if (!keyEl || !iconEl) return;
    if (keyEl.classList.contains('api-key-hidden')) {
        keyEl.classList.remove('api-key-hidden');
        keyEl.classList.add('api-key-visible');
        iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        keyEl.classList.remove('api-key-visible');
        keyEl.classList.add('api-key-hidden');
        iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

// Copy API key
function copyApiKey() {
    const keyEl = document.getElementById('apiKeyDisplay');
    if (!keyEl) return;
    // Temporarily show key to copy
    const wasHidden = keyEl.classList.contains('api-key-hidden');
    if (wasHidden) {
        keyEl.classList.remove('api-key-hidden');
        keyEl.classList.add('api-key-visible');
    }
    navigator.clipboard.writeText(keyEl.innerText).then(() => {
        alert('API key copied!');
    }).catch(() => {
        // Fallback
        const range = document.createRange();
        range.selectNode(keyEl);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        alert('API key copied!');
    });
    if (wasHidden) {
        keyEl.classList.remove('api-key-visible');
        keyEl.classList.add('api-key-hidden');
    }
}
</script>

<div class="h-16 lg:hidden"></div>

@endsection
