@extends('layouts.admin')

@section('title', 'Merchants - SalamaPay')
@section('page_title', 'All Merchants')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', ['title' => 'Merchants', 'subtitle' => 'Manage all registered merchants'])

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['label'=>'Total','value'=>number_format($stats['total']),'color'=>'gray','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label'=>'Active','value'=>number_format($stats['active']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Pending','value'=>number_format($stats['pending']),'color'=>'amber','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Suspended','value'=>number_format($stats['suspended']),'color'=>'red','icon'=>'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636']
    ] as $card)
    <div class="bg-white rounded-xl border p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-gray-500">{{ $card['label'] }}</span>
            <div class="w-7 h-7 rounded-md bg-{{ $card['color'] }}-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
        </div>
        <p class="text-lg font-bold text-gray-900">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- Filters & Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="text-sm font-semibold text-gray-900">Merchant List</h3>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search merchants..." class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 w-48">
            <select name="status" class="px-3 py-1.5 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 bg-white" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                <option value="suspended" {{ request('status')==='suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Merchant</th>
                    <th class="px-5 py-3 font-medium">Contact</th>
                    <th class="px-5 py-3 font-medium">Business</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Joined</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-[10px]">
                                {{ strtoupper(substr($u->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $u->first_name }} {{ $u->last_name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-600">
                        <p>{{ $u->email }}</p>
                        <p>{{ $u->phone }}</p>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-600">{{ $u->business_name ?? '-' }}</td>
                    <td class="px-5 py-3">
                        @if($u->status === 'active')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                        @elseif($u->status === 'pending')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Suspended</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $u->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.users.show', $u->id) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                        <p class="text-sm font-medium">No merchants found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-3 border-t">{{ $users->links() }}</div>
    @endif
</div>
@endsection
