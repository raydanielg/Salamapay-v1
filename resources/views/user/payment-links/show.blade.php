@extends('layouts.user')

@section('title', $link->title . ' - Payment Link - SalamaPay')
@section('page_title', 'Payment Link Details')

@section('content')
<style>
    .detail-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .detail-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -8px rgba(0,0,0,0.1); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .status-pulse { animation: statusPulse 2s infinite; }
    @keyframes statusPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,0.3)} 50%{box-shadow:0 0 0 8px rgba(16,185,129,0)} }
</style>

@include('user.partials.alert')

{{-- Breadcrumb --}}
<div class="mb-4">
    <a href="{{ route('user.payment-links') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-emerald-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Payment Links
    </a>
</div>

{{-- Header / Status Hero --}}
<div class="animate-slide-up mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            {{-- Left: Title & Reference --}}
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">{{ $link->title }}</h1>
                        <p class="text-xs text-gray-400 mt-0.5">Payment Link Details</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3 mt-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Reference</span>
                        <span class="text-xs font-mono font-bold text-gray-700">PAY{{ str_pad($link->id, 14, '0', STR_PAD_LEFT) }}</span>
                        <button onclick="copyToClipboard('PAY{{ str_pad($link->id, 14, '0', STR_PAD_LEFT) }}')" class="text-gray-400 hover:text-emerald-600 transition-colors" title="Copy">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                    @if($link->isValid())
                        <span class="status-pulse inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>Active
                        </span>
                    @elseif($link->isExpired())
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>Expired
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500"></span>Inactive
                        </span>
                    @endif
                </div>
            </div>

            {{-- Right: Amount & Actions --}}
            <div class="text-left lg:text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Amount</p>
                <p class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    {{ $link->amount ? 'TSh ' . number_format($link->amount) : 'Custom' }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $link->currency }}</p>
                <div class="flex items-center gap-2 mt-4 lg:justify-end">
                    <button onclick="copyToClipboard('{{ url('/pay/'.$link->slug) }}')" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        Copy Link
                    </button>
                    <a href="{{ url('/pay/'.$link->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m-6-6L10 14"/></svg>
                        Preview
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Details Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    {{-- Main Details --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Link Info --}}
        <div class="detail-card animate-slide-up delay-1 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Link Information</h3>
                    <p class="text-xs text-gray-400">Core payment link details</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Status</label>
                    <div class="flex items-center gap-2">
                        @if($link->isValid())
                            <span class="w-3 h-3 rounded-full bg-emerald-500 status-pulse"></span>
                            <span class="text-sm font-bold text-emerald-700">Completed</span>
                        @elseif($link->isExpired())
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-sm font-bold text-red-700">Expired</span>
                        @else
                            <span class="w-3 h-3 rounded-full bg-gray-500"></span>
                            <span class="text-sm font-bold text-gray-700">Inactive</span>
                        @endif
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Amount</label>
                    <p class="text-sm font-bold text-gray-900">{{ $link->amount ? 'TSh ' . number_format($link->amount, 2) : 'Custom Amount' }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Payment Methods</label>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            Mobile Money
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM8 5h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                            QR
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Description</label>
                    <p class="text-sm font-bold text-gray-900">{{ $link->description ?: 'SalamaPay' }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Created</label>
                    <p class="text-sm font-bold text-gray-900">{{ $link->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Expires</label>
                    <p class="text-sm font-bold {{ $link->isExpired() ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $link->expires_at ? $link->expires_at->format('d M Y, H:i') : 'Never' }}
                    </p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Profile</label>
                    <div class="flex items-center gap-2">
                        @if($link->profile)
                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $link->profile->color }}"></span>
                            <span class="text-sm font-bold text-gray-900">{{ $link->profile->name }}</span>
                            @if($link->profile->is_default)
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">Default</span>
                            @endif
                        @else
                            <span class="text-sm text-gray-400">No profile selected</span>
                        @endif
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Link URL</label>
                    <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                        <code class="text-xs font-mono text-gray-700 flex-1 break-all">{{ url('/pay/'.$link->slug) }}</code>
                        <button onclick="copyToClipboard('{{ url('/pay/'.$link->slug) }}')" class="p-1.5 rounded-lg hover:bg-gray-200 transition-colors shrink-0" title="Copy">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
                @if(!empty($link->custom_fields))
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Custom Fields</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($link->custom_fields as $field)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                            {{ $field['label'] }}
                            @if($field['required'])<span class="text-red-500">*</span>@endif
                            <span class="text-blue-400 text-[10px]">({{ $field['type'] }})</span>
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Parties --}}
        <div class="detail-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Parties</h3>
                    <p class="text-xs text-gray-400">People involved in this transaction</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Customer</label>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center text-white text-sm font-bold shadow-md">
                            EJ
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Euphemia Vitus Joseph</p>
                            <p class="text-xs text-gray-500">Payer</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Merchant</label>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center text-white text-sm font-bold shadow-md">
                            {{ substr(Auth::user()->business_name ?? Auth::user()->first_name, 0, 2) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->business_name ?: Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Recipient</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Phone</label>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <p class="text-sm font-bold text-gray-900">+255655132921</p>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <p class="text-sm font-bold text-gray-900">airezra2@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Usage Stats --}}
        <div class="detail-card animate-slide-up delay-1 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center shadow-lg shadow-gold-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Usage Stats</h3>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-500">Total Visits</span>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($link->usage_count ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-500">Successful Payments</span>
                    <span class="text-sm font-bold text-emerald-700">{{ number_format($link->usage_count ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-500">Conversion Rate</span>
                    <span class="text-sm font-bold text-emerald-700">100%</span>
                </div>
            </div>
        </div>

        {{-- Metadata --}}
        <div class="detail-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center shadow-lg shadow-gray-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Metadata</h3>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Link ID</span>
                    <span class="text-xs font-mono font-bold text-gray-700">{{ $link->id }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Slug</span>
                    <span class="text-xs font-mono font-bold text-gray-700">{{ $link->slug }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Currency</span>
                    <span class="text-xs font-bold text-gray-700">{{ $link->currency }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Active</span>
                    <span class="text-xs font-bold {{ $link->is_active ? 'text-emerald-700' : 'text-red-700' }}">{{ $link->is_active ? 'Yes' : 'No' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Last Updated</span>
                    <span class="text-xs font-bold text-gray-700">{{ $link->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="detail-card animate-slide-up delay-3 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-2.5">
                <a href="{{ url('/pay/'.$link->slug) }}" target="_blank" class="flex items-center gap-2.5 w-full px-4 py-2.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Open Public Page
                </a>
                <button onclick="copyToClipboard('{{ url('/pay/'.$link->slug) }}')" class="flex items-center gap-2.5 w-full px-4 py-2.5 text-xs font-bold text-gray-700 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    Copy Link URL
                </button>
                <form action="{{ route('user.payment-links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Delete this payment link permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2.5 w-full px-4 py-2.5 text-xs font-bold text-red-700 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Link
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Copied to clipboard!'));
}
</script>
@endsection
