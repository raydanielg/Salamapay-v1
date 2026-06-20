@extends('layouts.user')

@section('title', 'New Payment Link - SalamaPay')
@section('page_title', 'New Payment Link')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'New Payment Link', 'subtitle' => 'Create a shareable link to accept payments'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border p-6">
            <form action="{{ route('user.payment-links.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Link Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. Monthly Subscription" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Description (optional)</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none resize-none" placeholder="What is this payment for?">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Amount (TZS)</label>
                        <input type="number" name="amount" value="{{ old('amount') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="Leave empty for custom amount" min="100">
                        <p class="text-[10px] text-gray-400 mt-1">Leave empty to let customer enter amount</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Custom Slug (optional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none font-mono" placeholder="my-link">
                        <p class="text-[10px] text-gray-400 mt-1">Auto-generated if left blank</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Currency</label>
                        <select name="currency" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white">
                            <option value="TZS" selected>TZS — Tanzanian Shilling</option>
                            <option value="USD">USD — US Dollar</option>
                            <option value="KES">KES — Kenyan Shilling</option>
                            <option value="UGX">UGX — Ugandan Shilling</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Expires At (optional)</label>
                        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                        <p class="text-[10px] text-gray-400 mt-1">Leave empty for no expiry</p>
                    </div>
                </div>
                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">Create Link</button>
                    <a href="{{ route('user.payment-links') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview --}}
    <div class="space-y-4">
        <div class="bg-emerald-900 rounded-xl p-5 text-white">
            <h3 class="text-sm font-semibold mb-2">How it works</h3>
            <ul class="space-y-2 text-xs text-emerald-200">
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">1.</span>Create a link with a fixed or custom amount</li>
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">2.</span>Share the link via WhatsApp, SMS, or email</li>
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">3.</span>Customer pays directly on the page</li>
                <li class="flex items-start gap-2"><span class="text-gold-400 mt-0.5">4.</span>Money arrives in your SalamaPay wallet</li>
            </ul>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Link URL Preview</h3>
            <div class="bg-gray-50 rounded-lg p-3">
                <code class="text-xs font-mono text-gray-600 break-all">{{ url('/pay/your-link-slug') }}</code>
            </div>
            <p class="text-[10px] text-gray-400 mt-2">Customers will see a secure checkout page when they visit this link.</p>
        </div>
    </div>
</div>
@endsection
