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
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">TIN Number</label>
                    <input type="text" name="business_tin" value="{{ old('business_tin', $user->business_tin ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. 123-456-789">
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Verification Status</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Email Verified</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Phone Verified</p>
                        <p class="text-xs text-gray-500">{{ $user->phone }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Business Verification</p>
                        <p class="text-xs text-gray-500">Pending review</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
