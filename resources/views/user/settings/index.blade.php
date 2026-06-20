@extends('layouts.user')

@section('title', 'Settings - SalamaPay')
@section('page_title', 'Settings')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Settings', 'subtitle' => 'Manage your account, security, and preferences'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Account Settings --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Account Information</h3>
            <p class="text-xs text-gray-400 mb-4">Update your personal and business details</p>
            <form action="{{ route('user.settings.account') }}" method="POST" class="space-y-4">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $user->email }}" class="w-full px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-sm text-gray-500 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Business Name</label>
                    <input type="text" name="business_name" value="{{ old('business_name', $user->business_name ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. My Business">
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Save Account</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Change Password</h3>
            <p class="text-xs text-gray-400 mb-4">Ensure your account is secure with a strong password</p>
            <form action="{{ route('user.settings.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" name="current_password" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" required>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Side Cards --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Security</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-md bg-emerald-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-700">Password</span>
                    </div>
                    <span class="text-[10px] font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">Secure</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-md bg-gray-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-700">2FA</span>
                    </div>
                    <span class="text-[10px] font-medium text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">Off</span>
                </div>
            </div>
        </div>

        <div class="bg-red-50 rounded-xl border border-red-100 p-5">
            <h3 class="text-sm font-semibold text-red-800 mb-1">Danger Zone</h3>
            <p class="text-xs text-red-600 mb-3">These actions are irreversible.</p>
            <button class="w-full px-3 py-2 text-xs font-medium text-red-700 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition-colors">Deactivate Account</button>
        </div>
    </div>
</div>
@endsection
