@extends('layouts.admin')

@section('title', 'Settings - SalamaPay')
@section('page_title', 'System Settings')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', ['title' => 'System Settings', 'subtitle' => 'Configure platform-wide settings and preferences'])

@php
$groupConfig = [
    'general' => ['label' => 'General', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'emerald'],
    'payments' => ['label' => 'Payments', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => 'blue'],
    'fees' => ['label' => 'Fees & Pricing', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'gold'],
    'security' => ['label' => 'Security', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'color' => 'red'],
    'notifications' => ['label' => 'Notifications', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => 'purple'],
];
$activeGroup = request('group', array_key_first($settings->toArray()) ?? 'general');
@endphp

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- Sidebar Tabs --}}
    <div class="lg:col-span-1 space-y-2">
        <div class="bg-white rounded-xl border p-2">
            @foreach($settings as $group => $items)
            @php $cfg = $groupConfig[$group] ?? ['label' => ucfirst($group), 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'gray']; @endphp
            <a href="?group={{ $group }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $activeGroup === $group ? 'bg-' . $cfg['color'] . '-50 text-' . $cfg['color'] . '-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="w-7 h-7 rounded-md {{ $activeGroup === $group ? 'bg-' . $cfg['color'] . '-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 {{ $activeGroup === $group ? 'text-' . $cfg['color'] . '-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cfg['icon'] }}"/></svg>
                </div>
                <span>{{ $cfg['label'] }}</span>
                <span class="ml-auto text-[10px] {{ $activeGroup === $group ? 'text-' . $cfg['color'] . '-600' : 'text-gray-400' }}">{{ count($items) }}</span>
            </a>
            @endforeach
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl border p-4">
            <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-3">Quick Actions</h3>
            <div class="space-y-2">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="setting_maintenance_mode" value="{{ \App\Models\SystemSetting::get('maintenance_mode', 0) ? '0' : '1' }}">
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium {{ \App\Models\SystemSetting::get('maintenance_mode', 0) ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }} transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ \App\Models\SystemSetting::get('maintenance_mode', 0) ? 'Disable Maintenance' : 'Enable Maintenance' }}
                    </button>
                </form>
                <a href="{{ route('admin.settings') }}?action=seed" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 border border-gray-200 hover:bg-gray-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Reset to Defaults
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="lg:col-span-3 space-y-6">
        @if(isset($settings[$activeGroup]))
        @php $items = $settings[$activeGroup]; $cfg = $groupConfig[$activeGroup] ?? ['label' => ucfirst($activeGroup), 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'gray']; @endphp
        <div class="bg-white rounded-xl border overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-{{ $cfg['color'] }}-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-{{ $cfg['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cfg['icon'] }}"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">{{ $cfg['label'] }} Settings</h3>
                    <p class="text-xs text-gray-500">Manage {{ strtolower($cfg['label']) }} configuration</p>
                </div>
            </div>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($items as $setting)
                    <div class="{{ $setting->type === 'json' ? 'md:col-span-2' : '' }}">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">{{ $setting->description ?? $setting->key }}</label>
                        @if($setting->type === 'boolean')
                        <select name="setting_{{ $setting->key }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white transition-all">
                            <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                        @elseif($setting->type === 'json')
                        <textarea name="setting_{{ $setting->key }}" rows="5" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none font-mono text-xs resize-none">{{ $setting->value }}</textarea>
                        @elseif($setting->type === 'number')
                        <input type="number" name="setting_{{ $setting->key }}" value="{{ $setting->value }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                        @else
                        <input type="text" name="setting_{{ $setting->key }}" value="{{ $setting->value }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                        @endif
                        <p class="text-[10px] text-gray-400 mt-1 font-mono flex items-center gap-1">
                            <span class="px-1 py-0.5 bg-gray-100 rounded text-gray-500">{{ $setting->key }}</span>
                            <span>{{ $setting->type }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-4 border-t flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">Save Changes</button>
                    <a href="{{ route('admin.settings') }}" class="text-sm text-gray-500 hover:text-gray-700">Reset</a>
                </div>
            </form>
        </div>
        @endif

        @if($settings->isEmpty())
        <div class="bg-white rounded-xl border p-10 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
            <p class="text-sm font-medium text-gray-500">No settings configured yet</p>
            <p class="text-xs text-gray-400 mt-1">Run <code class="bg-gray-100 px-1 py-0.5 rounded">php artisan db:seed --class=SystemSettingSeeder</code> to populate defaults.</p>
        </div>
        @endif
    </div>
</div>
@endsection
