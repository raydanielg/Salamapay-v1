<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt {{ $transaction->tx_id }} — SalamaPay</title>
    <link rel="icon" type="image/png" href="{{ asset('icons8-logo-32.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .receipt-wrapper { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Receipt --}}
        <div class="receipt-wrapper">
            @include('components.receipt', ['transaction' => $transaction, 'merchantName' => $merchantName ?? null])
        </div>

        {{-- Actions --}}
        <div class="no-print flex items-center justify-center gap-3 mt-6">
            <button onclick="window.print()" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl shadow-lg hover:bg-emerald-700 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download PDF
            </button>
            <button onclick="copyReceiptLink()" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold bg-white text-gray-700 border border-gray-200 rounded-xl shadow-lg hover:bg-gray-50 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                Copy Link
            </button>
        </div>

        <p class="no-print text-center text-[11px] text-gray-400 mt-4">Powered by SalamaPay</p>
    </div>

    <script>
        function copyReceiptLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Receipt link copied to clipboard!');
            }).catch(() => {
                alert('Could not copy link automatically.');
            });
        }
    </script>
</body>
</html>
