@extends('layouts.user')

@section('title', 'Invoices - SalamaPay')
@section('page_title', 'Invoices')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Invoices', 'subtitle' => 'Manage and track all your invoices'])

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Invoices</p>
        <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($stats['total']) }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Paid</p>
        <p class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($stats['paid']) }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Pending</p>
        <p class="text-2xl font-black text-amber-600 mt-1">{{ number_format($stats['pending']) }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Amount</p>
        <p class="text-2xl font-black text-gray-900 mt-1">TSh {{ number_format($stats['totalAmount']) }}</p>
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
