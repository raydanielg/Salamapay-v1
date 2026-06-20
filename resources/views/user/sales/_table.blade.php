@forelse($sales as $sale)
<tr class="hover:bg-gray-50/50 transition-colors group" data-sale='{{ json_encode([
    "id" => $sale->id,
    "tx_id" => $sale->tx_id,
    "customer_name" => $sale->customer_name,
    "customer_email" => $sale->customer_email,
    "customer_phone" => $sale->customer_phone,
    "amount" => $sale->amount,
    "discount" => $sale->discount ?? 0,
    "tax" => $sale->tax ?? 0,
    "method" => $sale->method,
    "status" => $sale->status,
    "processed_at" => $sale->processed_at?->format('M d, Y H:i'),
    "source_type" => $sale->source_type,
    "items" => $sale->items ?? [],
]) }}'>
    <td class="px-5 py-3.5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg {{ ($sale->source_type ?? 'other') === 'product' ? 'bg-emerald-100 text-emerald-700' : (($sale->source_type ?? 'other') === 'service' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }} flex items-center justify-center font-bold text-xs shrink-0">
                @if(($sale->source_type ?? 'other') === 'product')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                @elseif(($sale->source_type ?? 'other') === 'service')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                @endif
            </div>
            <div>
                <p class="font-mono text-xs font-bold text-gray-900">{{ $sale->tx_id }}</p>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold {{ ($sale->source_type ?? 'other') === 'product' ? 'bg-emerald-50 text-emerald-700' : (($sale->source_type ?? 'other') === 'service' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500') }}">
                    {{ ($sale->source_type ?? 'Other') === 'product' ? 'Product' : (($sale->source_type ?? 'Other') === 'service' ? 'Service' : 'Other') }}
                </span>
            </div>
        </div>
    </td>
    <td class="px-5 py-3.5">
        <p class="font-semibold text-gray-900 text-xs">{{ $sale->customer_name ?? 'Guest' }}</p>
        <p class="text-[10px] text-gray-400">{{ $sale->customer_email ?? '' }}</p>
    </td>
    <td class="px-5 py-3.5">
        <p class="font-bold text-emerald-700 text-xs">TSh {{ number_format($sale->amount) }}</p>
        @if(($sale->discount ?? 0) > 0)
        <p class="text-[9px] text-red-400">-TSh {{ number_format($sale->discount) }} disc</p>
        @endif
    </td>
    <td class="px-5 py-3.5">
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-wide">{{ strtoupper($sale->method) }}</span>
    </td>
    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $sale->processed_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
    <td class="px-5 py-3.5">
        <div class="flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
            <button onclick="viewSale(this.closest('tr'))" class="p-1.5 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors" title="View Receipt">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
            <button onclick="deleteSale({{ $sale->id }}, '{{ addslashes($sale->tx_id) }}')" class="p-1.5 rounded-md bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 transition-colors" title="Delete Sale">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-5 py-12 text-center">
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            </div>
            <p class="text-sm font-bold text-gray-500">No sales found</p>
            <p class="text-xs text-gray-400 mt-0.5">Try adjusting your filters or search.</p>
        </div>
    </td>
</tr>
@endforelse
