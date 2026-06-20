@extends('layouts.user')

@section('title', 'Reports - SalamaPay')
@section('page_title', 'Reports')

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
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Sales Reports', 'subtitle' => 'Analyze your payment performance'])

@php
$fmt = fn($n) => 'TZS ' . number_format($n, 0);
$revMax = max(array_column($daily, 'revenue')) ?: 1;
@endphp

{{-- Period Filter --}}
<div class="flex items-center gap-2 mb-6 animate-slide-up">
    @foreach(['7'=>'Last 7 Days','30'=>'Last 30 Days','90'=>'Last 90 Days'] as $days=>$label)
    <a href="?period={{ $days }}" class="px-4 py-2 text-xs font-bold rounded-xl {{ $period == $days ? 'bg-gradient-to-r from-emerald-600 to-emerald-500 text-white shadow-lg shadow-emerald-500/25' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }} transition-all">{{ $label }}</a>
    @endforeach
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['label'=>'Total Revenue','value'=>$fmt($summary['total_revenue']),'color'=>'emerald','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','delay'=>'delay-1'],
        ['label'=>'Transactions','value'=>number_format($summary['total_count']),'color'=>'blue','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','delay'=>'delay-2'],
        ['label'=>'Successful','value'=>number_format($summary['success_count']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','delay'=>'delay-3'],
        ['label'=>'Avg Transaction','value'=>$fmt($summary['avg_transaction']),'color'=>'amber','icon'=>'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6','delay'=>'delay-4']
    ] as $card)
    <div class="stat-card animate-slide-up {{ $card['delay'] }} bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500">{{ $card['label'] }}</span>
            <div class="w-8 h-8 rounded-lg bg-{{ $card['color'] }}-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
        </div>
        <p class="text-xl font-bold text-gray-900 tracking-tight">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- Revenue Chart --}}
<div class="stat-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 mb-6 shadow-sm">
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
    </div>
    <div class="flex items-end gap-[6px] h-44 px-2">
        @foreach($daily as $date => $d)
        @php
            $pct = min(100, ($d['revenue'] / $revMax) * 100);
            $isToday = $date === now()->format('Y-m-d');
        @endphp
        <div class="flex-1 flex flex-col items-center gap-1.5 group cursor-pointer" title="{{ $date }}: TZS {{ number_format($d['revenue']) }}">
            <div class="w-full bg-gray-50 rounded-t-xl relative h-36 overflow-hidden">
                <div class="chart-bar absolute bottom-0 left-0 right-0 rounded-t-xl {{ $isToday ? 'bg-gradient-to-t from-emerald-600 to-emerald-400' : 'bg-gradient-to-t from-emerald-400 to-emerald-200 group-hover:from-emerald-500 group-hover:to-emerald-300' }}" style="height: {{ max($pct, 3) }}%"></div>
            </div>
            <span class="text-[10px] text-gray-500 font-bold">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
        </div>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Transactions List --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-semibold text-gray-900">Recent Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                        <th class="px-5 py-2.5 font-medium">Customer</th>
                        <th class="px-5 py-2.5 font-medium">Amount</th>
                        <th class="px-5 py-2.5 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions->take(10) as $tx)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-2.5 text-xs">{{ $tx->customer_name }}</td>
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

    {{-- Payment Methods Breakdown --}}
    <div class="stat-card animate-slide-up delay-3 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center shadow-lg shadow-gold-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Payment Methods</h3>
                    <p class="text-xs text-gray-400">Breakdown by channel</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            @forelse($methods as $method => $data)
            <div class="flex items-center gap-4 group">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1.5">
                        <p class="text-sm font-semibold text-gray-900">{{ $method }}</p>
                        <p class="text-sm font-bold text-gray-900">TZS {{ number_format($data['amount']) }}</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2.5 rounded-full transition-all duration-700" style="width: {{ $summary['total_revenue'] > 0 ? ($data['amount'] / $summary['total_revenue'] * 100) : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">{{ number_format($data['count']) }} transactions</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <p class="text-sm text-gray-400">No data available</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
