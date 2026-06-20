@extends('layouts.user')

@section('title', 'Customize Template - SalamaPay')
@section('page_title', 'Customize Template')

@section('content')
@include('user.partials.alert')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('user.templates') }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900">Customize Website</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ $profile->business_name }}</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('user.templates.preview', $profile->id) }}" target="_blank" class="px-3 py-2 text-xs font-medium text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Preview
        </a>
    </div>
</div>

<form action="{{ route('user.templates.update', $profile->id) }}" method="POST" enctype="multipart/form-data" id="customizeForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')

    {{-- Left: Settings --}}
    <div class="lg:col-span-1 space-y-5">
        {{-- Template Selection --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Choose Template</h3>
            <div class="space-y-2">
                @foreach($templates as $template)
                <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all hover:border-emerald-300 {{ $profile->template_id == $template->id ? 'border-emerald-500 bg-emerald-50/30' : 'border-gray-200' }}">
                    <input type="radio" name="template_id" value="{{ $template->id }}" {{ $profile->template_id == $template->id ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">{{ $template->name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $template->slug }}</p>
                    </div>
                    @if($template->is_premium)
                    <span class="px-1.5 py-0.5 bg-gold-400 text-white text-[9px] font-bold rounded">PRO</span>
                    @endif
                </label>
                @endforeach
            </div>
        </div>

        {{-- Colors --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Brand Colors</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Primary Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="color" value="{{ $profile->color ?? '#024938' }}" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer shrink-0">
                        <input type="text" value="{{ $profile->color ?? '#024938' }}" class="flex-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Accent Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="template_settings[accent_color]" value="{{ ($profile->template_settings['accent_color'] ?? '#f9ac00') }}" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer shrink-0">
                        <input type="text" value="{{ $profile->template_settings['accent_color'] ?? '#f9ac00' }}" class="flex-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Background</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="template_settings[bg_color]" value="{{ ($profile->template_settings['bg_color'] ?? '#ffffff') }}" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer shrink-0">
                        <input type="text" value="{{ $profile->template_settings['bg_color'] ?? '#ffffff' }}" class="flex-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono" readonly>
                    </div>
                </div>
            </div>
        </div>

        {{-- Logo --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Logo</h3>
            <div class="space-y-3">
                @if($profile->logo)
                <div class="w-full h-24 rounded-lg border border-gray-100 flex items-center justify-center bg-gray-50">
                    <img src="{{ asset('storage/'.$profile->logo) }}" class="h-16 object-contain">
                </div>
                @endif
                <input type="file" name="logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>
        </div>
    </div>

    {{-- Right: Content & Preview --}}
    <div class="lg:col-span-2 space-y-5">
        {{-- Website Content --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Website Content</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Hero Title</label>
                    <input type="text" name="template_settings[hero_title]" value="{{ $profile->template_settings['hero_title'] ?? 'Welcome to ' . $profile->business_name }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                    <p class="text-[10px] text-gray-400 mt-1">Main headline on your homepage</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Hero Text</label>
                    <textarea name="template_settings[hero_text]" rows="2" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all resize-none">{{ $profile->template_settings['hero_text'] ?? $profile->description }}</textarea>
                    <p class="text-[10px] text-gray-400 mt-1">Subtitle under the hero title</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Button Text</label>
                    <input type="text" name="template_settings[cta_text]" value="{{ $profile->template_settings['cta_text'] ?? 'Pay Now' }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                    <p class="text-[10px] text-gray-400 mt-1">Text on the main call-to-action button</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Footer Text</label>
                    <input type="text" name="template_settings[footer_text]" value="{{ $profile->template_settings['footer_text'] ?? 'All rights reserved. Powered by SalamaPay.' }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                </div>
            </div>
        </div>

        {{-- Business Info --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Business Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Business Name</label>
                    <input type="text" name="business_name" value="{{ $profile->business_name }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all resize-none">{{ $profile->description }}</textarea>
                </div>
            </div>
        </div>

        {{-- Cover Image --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Cover / Hero Image</h3>
            @if($profile->template_settings['cover_image'] ?? false)
            <div class="w-full h-40 rounded-lg border border-gray-100 overflow-hidden mb-3">
                <img src="{{ asset('storage/'.$profile->template_settings['cover_image']) }}" class="w-full h-full object-cover">
            </div>
            @endif
            <input type="file" name="template_settings[cover_image]" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            <p class="text-[10px] text-gray-400 mt-2">Recommended: 1200 x 600 pixels</p>
        </div>

        {{-- Layout Options --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Layout Options</h3>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer transition-all">
                    <input type="checkbox" name="template_settings[show_logo]" value="1" {{ ($profile->template_settings['show_logo'] ?? true) ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                    <span class="text-xs text-gray-700 font-medium">Show Logo</span>
                </label>
                <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer transition-all">
                    <input type="checkbox" name="template_settings[show_description]" value="1" {{ ($profile->template_settings['show_description'] ?? true) ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                    <span class="text-xs text-gray-700 font-medium">Show Description</span>
                </label>
                <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer transition-all">
                    <input type="checkbox" name="template_settings[rounded_cards]" value="1" {{ ($profile->template_settings['rounded_cards'] ?? true) ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                    <span class="text-xs text-gray-700 font-medium">Rounded Cards</span>
                </label>
                <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer transition-all">
                    <input type="checkbox" name="template_settings[dark_mode]" value="1" {{ ($profile->template_settings['dark_mode'] ?? false) ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                    <span class="text-xs text-gray-700 font-medium">Dark Mode</span>
                </label>
            </div>
        </div>
    </div>
</form>

{{-- Floating Save Button --}}
<div class="fixed bottom-6 right-6 z-40">
    <button type="submit" form="customizeForm" class="px-6 py-3 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-lg flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Save Changes
    </button>
</div>

<script>
// Sync color pickers with text inputs
document.querySelectorAll('input[type="color"]').forEach(picker => {
    picker.addEventListener('input', function() {
        this.nextElementSibling.value = this.value;
    });
});
</script>
@endsection
