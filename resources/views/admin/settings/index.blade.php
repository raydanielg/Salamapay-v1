@extends('layouts.admin')

@section('title', 'Settings - SalamaPay')
@section('page_title', 'System Settings')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', ['title' => 'System Settings', 'subtitle' => 'Configure platform-wide settings and preferences'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        @foreach($settings as $group => $items)
        <div class="bg-white rounded-xl border overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50/50">
                <h3 class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $group) }}</h3>
            </div>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                @foreach($items as $setting)
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">{{ $setting->description ?? $setting->key }}</label>
                    @if($setting->type === 'boolean')
                    <select name="setting_{{ $setting->key }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white">
                        <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Disabled</option>
                    </select>
                    @elseif($setting->type === 'json')
                    <textarea name="setting_{{ $setting->key }}" rows="4" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none font-mono text-xs">{{ $setting->value }}</textarea>
                    @else
                    <input type="text" name="setting_{{ $setting->key }}" value="{{ $setting->value }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none">
                    @endif
                    <p class="text-[10px] text-gray-400 mt-1 font-mono">{{ $setting->key }} ({{ $setting->type }})</p>
                </div>
                @endforeach
                <div class="pt-2">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Save {{ str_replace('_', ' ', $group) }}</button>
                </div>
            </form>
        </div>
        @endforeach

        @if($settings->isEmpty())
        <div class="bg-white rounded-xl border p-10 text-center">
            <p class="text-sm text-gray-500">No settings configured yet</p>
        </div>
        @endif
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Add New Setting</h3>
            <form action="{{ route('admin.settings.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Key</label>
                    <input type="text" name="key" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none" placeholder="e.g. platform_name" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Value</label>
                    <input type="text" name="value" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none" placeholder="Setting value">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Group</label>
                    <input type="text" name="group" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none" placeholder="general" value="general">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white">
                        <option value="string">String</option>
                        <option value="number">Number</option>
                        <option value="boolean">Boolean</option>
                        <option value="json">JSON</option>
                    </select>
                </div>
                <button type="submit" class="w-full px-4 py-2 text-sm font-semibold bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm">Add Setting</button>
            </form>
        </div>
    </div>
</div>
@endsection
