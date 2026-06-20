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
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Bookings</p>
        <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($stats['totalBookings']) }}</p>
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
    <button onclick="openServiceModal()" class="px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
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
                            <button onclick="openEditServiceModal({{ $service->id }}, '{{ addslashes($service->name) }}', '{{ addslashes($service->description ?? '') }}', {{ $service->price }}, '{{ $service->duration ?? '' }}', '{{ $service->category ?? '' }}', '{{ $service->status }}')" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded-md transition-colors">Edit</button>
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

{{-- Service Modal --}}
<div id="serviceModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeServiceModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-fade">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900" id="svcModalTitle">Add Service</h3>
            <button onclick="closeServiceModal()" class="p-1 rounded-lg hover:bg-gray-100 transition-colors"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="serviceForm" method="POST" action="{{ route('user.services.store') }}" class="p-5 space-y-3.5">
            @csrf
            <div id="svcMethodField"></div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Service Name</label>
                <input type="text" name="name" id="svcName" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Web Development">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Price (TSh)</label>
                    <input type="number" name="price" id="svcPrice" required min="0" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="0">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Duration</label>
                    <input type="text" name="duration" id="svcDuration" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. 2 Weeks">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                    <input type="text" name="category" id="svcCategory" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Design">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" id="svcStatus" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 transition-all">
                        <option value="active">Active</option>
                        <option value="paused">Paused</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Description</label>
                <textarea name="description" id="svcDesc" rows="2" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all resize-none" placeholder="Optional description..."></textarea>
            </div>
            <div class="pt-1 flex gap-2">
                <button type="button" onclick="closeServiceModal()" class="flex-1 py-2.5 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Service</button>
            </div>
        </form>
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
