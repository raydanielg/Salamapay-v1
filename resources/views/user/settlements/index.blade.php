@extends('layouts.user')

@section('title', 'Settlements - SalamaPay')
@section('page_title', 'Settlements')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Settlements', 'subtitle' => 'Track all your withdrawal and settlement requests'])

@php
$fmt = fn($n) => $n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n));
@endphp

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['label'=>'Total','value'=>number_format($stats['total']),'color'=>'gray','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label'=>'Pending','value'=>number_format($stats['pending']),'color'=>'amber','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Completed','value'=>number_format($stats['completed']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Total Settled','value'=>'TZS '.$fmt($stats['totalAmount']),'color'=>'emerald','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
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

{{-- Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b">
        <h3 class="text-sm font-semibold text-gray-900">Settlement History</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Reference</th>
                    <th class="px-5 py-3 font-medium">Amount</th>
                    <th class="px-5 py-3 font-medium">Fee</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Method</th>
                    <th class="px-5 py-3 font-medium">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settlements as $st)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $st->reference }}</td>
                    <td class="px-5 py-3 font-semibold text-gray-900">TSh {{ number_format($st->amount) }}</td>
                    <td class="px-5 py-3 text-gray-500">TSh {{ number_format($st->fee) }}</td>
                    <td class="px-5 py-3">
                        @if($st->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1 h-1 rounded-full bg-emerald-500"></span>Completed</span>
                        @elseif($st->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100"><span class="w-1 h-1 rounded-full bg-amber-400"></span>Pending</span>
                        @elseif($st->status === 'processing')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100"><span class="w-1 h-1 rounded-full bg-blue-500"></span>Processing</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100"><span class="w-1 h-1 rounded-full bg-red-400"></span>Failed</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-600 capitalize">{{ $st->method ?? 'Bank' }}</td>
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $st->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <p class="text-sm font-medium">No settlements yet</p>
                        <p class="text-xs mt-1"><a href="{{ route('user.wallet.withdraw') }}" class="text-emerald-600 hover:text-emerald-700">Withdraw funds</a> to see them here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($settlements->hasPages())
    <div class="px-5 py-3 border-t">{{ $settlements->links() }}</div>
    @endif
</div>
@endsection
