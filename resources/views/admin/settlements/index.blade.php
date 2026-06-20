@extends('layouts.admin')

@section('title', 'Settlements - SalamaPay')
@section('page_title', 'Settlements')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', ['title' => 'Settlements', 'subtitle' => 'Manage all merchant withdrawal requests'])

@php
$fmt = fn($n) => $n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n));
@endphp

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    @foreach([
        ['label'=>'Total','value'=>number_format($stats['total']),'color'=>'gray'],
        ['label'=>'Pending','value'=>number_format($stats['pending']),'color'=>'amber'],
        ['label'=>'Processing','value'=>number_format($stats['processing']),'color'=>'blue'],
        ['label'=>'Completed','value'=>number_format($stats['completed']),'color'=>'emerald'],
        ['label'=>'Failed','value'=>number_format($stats['failed']),'color'=>'red'],
        ['label'=>'Total Settled','value'=>'TZS '.$fmt($stats['totalAmount']),'color'=>'emerald']
    ] as $card)
    <div class="bg-white rounded-xl border p-3 hover:shadow-md transition-shadow">
        <p class="text-xs text-gray-500 font-medium mb-1">{{ $card['label'] }}</p>
        <p class="text-base font-bold text-gray-900">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="text-sm font-semibold text-gray-900">Settlement Requests</h3>
        <form method="GET" class="flex items-center gap-2">
            <select name="status" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 bg-white" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status')==='processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ request('status')==='failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Reference</th>
                    <th class="px-5 py-3 font-medium">Merchant</th>
                    <th class="px-5 py-3 font-medium">Amount</th>
                    <th class="px-5 py-3 font-medium">Fee</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Method</th>
                    <th class="px-5 py-3 font-medium">Date</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settlements as $st)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $st->reference }}</td>
                    <td class="px-5 py-3 text-xs text-gray-700">{{ $st->user?->business_name ?? $st->user?->first_name ?? 'Unknown' }}</td>
                    <td class="px-5 py-3 font-semibold text-gray-900">TSh {{ number_format($st->amount) }}</td>
                    <td class="px-5 py-3 text-xs text-gray-500">TSh {{ number_format($st->fee) }}</td>
                    <td class="px-5 py-3">
                        @if($st->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1 h-1 rounded-full bg-emerald-500"></span>Completed</span>
                        @elseif($st->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100"><span class="w-1 h-1 rounded-full bg-amber-400"></span>Pending</span>
                        @elseif($st->status === 'processing')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100"><span class="w-1 h-1 rounded-full bg-blue-500"></span>Processing</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100"><span class="w-1 h-1 rounded-full bg-red-400"></span>Failed</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-600 capitalize">{{ $st->method ?? 'Bank' }}</td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $st->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <form action="{{ route('admin.settlements.status', $st->id) }}" method="POST" class="inline-flex items-center gap-1">
                            @csrf
                            @method('PUT')
                            <select name="status" class="text-[10px] px-1.5 py-1 border border-gray-200 rounded outline-none focus:border-emerald-500 bg-white" onchange="this.form.submit()">
                                <option value="pending" {{ $st->status==='pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $st->status==='processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $st->status==='completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ $st->status==='failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                        <p class="text-sm font-medium">No settlements found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($settlements->hasPages())
    <div class="px-5 py-3 border-t">{{ $settlements->links() }}</div>
    @endif
</div>
@endsection
