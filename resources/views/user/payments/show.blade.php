@extends('layouts.user')

@section('title', 'Payment Details - SalamaPay')
@section('page_title', 'Payment Details')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Payment Details', 'subtitle' => 'Transaction ID: '.$payment->tx_id])

@php
    $receiptUrl = route('receipt.public', $payment->tx_id);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left: Receipt Preview --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Receipt Card --}}
        <div class="bg-gray-50/50 rounded-xl border p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Receipt Preview
                </h3>
                <span class="text-[10px] text-gray-400">Print-ready</span>
            </div>
            <div class="max-w-md mx-auto">
                @include('components.receipt', ['transaction' => $payment])
            </div>
        </div>
    </div>

    {{-- Right: Actions --}}
    <div class="space-y-4">
        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Actions</h3>
            <div class="space-y-2.5">
                {{-- Download PDF (print) --}}
                <button onclick="downloadReceipt()" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-sm active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download PDF
                </button>

                {{-- Share --}}
                <button onclick="openShareModal()" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Share Receipt
                </button>

                {{-- View Online --}}
                <a href="{{ $receiptUrl }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Online
                </a>
            </div>
        </div>

        {{-- Share Link Quick Copy --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Shareable Link</h3>
            <p class="text-[11px] text-gray-400 mb-3">Anyone with this link can view the receipt.</p>
            <div class="flex items-center gap-2 bg-gray-50 rounded-lg border border-gray-100 px-3 py-2">
                <input id="receiptLink" type="text" value="{{ $receiptUrl }}" readonly class="bg-transparent text-xs text-gray-600 outline-none flex-1 min-w-0 font-mono">
                <button onclick="copyReceiptLink()" class="px-2.5 py-1.5 bg-emerald-600 text-white text-[10px] font-bold rounded-md hover:bg-emerald-700 transition-colors shrink-0">Copy</button>
            </div>
        </div>

        {{-- Transaction Meta --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Transaction Info</h3>
            <div class="space-y-2.5 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-semibold
                        @if($payment->status === 'success') text-emerald-700
                        @elseif($payment->status === 'pending') text-amber-700
                        @else text-red-700 @endif">{{ ucfirst($payment->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Method</span>
                    <span class="font-semibold text-gray-900">{{ $payment->method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date</span>
                    <span class="font-semibold text-gray-900">{{ $payment->processed_at?->format('M d, Y') ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Time</span>
                    <span class="font-semibold text-gray-900">{{ $payment->processed_at?->format('H:i:s') ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('user.payments') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Payments
        </a>
    </div>
</div>

{{-- Share Modal --}}
<div id="shareModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeShareModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden animate-fade">
        <div class="p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900">Share Receipt</h3>
                <button onclick="closeShareModal()" class="p-1 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 mb-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-gray-900 truncate">Receipt #{{ $payment->tx_id }}</p>
                    <p class="text-[11px] text-gray-500">TSh {{ number_format($payment->amount) }}</p>
                </div>
            </div>

            <p class="text-xs text-gray-500 mb-3">Share this receipt via:</p>
            <div class="grid grid-cols-4 gap-2 mb-4">
                <button onclick="shareVia('whatsapp')" class="flex flex-col items-center gap-1.5 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-gray-600">WhatsApp</span>
                </button>
                <button onclick="shareVia('email')" class="flex flex-col items-center gap-1.5 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-gray-600">Email</span>
                </button>
                <button onclick="shareVia('sms')" class="flex flex-col items-center gap-1.5 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-gray-600">SMS</span>
                </button>
                <button onclick="copyShareLink()" class="flex flex-col items-center gap-1.5 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-gray-600">Copy</span>
                </button>
            </div>

            <div class="flex items-center gap-2 bg-gray-50 rounded-lg border border-gray-100 px-3 py-2">
                <input id="shareLinkInput" type="text" value="{{ $receiptUrl }}" readonly class="bg-transparent text-[11px] text-gray-600 outline-none flex-1 min-w-0 font-mono">
                <button onclick="copyShareLink()" class="px-2.5 py-1.5 bg-emerald-600 text-white text-[10px] font-bold rounded-md hover:bg-emerald-700 transition-colors shrink-0">Copy</button>
            </div>
        </div>
    </div>
</div>

<script>
function downloadReceipt() {
    const receipt = document.getElementById('receiptCard');
    if (!receipt) return;
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Receipt ' + '{{ $payment->tx_id }}' + '</title>');
    printWindow.document.write('<link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">');
    printWindow.document.write('<script src="https://cdn.tailwindcss.com"><\/script>');
    printWindow.document.write('<style>body{font-family:"Nunito",sans-serif;padding:40px;background:#fff;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(receipt.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    setTimeout(() => { printWindow.print(); }, 500);
}

function copyReceiptLink() {
    const input = document.getElementById('receiptLink');
    if (!input) return;
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Link copied!');
    });
}

function openShareModal() {
    const modal = document.getElementById('shareModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeShareModal() {
    const modal = document.getElementById('shareModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function copyShareLink() {
    const input = document.getElementById('shareLinkInput');
    if (!input) return;
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Link copied to clipboard!');
    });
}

function shareVia(platform) {
    const url = encodeURIComponent('{{ $receiptUrl }}');
    const text = encodeURIComponent('Here is my payment receipt from SalamaPay: ');
    let shareUrl = '';
    if (platform === 'whatsapp') {
        shareUrl = 'https://wa.me/?text=' + text + url;
    } else if (platform === 'email') {
        shareUrl = 'mailto:?subject=Payment Receipt&body=' + text + url;
    } else if (platform === 'sms') {
        shareUrl = 'sms:?body=' + text + url;
    }
    if (shareUrl) window.open(shareUrl, '_blank');
}
</script>
@endsection
