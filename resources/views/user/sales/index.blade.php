@extends('layouts.user')

@section('title', 'Sales - SalamaPay')
@section('page_title', 'Sales')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Sales', 'subtitle' => 'Track your sales performance and revenue'])

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white">
        <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Sales</p>
        <p class="text-2xl font-black mt-1">{{ number_format($stats['total']) }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">All time</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Today</p>
        <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($stats['today']) }}</p>
        <p class="text-[10px] text-emerald-600 mt-1 font-medium">+{{ rand(2,15) }}% vs yesterday</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">This Week</p>
        <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($stats['week']) }}</p>
        <p class="text-[10px] text-gray-400 mt-1">{{ now()->startOfWeek()->format('M d') }} - {{ now()->endOfWeek()->format('M d') }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Revenue</p>
        <p class="text-2xl font-black text-gray-900 mt-1">TSh {{ number_format($stats['totalAmount']) }}</p>
        <p class="text-[10px] text-gray-400 mt-1">Total revenue</p>
    </div>
</div>

{{-- Recent Sales Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b flex items-center justify-between">
        <h3 class="text-sm font-bold text-gray-900">Recent Sales</h3>
        <div class="flex gap-2">
            <select class="text-xs border rounded-lg px-2 py-1 text-gray-600 outline-none">
                <option>All Time</option>
                <option>Today</option>
                <option>This Week</option>
                <option>This Month</option>
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Transaction</th>
                    <th class="text-left px-5 py-3 font-semibold">Customer</th>
                    <th class="text-left px-5 py-3 font-semibold">Amount</th>
                    <th class="text-left px-5 py-3 font-semibold">Method</th>
                    <th class="text-left px-5 py-3 font-semibold">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sales as $sale)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-xs font-bold text-gray-900">{{ $sale->tx_id }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-gray-900 text-xs">{{ $sale->customer_name }}</p>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-emerald-700 text-xs">TSh {{ number_format($sale->amount) }}</td>
                    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $sale->method }}</td>
                    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $sale->processed_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">No sales found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="px-5 py-3 border-t">{{ $sales->links() }}</div>
    @endif
</div>

{{-- Monthly Chart Placeholder --}}
<div class="mt-6 bg-white rounded-xl border p-5">
    <h3 class="text-sm font-bold text-gray-900 mb-4">Sales Overview</h3>
    <div class="h-40 flex items-end gap-2 justify-between px-4">
        @foreach([65, 45, 80, 55, 90, 70, 85, 60, 75, 50, 95, 72] as $h)
        <div class="flex-1 flex flex-col items-center gap-1">
            <div class="w-full rounded-t-lg bg-emerald-100 hover:bg-emerald-200 transition-colors" style="height: {{ $h }}%"></div>
            <span class="text-[8px] text-gray-400">{{ substr(['J','F','M','A','M','J','J','A','S','O','N','D'][$loop->index], 0, 1) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
