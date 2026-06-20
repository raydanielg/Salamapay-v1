<div class="receipt-card bg-white rounded-none sm:rounded-sm border border-gray-300 shadow-sm overflow-hidden relative" id="receiptCard" style="font-family:'Courier New',Courier,monospace;">
    {{-- Watermark --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.04] select-none" style="z-index:0;">
        <span class="text-6xl font-black text-gray-900 tracking-tighter rotate-[-30deg]">SALAMAPAY</span>
    </div>

    {{-- Receipt Body --}}
    <div class="relative z-10">
        {{-- Merchant Info --}}
        <div class="px-4 pt-4 pb-2 text-center border-b-2 border-dashed border-gray-300">
            <p class="text-xs font-bold text-gray-900 uppercase tracking-wide">{{ $transaction->user?->business_name ?? 'Merchant' }}</p>
            <p class="text-[9px] text-gray-500 mt-0.5">{{ $transaction->user?->email ?? 'support@salamapay.com' }}</p>
        </div>

        {{-- Receipt Title --}}
        <div class="text-center py-2 border-b border-dotted border-gray-300">
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-bold">Payment Receipt</p>
            <p class="text-[9px] text-gray-400 mt-0.5 font-mono">{{ $transaction->processed_at?->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s') }}</p>
        </div>

        {{-- Amount --}}
        <div class="text-center py-3 border-b border-dotted border-gray-300">
            <p class="text-[9px] text-gray-500 uppercase tracking-wider">Amount</p>
            <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $transaction->currency }} {{ number_format($transaction->amount) }}</p>
        </div>

        {{-- Details --}}
        <div class="px-4 py-2 text-[10px] space-y-1.5 border-b border-dotted border-gray-300">
            <div class="flex justify-between">
                <span class="text-gray-500">REF</span>
                <span class="font-mono font-bold text-gray-900">{{ $transaction->tx_id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">DATE</span>
                <span class="font-mono text-gray-900">{{ $transaction->processed_at?->format('d-m-Y') ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">TIME</span>
                <span class="font-mono text-gray-900">{{ $transaction->processed_at?->format('H:i:s') ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">METHOD</span>
                <span class="text-gray-900 font-semibold">{{ $transaction->method }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">STATUS</span>
                <span class="font-bold
                    @if($transaction->status === 'success') text-emerald-700
                    @elseif($transaction->status === 'pending') text-amber-700
                    @else text-red-700 @endif">
                    {{ strtoupper($transaction->status) }}
                </span>
            </div>
        </div>

        {{-- Customer --}}
        <div class="px-4 py-2 text-[10px] border-b border-dotted border-gray-300">
            <p class="text-gray-500 uppercase tracking-wider mb-1">Customer</p>
            <p class="font-bold text-gray-900">{{ $transaction->customer_name }}</p>
            <p class="text-gray-500">{{ $transaction->customer_email }}</p>
        </div>

        {{-- Tear-off line --}}
        <div class="px-4 py-1 border-b-2 border-dashed border-gray-400">
            <div class="flex items-center justify-between">
                <div class="flex-1 border-t border-dotted border-gray-300"></div>
                <span class="px-2 text-[8px] text-gray-400 uppercase tracking-wider whitespace-nowrap">&mdash; Cut Here &mdash;</span>
                <div class="flex-1 border-t border-dotted border-gray-300"></div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-4 py-3 bg-gray-50 text-center">
            <p class="text-[8px] text-gray-400 uppercase tracking-wider font-bold">Verified by SalamaPay</p>
            <p class="text-[7px] text-gray-400 mt-0.5">www.salamapay.com &middot; support@salamapay.com</p>
            <p class="text-[7px] text-gray-400 mt-0.5">Keep this receipt for your records.</p>
        </div>
    </div>
</div>
