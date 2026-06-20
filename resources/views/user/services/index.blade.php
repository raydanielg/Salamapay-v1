@extends('layouts.user')

@section('title', 'Services - SalamaPay')
@section('page_title', 'Services')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Services', 'subtitle' => 'Manage your service offerings'])

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Services</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['total'] }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">All services</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Active</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['active'] }}</p>
        <p class="text-[10px] text-blue-200 mt-1">Available for booking</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Paused</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['paused'] }}</p>
        <p class="text-[10px] text-amber-100 mt-1">Temporarily unavailable</p>
    </div>
    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-violet-100">Total Bookings</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['totalBookings']) }}</p>
        <p class="text-[10px] text-violet-100 mt-1">All time bookings</p>
    </div>
</div>

{{-- Filters + Add --}}
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-4">
    <form method="GET" action="{{ route('user.services') }}" class="flex-1 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1 max-w-sm">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services..." class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
        </div>
        <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 border rounded-xl text-xs font-medium text-gray-600 outline-none focus:border-emerald-500 cursor-pointer">
            <option value="all">All Status</option>
            <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
            <option value="paused" {{ request('status')==='paused'?'selected':'' }}>Paused</option>
            <option value="archived" {{ request('status')==='archived'?'selected':'' }}>Archived</option>
        </select>
        @if($categories->count())
        <select name="category" onchange="this.form.submit()" class="px-3 py-2.5 border rounded-xl text-xs font-medium text-gray-600 outline-none focus:border-emerald-500 cursor-pointer">
            <option value="all">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>
        @endif
        @if(request()->hasAny(['search','status','category']))
        <a href="{{ route('user.services') }}" class="px-3 py-2.5 border rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-50 flex items-center gap-1.5 whitespace-nowrap">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Clear
        </a>
        @endif
    </form>
    <div class="flex gap-2">
        <div class="relative" id="exportDropdownContainer">
            <button onclick="toggleExportDropdown()" class="px-4 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="exportDropdown" class="hidden absolute right-0 top-full mt-2 w-48 bg-white rounded-xl border shadow-lg py-1.5 z-50">
                <button onclick="printServices()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print
                </button>
                <button onclick="exportCSV()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </button>
                <button onclick="exportPDF()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export PDF
                </button>
            </div>
        </div>
        <button onclick="openServiceDrawer()" class="px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Service
        </button>
    </div>
</div>

{{-- Printable Area --}}
<div id="printableArea">

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
                @forelse($services as $service)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                {{ strtoupper(substr($service->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-xs">{{ $service->name }}</p>
                                @if($service->category)
                                <p class="text-[10px] text-gray-400">{{ $service->category }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-gray-900 text-xs">TSh {{ number_format($service->price) }}</td>
                    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $service->duration ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        @if($service->status === 'active')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                        @elseif($service->status === 'paused')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Paused</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">Archived</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-xs text-gray-500">{{ number_format($service->bookings) }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="openEditServiceDrawer({{ $service->id }}, '{{ addslashes($service->name) }}', '{{ addslashes($service->description ?? '') }}', {{ $service->price }}, '{{ $service->duration ?? '' }}', '{{ $service->category ?? '' }}', '{{ $service->status }}', {{ json_encode($service->variants ?? []) }})" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded-md transition-colors">Edit</button>
                            <button onclick="deleteService({{ $service->id }}, '{{ addslashes($service->name) }}')" class="text-[10px] font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-md transition-colors">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-500">No services found</p>
                            <p class="text-xs text-gray-400 mt-0.5">Add your first service to get started.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
    <div class="px-5 py-3 border-t">{{ $services->links() }}</div>
    @endif
</div>
</div>

{{-- Slide-in Service Drawer --}}
<style>
#serviceDrawer { transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
#serviceDrawer.overlay-open { transform: translateX(0); }
#serviceDrawer.overlay-closed { transform: translateX(100%); }
.drawer-backdrop { transition: opacity 0.3s ease; }
.drawer-backdrop.open { opacity: 1; pointer-events: auto; }
.drawer-backdrop.closed { opacity: 0; pointer-events: none; }
@media print {
    body * { visibility: hidden; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea { position: absolute; left: 0; top: 0; width: 100%; }
    #printableArea .overflow-x-auto { overflow: visible !important; }
    #printableArea table { width: 100% !important; border-collapse: collapse; }
    #printableArea th, #printableArea td { border: 1px solid #ddd; padding: 8px; }
    #printableArea .opacity-0 { opacity: 1 !important; }
}
</style>

<div id="drawerBackdrop" class="drawer-backdrop closed fixed inset-0 bg-black/40 backdrop-blur-sm z-[50]" onclick="closeServiceDrawer()"></div>
<div id="serviceDrawer" class="fixed inset-y-0 right-0 z-[55] w-full max-w-lg bg-white shadow-2xl flex flex-col overlay-closed">
    {{-- Drawer Header --}}
    <div class="px-6 py-4 border-b flex items-center justify-between bg-white shrink-0">
        <div>
            <h3 class="text-base font-black text-gray-900" id="svcDrawerTitle">Add Service</h3>
            <p class="text-[10px] text-gray-400">Manage service details, variants & settings</p>
        </div>
        <button onclick="closeServiceDrawer()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Tabs --}}
    <div class="flex border-b bg-gray-50/50 shrink-0">
        <button onclick="switchDrawerTab('service')" id="tabService" class="flex-1 py-3 text-xs font-bold text-emerald-600 border-b-2 border-emerald-600 bg-white transition-colors">Service</button>
        <button onclick="switchDrawerTab('settings')" id="tabSettings" class="flex-1 py-3 text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">Settings</button>
    </div>

    {{-- Drawer Content --}}
    <div class="flex-1 overflow-y-auto">
        {{-- Tab: Service Form --}}
        <div id="panelService" class="p-6 space-y-4">
            <form id="serviceForm" method="POST" action="{{ route('user.services.store') }}">
                @csrf
                <div id="svcMethodField"></div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Service Name</label>
                    <input type="text" name="name" id="svcName" required class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Web Development">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Price (TSh)</label>
                        <input type="number" name="price" id="svcPrice" required min="0" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Duration</label>
                        <input type="text" name="duration" id="svcDuration" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. 2 Weeks">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                        <input type="text" name="category" id="svcCategory" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Design">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                        <select name="status" id="svcStatus" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 transition-all">
                            <option value="active">Active</option>
                            <option value="paused">Paused</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Description</label>
                    <textarea name="description" id="svcDesc" rows="3" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all resize-none" placeholder="Describe the service in detail..."></textarea>
                </div>

                {{-- Sub-services / Variants --}}
                <div class="pt-2 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Service Variants / Sub-types</label>
                        <span class="text-[10px] text-gray-400">Optional packages or tiers</span>
                    </div>
                    <div id="variantsList" class="space-y-2 mb-2">
                        {{-- Variants added dynamically --}}
                    </div>
                    <button type="button" onclick="addVariantRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Variant (Package / Tier)
                    </button>
                </div>

                <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-2">
                    <button type="button" onclick="closeServiceDrawer()" class="flex-1 py-3 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Service</button>
                </div>
            </form>
        </div>

        {{-- Tab: Settings --}}
        <div id="panelSettings" class="p-6 space-y-5 hidden">
            <form method="POST" action="{{ route('user.tools.update') }}">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Service Categories</label>
                    <div id="drawerServiceCategories" class="space-y-2 mb-2">
                        @php
                            $svcCats = json_decode(auth()->user()->settings['service_categories'] ?? '[]', true) ?: ['Consulting','Design','Development','Marketing','Cleaning','Repair'];
                        @endphp
                        @foreach($svcCats as $cat)
                        <div class="flex items-center gap-2 svc-cat-row">
                            <input type="text" name="service_categories[]" value="{{ $cat }}" class="flex-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                            <button type="button" onclick="this.closest('.svc-cat-row').remove()" class="p-2 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addServiceCategoryRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Category
                    </button>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Default Durations</label>
                    <div id="drawerDurationsList" class="space-y-2 mb-2">
                        @php
                            $durations = json_decode(auth()->user()->settings['service_durations'] ?? '[]', true) ?: ['30 Minutes','1 Hour','2 Hours','1 Day','1 Week'];
                        @endphp
                        @foreach($durations as $dur)
                        <div class="flex items-center gap-2 dur-row">
                            <input type="text" name="service_durations[]" value="{{ $dur }}" class="flex-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                            <button type="button" onclick="this.closest('.dur-row').remove()" class="p-2 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addDurationRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Duration
                    </button>
                </div>

                <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-2">
                    <button type="button" onclick="closeServiceDrawer()" class="flex-1 py-3 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Form --}}
<form id="deleteServiceForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

<script>
function openServiceModal() {
    document.getElementById('serviceForm').action = '{{ route('user.services.store') }}';
    document.getElementById('svcMethodField').innerHTML = '';
    document.getElementById('svcModalTitle').textContent = 'Add Service';
    ['svcName','svcPrice','svcDuration','svcCategory','svcDesc'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('svcStatus').value = 'active';
    const m = document.getElementById('serviceModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function openEditServiceModal(id, name, description, price, duration, category, status) {
    document.getElementById('serviceForm').action = '{{ url('services') }}/' + id;
    document.getElementById('svcMethodField').innerHTML = '@method('PUT')';
    document.getElementById('svcModalTitle').textContent = 'Edit Service';
    document.getElementById('svcName').value = name;
    document.getElementById('svcDesc').value = description;
    document.getElementById('svcPrice').value = price;
    document.getElementById('svcDuration').value = duration;
    document.getElementById('svcCategory').value = category;
    document.getElementById('svcStatus').value = status;
    const m = document.getElementById('serviceModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closeServiceModal() {
    const m = document.getElementById('serviceModal');
    m.classList.add('hidden'); m.classList.remove('flex');
}
function deleteService(id, name) {
    saConfirm({
        title: 'Delete Service?',
        text: 'Are you sure you want to delete "' + name + '"? This cannot be undone.',
        icon: 'danger',
        confirmText: 'Delete',
        confirmColor: 'red',
        onConfirm: function() {
            const form = document.getElementById('deleteServiceForm');
            form.action = '{{ url('services') }}/' + id;
            form.submit();
        }
    });
}
</script>
@endsection
