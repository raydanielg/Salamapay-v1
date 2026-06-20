@extends('layouts.admin')

@section('title', 'KYC Review - SalamaPay Admin')
@section('page_title', 'Review KYC')

@section('content')
@include('admin.partials.alert')

<div class="mb-4">
    <a href="{{ route('admin.kyc') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to KYC</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Merchant Details --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Merchant Information</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Name:</span> <span class="font-medium">{{ $user->first_name }} {{ $user->last_name }}</span></div>
                <div><span class="text-gray-500">Email:</span> <span class="font-medium">{{ $user->email }}</span></div>
                <div><span class="text-gray-500">Phone:</span> <span class="font-medium">+{{ $user->phone }}</span></div>
                <div><span class="text-gray-500">Registered:</span> <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Business Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Business Name:</span> <span class="font-medium">{{ $user->business_name ?? 'N/A' }}</span></div>
                <div><span class="text-gray-500">Type:</span> <span class="font-medium capitalize">{{ str_replace('_', ' ', $user->business_type) ?? 'N/A' }}</span></div>
                <div><span class="text-gray-500">TIN:</span> <span class="font-medium">{{ $user->business_tin ?? 'N/A' }}</span></div>
                <div><span class="text-gray-500">Registration No:</span> <span class="font-medium">{{ $user->business_registration_number ?? 'N/A' }}</span></div>
                <div class="sm:col-span-2"><span class="text-gray-500">Address:</span> <span class="font-medium whitespace-pre-line">{{ $user->business_address ?? 'N/A' }}</span></div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="space-y-4">
        {{-- Status --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Verification Status</h3>
            @php
            $statusBadge = [
                'verified' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                'rejected' => 'bg-red-50 text-red-700 border-red-100',
                'unverified' => 'bg-gray-50 text-gray-600 border-gray-200',
            ][$user->verification_status] ?? 'bg-gray-50 text-gray-600 border-gray-200';
            @endphp
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusBadge }}">
                {{ ucfirst($user->verification_status) }}
            </span>
            @if($user->verified_at)
            <p class="text-xs text-gray-500 mt-2">Verified on {{ $user->verified_at->format('M d, Y H:i') }}</p>
            @endif
            @if($user->verification_notes)
            <p class="text-xs text-gray-600 mt-2 bg-gray-50 p-2 rounded">{{ $user->verification_notes }}</p>
            @endif
        </div>

        {{-- Approve Form --}}
        @if($user->verification_status !== 'verified')
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Approve</h3>
            <form action="{{ route('admin.kyc.approve', $user->id) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Notes (optional)</label>
                    <textarea name="notes" rows="2" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none resize-none" placeholder="Approval notes..."></textarea>
                </div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Approve Business
                </button>
            </form>
        </div>
        @endif

        {{-- Reject Form --}}
        @if($user->verification_status !== 'rejected' && $user->verification_status !== 'verified')
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Reject</h3>
            <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Reason *</label>
                    <textarea name="reason" rows="2" required class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none resize-none" placeholder="Why is this being rejected?"></textarea>
                </div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reject Application
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
