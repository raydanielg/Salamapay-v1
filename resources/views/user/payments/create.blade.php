@extends('layouts.user')

@section('title', 'New Payment - SalamaPay')
@section('page_title', 'New Payment')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'New Payment', 'subtitle' => 'Create a payment request or send a payment link'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Payment Form --}}
    <div class="bg-white rounded-xl border p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Payment Details</h3>
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Customer Name</label>
                <input type="text" name="customer_name" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="John Doe" required>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Customer Email</label>
                <input type="email" name="customer_email" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="john@example.com" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Amount (TZS)</label>
                    <input type="number" name="amount" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="50000" min="100" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="method" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white">
                        <option>M-Pesa</option>
                        <option>Tigo Pesa</option>
                        <option>Airtel Money</option>
                        <option>Card</option>
                        <option>Bank Transfer</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Description (optional)</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none resize-none" placeholder="Payment for order #12345..."></textarea>
            </div>
            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Create Payment</button>
                <a href="{{ route('user.payments') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Quick Link --}}
    <div class="space-y-6">
        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Use Payment Link</h3>
            <p class="text-xs text-gray-500 mb-3">Select an existing payment link to share with the customer.</p>
            @forelse($links as $link)
            <div class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-colors mb-2">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $link->title }}</p>
                    <p class="text-xs text-gray-500">{{ $link->amount ? 'TZS '.number_format($link->amount) : 'Custom amount' }} &middot; {{ $link->slug }}</p>
                </div>
                <button onclick="copyToClipboard('{{ url('/pay/'.$link->slug) }}')" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 px-2 py-1 rounded hover:bg-emerald-50">Copy Link</button>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No active payment links. <a href="#" class="text-emerald-600 hover:text-emerald-700">Create one</a></p>
            @endforelse
        </div>

        <div class="bg-emerald-900 rounded-xl p-6 text-white">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-semibold">Pro Tip</h3>
            </div>
            <p class="text-xs text-emerald-200 leading-relaxed">Payment links let customers pay without you creating a new request each time. Share via WhatsApp, SMS, or embed on your website.</p>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Link copied to clipboard!'));
}
</script>
@endsection
