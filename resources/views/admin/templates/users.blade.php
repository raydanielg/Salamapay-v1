@extends('layouts.admin')

@section('title', 'Template Users - SalamaPay')
@section('page_title', $template->name . ' Users')

@section('content')
@include('admin.partials.alert')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.templates') }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900">{{ $template->name }} Users</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ $template->paymentProfiles->count() }} merchants using this template</p>
        </div>
    </div>
</div>

{{-- Users Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Merchant</th>
                    <th class="px-5 py-3 font-medium">Business</th>
                    <th class="px-5 py-3 font-medium">Profile</th>
                    <th class="px-5 py-3 font-medium">Joined</th>
                    <th class="px-5 py-3 font-medium text-right">Links</th>
                </tr>
            </thead>
            <tbody>
                @forelse($template->paymentProfiles as $profile)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($profile->user->first_name ?? $profile->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $profile->user->first_name }} {{ $profile->user->last_name }}</p>
                                <p class="text-[10px] text-gray-400">{{ $profile->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-700">{{ $profile->business_name }}</td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">{{ $profile->name }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $profile->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <span class="text-xs text-gray-600 font-medium">{{ $profile->paymentLinks->count() }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                        <p class="text-sm font-medium">No merchants using this template yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
