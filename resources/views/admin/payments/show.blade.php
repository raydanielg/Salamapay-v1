@extends('layouts.admin')

@section('title', 'Transaction Details - SalamaPay')
@section('page_title', 'Transaction Details')

@section('content')
@include('admin.partials.alert')

<div class="mb-6">
    <a href="{{ route('admin.payments') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Payments
    </a>
    <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Transaction #{{ $payment->tx_id }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Transaction Summary</h3>
                @if($payment->status === 'success')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Completed</span>
                @elseif($payment->status === 'pending')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Amount</p>
                    <p class="text-lg font-bold text-gray-900">TSh {{ number_format($payment->amount) }}</p>
                </div>
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Method</p>
                    <p class="text-lg font-bold text-gray-900">{{ $payment->method }}</p>
                </div>
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Customer</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $payment->customer_name }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->customer_email }}</p>
                </div>
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Date</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $payment->processed_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                </div>
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Currency</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $payment->currency }}</p>
                </div>
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Merchant</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $payment->user?->business_name ?? $payment->user?->first_name ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-emerald-900 rounded-xl p-5 text-white">
            <h3 class="text-sm font-semibold mb-2">Transaction Timeline</h3>
            <div class="space-y-3">
                <div class="flex items-start gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mt-1.5 shrink-0"></span>
                    <div>
                        <p class="text-xs font-medium">Transaction Initiated</p>
                        <p class="text-[10px] text-emerald-300">{{ $payment->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
                @if($payment->processed_at)
                <div class="flex items-start gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mt-1.5 shrink-0"></span>
                    <div>
                        <p class="text-xs font-medium">Processed</p>
                        <p class="text-[10px] text-emerald-300">{{ $payment->processed_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
