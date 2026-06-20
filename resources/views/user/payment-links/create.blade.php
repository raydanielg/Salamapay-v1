@extends('layouts.user')

@section('title', 'New Payment Link - SalamaPay')
@section('page_title', 'New Payment Link')

@section('content')
<style>
    .form-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .form-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -12px rgba(2,73,56,0.15); }
    .form-input:focus { box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
    .tip-card { background: linear-gradient(135deg, #024938 0%, #013028 100%); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'New Payment Link', 'subtitle' => 'Create a shareable link to accept payments'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="form-card animate-slide-up bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Link Details</h3>
                    <p class="text-xs text-gray-400">Configure your shareable payment link</p>
                </div>
            </div>
            <form action="{{ route('user.payment-links.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Link Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="e.g. Monthly Subscription" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description (optional)</label>
                    <textarea name="description" rows="3" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none resize-none transition-all" placeholder="What is this payment for?">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Amount (TZS)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">TZS</span>
                            <input type="number" name="amount" value="{{ old('amount') }}" class="form-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="Leave empty for custom" min="100">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Leave empty to let customer enter amount</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Custom Slug (optional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none font-mono transition-all" placeholder="my-link">
                        <p class="text-[10px] text-gray-400 mt-1">Auto-generated if left blank</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Currency</label>
                        <select name="currency" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all">
                            <option value="TZS" selected>TZS — Tanzanian Shilling</option>
                            <option value="USD">USD — US Dollar</option>
                            <option value="KES">KES — Kenyan Shilling</option>
                            <option value="UGX">UGX — Ugandan Shilling</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Expires At (optional)</label>
                        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Leave empty for no expiry</p>
                    </div>
                </div>
                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5">Create Link</button>
                    <a href="{{ route('user.payment-links') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium px-3 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview --}}
    <div class="space-y-4">
        <div class="tip-card animate-slide-up delay-1 rounded-2xl p-6 text-white shadow-lg shadow-emerald-900/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-white">How it works</h3>
            </div>
            <ul class="space-y-3 text-xs text-emerald-200/90">
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">1.</span><span>Create a link with a fixed or custom amount</span></li>
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">2.</span><span>Share the link via WhatsApp, SMS, or email</span></li>
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">3.</span><span>Customer pays directly on the page</span></li>
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">4.</span><span>Money arrives in your SalamaPay wallet</span></li>
            </ul>
        </div>
        <div class="form-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Link URL Preview</h3>
                    <p class="text-xs text-gray-400">What customers will see</p>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <code class="text-xs font-mono text-gray-600 break-all">{{ url('/pay/your-link-slug') }}</code>
            </div>
            <p class="text-[10px] text-gray-400 mt-3">Customers will see a secure checkout page when they visit this link.</p>
        </div>
    </div>
</div>
@endsection
