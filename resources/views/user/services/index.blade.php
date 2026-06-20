@extends('layouts.user')

@section('title', 'Services - SalamaPay')
@section('page_title', 'Services')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Services', 'subtitle' => 'Manage your service offerings'])

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Services</p>
        <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Active</p>
        <p class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['active'] }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Paused</p>
        <p class="text-2xl font-black text-amber-600 mt-1">{{ $stats['paused'] }}</p>
    </div>
    <div class="bg-white rounded-xl border p-4">
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Bookings</p>
        <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($stats['totalBookings']) }}</p>
    </div>
</div>

{{-- Actions --}}
<div class="flex items-center justify-between mb-4">
    <div class="relative flex-1 max-w-sm">
        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" placeholder="Search services..." class="w-full pl-10 pr-4 py-2 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
    </div>
    <button class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-colors flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Service
    </button>
</div>

{{-- Services Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Service</th>
                    <th class="text-left px-5 py-3 font-semibold">Price</th>
                    <th class="text-left px-5 py-3 font-semibold">Duration</th>
                    <th class="text-left px-5 py-3 font-semibold">Status</th>
                    <th class="text-left px-5 py-3 font-semibold">Bookings</th>
                    <th class="text-left px-5 py-3 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($services as $service)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                {{ strtoupper(substr($service['name'], 0, 1)) }}
                            </div>
                            <p class="font-semibold text-gray-900 text-xs">{{ $service['name'] }}</p>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-gray-900 text-xs">TSh {{ number_format($service['price']) }}</td>
                    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $service['duration'] }}</td>
                    <td class="px-5 py-3.5">
                        @if($service['status'] === 'active')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Paused</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-xs text-gray-500">{{ number_format($service['bookings']) }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-2">
                            <button class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700">Edit</button>
                            <button class="text-[10px] font-bold text-gray-400 hover:text-red-600">Delete</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
