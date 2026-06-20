@extends('layouts.user')

@section('title', 'New Payment - SalamaPay')
@section('page_title', 'New Payment')

@section('content')
<style>
    .form-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .form-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -12px rgba(2,73,56,0.15); }
    .form-input:focus { box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
    .method-card { transition: all 0.2s ease; cursor: pointer; }
    .method-card:hover { border-color: #10b981; background: #ecfdf5; }
    .method-card.selected { border-color: #10b981; background: #ecfdf5; box-shadow: 0 0 0 2px rgba(16,185,129,0.2); }
    .tip-card { background: linear-gradient(135deg, #024938 0%, #013028 100%); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'New Payment', 'subtitle' => 'Create a payment request or send a payment link'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Payment Form --}}
    <div class="form-card animate-slide-up bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900">Payment Details</h3>
                <p class="text-xs text-gray-400">Fill in customer and amount info</p>
            </div>
        </div>
        <form action="#" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Customer Name</label>
                    <input type="text" name="customer_name" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="John Doe" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Customer Email</label>
                    <input type="email" name="customer_email" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="john@example.com" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Amount (TZS)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">TZS</span>
                        <input type="number" name="amount" class="form-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="50,000" min="100" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Payment Method</label>
                    <select name="method" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all">
                        <option>M-Pesa</option>
                        <option>Tigo Pesa</option>
                        <option>Airtel Money</option>
                        <option>Card</option>
                        <option>Bank Transfer</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description (optional)</label>
                <textarea name="description" rows="3" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none resize-none transition-all" placeholder="Payment for order #12345..."></textarea>
            </div>
            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5">Create Payment</button>
                <a href="{{ route('user.payments') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium px-3 py-2">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Quick Link --}}
    <div class="space-y-6">
        <div class="form-card animate-slide-up delay-1 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center shadow-lg shadow-gold-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Use Payment Link</h3>
                    <p class="text-xs text-gray-400">Share existing links instantly</p>
                </div>
            </div>
            @forelse($links as $link)
            <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all mb-2 group">
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $link->title }}</p>
                    <p class="text-xs text-gray-500">{{ $link->amount ? 'TZS '.number_format($link->amount) : 'Custom amount' }} &middot; {{ $link->slug }}</p>
                </div>
                <button onclick="copyToClipboard('{{ url('/pay/'.$link->slug) }}')" class="text-xs font-bold text-emerald-600 hover:text-white hover:bg-emerald-500 px-3 py-1.5 rounded-lg transition-all">Copy</button>
            </div>
            @empty
            <div class="text-center py-8 bg-gray-50 rounded-xl">
                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <p class="text-sm text-gray-400">No active payment links.</p>
                <a href="{{ route('user.payment-links.create') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 mt-1 inline-block">Create one now</a>
            </div>
            @endforelse
        </div>

        <div class="tip-card animate-slide-up delay-2 rounded-2xl p-6 text-white shadow-lg shadow-emerald-900/20">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-white">Pro Tip</h3>
            </div>
            <p class="text-xs text-emerald-200/90 leading-relaxed">Payment links let customers pay without you creating a new request each time. Share via WhatsApp, SMS, or embed on your website.</p>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Link copied to clipboard!'));
}
</script>
@endsection
