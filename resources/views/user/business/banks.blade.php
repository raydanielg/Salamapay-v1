@extends('layouts.user')

@section('title', 'Bank Accounts - SalamaPay')
@section('page_title', 'Bank Accounts')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', [
    'title' => 'Bank Accounts',
    'subtitle' => 'Manage your withdrawal accounts',
    'action' => true,
    'actionUrl' => '#addBankModal',
    'actionLabel' => 'Add Account'
])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($accounts as $acc)
    <div class="bg-white rounded-xl border p-5 hover:shadow-md transition-shadow relative">
        @if($acc->is_default)
        <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Default</span>
        @endif
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $acc->bank_name }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ $acc->type }}</p>
            </div>
        </div>
        <div class="space-y-1 text-sm">
            <p class="text-gray-700"><span class="text-gray-400 text-xs">Account Name:</span> {{ $acc->account_name }}</p>
            <p class="text-gray-700"><span class="text-gray-400 text-xs">Number:</span> ****{{ substr($acc->account_number, -4) }}</p>
            @if($acc->branch_name)
            <p class="text-gray-700"><span class="text-gray-400 text-xs">Branch:</span> {{ $acc->branch_name }}</p>
            @endif
        </div>
        <div class="mt-4 flex items-center gap-2">
            <form action="{{ route('user.business.banks.destroy', $acc->id) }}" method="POST" onsubmit="return confirm('Remove this account?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors">Remove</button>
            </form>
        </div>
    </div>
    @empty
    <div class="md:col-span-2 lg:col-span-3 bg-white rounded-xl border p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
        <p class="text-sm font-medium text-gray-500">No bank accounts added yet</p>
        <p class="text-xs text-gray-400 mt-1">Add a bank account to withdraw funds</p>
    </div>
    @endforelse
</div>

{{-- Add Account Modal (simplified inline form) --}}
<div id="addBankModal" class="bg-white rounded-xl border p-6 mt-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">Add New Account</h3>
    <form action="{{ route('user.business.banks.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @csrf
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Account Name</label>
            <input type="text" name="account_name" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="John Doe" required>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Account Number</label>
            <input type="text" name="account_number" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="0123456789" required>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Bank Name</label>
            <input type="text" name="bank_name" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="CRDB Bank" required>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Branch</label>
            <input type="text" name="branch_name" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="Dar es Salaam">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Account Type</label>
            <select name="type" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white">
                <option value="bank">Bank Account</option>
                <option value="mobile_money">Mobile Money</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Add Account</button>
        </div>
    </form>
</div>
@endsection
