@extends('layouts.user')

@section('title', 'Webhooks - SalamaPay')
@section('page_title', 'Webhooks')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Webhook Configuration', 'subtitle' => 'Receive real-time notifications for payment events'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    @forelse($webhooks as $hook)
    <div class="bg-white rounded-xl border p-5 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg {{ $hook->is_active ? 'bg-emerald-50' : 'bg-gray-100' }} flex items-center justify-center">
                    <svg class="w-4 h-4 {{ $hook->is_active ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Webhook #{{ $hook->id }}</p>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium {{ $hook->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">{{ $hook->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
            </div>
            <form action="{{ route('user.api.webhooks.destroy', $hook->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this webhook?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50">Delete</button>
            </form>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 w-14">URL:</span>
                <code class="text-xs font-mono text-gray-700 bg-gray-50 px-2 py-0.5 rounded truncate flex-1">{{ $hook->url }}</code>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 w-14">Secret:</span>
                <code class="text-xs font-mono text-gray-500 bg-gray-50 px-2 py-0.5 rounded">{{ substr($hook->secret, 0, 8) }}...</code>
                <button onclick="copyToClipboard('{{ $hook->secret }}')" class="text-xs text-emerald-600 hover:text-emerald-700">Copy</button>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 w-14">Events:</span>
                <span class="text-xs text-gray-600">{{ is_array($events = json_decode($hook->events, true)) ? implode(', ', $events) : 'All' }}</span>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <span class="text-xs text-gray-400 w-14">Stats:</span>
                <span class="text-xs text-emerald-600 font-medium">{{ $hook->success_count }} success</span>
                <span class="text-xs text-gray-300">|</span>
                <span class="text-xs text-red-500 font-medium">{{ $hook->fail_count }} fail</span>
                <span class="text-xs text-gray-300">|</span>
                <span class="text-xs text-gray-500">Last: {{ $hook->last_triggered_at?->diffForHumans() ?? 'Never' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="lg:col-span-2 bg-white rounded-xl border p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        <p class="text-sm font-medium text-gray-500">No webhooks configured</p>
        <p class="text-xs text-gray-400 mt-1">Add a webhook to receive real-time payment notifications</p>
    </div>
    @endforelse
</div>

{{-- Create Webhook --}}
<div class="bg-white rounded-xl border p-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">Add Webhook Endpoint</h3>
    <form action="{{ route('user.api.webhooks.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Endpoint URL</label>
            <input type="url" name="url" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="https://your-site.com/webhook" required>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Events to Subscribe</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                @foreach(['payment.success','payment.failed','payment.pending','settlement.completed','refund.processed'] as $evt)
                <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-100 hover:border-emerald-200 cursor-pointer">
                    <input type="checkbox" name="events[]" value="{{ $evt }}" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span class="text-xs text-gray-700">{{ str_replace('.', ' ', $evt) }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Add Webhook</button>
        </div>
    </form>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Secret copied!'));
}
</script>
@endsection
