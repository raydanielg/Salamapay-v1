@extends('layouts.user')

@section('title', 'POS - SalamaPay')
@section('page_title', 'Point of Sale')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Point of Sale', 'subtitle' => 'Quick checkout and payment collection'])

{{-- Quick Actions Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <button class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-5 text-white text-left hover:from-emerald-700 hover:to-emerald-800 transition-all active:scale-95 shadow-sm">
        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <p class="text-sm font-bold">Quick Charge</p>
        <p class="text-[10px] text-emerald-200 mt-0.5">Enter amount and collect</p>
    </button>

    <button class="bg-white rounded-xl border p-5 text-left hover:bg-gray-50 transition-all active:scale-95">
        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>
        <p class="text-sm font-bold text-gray-900">Scan to Pay</p>
        <p class="text-[10px] text-gray-400 mt-0.5">Generate QR code</p>
    </button>

    <button class="bg-white rounded-xl border p-5 text-left hover:bg-gray-50 transition-all active:scale-95">
        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        </div>
        <p class="text-sm font-bold text-gray-900">Saved Items</p>
        <p class="text-[10px] text-gray-400 mt-0.5">Quick select products</p>
    </button>
</div>

{{-- Quick Payment Links --}}
<div class="bg-white rounded-xl border overflow-hidden mb-6">
    <div class="px-5 py-4 border-b">
        <h3 class="text-sm font-bold text-gray-900">Quick Payment Links</h3>
        <p class="text-[11px] text-gray-400 mt-0.5">Select a link to collect payment</p>
    </div>
    <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @forelse($quickLinks as $link)
        <div class="border rounded-xl p-4 hover:border-emerald-300 transition-colors cursor-pointer group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-gray-900 truncate">{{ $link->title ?? 'Payment Link' }}</p>
                <span class="w-2 h-2 rounded-full {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
            </div>
            <p class="text-lg font-black text-emerald-700">TSh {{ number_format($link->amount ?? 0) }}</p>
            <p class="text-[10px] text-gray-400 mt-1">{{ Str::limit($link->description ?? 'No description', 40) }}</p>
            <div class="mt-3 flex gap-2">
                <button class="flex-1 py-1.5 bg-emerald-600 text-white text-[10px] font-bold rounded-lg hover:bg-emerald-700 transition-colors">Collect</button>
                <button class="px-2 py-1.5 border rounded-lg text-gray-400 hover:text-gray-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full py-8 text-center text-gray-400 text-sm">
            <p>No active payment links.</p>
            <a href="{{ route('user.payment-links.create') }}" class="text-emerald-600 text-xs font-bold mt-1 inline-block">Create one now</a>
        </div>
        @endforelse
    </div>
</div>

{{-- Manual Amount Entry --}}
<div class="bg-white rounded-xl border p-5">
    <h3 class="text-sm font-bold text-gray-900 mb-3">Quick Amount Entry</h3>
    <div class="flex gap-3">
        <div class="flex-1 relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">TSh</span>
            <input type="number" placeholder="0" class="w-full pl-12 pr-4 py-3 border rounded-xl text-lg font-black text-gray-900 outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
        </div>
        <button class="px-6 py-3 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition-colors active:scale-95">Charge</button>
    </div>
    <div class="flex gap-2 mt-3 flex-wrap">
        @foreach([1000, 5000, 10000, 20000, 50000, 100000] as $amt)
        <button class="px-3 py-1.5 border rounded-lg text-xs font-medium text-gray-600 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-700 transition-colors">+{{ number_format($amt) }}</button>
        @endforeach
    </div>
</div>
@endsection
