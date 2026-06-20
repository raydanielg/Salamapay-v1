@extends('layouts.user')

@section('title', 'Settings - SalamaPay')
@section('page_title', 'Settings')

@section('content')
<style>
    .settings-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .settings-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -12px rgba(0,0,0,0.1); }
    .form-input:focus { box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
    .security-card { background: linear-gradient(135deg, #024938 0%, #013028 100%); }
    .danger-card { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Settings', 'subtitle' => 'Manage your account, security, and preferences'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Account Settings --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="settings-card animate-slide-up bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Account Information</h3>
                    <p class="text-xs text-gray-400">Update your personal and business details</p>
                </div>
            </div>
            <form action="{{ route('user.settings.account') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <input type="email" value="{{ $user->email }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-500 cursor-not-allowed" disabled>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">Locked</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business Name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $user->business_name ?? '') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="e.g. My Business">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business Type</label>
                        <select name="business_type" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all">
                            <option value="">Select type</option>
                            <option value="sole_proprietorship" {{ old('business_type', $user->business_type) === 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                            <option value="partnership" {{ old('business_type', $user->business_type) === 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="limited_company" {{ old('business_type', $user->business_type) === 'limited_company' ? 'selected' : '' }}>Limited Company</option>
                            <option value="ngo" {{ old('business_type', $user->business_type) === 'ngo' ? 'selected' : '' }}>NGO</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business TIN (Tax ID)</label>
                    <input type="text" name="business_tin" value="{{ old('business_tin', $user->business_tin ?? '') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="e.g. 123-456-789">
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5">Save Account</button>
                </div>
            </form>
        </div>

        <div class="settings-card animate-slide-up delay-1 bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Change Password</h3>
                    <p class="text-xs text-gray-400">Ensure your account is secure with a strong password</p>
                </div>
            </div>
            <form action="{{ route('user.settings.password') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Current Password</label>
                    <input type="password" name="current_password" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">New Password</label>
                        <input type="password" name="password" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" required>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-gray-800 to-gray-700 text-white rounded-xl hover:from-gray-900 hover:to-gray-800 transition-all shadow-lg shadow-gray-500/25 hover:shadow-gray-500/40 hover:-translate-y-0.5">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Side Cards --}}
    <div class="space-y-4">
        <div class="security-card animate-slide-up delay-2 rounded-2xl p-6 text-white shadow-lg shadow-emerald-900/20">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-white">Security Status</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-400/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-white">Password</span>
                            <p class="text-[10px] text-emerald-200/80">Last changed recently</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-900 bg-emerald-300 px-2 py-1 rounded-md">Secure</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-white">2FA</span>
                            <p class="text-[10px] text-emerald-200/80">Two-factor authentication</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-700 bg-gray-300 px-2 py-1 rounded-md">Off</span>
                </div>
            </div>
        </div>

        <div class="settings-card animate-slide-up delay-3 danger-card rounded-2xl border border-red-200 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-800">Danger Zone</h3>
                    <p class="text-xs text-red-600">These actions are irreversible.</p>
                </div>
            </div>
            <button class="w-full px-4 py-2.5 text-xs font-bold text-red-700 bg-white border border-red-200 rounded-xl hover:bg-red-50 transition-all shadow-sm">Deactivate Account</button>
        </div>
    </div>
</div>
@endsection
