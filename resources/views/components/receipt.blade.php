{{-- Receipt Page Wrapper: Dark background with centered card --}}
<div class="receipt-page min-h-screen flex items-center justify-center p-6 md:p-10" style="background:#0f172a;">
    {{-- Background Security Pattern --}}
    <div class="fixed inset-0 opacity-[0.04] pointer-events-none" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

    {{-- Receipt Card --}}
    <div class="receipt-card relative bg-white w-full max-w-[420px] mx-auto overflow-hidden" id="receiptCard" style="box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.1);">

        {{-- Top Security Dashed Border --}}
        <div class="h-[6px] w-full" style="background-image: repeating-linear-gradient(90deg, #0f766e 0px, #0f766e 8px, transparent 8px, transparent 12px); opacity: 0.6;"></div>

        {{-- Header / Merchant --}}
        <div class="px-8 pt-6 pb-5">
            <div class="text-center">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-1">Payment Receipt</p>
                <p class="text-base font-black text-gray-900 tracking-tight">{{ $transaction->user?->business_name ?? 'Business' }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">{{ $transaction->user?->email ?? 'support@salamapay.com' }}</p>
            </div>
            {{-- Center decorative line --}}
            <div class="mt-4 flex items-center gap-3 justify-center">
                <div class="h-[1px] flex-1 max-w-[60px]" style="background-image: repeating-linear-gradient(90deg, #d1d5db 0px, #d1d5db 4px, transparent 4px, transparent 7px);"></div>
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="h-[1px] flex-1 max-w-[60px]" style="background-image: repeating-linear-gradient(90deg, #d1d5db 0px, #d1d5db 4px, transparent 4px, transparent 7px);"></div>
            </div>
        </div>

        {{-- Amount Section --}}
        <div class="px-8 py-5" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdf4 100%);">
            {{-- Security microtext top border --}}
            <div class="mb-3 flex justify-center">
                <p class="text-[6px] uppercase tracking-[0.3em] text-emerald-300 font-mono">SALAMAPAY SECURE RECEIPT &bull; SALAMAPAY SECURE RECEIPT &bull; SALAMAPAY SECURE RECEIPT</p>
            </div>
            <div class="text-center">
                <p class="text-[10px] font-semibold text-emerald-600 uppercase tracking-widest mb-1">Amount Received</p>
                <div class="flex items-baseline justify-center gap-1.5">
                    <span class="text-sm font-bold text-gray-500">{{ $transaction->currency }}</span>
                    <span class="text-4xl font-black text-gray-900 tracking-tight">{{ number_format($transaction->amount) }}</span>
                    <span class="text-sm font-bold text-gray-500">/=</span>
                </div>
            </div>
            {{-- Security microtext bottom border --}}
            <div class="mt-3 flex justify-center">
                <p class="text-[6px] uppercase tracking-[0.3em] text-emerald-300 font-mono">AUTHENTIC &bull; VERIFIED &bull; NON-TRANSFERABLE &bull; AUTHENTIC &bull; VERIFIED</p>
            </div>
        </div>

        {{-- Security Strip --}}
        <div class="relative h-3 overflow-hidden">
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #059669 0px, #059669 2px, #10b981 2px, #10b981 4px, #059669 4px, #059669 6px, transparent 6px, transparent 10px);"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <p class="text-[6px] font-bold text-white uppercase tracking-[0.5em] drop-shadow-sm">SECURE &bull; SALAMAPAY &bull; SECURE &bull; SALAMAPAY &bull; SECURE</p>
            </div>
        </div>

        {{-- Details Section --}}
        <div class="px-8 py-5">
            {{-- Dashed separator top --}}
            <div class="mb-4 border-t-2 border-dashed border-gray-200"></div>

            <div class="space-y-0">
                @php
                    $rows = [
                        ['Transaction ID', $transaction->tx_id, true],
                        ['Date & Time', $transaction->processed_at?->format('M d, Y H:i') ?? 'N/A', false],
                        ['Payment Method', $transaction->method, false],
                        ['Customer', $transaction->customer_name, false],
                        ['Customer Email', $transaction->customer_email, false],
                        ['Currency', $transaction->currency, false],
                        ['Status', ucfirst($transaction->status), false, $transaction->status],
                    ];
                @endphp
                @foreach($rows as $i => $row)
                <div class="flex justify-between items-center py-2.5 @if($i < count($rows)-1) border-b border-dotted border-gray-200 @endif">
                    <span class="text-[11px] text-gray-400 font-medium">{{ $row[0] }}</span>
                    <span class="text-[11px] font-bold text-gray-900 @if($row[2] ?? false) font-mono @endif
                        @if(($row[3] ?? '') === 'success') text-emerald-700
                        @elseif(($row[3] ?? '') === 'pending') text-amber-700
                        @elseif(($row[3] ?? '') === 'failed') text-red-700
                        @endif">
                        {{ $row[1] }}
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Dashed separator bottom --}}
            <div class="mt-4 border-t-2 border-dashed border-gray-200"></div>
        </div>

        {{-- Security Footer Block --}}
        <div class="px-8 pb-6 pt-2">
            <div class="relative overflow-hidden rounded-lg border border-gray-100 bg-gray-50 p-3">
                {{-- Subtle security pattern bg --}}
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(90deg, #000 0px, #000 1px, transparent 1px, transparent 4px);"></div>

                <div class="relative flex items-center justify-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <p class="text-[10px] font-bold text-gray-700 uppercase tracking-wider">Verified by SalamaPay</p>
                </div>

                {{-- Verification ID strip --}}
                <div class="flex items-center justify-center gap-2 mb-1.5">
                    <div class="h-[1px] flex-1" style="background-image: repeating-linear-gradient(90deg, #d1d5db 0px, #d1d5db 3px, transparent 3px, transparent 5px);"></div>
                    <p class="text-[8px] font-mono text-gray-400">VERIFICATION: {{ strtoupper(substr(md5($transaction->tx_id . 'SALAMAPAY'), 0, 16)) }}</p>
                    <div class="h-[1px] flex-1" style="background-image: repeating-linear-gradient(90deg, #d1d5db 0px, #d1d5db 3px, transparent 3px, transparent 5px);"></div>
                </div>

                <p class="relative text-center text-[8px] text-gray-400 leading-relaxed">
                    This is an electronically generated receipt. Any alteration renders it invalid.<br>
                    www.salamapay.com &bull; support@salamapay.com
                </p>
            </div>
        </div>

        {{-- Bottom Security Dashed Border --}}
        <div class="h-[6px] w-full" style="background-image: repeating-linear-gradient(90deg, #0f766e 0px, #0f766e 8px, transparent 8px, transparent 12px); opacity: 0.6;"></div>
    </div>
</div>
