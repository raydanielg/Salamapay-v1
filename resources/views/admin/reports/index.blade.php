@extends('layouts.admin')

@section('title', 'Reports - SalamaPay')
@section('page_title', 'Platform Reports')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', ['title' => 'Platform Reports', 'subtitle' => 'Comprehensive analytics across all merchants'])

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
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    @foreach([
        ['label'=>'Revenue','value'=>'TZS '.$fmt($summary['total_revenue']),'color'=>'emerald','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Transactions','value'=>number_format($summary['total_count']),'color'=>'blue','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label'=>'Successful','value'=>number_format($summary['success_count']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Failed','value'=>number_format($summary['failed_count']),'color'=>'red','icon'=>'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'New Merchants','value'=>number_format($summary['total_merchants']),'color'=>'purple','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label'=>'Settlements','value'=>'TZS '.$fmt($summary['total_settlements']),'color'=>'gold','icon'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4']
    ] as $card)
    <div class="bg-white rounded-xl border p-3 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-1">
            <div class="w-6 h-6 rounded bg-{{ $card['color'] }}-50 flex items-center justify-center">
                <svg class="w-3 h-3 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
        </div>
        <p class="text-base font-bold text-gray-900">{{ $card['value'] }}</p>
        <p class="text-[10px] text-gray-500">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Revenue Chart --}}
<div class="bg-white rounded-xl border p-5 mb-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">Revenue Trend</h3>
    <div class="flex items-end gap-[4px] h-40">
        @foreach($daily as $date => $d)
        @php $pct = min(100, ($d['revenue'] / $revMax) * 100); $isToday = $date === now()->format('Y-m-d'); @endphp
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
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b"><h3 class="text-sm font-semibold text-gray-900">Payment Methods Breakdown</h3></div>
        <div class="p-5 space-y-3">
            @forelse($methods as $method => $data)
            <div class="flex items-center gap-3">
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
            <p class="text-center text-gray-400 text-sm py-8">No data</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b"><h3 class="text-sm font-semibold text-gray-900">Daily Transaction Count</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-2.5 font-medium">Date</th>
                    <th class="px-5 py-2.5 font-medium">Count</th>
                    <th class="px-5 py-2.5 font-medium">Revenue</th>
                    <th class="px-5 py-2.5 font-medium">Success</th>
                </tr></thead>
                <tbody>
                    @foreach(collect($daily)->take(10) as $date => $d)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-2.5 text-xs">{{ \Carbon\Carbon::parse($date)->format('M d') }}</td>
                        <td class="px-5 py-2.5 text-xs font-medium">{{ $d['count'] }}</td>
                        <td class="px-5 py-2.5 text-xs font-semibold text-gray-900">TSh {{ number_format($d['revenue']) }}</td>
                        <td class="px-5 py-2.5 text-xs text-emerald-600">{{ $d['success'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
