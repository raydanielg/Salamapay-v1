@extends('layouts.user')

@section('title', 'Reports - SalamaPay')
@section('page_title', 'Reports')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Sales Reports', 'subtitle' => 'Analyze your payment performance'])

@php
$fmt = fn($n) => $n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n));
$revMax = max(array_column($daily, 'revenue')) ?: 1;
@endphp

{{-- Period Filter --}}
<div class="flex items-center gap-2 mb-6">
    @foreach(['7'=>'Last 7 Days','30'=>'Last 30 Days','90'=>'Last 90 Days'] as $days=>$label)
    <a href="?period={{ $days }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg {{ $period == $days ? 'bg-emerald-600 text-white' : 'bg-white border text-gray-700 hover:bg-gray-50' }} transition-colors">{{ $label }}</a>
    @endforeach
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['label'=>'Total Revenue','value'=>'TZS '.$fmt($summary['total_revenue']),'color'=>'emerald','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Transactions','value'=>number_format($summary['total_count']),'color'=>'blue','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label'=>'Successful','value'=>number_format($summary['success_count']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Avg Transaction','value'=>'TZS '.$fmt($summary['avg_transaction']),'color'=>'amber','icon'=>'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6']
    ] as $card)
    <div class="bg-white rounded-xl border p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-gray-500">{{ $card['label'] }}</span>
            <div class="w-7 h-7 rounded-md bg-{{ $card['color'] }}-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
        </div>
        <p class="text-lg font-bold text-gray-900">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- Revenue Chart --}}
<div class="bg-white rounded-xl border p-5 mb-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">Revenue Trend</h3>
    <div class="flex items-end gap-[4px] h-40">
        @foreach($daily as $date => $d)
        @php
            $pct = min(100, ($d['revenue'] / $revMax) * 100);
            $isToday = $date === now()->format('Y-m-d');
        @endphp
        <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer" title="{{ $date }}: TSh {{ number_format($d['revenue']) }}">
            <div class="w-full bg-gray-50 rounded-t-md relative h-32 overflow-hidden">
                <div class="absolute bottom-0 left-0 right-0 rounded-t-md transition-all duration-300 {{ $isToday ? 'bg-emerald-500' : 'bg-emerald-300 hover:bg-emerald-400' }}" style="height: {{ max($pct, 3) }}%"></div>
            </div>
            <span class="text-[9px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
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
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-semibold text-gray-900">Payment Methods</h3>
        </div>
        <div class="p-5 space-y-4">
            @forelse($methods as $method => $data)
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-medium text-gray-900">{{ $method }}</p>
                        <p class="text-sm font-semibold text-gray-900">TSh {{ number_format($data['amount']) }}</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $summary['total_revenue'] > 0 ? ($data['amount'] / $summary['total_revenue'] * 100) : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $data['count'] }} transactions</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 text-sm py-8">No data available</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
