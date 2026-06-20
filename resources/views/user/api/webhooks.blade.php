@extends('layouts.user')

@section('title', 'Webhooks - SalamaPay')
@section('page_title', 'Webhooks')

@section('content')
@include('user.partials.alert')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-bold text-gray-900">Webhook Configuration</h1>
        <p class="text-xs text-gray-500 mt-0.5">Receive real-time notifications for payment events</p>
    </div>
    <button type="button" onclick="openHookModal()" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Webhook
    </button>
</div>

{{-- Webhooks Grid --}}
<div class="mb-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-900">Your Endpoints</h3>
        <span class="text-xs text-gray-400">{{ $webhooks->where('is_active', true)->count() }} active</span>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @forelse($webhooks as $hook)
        <div class="bg-white rounded-xl border p-4 hover:shadow-sm transition-all">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg {{ $hook->is_active ? 'bg-emerald-50' : 'bg-gray-100' }} flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 {{ $hook->is_active ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Webhook #{{ $hook->id }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $hook->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                            {{ $hook->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('user.api.webhooks.destroy', $hook->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this webhook?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-[10px] text-red-500 hover:text-red-600 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors">Delete</button>
                </form>
            </div>

            {{-- URL --}}
            <div class="bg-gray-50 rounded-lg border border-gray-100 p-2.5 mb-3">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] text-gray-400 font-medium shrink-0">URL</span>
                    <code class="text-xs font-mono text-gray-600 truncate flex-1">{{ $hook->url }}</code>
                </div>
            </div>

            {{-- Secret --}}
            <div class="flex items-center gap-2 mb-3">
                <span class="text-[10px] text-gray-400 font-medium">Secret</span>
                <code class="text-xs font-mono text-gray-500 bg-gray-50 px-2 py-0.5 rounded">{{ substr($hook->secret, 0, 12) }}...</code>
                <button onclick="copySecret('{{ $hook->secret }}')" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 px-1.5 py-0.5 rounded hover:bg-emerald-50 transition-colors">Copy</button>
            </div>

            {{-- Events --}}
            <div class="mb-3">
                <p class="text-[10px] text-gray-400 font-medium mb-1.5">Subscribed Events</p>
                <div class="flex flex-wrap gap-1.5">
                    @php $events = is_array($e = json_decode($hook->events, true)) ? $e : []; @endphp
                    @forelse($events as $evt)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-purple-50 border border-purple-100 text-[10px] font-medium text-purple-700">{{ str_replace('.', ' ', $evt) }}</span>
                    @empty
                    <span class="text-[10px] text-gray-400">No events selected</span>
                    @endforelse
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                <span class="flex items-center gap-1 text-[10px] text-emerald-600 font-medium">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $hook->success_count }}
                </span>
                <span class="flex items-center gap-1 text-[10px] text-red-500 font-medium">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ $hook->fail_count }}
                </span>
                <span class="text-[10px] text-gray-400 ml-auto">{{ $hook->last_triggered_at?->diffForHumans() ?? 'Never triggered' }}</span>
            </div>
        </div>
        @empty
        <div class="lg:col-span-2 bg-white rounded-xl border border-dashed border-gray-200 p-10 text-center">
            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-700">No webhooks configured</p>
            <p class="text-xs text-gray-400 mt-1 mb-4">Add a webhook to receive real-time payment notifications</p>
            <button type="button" onclick="openHookModal()" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Add Webhook</button>
        </div>
        @endforelse
    </div>
</div>

{{-- Recent Deliveries / Log Simulation --}}
<div class="bg-white rounded-xl border overflow-hidden mb-6">
    <div class="px-5 py-4 border-b flex items-center justify-between">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Recent Deliveries</h3>
            <p class="text-[10px] text-gray-400 mt-0.5">Last webhook requests sent to your endpoints</p>
        </div>
        <span class="text-[10px] text-gray-400 px-2 py-1 bg-gray-50 rounded-lg">Live</span>
    </div>
    <div class="divide-y divide-gray-50">
        @php
        $deliveries = [
            ['event' => 'payment.success', 'status' => 'success', 'time' => '2 min ago', 'endpoint' => 'https://api.example.com/webhooks'],
            ['event' => 'payment.pending', 'status' => 'success', 'time' => '15 min ago', 'endpoint' => 'https://api.example.com/webhooks'],
            ['event' => 'payment.failed', 'status' => 'failed', 'time' => '1 hour ago', 'endpoint' => 'https://api.example.com/webhooks'],
            ['event' => 'settlement.completed', 'status' => 'success', 'time' => '3 hours ago', 'endpoint' => 'https://api.example.com/webhooks'],
        ];
        @endphp
        @foreach($deliveries as $delivery)
        <div class="px-5 py-3 flex items-center gap-3 hover:bg-gray-50/50 transition-colors">
            <div class="w-6 h-6 rounded-full {{ $delivery['status'] === 'success' ? 'bg-emerald-50' : 'bg-red-50' }} flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 {{ $delivery['status'] === 'success' ? 'text-emerald-600' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($delivery['status'] === 'success')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    @endif
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-gray-700">{{ str_replace('.', ' ', $delivery['event']) }}</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-medium {{ $delivery['status'] === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">{{ $delivery['status'] === 'success' ? '200 OK' : 'Failed' }}</span>
                </div>
                <p class="text-[10px] text-gray-400 truncate">{{ $delivery['endpoint'] }}</p>
            </div>
            <span class="text-[10px] text-gray-400 shrink-0">{{ $delivery['time'] }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- Create Webhook Modal --}}
<div id="hookModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeHookModal()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl transform transition-transform duration-300 translate-x-full" id="hookModalPanel">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">New Webhook</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Receive real-time event notifications</p>
                </div>
                <button onclick="closeHookModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-6">
                <form action="{{ route('user.api.webhooks.store') }}" method="POST" id="hookForm" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Endpoint URL</label>
                        <input type="url" name="url" required placeholder="https://your-site.com/webhook" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Must be HTTPS and publicly accessible</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Events to Subscribe</label>
                        <div class="space-y-1.5">
                            @foreach(['payment.success'=>'Payment completed','payment.failed'=>'Payment failed','payment.pending'=>'Payment pending','settlement.completed'=>'Settlement done','refund.processed'=>'Refund processed'] as $evt => $label)
                            <label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer transition-all">
                                <input type="checkbox" name="events[]" value="{{ $evt }}" class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-700">{{ $label }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $evt }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 border-t bg-gray-50/50">
                <button type="submit" form="hookForm" class="w-full py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">Add Webhook</button>
            </div>
        </div>
    </div>
</div>

<script>
function copySecret(text) {
    navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 z-50 px-4 py-2 bg-gray-900 text-white text-xs rounded-lg shadow-lg';
        toast.textContent = 'Secret copied!';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}

const hookModal = document.getElementById('hookModal');
const hookModalPanel = document.getElementById('hookModalPanel');

function openHookModal() {
    hookModal.classList.remove('hidden');
    setTimeout(() => hookModalPanel.classList.remove('translate-x-full'), 10);
}

function closeHookModal() {
    hookModalPanel.classList.add('translate-x-full');
    setTimeout(() => hookModal.classList.add('hidden'), 300);
}
</script>
@endsection
