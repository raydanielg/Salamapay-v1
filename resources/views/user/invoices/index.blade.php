@extends('layouts.user')

@section('title', 'Invoices - SalamaPay')
@section('page_title', 'Invoices')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Invoices', 'subtitle' => 'Manage and track all your invoices'])

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Invoices</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['total']) }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">All invoices</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Paid</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['paid']) }}</p>
        <p class="text-[10px] text-blue-200 mt-1">TSh {{ number_format($stats['totalAmount']) }}</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Pending / Overdue</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-2xl font-black">{{ number_format($stats['pending'] + $stats['overdue']) }}</p>
            <span class="text-[10px] text-amber-100">pending</span>
        </div>
        <p class="text-[10px] text-amber-100 mt-1">TSh {{ number_format($stats['pendingAmount']) }}</p>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b flex items-center justify-between">
        <h3 class="text-sm font-bold text-gray-900">All Invoices</h3>
        <button class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 transition-colors">+ New Invoice</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Invoice #</th>
                    <th class="text-left px-5 py-3 font-semibold">Customer</th>
                    <th class="text-left px-5 py-3 font-semibold">Amount</th>
                    <th class="text-left px-5 py-3 font-semibold">Status</th>
                    <th class="text-left px-5 py-3 font-semibold">Date</th>
                    <th class="text-left px-5 py-3 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-xs font-bold text-gray-900">{{ $invoice->tx_id }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-gray-900 text-xs">{{ $invoice->customer_name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $invoice->customer_email }}</p>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-gray-900 text-xs">TSh {{ number_format($invoice->amount) }}</td>
                    <td class="px-5 py-3.5">
                        @if($invoice->status === 'success')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Paid</span>
                        @elseif($invoice->status === 'pending')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">Failed</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $invoice->processed_at?->format('M d, Y') ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('user.payments.show', $invoice->id) }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">No invoices found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
    <div class="px-5 py-3 border-t">{{ $invoices->links() }}</div>
    @endif
</div>
@endsection
