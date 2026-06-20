@extends('layouts.user')

@section('title', 'API Keys - SalamaPay')
@section('page_title', 'API Keys')

@section('content')
@include('user.partials.alert')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-bold text-gray-900">API Access</h1>
        <p class="text-xs text-gray-500 mt-0.5">Manage keys, monitor usage, and control access</p>
    </div>
    <button type="button" onclick="openKeyModal()" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Key
    </button>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-3 gap-3 mb-6">
    @foreach([
        ['label'=>'Total Requests','value'=>number_format($usageStats['total_requests']),'sub'=>'This month','icon'=>'M13 10V3L4 14h7v7l9-11h-7z','color'=>'emerald'],
        ['label'=>'Success Rate','value'=>$usageStats['success_rate'].'%','sub'=>'Uptime','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'emerald'],
        ['label'=>'Avg Latency','value'=>$usageStats['avg_latency'],'sub'=>'Response time','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'blue']
    ] as $card)
    <div class="bg-white rounded-xl border p-4 hover:shadow-sm transition-all">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[11px] font-medium text-gray-500">{{ $card['label'] }}</span>
            <div class="w-7 h-7 rounded-lg bg-{{ $card['color'] }}-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
        </div>
        <p class="text-lg font-bold text-gray-900">{{ $card['value'] }}</p>
        <p class="text-[10px] text-gray-400 mt-0.5">{{ $card['sub'] }}</p>
    </div>
    @endforeach
</div>

{{-- API Keys Grid --}}
<div class="mb-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-900">Your API Keys</h3>
        <span class="text-xs text-gray-400">{{ $apiKeys->where('is_active', true)->count() }} active</span>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @forelse($apiKeys as $key)
        <div class="bg-white rounded-xl border p-4 hover:shadow-sm transition-all group">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg {{ $key->is_active ? 'bg-emerald-50' : 'bg-gray-100' }} flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 {{ $key->is_active ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $key->name }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Created {{ $key->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $key->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                    {{ $key->is_active ? 'Active' : 'Revoked' }}
                </span>
            </div>

            {{-- Key Display --}}
            <div class="bg-gray-50 rounded-lg border border-gray-100 p-2.5 mb-3 flex items-center gap-2">
                <code class="text-xs font-mono text-gray-600 flex-1 truncate">{{ $key->key }}</code>
                <button onclick="copyKey('{{ $key->key }}')" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 px-2 py-1 rounded hover:bg-emerald-50 transition-colors shrink-0 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Copy
                </button>
            </div>

            {{-- Meta Row --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 text-[10px] text-gray-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $key->last_used_at?->diffForHumans() ?? 'Never used' }}
                    </span>
                </div>
                @if($key->is_active)
                <form action="{{ route('user.api.revoke', $key->id) }}" method="POST" class="inline" onsubmit="return confirm('Revoke this API key? It cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-[10px] text-red-500 hover:text-red-600 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors">Revoke</button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="lg:col-span-2 bg-white rounded-xl border border-dashed border-gray-200 p-10 text-center">
            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-700">No API keys yet</p>
            <p class="text-xs text-gray-400 mt-1 mb-4">Create a key to start integrating with the SalamaPay API</p>
            <button type="button" onclick="openKeyModal()" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Create API Key</button>
        </div>
        @endforelse
    </div>
</div>

{{-- Quick Link to Webhooks --}}
<div class="bg-white rounded-xl border p-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center">
            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-900">Webhooks</p>
            <p class="text-[11px] text-gray-500">Receive real-time payment notifications</p>
        </div>
    </div>
    <a href="{{ route('user.api.webhooks') }}" class="px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">Configure</a>
</div>

{{-- Create Key Modal --}}
<div id="keyModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeKeyModal()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl transform transition-transform duration-300 translate-x-full" id="keyModalPanel">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">New API Key</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Generate a key for your application</p>
                </div>
                <button onclick="closeKeyModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-6">
                <form action="{{ route('user.api.store') }}" method="POST" id="keyForm" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Key Name</label>
                        <input type="text" name="name" required placeholder="e.g. Production Server" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">A descriptive name to identify this key</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Permissions</label>
                        <div class="space-y-2">
                            @foreach(['payments.read','payments.write','refunds','settlements.read','webhooks'] as $perm)
                            <label class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer transition-all">
                                <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                                <span class="text-xs text-gray-700 font-medium">{{ str_replace('.', ' ', $perm) }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 border-t bg-gray-50/50">
                <button type="submit" form="keyForm" class="w-full py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">Generate Key</button>
            </div>
        </div>
    </div>
</div>

<script>
function copyKey(text) {
    navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 z-50 px-4 py-2 bg-gray-900 text-white text-xs rounded-lg shadow-lg';
        toast.textContent = 'API key copied!';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}

const keyModal = document.getElementById('keyModal');
const keyModalPanel = document.getElementById('keyModalPanel');

function openKeyModal() {
    keyModal.classList.remove('hidden');
    setTimeout(() => keyModalPanel.classList.remove('translate-x-full'), 10);
}

function closeKeyModal() {
    keyModalPanel.classList.add('translate-x-full');
    setTimeout(() => keyModal.classList.add('hidden'), 300);
}
</script>
@endsection
