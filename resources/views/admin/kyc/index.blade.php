@extends('layouts.admin')

@section('title', 'KYC Verification - SalamaPay Admin')
@section('page_title', 'KYC Verification')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', [
    'title' => 'KYC Verification',
    'subtitle' => 'Review and approve business verification requests',
    'action' => false
])

{{-- Pending Stats --}}
@php
$pendingCount = $pending->total();
@endphp
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
            <p class="text-xs text-gray-500">Pending Review</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('verification_status','verified')->count() }}</p>
            <p class="text-xs text-gray-500">Verified</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('verification_status','rejected')->count() }}</p>
            <p class="text-xs text-gray-500">Rejected</p>
        </div>
    </div>
</div>

{{-- Pending Requests --}}
<div class="bg-white rounded-xl border overflow-hidden mb-6">
    <div class="px-5 py-4 border-b flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">Pending Requests</h3>
        <span class="text-xs text-gray-400">{{ $pending->total() }} total</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Merchant</th>
                    <th class="px-5 py-3 font-medium">Business</th>
                    <th class="px-5 py-3 font-medium">Type</th>
                    <th class="px-5 py-3 font-medium">TIN</th>
                    <th class="px-5 py-3 font-medium">Submitted</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pending as $u)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="font-medium text-gray-900">{{ $u->first_name }} {{ $u->last_name }}</div>
                        <div class="text-xs text-gray-500">{{ $u->email }}</div>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $u->business_name }}</td>
                    <td class="px-5 py-3 text-gray-600 capitalize">{{ str_replace('_', ' ', $u->business_type) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $u->business_tin ?? 'N/A' }}</td>
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $u->updated_at->diffForHumans() }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.kyc.show', $u->id) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Review</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                        <p class="text-sm font-medium">No pending requests</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pending->hasPages())
    <div class="px-5 py-3 border-t">{{ $pending->links() }}</div>
    @endif
</div>

{{-- All Merchants --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">All Merchants</h3>
        <span class="text-xs text-gray-400">{{ $all->total() }} total</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Merchant</th>
                    <th class="px-5 py-3 font-medium">Business</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Verified</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($all as $u)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="font-medium text-gray-900">{{ $u->first_name }} {{ $u->last_name }}</div>
                        <div class="text-xs text-gray-500">{{ $u->email }}</div>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $u->business_name ?? 'N/A' }}</td>
                    <td class="px-5 py-3">
                        @php
                        $sBadge = [
                            'verified' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'rejected' => 'bg-red-50 text-red-700 border-red-100',
                            'unverified' => 'bg-gray-50 text-gray-600 border-gray-200',
                        ][$u->verification_status] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium border {{ $sBadge }}">
                            {{ ucfirst($u->verification_status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $u->verified_at?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.kyc.show', $u->id) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                        <p class="text-sm font-medium">No merchants yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($all->hasPages())
    <div class="px-5 py-3 border-t">{{ $all->links() }}</div>
    @endif
</div>
@endsection
