@forelse($invoices as $invoice)
<tr class="hover:bg-gray-50/50 transition-colors group" data-invoice='{{ json_encode([
    "id" => $invoice->id,
    "invoice_number" => $invoice->invoice_number,
    "customer_name" => $invoice->customer_name,
    "customer_email" => $invoice->customer_email,
    "customer_phone" => $invoice->customer_phone,
    "amount" => $invoice->total,
    "discount" => $invoice->discount ?? 0,
    "tax" => $invoice->tax ?? 0,
    "subtotal" => $invoice->subtotal ?? 0,
    "status" => $invoice->status,
    "issue_date" => $invoice->issue_date?->format('M d, Y'),
    "due_date" => $invoice->due_date?->format('M d, Y'),
    "items" => $invoice->items ?? [],
    "notes" => $invoice->notes ?? '',
    "payment_method" => $invoice->payment_method,
]) }}'>
    <td class="px-5 py-3.5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($invoice->status === 'overdue' ? 'bg-red-100 text-red-700' : ($invoice->status === 'sent' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600')) }} flex items-center justify-center font-bold text-xs shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="font-mono text-xs font-bold text-gray-900">{{ $invoice->invoice_number }}</p>
                <p class="text-[10px] text-gray-400">Due {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}</p>
            </div>
        </div>
    </td>
    <td class="px-5 py-3.5">
        <p class="font-semibold text-gray-900 text-xs">{{ $invoice->customer_name }}</p>
        <p class="text-[10px] text-gray-400">{{ $invoice->customer_email ?? '' }}</p>
    </td>
    <td class="px-5 py-3.5">
        <p class="font-bold text-gray-900 text-xs">TSh {{ number_format($invoice->total) }}</p>
        @if(($invoice->discount ?? 0) > 0)
        <p class="text-[9px] text-red-400">-TSh {{ number_format($invoice->discount) }} disc</p>
        @endif
    </td>
    <td class="px-5 py-3.5">
        @if($invoice->status === 'paid')
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Paid</span>
        @elseif($invoice->status === 'sent')
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">Sent</span>
        @elseif($invoice->status === 'draft')
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">Draft</span>
        @elseif($invoice->status === 'overdue')
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">Overdue</span>
        @else
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500 border border-gray-200">{{ ucfirst($invoice->status) }}</span>
        @endif
    </td>
    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $invoice->issue_date?->format('M d, Y') ?? 'N/A' }}</td>
    <td class="px-5 py-3.5">
        <div class="flex gap-1.5">
            <button onclick="viewInvoice(this.closest('tr'))" class="p-1.5 rounded-md bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 hover:text-blue-700 transition-colors" title="View Invoice">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
            @if($invoice->status !== 'paid')
            <button onclick="payInvoice({{ $invoice->id }}, '{{ addslashes($invoice->invoice_number) }}')" class="p-1.5 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 hover:text-emerald-700 transition-colors" title="Mark as Paid">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </button>
            @endif
            <button onclick="deleteInvoice({{ $invoice->id }}, '{{ addslashes($invoice->invoice_number) }}')" class="p-1.5 rounded-md bg-red-50 text-red-500 border border-red-200 hover:bg-red-100 hover:text-red-700 transition-colors" title="Delete Invoice">
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
            <p class="text-sm font-bold text-gray-500">No invoices found</p>
            <p class="text-xs text-gray-400 mt-0.5">Create your first invoice to get started.</p>
        </div>
    </td>
</tr>
@endforelse
