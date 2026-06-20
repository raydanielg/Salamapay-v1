@extends('layouts.admin')

@section('title', 'Merchant Details - SalamaPay')
@section('page_title', 'Merchant Details')

@section('content')
@include('admin.partials.alert')

<div class="mb-6">
    <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Merchants
    </a>
    <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">{{ $user->business_name ?? $user->first_name . ' ' . $user->last_name }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Profile Card --}}
    <div class="bg-white rounded-xl border p-6">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-bold text-lg">
                {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Phone</span><span class="font-medium text-gray-900">{{ $user->phone }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Business</span><span class="font-medium text-gray-900">{{ $user->business_name ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Type</span><span class="font-medium text-gray-900">{{ $user->business_type ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">TIN</span><span class="font-medium text-gray-900">{{ $user->business_tin ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Joined</span><span class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span></div>
        </div>
        <div class="mt-5 pt-4 border-t">
            <form action="{{ route('admin.users.status', $user->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PUT')
                <select name="status" class="flex-1 px-3 py-2 text-xs border border-gray-200 rounded-lg outline-none focus:border-emerald-500 bg-white">
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                <button type="submit" class="px-3 py-2 text-xs font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Update</button>
            </form>
        </div>
    </div>

    {{-- Transactions --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border overflow-hidden">
            <div class="px-5 py-4 border-b">
                <h3 class="text-sm font-semibold text-gray-900">Recent Transactions</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                        <th class="px-5 py-2.5 font-medium">ID</th>
                        <th class="px-5 py-2.5 font-medium">Amount</th>
                        <th class="px-5 py-2.5 font-medium">Method</th>
                        <th class="px-5 py-2.5 font-medium">Status</th>
                        <th class="px-5 py-2.5 font-medium">Date</th>
                    </tr></thead>
                    <tbody>
                        @forelse($transactions as $tx)
                        <tr class="border-t border-gray-100">
                            <td class="px-5 py-2.5 font-mono text-xs text-gray-500">{{ $tx->tx_id }}</td>
                            <td class="px-5 py-2.5 font-semibold text-gray-900">TSh {{ number_format($tx->amount) }}</td>
                            <td class="px-5 py-2.5 text-xs text-gray-600">{{ $tx->method }}</td>
                            <td class="px-5 py-2.5">
                                @if($tx->status === 'success')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Success</span>
                                @elseif($tx->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                                @endif
                            </td>
                            <td class="px-5 py-2.5 text-xs text-gray-400">{{ $tx->processed_at?->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400 text-xs">No transactions</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border overflow-hidden">
            <div class="px-5 py-4 border-b">
                <h3 class="text-sm font-semibold text-gray-900">Recent Settlements</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                        <th class="px-5 py-2.5 font-medium">Reference</th>
                        <th class="px-5 py-2.5 font-medium">Amount</th>
                        <th class="px-5 py-2.5 font-medium">Status</th>
                        <th class="px-5 py-2.5 font-medium">Date</th>
                    </tr></thead>
                    <tbody>
                        @forelse($settlements as $st)
                        <tr class="border-t border-gray-100">
                            <td class="px-5 py-2.5 font-mono text-xs text-gray-500">{{ $st->reference }}</td>
                            <td class="px-5 py-2.5 font-semibold text-gray-900">TSh {{ number_format($st->amount) }}</td>
                            <td class="px-5 py-2.5">
                                @if($st->status === 'completed')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Completed</span>
                                @elseif($st->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Failed</span>
                                @endif
                            </td>
                            <td class="px-5 py-2.5 text-xs text-gray-400">{{ $st->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400 text-xs">No settlements</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
