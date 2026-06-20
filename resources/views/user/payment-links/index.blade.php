@extends('layouts.user')

@section('title', 'Payment Links - SalamaPay')
@section('page_title', 'Payment Links')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', [
    'title' => 'Payment Links',
    'subtitle' => 'Create and manage shareable payment links',
    'action' => true,
    'actionUrl' => route('user.payment-links.create'),
    'actionLabel' => 'New Link'
])

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['label'=>'Total Links','value'=>number_format($stats['total']),'color'=>'gray','icon'=>'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
        ['label'=>'Active','value'=>number_format($stats['active']),'color'=>'emerald','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Expired','value'=>number_format($stats['expired']),'color'=>'red','icon'=>'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Total Payments','value'=>number_format($stats['totalPayments']),'color'=>'blue','icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z']
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

{{-- Links Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b">
        <h3 class="text-sm font-semibold text-gray-900">Your Links</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Title</th>
                    <th class="px-5 py-3 font-medium">Amount</th>
                    <th class="px-5 py-3 font-medium">Slug</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Expiry</th>
                    <th class="px-5 py-3 font-medium">Payments</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($links as $link)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <p class="text-sm font-medium text-gray-900">{{ $link->title }}</p>
                        <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $link->description }}</p>
                    </td>
                    <td class="px-5 py-3 font-semibold text-gray-900">
                        {{ $link->amount ? 'TZS '.number_format($link->amount) : 'Custom' }}
                    </td>
                    <td class="px-5 py-3">
                        <code class="text-xs font-mono text-gray-600 bg-gray-100 px-2 py-0.5 rounded">{{ $link->slug }}</code>
                        <button onclick="copyToClipboard('{{ url('/pay/'.$link->slug) }}')" class="ml-1 text-xs text-emerald-600 hover:text-emerald-700">Copy</button>
                    </td>
                    <td class="px-5 py-3">
                        @if($link->isValid())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                        @elseif($link->isExpired())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Expired</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">Inactive</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-500">
                        {{ $link->expires_at ? $link->expires_at->format('M d, Y H:i') : 'Never' }}
                    </td>
                    <td class="px-5 py-3 text-xs font-medium text-gray-700">{{ $link->usage_count }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('user.payment-links.show', $link->id) }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium mr-2">Details</a>
                        <a href="{{ url('/pay/'.$link->slug) }}" target="_blank" class="text-xs text-gray-500 hover:text-gray-700 font-medium mr-2">View</a>
                        <form action="{{ route('user.payment-links.destroy', $link->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this link?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <p class="text-sm font-medium">No payment links yet</p>
                        <p class="text-xs mt-1">Create your first link to start accepting payments</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($links->hasPages())
    <div class="px-5 py-3 border-t">{{ $links->links() }}</div>
    @endif
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Link copied!'));
}
</script>
@endsection
