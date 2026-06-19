@extends('layouts.user')

@section('title', 'Merchant Dashboard - SalamaPay')
@section('page_title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+15%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">TZS 8.4M</p>
        <p class="text-sm text-gray-500 mt-0.5">Wallet Balance</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-gold-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+22%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">TZS 12.1M</p>
        <p class="text-sm text-gray-500 mt-0.5">Sales This Month</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+8%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">1,245</p>
        <p class="text-sm text-gray-500 mt-0.5">Total Orders</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+3%</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-800">99.5%</p>
        <p class="text-sm text-gray-500 mt-0.5">Success Rate</p>
    </div>
</div>

{{-- Quick Actions + Recent --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Quick Actions</h3>
        </div>
        <div class="p-6 grid grid-cols-2 gap-3">
            <a href="#" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-emerald-50 hover:bg-emerald-100 transition-colors border border-emerald-100">
                <div class="w-10 h-10 rounded-lg bg-emerald-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <span class="text-xs font-semibold text-emerald-700">New Payment</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-gold-50 hover:bg-gold-100 transition-colors border border-gold-100">
                <div class="w-10 h-10 rounded-lg bg-gold-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <span class="text-xs font-semibold text-gold-700">Withdraw</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors border border-blue-100">
                <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <span class="text-xs font-semibold text-blue-700">API Keys</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-purple-50 hover:bg-purple-100 transition-colors border border-purple-100">
                <div class="w-10 h-10 rounded-lg bg-purple-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <span class="text-xs font-semibold text-purple-700">Reports</span>
            </a>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Recent Payments</h3>
            <a href="#" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">View All</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach([
                ['customer'=>'John Mwakasege','amount'=>'TZS 250,000','status'=>'success','method'=>'M-Pesa','time'=>'Just now'],
                ['customer'=>'Sarah Hussein','amount'=>'TZS 180,000','status'=>'success','method'=>'Tigo Pesa','time'=>'3 min ago'],
                ['customer'=>'Michael Joseph','amount'=>'TZS 500,000','status'=>'pending','method'=>'Airtel Money','time'=>'7 min ago'],
                ['customer'=>'Grace Mallya','amount'=>'TZS 95,000','status'=>'success','method'=>'M-Pesa','time'=>'12 min ago'],
                ['customer'=>'Daniel Kavishe','amount'=>'TZS 320,000','status'=>'success','method'=>'Bank Transfer','time'=>'20 min ago'],
            ] as $tx)
            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white
                        {{ $tx['status'] === 'success' ? 'bg-emerald-500' : 'bg-gold-400' }}">
                        {{ substr($tx['customer'], 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $tx['customer'] }}</p>
                        <p class="text-xs text-gray-400">{{ $tx['method'] }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">{{ $tx['amount'] }}</p>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $tx['status'] === 'success' ? 'bg-emerald-50 text-emerald-600' : 'bg-gold-50 text-gold-600' }}">{{ ucfirst($tx['status']) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
