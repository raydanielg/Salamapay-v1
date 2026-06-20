@extends('layouts.user')

@section('title', 'Website Builder - SalamaPay')
@section('page_title', 'Website Builder')

@section('content')
@include('user.partials.alert')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-bold text-gray-900">Website Builder</h1>
        <p class="text-xs text-gray-500 mt-0.5">Choose and customize a template for your payment pages</p>
    </div>
</div>

{{-- Templates Showcase --}}
<div class="mb-8">
    <h2 class="text-sm font-semibold text-gray-900 mb-4">Available Templates</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($templates as $template)
        <div class="bg-white rounded-xl border overflow-hidden hover:shadow-sm transition-all group">
            <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                @if($template->thumbnail)
                <img src="{{ asset('storage/'.$template->thumbnail) }}" alt="{{ $template->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-gray-100">
                    <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    </div>
                </div>
                @endif
                @if($template->is_premium)
                <div class="absolute top-2 right-2">
                    <span class="px-2 py-0.5 bg-gold-400 text-white text-[10px] font-bold rounded-md">PREMIUM</span>
                </div>
                @endif
            </div>
            <div class="p-4">
                <h3 class="text-sm font-bold text-gray-900">{{ $template->name }}</h3>
                <p class="text-xs text-gray-500 mt-1 mb-3">{{ $template->description ?? 'Clean and modern payment page template' }}</p>
                @if($template->default_colors)
                <div class="flex items-center gap-1.5 mb-3">
                    <span class="text-[10px] text-gray-400">Default colors:</span>
                    @foreach($template->default_colors as $key => $color)
                    <div class="w-4 h-4 rounded-full border border-gray-200" style="background: {{ $color }}"></div>
                    @endforeach
                </div>
                @endif
                <div class="flex items-center gap-2 text-[10px] text-gray-400 mb-3">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        {{ $template->payment_profiles_count }} merchants using
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Your Profiles --}}
<div>
    <h2 class="text-sm font-semibold text-gray-900 mb-4">Your Payment Profiles</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @forelse($profiles as $profile)
        <div class="bg-white rounded-xl border p-4 hover:shadow-sm transition-all">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: {{ $profile->color ?? '#024938' }}10;">
                        @if($profile->logo)
                        <img src="{{ asset('storage/'.$profile->logo) }}" class="w-8 h-8 object-contain rounded">
                        @else
                        <span class="text-sm font-bold" style="color: {{ $profile->color ?? '#024938' }}">{{ strtoupper(substr($profile->business_name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $profile->business_name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $profile->name }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $profile->is_default ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                    {{ $profile->is_default ? 'Default' : 'Profile' }}
                </span>
            </div>

            {{-- Current Template --}}
            <div class="flex items-center gap-2 mb-3 p-2 bg-gray-50 rounded-lg">
                <div class="w-6 h-6 rounded bg-gray-200 flex items-center justify-center">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/></svg>
                </div>
                <span class="text-xs text-gray-600">{{ $profile->template?->name ?? 'Default Template' }}</span>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('user.templates.customize', $profile->id) }}" class="flex-1 py-2 text-center text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                    Customize
                </a>
                <a href="{{ route('user.templates.preview', $profile->id) }}" target="_blank" class="px-3 py-2 text-xs font-medium text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Preview
                </a>
            </div>
        </div>
        @empty
        <div class="lg:col-span-2 bg-white rounded-xl border border-dashed border-gray-200 p-10 text-center">
            <p class="text-sm font-semibold text-gray-700">No payment profiles</p>
            <p class="text-xs text-gray-400 mt-1">Create a payment profile first to customize your template</p>
            <a href="{{ route('user.payment-profiles') }}" class="inline-block mt-4 px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Create Profile</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
