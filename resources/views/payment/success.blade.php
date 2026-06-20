<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful — SalamaPay</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: { 50:'#e6f5f1',100:'#b3e0d4',200:'#80cbc0',300:'#4db5a8',400:'#1a9f8e',500:'#024938',600:'#023d30',700:'#013028',800:'#01241f',900:'#001816' },
                        gold: { 50:'#fff5e0',100:'#ffe6b3',200:'#ffd680',300:'#ffc64d',400:'#ffb71a',500:'#f9ac00',600:'#d49700',700:'#b07c00',800:'#8c6100',900:'#684600' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        @keyframes popIn { 0% { transform: scale(0); opacity:0; } 60% { transform: scale(1.1); } 100% { transform: scale(1); opacity:1; } }
        @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        .animate-pop { animation: popIn 0.5s ease both; }
        .animate-slide-up { animation: slideUp 0.5s ease both; }
        .animate-delay-1 { animation-delay: 0.2s; }
        .animate-delay-2 { animation-delay: 0.4s; }
        .check-circle { stroke-dasharray: 50; stroke-dashoffset: 50; animation: drawCheck 0.6s 0.3s ease forwards; }
        @keyframes drawCheck { to { stroke-dashoffset: 0; } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Success Icon --}}
        <div class="text-center mb-6 animate-pop">
            <div class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" class="text-emerald-200" fill="currentColor" fill-opacity="0.2"/>
                    <path class="check-circle" d="M8 12l2.5 2.5L16 9" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Payment Successful!</h1>
            <p class="text-sm text-gray-500 mt-1">Thank you, {{ $transaction->customer_name }}. Your payment has been received.</p>
        </div>

        {{-- Receipt Card --}}
        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden animate-slide-up animate-delay-1">
            <div class="bg-emerald-900 px-6 py-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-emerald-300 uppercase tracking-wider">Amount Paid</p>
                        <p class="text-2xl font-bold tracking-tight">TZS {{ number_format($transaction->amount) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-emerald-300 uppercase tracking-wider">Transaction ID</p>
                        <p class="text-sm font-mono font-medium">{{ $transaction->tx_id }}</p>
                    </div>
                </div>
            </div>
            <div class="p-5 space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Merchant</span><span class="font-medium text-gray-900">{{ $link->user?->business_name ?? $link->user?->first_name ?? 'Unknown' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Date</span><span class="font-medium text-gray-900">{{ $transaction->processed_at?->format('M d, Y H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Method</span><span class="font-medium text-gray-900">{{ $transaction->method }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Email</span><span class="font-medium text-gray-900">{{ $transaction->customer_email }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Paid</span></div>
            </div>
            <div class="px-5 py-4 border-t bg-gray-50/50 flex items-center gap-2">
                <a href="{{ route('payment.receipt', ['slug' => $link->slug, 'tx' => $transaction->tx_id]) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Receipt
                </a>
                <button onclick="shareReceipt()" class="px-4 py-2.5 text-xs font-medium border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                </button>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6 animate-slide-up animate-delay-2">
            <p class="text-xs text-gray-400">Powered by</p>
            <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-6 mx-auto mt-1 opacity-50">
        </div>
    </div>

<script>
function shareReceipt() {
    const url = '{{ route('payment.receipt', ['slug' => $link->slug, 'tx' => $transaction->tx_id]) }}';
    if (navigator.share) {
        navigator.share({ title: 'Payment Receipt', url: url });
    } else {
        navigator.clipboard.writeText(url).then(() => alert('Receipt link copied!'));
    }
}
</script>
</body>
</html>
