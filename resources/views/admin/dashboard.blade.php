@extends('layouts.admin')

@section('title', 'Admin Dashboard - SalamaPay')
@section('page_title', 'Dashboard Overview')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+12%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">1,247</p>
        <p class="text-sm text-gray-500 mt-0.5">Total Merchants</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-gold-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+8.5%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">TZS 45.2M</p>
        <p class="text-sm text-gray-500 mt-0.5">Total Volume</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-full">-2%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">3,842</p>
        <p class="text-sm text-gray-500 mt-0.5">Transactions</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+5%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">98.2%</p>
        <p class="text-sm text-gray-500 mt-0.5">Success Rate</p>
    </div>
</div>

{{-- Main Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Recent Transactions --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Recent Transactions</h3>
            <a href="#" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">View All</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach([
                ['id'=>'#TRX-8921','merchant'=>'Jumia Tanzania','amount'=>'TZS 1,250,000','status'=>'success','time'=>'2 min ago'],
                ['id'=>'#TRX-8920','merchant'=>'M-Pesa Agent','amount'=>'TZS 450,000','status'=>'pending','time'=>'5 min ago'],
                ['id'=>'#TRX-8919','merchant'=>'Nala Money','amount'=>'TZS 2,100,000','status'=>'success','time'=>'12 min ago'],
                ['id'=>'#TRX-8918','merchant'=>'Azam TV','amount'=>'TZS 89,000','status'=>'failed','time'=>'18 min ago'],
                ['id'=>'#TRX-8917','merchant'=>'Tigo Pesa','amount'=>'TZS 670,000','status'=>'success','time'=>'25 min ago'],
            ] as $tx)
            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center
                        {{ $tx['status'] === 'success' ? 'bg-emerald-50 text-emerald-600' : ($tx['status'] === 'pending' ? 'bg-gold-50 text-gold-600' : 'bg-red-50 text-red-600') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($tx['status'] === 'success')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            @elseif($tx['status'] === 'pending')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            @endif
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $tx['merchant'] }}</p>
                        <p class="text-xs text-gray-400">{{ $tx['id'] }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">{{ $tx['amount'] }}</p>
                    <p class="text-xs text-gray-400">{{ $tx['time'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right Column --}}
    <div class="space-y-6">
        {{-- Pending KYC --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">Pending KYC</h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach(['Skyline Tech Ltd','Dar es Salaam Motors','Kariakoo Traders'] as $kyc)
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-600">
                        {{ substr($kyc, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $kyc }}</p>
                        <p class="text-xs text-gray-400">Awaiting verification</p>
                    </div>
                    <button class="text-xs font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Review</button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- System Health --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">System Health</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs text-gray-500">API Uptime</span>
                        <span class="text-xs font-bold text-emerald-600">99.98%</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: 99.98%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs text-gray-500">Database</span>
                        <span class="text-xs font-bold text-emerald-600">Healthy</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs text-gray-500">Queue Workers</span>
                        <span class="text-xs font-bold text-gold-500">4 Active</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gold-400 rounded-full" style="width: 80%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
