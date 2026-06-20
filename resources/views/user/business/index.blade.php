@extends('layouts.user')

@section('title', 'Business Profile - SalamaPay')
@section('page_title', 'Business Profile')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Business Profile', 'subtitle' => 'Manage your business information and verification details'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Business Information</h3>
            <form action="{{ route('user.business.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Business Name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $user->business_name ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. Duka Langu">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Business Type</label>
                        <select name="business_type" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white">
                            <option value="">Select type...</option>
                            <option value="sole_proprietor" {{ old('business_type', $user->business_type) == 'sole_proprietor' ? 'selected' : '' }}>Sole Proprietor</option>
                            <option value="partnership" {{ old('business_type', $user->business_type) == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="limited_company" {{ old('business_type', $user->business_type) == 'limited_company' ? 'selected' : '' }}>Limited Company</option>
                            <option value="ngo" {{ old('business_type', $user->business_type) == 'ngo' ? 'selected' : '' }}>NGO</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Business Address</label>
                    <textarea name="business_address" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none resize-none">{{ old('business_address', $user->business_address ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">TIN Number</label>
                        <input type="text" name="business_tin" value="{{ old('business_tin', $user->business_tin ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. 123-456-789">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Registration Number</label>
                        <input type="text" name="business_registration_number" value="{{ old('business_registration_number', $user->business_registration_number ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. TZ1234567">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-4">
        {{-- Verification Status Card --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Verification Status</h3>
            <div class="space-y-3">
                {{-- Email --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full {{ $user->email_verified_at ? 'bg-emerald-50' : 'bg-gray-50' }} flex items-center justify-center">
                        <svg class="w-4 h-4 {{ $user->email_verified_at ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Email Verified</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                {{-- Phone --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Phone Verified</p>
                        <p class="text-xs text-gray-500">+{{ $user->phone }}</p>
                    </div>
                </div>
                {{-- Business --}}
                @php
                    $vStatus = $user->verification_status ?? 'unverified';
                    $vColors = [
                        'verified' => ['bg'=>'bg-emerald-50','text'=>'text-emerald-600','icon'=>'M5 13l4 4L19 7','label'=>'Verified'],
                        'pending' => ['bg'=>'bg-amber-50','text'=>'text-amber-600','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','label'=>'Pending Review'],
                        'rejected' => ['bg'=>'bg-red-50','text'=>'text-red-600','icon'=>'M6 18L18 6M6 6l12 12','label'=>'Rejected'],
                        'unverified' => ['bg'=>'bg-gray-50','text'=>'text-gray-400','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','label'=>'Not Verified']
                    ];
                    $v = $vColors[$vStatus] ?? $vColors['unverified'];
                @endphp
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full {{ $v['bg'] }} flex items-center justify-center">
                        <svg class="w-4 h-4 {{ $v['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $v['icon'] }}"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Business Verification</p>
                        <p class="text-xs {{ $v['text'] }} font-medium">{{ $v['label'] }}</p>
                    </div>
                </div>
            </div>

            @if($vStatus === 'unverified')
            <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-xs text-gray-600">Complete your business profile and upload required documents to start accepting payments.</p>
            </div>
            @elseif($vStatus === 'pending')
            <div class="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-100">
                <p class="text-xs text-amber-700">Your verification is under review. This usually takes 1-2 business days.</p>
            </div>
            @elseif($vStatus === 'rejected')
            <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100">
                <p class="text-xs text-red-700">Verification rejected. {{ $user->verification_notes ?? 'Please review and resubmit your documents.' }}</p>
            </div>
            @elseif($vStatus === 'verified')
            <div class="mt-4 p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                <p class="text-xs text-emerald-700">Your business is fully verified. No transaction limits apply.</p>
                @if($user->verified_at)
                <p class="text-[10px] text-emerald-500 mt-1">Verified on {{ $user->verified_at->format('M d, Y') }}</p>
                @endif
            </div>
            @endif
        </div>

        {{-- Quick Links --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Quick Links</h3>
            <div class="space-y-2">
                <a href="{{ route('user.business.banks') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">Bank Accounts</span>
                </a>
                <a href="{{ route('user.api') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">API Keys</span>
                </a>
                <a href="{{ route('user.settlements') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">Settlements</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
