<div class="receipt-card bg-white rounded-none border border-gray-300 shadow-sm overflow-hidden max-w-[280px] mx-auto" id="receiptCard" style="font-family:'Courier New',Courier,monospace;">
    {{-- Merchant --}}
    <div class="px-3 pt-3 pb-1 text-center border-b border-dashed border-gray-300">
        <p class="text-[10px] font-bold text-gray-900 uppercase">{{ $transaction->user?->business_name ?? 'MERCHANT' }}</p>
        <p class="text-[8px] text-gray-500">{{ $transaction->user?->email ?? 'support@salamapay.com' }}</p>
    </div>

    {{-- Title --}}
    <div class="text-center py-1 border-b border-dotted border-gray-300">
        <p class="text-[9px] text-gray-500 font-bold">*** PAYMENT RECEIPT ***</p>
        <p class="text-[8px] text-gray-400 font-mono">{{ $transaction->processed_at?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i') }}</p>
    </div>

    {{-- Items --}}
    <div class="px-3 py-1 text-[9px] space-y-0.5 border-b border-dotted border-gray-300">
        <p class="text-gray-500">QTY  ITEM</p>
        <div class="flex justify-between">
            <span>1x Payment</span>
            <span class="font-mono">{{ number_format($transaction->amount) }}</span>
        </div>
        <div class="border-t border-dotted border-gray-300 my-1"></div>
        <div class="flex justify-between font-bold text-[10px]">
            <span>TOTAL</span>
            <span class="font-mono">{{ $transaction->currency }} {{ number_format($transaction->amount) }}</span>
        </div>
    </div>

    {{-- Payment Info --}}
    <div class="px-3 py-1 text-[8px] space-y-0.5 border-b border-dotted border-gray-300">
        <p class="text-gray-500">PAYMENT INFO</p>
        <p>REF:  <span class="font-mono font-bold">{{ $transaction->tx_id }}</span></p>
        <p>DATE: <span class="font-mono">{{ $transaction->processed_at?->format('d-m-Y') ?? 'N/A' }}</span></p>
        <p>TIME: <span class="font-mono">{{ $transaction->processed_at?->format('H:i:s') ?? 'N/A' }}</span></p>
        <p>METHOD: <span class="font-bold">{{ strtoupper($transaction->method) }}</span></p>
        <p>STATUS: <span class="font-bold
            @if($transaction->status === 'success') text-emerald-700
            @elseif($transaction->status === 'pending') text-amber-700
            @else text-red-700 @endif">
            {{ strtoupper($transaction->status) }}
        </span></p>
    </div>

    {{-- Customer --}}
    <div class="px-3 py-1 text-[8px] border-b border-dotted border-gray-300">
        <p class="text-gray-500">CUSTOMER</p>
        <p class="font-bold">{{ $transaction->customer_name }}</p>
        <p>{{ $transaction->customer_email }}</p>
    </div>

    {{-- Cut line --}}
    <div class="px-3 py-1 text-center border-b-2 border-dashed border-gray-400">
        <p class="text-[7px] text-gray-400">- - - - - - - - - - CUT HERE - - - - - - - - - -</p>
    </div>

    {{-- Footer --}}
    <div class="px-3 py-2 text-center">
        <p class="text-[7px] text-gray-400 font-bold">Verified by SalamaPay</p>
        <p class="text-[6px] text-gray-400">www.salamapay.com</p>
        <p class="text-[7px] text-gray-400 mt-1">*** THANK YOU ***</p>
    </div>
</div>
