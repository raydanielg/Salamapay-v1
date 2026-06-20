<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt {{ $transaction->tx_id }} — SalamaPay</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white rounded-2xl border shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="bg-emerald-900 px-8 py-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-emerald-300 uppercase tracking-widest mb-1">Payment Receipt</p>
                    <h1 class="text-2xl font-bold tracking-tight">TZS {{ number_format($transaction->amount) }}</h1>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-emerald-300 uppercase tracking-widest mb-1">Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/30 text-emerald-100 border border-emerald-400/30">PAID</span>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-8 space-y-5">
            <div class="flex items-center gap-4 pb-5 border-b border-dashed border-gray-200">
                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-lg">
                    {{ strtoupper(substr($link->user?->first_name ?? 'M', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $link->user?->business_name ?? $link->user?->first_name . ' ' . $link->user?->last_name }}</p>
                    <p class="text-xs text-gray-500">{{ $link->user?->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Transaction ID</p>
                    <p class="text-sm font-mono font-semibold text-gray-900">{{ $transaction->tx_id }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Date & Time</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $transaction->processed_at?->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $transaction->processed_at?->format('H:i:s') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Payment Method</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $transaction->method }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Currency</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $transaction->currency }}</p>
                </div>
            </div>

            <div class="pt-4 border-t border-dashed border-gray-200">
                <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-2">Customer</p>
                <p class="text-sm font-semibold text-gray-900">{{ $transaction->customer_name }}</p>
                <p class="text-xs text-gray-500">{{ $transaction->customer_email }}</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Paid</span>
                    <span class="text-xl font-bold text-gray-900">TZS {{ number_format($transaction->amount) }}</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-8 py-4 bg-gray-50 border-t text-center">
            <p class="text-[10px] text-gray-400">This is an official receipt from SalamaPay. Keep it for your records.</p>
            <p class="text-[10px] text-gray-400 mt-0.5">www.salamapay.com &middot; support@salamapay.com</p>
        </div>
    </div>

    {{-- Print Button --}}
    <div class="no-print fixed bottom-6 right-6 flex items-center gap-2">
        <button onclick="window.print()" class="flex items-center gap-2 px-5 py-3 text-sm font-bold bg-emerald-600 text-white rounded-full shadow-lg hover:bg-emerald-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Receipt
        </button>
        <a href="/" class="px-5 py-3 text-sm font-bold bg-white border text-gray-700 rounded-full shadow-lg hover:bg-gray-50 transition-colors">Done</a>
    </div>
</body>
</html>
