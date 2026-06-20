@extends('layouts.user')

@section('title', 'Payment Profiles - SalamaPay')
@section('page_title', 'Payment Profiles')

@section('content')
<style>
    .profile-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .profile-card:hover { transform: translateY(-3px); box-shadow: 0 16px 48px -12px rgba(0,0,0,0.12); }
    .animate-fade-up { animation: fadeUp 0.4s ease-out both; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.06s; }
    .delay-2 { animation-delay: 0.12s; }
    .delay-3 { animation-delay: 0.18s; }
    .modal-overlay { opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
    .modal-overlay.open { opacity: 1; pointer-events: auto; }
    .modal-panel { transform: translateX(100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
    .modal-overlay.open .modal-panel { transform: translateX(0); }
    .type-badge.catalog { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .type-badge.fixed { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .logo-preview { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; }
    .page-type-btn { transition: all 0.15s; }
    .page-type-btn.active { border-color: #024938; background: #f0fdf4; }
    .page-type-btn.active .pt-check { opacity: 1; transform: scale(1); }
    .pt-check { opacity: 0; transform: scale(0.5); transition: all 0.15s; }
</style>

@include('user.partials.alert')

{{-- Header + Filter --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 animate-fade-up">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Payment Profiles</h1>
        <p class="text-xs text-gray-500 mt-0.5">Manage business profiles shown on your payment pages</p>
    </div>
    <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('user.payment-profiles') }}" class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search profiles..." class="pl-9 pr-4 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none w-56">
        </form>
        <button onclick="openModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-800 text-white text-sm font-semibold rounded-lg hover:bg-emerald-900 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Profile
        </button>
    </div>
</div>

{{-- Profiles Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    @forelse($profiles as $profile)
    <div class="profile-card animate-slide-up delay-{{ $loop->iteration > 2 ? 2 : $loop->iteration }} bg-white rounded-2xl border border-gray-100 p-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1.5" style="background-color: {{ $profile->color }}"></div>
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-lg" style="background: linear-gradient(135deg, {{ $profile->color }} 0%, {{ $profile->color }}dd 100%)">
                    {{ strtoupper(substr($profile->business_name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ $profile->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $profile->business_name }}</p>
                </div>
            </div>
            @if($profile->is_default)
            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Default</span>
            @endif
        </div>

        <div class="space-y-2 text-xs text-gray-500 mb-4">
            @if($profile->business_type)<p>Type: <span class="text-gray-700 font-medium">{{ $profile->business_type }}</span></p>@endif
            @if($profile->phone)<p>Phone: <span class="text-gray-700 font-medium">{{ $profile->phone }}</span></p>@endif
            @if($profile->email)<p>Email: <span class="text-gray-700 font-medium">{{ $profile->email }}</span></p>@endif
            @if($profile->business_tin)<p>TIN: <span class="text-gray-700 font-medium">{{ $profile->business_tin }}</span></p>@endif
        </div>

        @if($profile->description)
        <p class="text-xs text-gray-500 mb-4 leading-relaxed">{{ $profile->description }}</p>
        @endif

        <div class="flex items-center gap-2 pt-3 border-t">
            <form action="{{ route('user.payment-profiles.update', $profile->id) }}" method="POST" class="flex-1">
                @csrf
                @method('PUT')
                <input type="hidden" name="name" value="{{ $profile->name }}">
                <input type="hidden" name="business_name" value="{{ $profile->business_name }}">
                <input type="hidden" name="is_default" value="1">
                @if(!$profile->is_default)
                <button type="submit" class="w-full px-3 py-1.5 text-[10px] font-bold text-gray-600 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-all">Set as Default</button>
                @else
                <span class="block w-full text-center px-3 py-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-lg">Current Default</span>
                @endif
            </form>
            <form action="{{ route('user.payment-profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Delete this profile?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 text-[10px] font-bold text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-all">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="md:col-span-2 xl:col-span-3 text-center py-12 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <p class="text-sm font-medium text-gray-500">No payment profiles yet</p>
        <p class="text-xs text-gray-400 mt-1">Create your first profile to customize how customers see your business</p>
    </div>
    @endforelse
</div>

{{-- Create Profile Form --}}
<div id="createProfile" class="animate-slide-up bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h3 class="text-base font-bold text-gray-900">Create New Profile</h3>
            <p class="text-xs text-gray-400">Add a new business profile for your payment pages</p>
        </div>
    </div>
    <form action="{{ route('user.payment-profiles.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Profile Name</label>
                <input type="text" name="name" required class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="e.g. Main Store">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business Name</label>
                <input type="text" name="business_name" required class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="e.g. SalamaPay Ltd">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business Type</label>
                <select name="business_type" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all">
                    <option value="">Select type</option>
                    <option value="Sole Proprietorship">Sole Proprietorship</option>
                    <option value="Partnership">Partnership</option>
                    <option value="Limited Company">Limited Company</option>
                    <option value="NGO">NGO</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Phone</label>
                <input type="text" name="phone" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="+255...">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="business@example.com">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business TIN</label>
                <input type="text" name="business_tin" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="123-456-789">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Brand Color</label>
                <div class="flex items-center gap-2">
                    <input type="color" name="color" value="#024938" class="w-10 h-10 rounded-xl border border-gray-200 cursor-pointer">
                    <input type="text" name="color_text" value="#024938" onchange="this.previousElementSibling.value = this.value" class="form-input flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all font-mono" placeholder="#024938">
                </div>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
            <textarea name="description" rows="2" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none resize-none transition-all" placeholder="Short description shown on payment pages"></textarea>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_default" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
            <span class="text-xs font-semibold text-gray-700">Set as default profile</span>
        </label>
        <div class="pt-2">
            <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5">Create Profile</button>
        </div>
    </form>
</div>
@endsection
