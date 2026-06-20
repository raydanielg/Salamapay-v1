@extends('layouts.user')

@section('title', 'Payment Details - SalamaPay')
@section('page_title', 'Payment Details')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Payment Details', 'subtitle' => 'Transaction ID: '.$payment->tx_id])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Payment Info Card --}}
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
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Actions</h3>
            <div class="space-y-2">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Receipt
                </button>
                <button class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Share Receipt
                </button>
            </div>
        </div>
        <a href="{{ route('user.payments') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Payments
        </a>
    </div>
</div>
@endsection
