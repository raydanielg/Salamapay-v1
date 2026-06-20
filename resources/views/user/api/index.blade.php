@extends('layouts.user')

@section('title', 'API Keys - SalamaPay')
@section('page_title', 'API Keys')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', [
    'title' => 'API Access',
    'subtitle' => 'Manage API keys and monitor usage',
    'action' => true,
    'actionUrl' => '#',
    'actionLabel' => 'New Key'
])

{{-- Usage Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
    @foreach([
        ['label'=>'Total Requests','value'=>$usageStats['total_requests'],'icon'=>'M13 10V3L4 14h7v7l9-11h-7z','color'=>'emerald'],
        ['label'=>'Success Rate','value'=>$usageStats['success_rate'].'%','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'emerald'],
        ['label'=>'Avg Latency','value'=>$usageStats['avg_latency'],'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'blue']
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

{{-- API Keys Table --}}
<div class="bg-white rounded-xl border overflow-hidden mb-6">
    <div class="px-5 py-4 border-b">
        <h3 class="text-sm font-semibold text-gray-900">API Keys</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Name</th>
                    <th class="px-5 py-3 font-medium">Key</th>
                    <th class="px-5 py-3 font-medium">Last Used</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($apiKeys as $key)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $key->name }}</td>
                    <td class="px-5 py-3">
                        <code class="text-xs font-mono text-gray-600 bg-gray-100 px-2 py-0.5 rounded">{{ substr($key->key, 0, 12) }}...</code>
                        <button onclick="copyToClipboard('{{ $key->key }}')" class="ml-1 text-xs text-emerald-600 hover:text-emerald-700">Copy</button>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $key->last_used_at?->diffForHumans() ?? 'Never' }}</td>
                    <td class="px-5 py-3">
                        @if($key->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">Revoked</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        @if($key->is_active)
                        <form action="{{ route('user.api.revoke', $key->id) }}" method="POST" class="inline" onsubmit="return confirm('Revoke this API key?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium">Revoke</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        <p class="text-sm font-medium">No API keys yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Key Form --}}
<div class="bg-white rounded-xl border p-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-3">Create New API Key</h3>
    <form action="{{ route('user.api.store') }}" method="POST" class="flex items-end gap-3">
        @csrf
        <div class="flex-1">
            <label class="block text-xs font-medium text-gray-700 mb-1">Key Name</label>
            <input type="text" name="name" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. Production Key" required>
        </div>
        <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">Generate Key</button>
    </form>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('API key copied!'));
}
</script>
@endsection
