@extends('layouts.admin')

@section('title', 'All Payments - SalamaPay')
@section('page_title', 'All Payments')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', ['title' => 'All Payments', 'subtitle' => 'Monitor every transaction across the platform'])

@php
$fmt = fn($n) => $n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n));
@endphp

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['label'=>'Total','value'=>number_format($stats['total']),'color'=>'gray','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label'=>'Successful','value'=>number_format($stats['success']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Pending','value'=>number_format($stats['pending']),'color'=>'amber','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Total Revenue','value'=>'TZS '.$fmt($stats['totalRevenue']),'color'=>'emerald','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
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

{{-- Filters & Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="text-sm font-semibold text-gray-900">Transaction List</h3>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search TX ID or customer..." class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 w-56">
            <select name="status" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 bg-white" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="success" {{ request('status')==='success' ? 'selected' : '' }}>Success</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status')==='failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <select name="method" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 bg-white" onchange="this.form.submit()">
                <option value="">All Methods</option>
                @foreach(['M-Pesa','Tigo Pesa','Airtel Money','Card','Bank Transfer'] as $m)
                <option value="{{ $m }}" {{ request('method')===$m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">ID</th>
                    <th class="px-5 py-3 font-medium">Merchant</th>
                    <th class="px-5 py-3 font-medium">Customer</th>
                    <th class="px-5 py-3 font-medium">Amount</th>
                    <th class="px-5 py-3 font-medium">Method</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Date</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $tx)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $tx->tx_id }}</td>
                    <td class="px-5 py-3 text-xs text-gray-700">{{ $tx->user?->business_name ?? $tx->user?->first_name ?? 'Unknown' }}</td>
                    <td class="px-5 py-3">
                        <div class="font-medium text-gray-900 text-xs">{{ $tx->customer_name }}</div>
                        <div class="text-[10px] text-gray-500">{{ $tx->customer_email }}</div>
                    </td>
                    <td class="px-5 py-3 font-semibold text-gray-900">TSh {{ number_format($tx->amount) }}</td>
                    <td class="px-5 py-3 text-xs text-gray-600">{{ $tx->method }}</td>
                    <td class="px-5 py-3">
                        @if($tx->status === 'success')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Success</span>
                        @elseif($tx->status === 'pending')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $tx->processed_at?->format('M d, H:i') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.payments.show', $tx->id) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                        <p class="text-sm font-medium">No transactions found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-3 border-t">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
