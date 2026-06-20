@extends('layouts.user')

@section('title', 'Business Tools Settings - SalamaPay')
@section('page_title', 'Tools Settings')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Business Tools Settings', 'subtitle' => 'Configure POS, invoices, and sales preferences'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">

        {{-- POS Settings --}}
        <div class="bg-white rounded-xl border p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">POS Settings</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-gray-900">Enable POS Mode</p>
                        <p class="text-[10px] text-gray-400">Allow quick checkout from the POS page</p>
                    </div>
                    <button class="relative w-10 h-5 rounded-full bg-emerald-600 transition-colors">
                        <span class="absolute right-0.5 top-0.5 w-4 h-4 rounded-full bg-white shadow-sm"></span>
                    </button>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-xs font-bold text-gray-900">Default Currency</p>
                        <p class="text-[10px] text-gray-400">Currency used for POS transactions</p>
                    </div>
                    <select class="text-xs border rounded-lg px-2 py-1 outline-none focus:border-emerald-500">
                        <option>TZS - Tanzanian Shilling</option>
                        <option>USD - US Dollar</option>
                        <option>KES - Kenyan Shilling</option>
                        <option>UGX - Ugandan Shilling</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Invoice Settings --}}
        <div class="bg-white rounded-xl border p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Invoice Settings</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-gray-900">Auto-send Receipts</p>
                        <p class="text-[10px] text-gray-400">Automatically email receipt after payment</p>
                    </div>
                    <button class="relative w-10 h-5 rounded-full bg-gray-300 transition-colors">
                        <span class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full bg-white shadow-sm"></span>
                    </button>
                </div>
                <div class="py-3">
                    <p class="text-xs font-bold text-gray-900 mb-1">Receipt Footer Message</p>
                    <p class="text-[10px] text-gray-400 mb-2">Shown at the bottom of every receipt</p>
                    <input type="text" value="{{ $settings['receipt_footer'] }}" class="w-full px-3 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                </div>
            </div>
        </div>

        {{-- Tax Settings --}}
        <div class="bg-white rounded-xl border p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Tax & Pricing</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-gray-900">Enable Tax</p>
                        <p class="text-[10px] text-gray-400">Apply tax to all transactions</p>
                    </div>
                    <button class="relative w-10 h-5 rounded-full bg-emerald-600 transition-colors">
                        <span class="absolute right-0.5 top-0.5 w-4 h-4 rounded-full bg-white shadow-sm"></span>
                    </button>
                </div>
                <div class="py-3">
                    <p class="text-xs font-bold text-gray-900 mb-1">Tax Rate (%)</p>
                    <div class="flex items-center gap-2">
                        <input type="number" value="{{ $settings['sales_tax_rate'] }}" class="w-24 px-3 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                        <span class="text-xs text-gray-400">% applied to all sales</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Summary Card --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-3">Current Configuration</h3>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-400">POS Mode</span>
                    <span class="font-bold text-emerald-700">Enabled</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-400">Auto-receipts</span>
                    <span class="font-bold text-gray-500">Disabled</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-400">Tax Rate</span>
                    <span class="font-bold text-gray-900">{{ $settings['sales_tax_rate'] }}%</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-400">Currency</span>
                    <span class="font-bold text-gray-900">{{ $settings['currency'] }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-400">Receipt Footer</span>
                    <span class="font-bold text-gray-500 truncate max-w-[100px]">{{ $settings['receipt_footer'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-5 text-white">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200 mb-1">Need Help?</p>
            <p class="text-xs text-emerald-100 mb-3">Configure your business tools to streamline payments and invoicing.</p>
            <a href="#" class="inline-flex items-center gap-1 text-[10px] font-bold text-white hover:text-emerald-100 transition-colors">
                View Documentation
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection
