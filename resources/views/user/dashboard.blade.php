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

{{-- Welcome + Actions --}}
<div class="mb-6 flex flex-row items-start sm:items-center justify-between gap-3 flex-wrap">
    <div class="min-w-0">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Hello {{ Auth::user()->first_name ?? 'Merchant' }} 👋</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Here's what's happening with your payments today.</p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <button class="px-2 sm:px-3 py-1.5 text-[11px] sm:text-xs font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Export</button>
        <button class="px-2 sm:px-3 py-1.5 text-[11px] sm:text-xs font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors"><span class="hidden sm:inline">Create payment link</span><span class="sm:hidden">New link</span></button>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4 mb-6">
    {{-- Total Balance --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Total Balance</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-lg sm:text-2xl font-semibold tracking-tight text-gray-900">{{ $fmtTz($totalBalance) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $balanceChange }}% vs last week</div>
    </div>

    {{-- Total Transactions --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Total Transactions</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-lg sm:text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($totalTransactions) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $txChange }}% vs last week</div>
    </div>

    {{-- Active Payment Links --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Active Payment Links</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-lg sm:text-2xl font-semibold tracking-tight text-gray-900">{{ $activePaymentLinks }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $newPaymentLinks }} new vs last week</div>
    </div>

    {{-- Revenue Today --}}
    <div class="card-sm bg-white rounded-xl border p-3 sm:p-5">
        <div class="flex items-start justify-between">
            <span class="text-[10px] sm:text-xs font-medium text-gray-500">Revenue Today</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-lg sm:text-2xl font-semibold tracking-tight text-gray-900">{{ $fmtTz($revenueToday) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-600 font-medium">+{{ $todayChange }}% vs last week</div>
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
</script>

<div class="h-16 lg:hidden"></div>

@endsection
