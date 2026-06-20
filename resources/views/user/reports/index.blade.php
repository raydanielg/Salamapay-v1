@extends('layouts.user')

@section('title', 'Business Reports - SalamaPay')
@section('page_title', 'Business Reports')

@section('content')
<style>
    .stat-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px -8px rgba(0,0,0,0.12); }
    .chart-bar { transition: all 0.4s cubic-bezier(0.4,0,0.2,1); }
    .chart-bar:hover { filter: brightness(1.1); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }
    .donut-segment { transition: stroke-dashoffset 1s ease; }
    @media print { body * { visibility:hidden; } #printableArea, #printableArea * { visibility:visible; } #printableArea { position:absolute; left:0; top:0; width:100%; } }
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Business Reports', 'subtitle' => 'Complete overview of your business performance'])

@php
$fmt = fn($n) => 'TSh ' . number_format($n, 0);
$revMax = max(array_column($daily, 'revenue')) ?: 1;
$totalSplit = array_sum($productVsService);
$donutTotal = $totalSplit > 0 ? $totalSplit : 1;
$donutProduct = ($productVsService['product'] / $donutTotal) * 100;
$donutService = ($productVsService['service'] / $donutTotal) * 100;
$donutOther = ($productVsService['other'] / $donutTotal) * 100;
@endphp

{{-- Period Filter --}}
<div class="flex items-center gap-2 mb-6 animate-slide-up">
    @foreach(['7'=>'7 Days','30'=>'30 Days','90'=>'90 Days','365'=>'1 Year'] as $days=>$label)
    <a href="?period={{ $days }}" class="px-4 py-2 text-xs font-bold rounded-xl {{ $period == $days ? 'bg-gradient-to-r from-emerald-600 to-emerald-500 text-white shadow-lg shadow-emerald-500/25' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }} transition-all">{{ $label }}</a>
    @endforeach
</div>

{{-- KPI Row 1: Revenue & Sales --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    <div class="stat-card animate-slide-up delay-1 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-5 text-white shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Revenue</span>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-xl font-black">{{ $fmt($summary['total_revenue']) }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">{{ number_format($summary['success_count']) }} successful sales</p>
    </div>
    <div class="stat-card animate-slide-up delay-2 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-5 text-white shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Transactions</span>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        <p class="text-xl font-black">{{ number_format($summary['total_count']) }}</p>
        <p class="text-[10px] text-blue-200 mt-1">{{ number_format($summary['failed_count']) }} failed</p>
    </div>
    <div class="stat-card animate-slide-up delay-3 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-5 text-white shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[10px] font-bold uppercase tracking-wider text-purple-200">Avg Sale</span>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <p class="text-xl font-black">{{ $fmt($summary['avg_transaction']) }}</p>
        <p class="text-[10px] text-purple-200 mt-1">Per transaction</p>
    </div>
    <div class="stat-card animate-slide-up delay-4 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-5 text-white shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Success Rate</span>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-xl font-black">{{ $summary['total_count'] > 0 ? round(($summary['success_count'] / $summary['total_count']) * 100) : 0 }}%</p>
        <p class="text-[10px] text-amber-100 mt-1">{{ number_format($summary['success_count']) }} of {{ number_format($summary['total_count']) }}</p>
    </div>
</div>

{{-- KPI Row 2: Business Overview --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <div class="stat-card animate-slide-up delay-1 bg-white rounded-xl border p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Invoices</p>
                <p class="text-lg font-black text-gray-900">{{ number_format($invoiceStats['total']) }}</p>
                <p class="text-[10px] text-emerald-600 font-bold">{{ number_format($invoiceStats['paid']) }} paid</p>
            </div>
        </div>
    </div>
    <div class="stat-card animate-slide-up delay-2 bg-white rounded-xl border p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Products</p>
                <p class="text-lg font-black text-gray-900">{{ number_format($productStats['total']) }}</p>
                <p class="text-[10px] text-gray-500">{{ number_format($productStats['active']) }} active</p>
            </div>
        </div>
    </div>
    <div class="stat-card animate-slide-up delay-3 bg-white rounded-xl border p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Services</p>
                <p class="text-lg font-black text-gray-900">{{ number_format($servicesCount) }}</p>
                <p class="text-[10px] text-gray-500">Available</p>
            </div>
        </div>
    </div>
    <div class="stat-card animate-slide-up delay-4 bg-white rounded-xl border p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $productStats['low_stock'] > 0 ? 'bg-red-100' : 'bg-gray-100' }} flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 {{ $productStats['low_stock'] > 0 ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Low Stock</p>
                <p class="text-lg font-black {{ $productStats['low_stock'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($productStats['low_stock']) }}</p>
                <p class="text-[10px] text-gray-500">{{ number_format($productStats['out_of_stock']) }} out of stock</p>
            </div>
        </div>
    </div>
</div>

{{-- Revenue Chart + Product vs Service --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 stat-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Revenue Trend</h3>
                    <p class="text-xs text-gray-400">Daily revenue over selected period</p>
                </div>
            </div>
            <div class="flex gap-3 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-emerald-500"></span>Revenue</span>
            </div>
        </div>
        <div class="flex items-end gap-[4px] h-44 px-2">
            @foreach($daily as $date => $d)
            @php
                $pct = min(100, ($d['revenue'] / $revMax) * 100);
                $isToday = $date === now()->format('Y-m-d');
                $label = \Carbon\Carbon::parse($date)->format('d');
                if ($period > 30) $label = \Carbon\Carbon::parse($date)->format('M d');
                elseif ($period > 7) $label = \Carbon\Carbon::parse($date)->format('d');
                else $label = \Carbon\Carbon::parse($date)->format('D');
            @endphp
            <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer" title="{{ $date }}: TSh {{ number_format($d['revenue']) }} | {{ $d['success'] }} sales">
                <div class="w-full bg-gray-50 rounded-t-lg relative h-36 overflow-hidden">
                    <div class="chart-bar absolute bottom-0 left-0 right-0 rounded-t-lg {{ $isToday ? 'bg-gradient-to-t from-emerald-600 to-emerald-400' : 'bg-gradient-to-t from-emerald-400 to-emerald-200 group-hover:from-emerald-500 group-hover:to-emerald-300' }}" style="height: {{ max($pct, 2) }}%"></div>
                </div>
                <span class="text-[9px] text-gray-500 font-bold whitespace-nowrap">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Product vs Service Donut --}}
    <div class="stat-card animate-slide-up delay-3 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900">Product vs Service</h3>
                <p class="text-xs text-gray-400">Revenue breakdown (all time)</p>
            </div>
        </div>
        <div class="flex flex-col items-center">
            <svg viewBox="0 0 36 36" class="w-40 h-40 -rotate-90">
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10b981" stroke-width="3" stroke-dasharray="{{ $donutProduct }}, 100" stroke-dashoffset="0" stroke-linecap="round" class="donut-segment"/>
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#3b82f6" stroke-width="3" stroke-dasharray="{{ $donutService }}, 100" stroke-dashoffset="-{{ $donutProduct }}" stroke-linecap="round" class="donut-segment"/>
                @if($donutOther > 0)
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f59e0b" stroke-width="3" stroke-dasharray="{{ $donutOther }}, 100" stroke-dashoffset="-{{ $donutProduct + $donutService }}" stroke-linecap="round" class="donut-segment"/>
                @endif
            </svg>
            <div class="flex gap-4 mt-4 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Products</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Services</span>
                @if($donutOther > 0)
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>Other</span>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-3 w-full mt-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Products</p>
                    <p class="text-sm font-black text-emerald-700">{{ $fmt($productVsService['product']) }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Services</p>
                    <p class="text-sm font-black text-blue-700">{{ $fmt($productVsService['service']) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6" id="printableArea">
    {{-- Top Products --}}
    <div class="stat-card animate-slide-up delay-4 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">Top Products Sold</h3>
                <p class="text-[10px] text-gray-400">By revenue this period</p>
            </div>
        </div>
        <div class="p-4 space-y-3">
            @forelse($topProducts as $i => $product)
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-md {{ $i === 0 ? 'bg-amber-100 text-amber-700' : ($i === 1 ? 'bg-gray-100 text-gray-600' : 'bg-gray-50 text-gray-400') }} flex items-center justify-center text-[10px] font-black shrink-0">{{ $i + 1 }}</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-xs font-bold text-gray-900 truncate">{{ $product['name'] }}</p>
                        <p class="text-xs font-bold text-gray-900">{{ $fmt($product['revenue']) }}</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-1.5 rounded-full" style="width: {{ $topProducts[0]['revenue'] > 0 ? ($product['revenue'] / $topProducts[0]['revenue'] * 100) : 0 }}%"></div>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 shrink-0">{{ number_format($product['qty']) }} sold</p>
            </div>
            @empty
            <div class="text-center py-6">
                <svg class="w-8 h-8 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="text-xs text-gray-400">No product sales yet</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Top Customers --}}
    <div class="stat-card animate-slide-up delay-5 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">Top Customers</h3>
                <p class="text-[10px] text-gray-400">By spend this period</p>
            </div>
        </div>
        <div class="p-4 space-y-3">
            @forelse($topCustomers as $i => $customer)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center text-white text-[10px] font-bold shrink-0">{{ strtoupper(substr($customer->customer_name, 0, 1)) }}</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-0.5">
                        <p class="text-xs font-bold text-gray-900 truncate">{{ $customer->customer_name }}</p>
                        <p class="text-xs font-bold text-gray-900">{{ $fmt($customer->total) }}</p>
                    </div>
                    <p class="text-[10px] text-gray-400">{{ number_format($customer->count) }} transactions</p>
                </div>
            </div>
            @empty
            <div class="text-center py-6">
                <svg class="w-8 h-8 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-xs text-gray-400">No customer data yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Payment Methods --}}
    <div class="stat-card animate-slide-up delay-4 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">Payment Methods</h3>
                <p class="text-[10px] text-gray-400">Breakdown by channel</p>
            </div>
        </div>
        <div class="p-4 space-y-4">
            @forelse($methods as $method => $data)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg {{ strtolower($method) === 'cash' ? 'bg-emerald-50 text-emerald-600' : (strtolower($method) === 'mpesa' || strtolower($method) === 'tigo_pesa' ? 'bg-blue-50 text-blue-600' : 'bg-gray-50 text-gray-500') }} flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-xs font-bold text-gray-900">{{ strtoupper($method) }}</p>
                        <p class="text-xs font-bold text-gray-900">TSh {{ number_format($data['amount']) }}</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-2 rounded-full" style="width: {{ $summary['total_revenue'] > 0 ? ($data['amount'] / $summary['total_revenue'] * 100) : 0 }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">{{ number_format($data['count']) }} transactions</p>
                </div>
            </div>
            @empty
            <div class="text-center py-6">
                <svg class="w-8 h-8 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <p class="text-xs text-gray-400">No data available</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Recent Transactions</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50/50 text-[10px] uppercase tracking-wider">
                        <th class="px-4 py-3 font-bold">TX ID</th>
                        <th class="px-4 py-3 font-bold">Customer</th>
                        <th class="px-4 py-3 font-bold">Type</th>
                        <th class="px-4 py-3 font-bold">Amount</th>
                        <th class="px-4 py-3 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentTransactions as $tx)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 font-mono font-bold text-gray-900">{{ $tx->tx_id }}</td>
                        <td class="px-4 py-3">
                            <p class="font-bold text-gray-900">{{ $tx->customer_name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $tx->processed_at?->format('M d, H:i') ?? 'N/A' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold {{ $tx->source_type === 'product' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($tx->source_type === 'service' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-gray-50 text-gray-600 border border-gray-200') }}">
                                {{ $tx->source_type === 'product' ? 'Product' : ($tx->source_type === 'service' ? 'Service' : 'Other') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-bold text-gray-900">{{ $fmt($tx->amount) }}</td>
                        <td class="px-4 py-3">
                            @if($tx->status === 'success')
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Paid</span>
                            @elseif($tx->status === 'pending')
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Pending</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-600"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Failed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400 text-xs">No transactions in this period</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
