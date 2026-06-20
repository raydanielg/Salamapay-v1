@extends('layouts.user')

@section('title', 'Business Tools Settings - SalamaPay')
@section('page_title', 'Tools Settings')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Business Tools Settings', 'subtitle' => 'Configure your business profile, POS, and sales preferences'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">

        {{-- Business Profile Card --}}
        <div class="bg-white rounded-xl border p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Business Profile</h3>
                    <p class="text-[10px] text-gray-400">Your business information shown on receipts and invoices</p>
                </div>
            </div>
            <form method="POST" action="{{ route('user.tools.business.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="flex items-center gap-4 mb-4">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center overflow-hidden border-2 border-emerald-100">
                            @if($user->logo)
                                <img src="{{ asset('storage/' . $user->logo) }}" alt="Logo" class="w-full h-full object-cover">
                            @else
                                <span class="text-xl font-black text-emerald-700">{{ strtoupper(substr($user->business_name ?? $user->first_name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <label class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center cursor-pointer hover:bg-emerald-700 transition-colors shadow-sm">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="file" name="logo" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </label>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-700">Business Logo</p>
                        <p class="text-[10px] text-gray-400">Click the camera icon to upload. Max 2MB.</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Business Name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Business Type</label>
                        <input type="text" name="business_type" value="{{ old('business_type', $user->business_type) }}" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Retail Shop">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">TIN Number</label>
                        <input type="text" name="business_tin" value="{{ old('business_tin', $user->business_tin) }}" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="Tax ID">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="+255...">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Address</label>
                    <textarea name="address" rows="2" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all resize-none" placeholder="Business address...">{{ old('address', $user->address) }}</textarea>
                </div>
                <div class="pt-1">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Business Profile</button>
                </div>
            </form>
        </div>

        {{-- Tools Settings Form --}}
        <div class="bg-white rounded-xl border p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Tools Configuration</h3>
                    <p class="text-[10px] text-gray-400">POS, tax, receipt, and payment settings</p>
                </div>
            </div>
            <form method="POST" action="{{ route('user.tools.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Currency</label>
                        <select name="currency" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 transition-all">
                            <option value="TZS" {{ ($settings['currency'] ?? 'TZS') === 'TZS' ? 'selected' : '' }}>TZS - Tanzanian Shilling</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                            <option value="KES" {{ ($settings['currency'] ?? '') === 'KES' ? 'selected' : '' }}>KES - Kenyan Shilling</option>
                            <option value="UGX" {{ ($settings['currency'] ?? '') === 'UGX' ? 'selected' : '' }}>UGX - Ugandan Shilling</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate'] ?? 18) }}" step="0.01" min="0" max="100" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Receipt Footer</label>
                    <input type="text" name="receipt_footer" value="{{ old('receipt_footer', $settings['receipt_footer'] ?? 'Thank you for your business!') }}" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                </div>
                <div class="space-y-3 py-2 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-900">Enable POS Mode</p>
                            <p class="text-[10px] text-gray-400">Allow quick checkout from POS page</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="pos_enabled" value="1" class="sr-only peer" {{ ($settings['pos_enabled'] ?? true) ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-900">Auto-send Receipts</p>
                            <p class="text-[10px] text-gray-400">Email receipt automatically after payment</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="auto_receipt" value="1" class="sr-only peer" {{ ($settings['auto_receipt'] ?? false) ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
                <div class="pt-1">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Tool Settings</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Right: Summary + Preview --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-3">Business Preview</h3>
            <div class="text-center mb-4">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center mx-auto mb-2 overflow-hidden border-2 border-emerald-100">
                    @if($user->logo)
                        <img src="{{ asset('storage/' . $user->logo) }}" alt="Logo" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-black text-emerald-700">{{ strtoupper(substr($user->business_name ?? $user->first_name, 0, 1)) }}</span>
                    @endif
                </div>
                <p class="text-sm font-bold text-gray-900">{{ $user->business_name ?? 'Your Business' }}</p>
                <p class="text-[10px] text-gray-400">{{ $user->business_type ?? 'Business Type' }}</p>
            </div>
            <div class="space-y-2 text-xs border-t pt-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">Email</span>
                    <span class="font-medium text-gray-700 truncate max-w-[140px]">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Phone</span>
                    <span class="font-medium text-gray-700">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">TIN</span>
                    <span class="font-medium text-gray-700">{{ $user->business_tin ?? '—' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-3">Tools Status</h3>
            <div class="space-y-2.5 text-xs">
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">POS Mode</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($settings['pos_enabled'] ?? true) ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">{{ ($settings['pos_enabled'] ?? true) ? 'Enabled' : 'Disabled' }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Auto Receipt</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($settings['auto_receipt'] ?? false) ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">{{ ($settings['auto_receipt'] ?? false) ? 'Enabled' : 'Disabled' }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Tax Rate</span>
                    <span class="font-bold text-gray-900">{{ $settings['tax_rate'] ?? 18 }}%</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Currency</span>
                    <span class="font-bold text-gray-900">{{ $settings['currency'] ?? 'TZS' }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-500">Footer</span>
                    <span class="font-bold text-gray-500 truncate max-w-[100px]">{{ $settings['receipt_footer'] ?? '—' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-5 text-white">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200 mb-1">Quick Tip</p>
            <p class="text-xs text-emerald-100 mb-3">Your business info appears on all receipts, invoices, and payment pages.</p>
            <a href="{{ route('user.products') }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-white hover:text-emerald-100 transition-colors">
                Go to Products
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection
