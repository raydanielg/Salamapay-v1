@extends('layouts.user')

@section('title', 'Sales - SalamaPay')
@section('page_title', 'Sales')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Sales', 'subtitle' => 'Track your sales performance and revenue'])

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Sales</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['total']) }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">{{ $stats['range'] === 'all' ? 'All time' : 'In selected period' }}</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Revenue</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">TSh {{ number_format($stats['totalAmount']) }}</p>
        <p class="text-[10px] text-blue-200 mt-1">Total revenue</p>
    </div>
    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-violet-100">Avg Sale</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">TSh {{ number_format($stats['avgAmount']) }}</p>
        <p class="text-[10px] text-violet-100 mt-1">Per transaction</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Products vs Services</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-xl font-black">{{ $stats['productsCount'] }}</p>
            <span class="text-[10px] text-amber-100">prod</span>
            <span class="text-amber-100">/</span>
            <p class="text-xl font-black">{{ $stats['servicesCount'] }}</p>
            <span class="text-[10px] text-amber-100">svc</span>
        </div>
        <p class="text-[10px] text-amber-100 mt-1">Product vs Service sales</p>
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
