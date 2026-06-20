<div class="receipt-card bg-white rounded-xl border-2 border-gray-100 shadow-sm overflow-hidden" id="receiptCard">
    {{-- Receipt Header --}}
    <div class="px-6 py-5 border-b border-dashed border-gray-200 bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Official Receipt</p>
                    <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">SalamaPay</h2>
                </div>
            </div>
            <div class="text-right">
                @if($transaction->status === 'success')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">PAID</span>
                @elseif($transaction->status === 'pending')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">PENDING</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">FAILED</span>
                @endif
                <p class="text-[10px] text-gray-400 mt-1">Ref: {{ $transaction->tx_id }}</p>
            </div>
        </div>
    </div>

    {{-- Merchant Info --}}
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm">
                {{ strtoupper(substr($merchantName ?? ($transaction->user?->business_name ?? $transaction->user?->first_name ?? 'M'), 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">{{ $merchantName ?? ($transaction->user?->business_name ?? ($transaction->user?->first_name . ' ' . $transaction->user?->last_name) ?? 'Merchant') }}</p>
                <p class="text-[11px] text-gray-500">{{ $transaction->user?->email ?? 'support@salamapay.com' }}</p>
            </div>
        </div>
    </div>

    {{-- Amount Highlight --}}
    <div class="px-6 py-5 bg-gray-50/50">
        <div class="flex items-baseline justify-center gap-1">
            <span class="text-sm text-gray-500 font-medium">{{ $transaction->currency }}</span>
            <span class="text-3xl font-extrabold text-gray-900">{{ number_format($transaction->amount) }}</span>
            <span class="text-sm text-gray-500">/=</span>
        </div>
        <p class="text-center text-[11px] text-gray-400 mt-1">Total amount paid</p>
    </div>

    {{-- Details Grid --}}
    <div class="px-6 py-4 space-y-3">
        <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-xs text-gray-500">Transaction ID</span>
            <span class="text-xs font-mono font-semibold text-gray-900">{{ $transaction->tx_id }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-xs text-gray-500">Date & Time</span>
            <span class="text-xs font-semibold text-gray-900">{{ $transaction->processed_at?->format('M d, Y H:i') ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-xs text-gray-500">Payment Method</span>
            <span class="text-xs font-semibold text-gray-900">{{ $transaction->method }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-xs text-gray-500">Customer</span>
            <span class="text-xs font-semibold text-gray-900">{{ $transaction->customer_name }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-xs text-gray-500">Email</span>
            <span class="text-xs font-semibold text-gray-900">{{ $transaction->customer_email }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-gray-100">
            <span class="text-xs text-gray-500">Currency</span>
            <span class="text-xs font-semibold text-gray-900">{{ $transaction->currency }}</span>
        </div>
        <div class="flex justify-between items-center py-2">
            <span class="text-xs text-gray-500">Status</span>
            <span class="text-xs font-semibold
                @if($transaction->status === 'success') text-emerald-700
                @elseif($transaction->status === 'pending') text-amber-700
                @else text-red-700 @endif">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>
    </div>

    {{-- Footer --}}
    <div class="px-6 py-4 bg-gray-50 border-t border-dashed border-gray-200 text-center">
        <div class="flex items-center justify-center gap-1.5 mb-1">
            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <p class="text-[10px] text-gray-500 font-medium">Verified by SalamaPay</p>
        </div>
        <p class="text-[9px] text-gray-400">This is an official receipt. Keep it for your records.</p>
        <p class="text-[9px] text-gray-400 mt-0.5">www.salamapay.com</p>
    </div>
</div>
