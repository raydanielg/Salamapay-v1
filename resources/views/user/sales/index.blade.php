@extends('layouts.user')

@section('title', 'Sales - SalamaPay')
@section('page_title', 'Sales')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Sales', 'subtitle' => 'Track your sales performance and revenue'])

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Sales</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['total']) }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">{{ $stats['range'] === 'all' ? 'All time' : 'In selected period' }}</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Revenue</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">TSh {{ number_format($stats['totalAmount']) }}</p>
        <p class="text-[10px] text-blue-200 mt-1">Total revenue</p>
    </div>
    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-violet-100">Avg Sale</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">TSh {{ number_format($stats['avgAmount']) }}</p>
        <p class="text-[10px] text-violet-100 mt-1">Per transaction</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Products vs Services</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-xl font-black">{{ $stats['productsCount'] }}</p>
            <span class="text-[10px] text-amber-100">prod</span>
            <span class="text-amber-100">/</span>
            <p class="text-xl font-black">{{ $stats['servicesCount'] }}</p>
            <span class="text-[10px] text-amber-100">svc</span>
        </div>
        <p class="text-[10px] text-amber-100 mt-1">Product vs Service sales</p>
    </div>
</div>

{{-- Filters & Date Range --}}
<div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3 mb-4">
    <div class="relative flex-1 max-w-sm">
        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="saleSearch" placeholder="Search sales..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
    </div>
    @php $range = request('range', 'all'); @endphp
    <div class="flex gap-1.5 overflow-x-auto pb-1">
        <a href="{{ route('user.sales') }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='all' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">All Time</a>
        <a href="{{ route('user.sales', ['range'=>'today']) }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='today' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Today</a>
        <a href="{{ route('user.sales', ['range'=>'3d']) }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='3d' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">3 Days</a>
        <a href="{{ route('user.sales', ['range'=>'7d']) }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='7d' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">7 Days</a>
        <a href="{{ route('user.sales', ['range'=>'30d']) }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='30d' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">30 Days</a>
        <a href="{{ route('user.sales', ['range'=>'90d']) }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='90d' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">90 Days</a>
        <a href="{{ route('user.sales', ['range'=>'this_month']) }}" class="px-3 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $range==='this_month' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">This Month</a>
    </div>
    <div class="relative" id="exportDropdownContainer">
        <button onclick="toggleExportDropdown()" class="px-4 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Export
            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div id="exportDropdown" class="hidden absolute right-0 top-full mt-2 w-48 bg-white rounded-xl border shadow-lg py-1.5 z-50">
            <button onclick="printSales()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </button>
            <button onclick="exportCSV()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </button>
            <button onclick="exportPDF()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Export PDF
            </button>
        </div>
    </div>
</div>

{{-- Printable Area --}}
<div id="printableArea">
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Transaction</th>
                    <th class="text-left px-5 py-3 font-semibold">Customer</th>
                    <th class="text-left px-5 py-3 font-semibold">Amount</th>
                    <th class="text-left px-5 py-3 font-semibold">Method</th>
                    <th class="text-left px-5 py-3 font-semibold">Date</th>
                    <th class="text-left px-5 py-3 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="salesTableBody">
                @include('user.sales._table')
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="px-5 py-3 border-t" id="salesPagination">{{ $sales->links() }}</div>
    @endif
</div>
</div>

{{-- Delete Sale Form --}}
<form id="deleteSaleForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

{{-- A4 Receipt Modal --}}
<style>
@media print {
    body * { visibility: hidden; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea { position: absolute; left: 0; top: 0; width: 100%; }
    #printableArea .overflow-x-auto { overflow: visible !important; }
    #printableArea table { width: 100% !important; border-collapse: collapse; }
    #printableArea th, #printableArea td { border: 1px solid #ddd; padding: 8px; }
    #printableArea .opacity-0 { opacity: 1 !important; }
    /* Hide Action column during print */
    #printableArea th:last-child,
    #printableArea td:last-child { display: none !important; }
    /* Ensure action buttons never show in print */
    #printableArea button,
    #printableArea .group-hover\:opacity-100 { opacity: 0 !important; display: none !important; }
}
</style>
<div id="receiptModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeReceipt()"></div>
    <div class="relative bg-white shadow-2xl w-full max-w-md overflow-hidden" style="min-height: 600px; max-height: 90vh; overflow-y: auto;">
        <div id="receiptContent" class="p-8 text-sm">
            <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
                @if(auth()->user()->logo)
                <img src="{{ asset('storage/' . auth()->user()->logo) }}" alt="Logo" class="w-16 h-16 object-cover rounded-lg mx-auto mb-2">
                @else
                <div class="w-16 h-16 rounded-lg bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                    <span class="text-2xl font-black text-emerald-700">{{ strtoupper(substr(auth()->user()->business_name ?? auth()->user()->first_name, 0, 1)) }}</span>
                </div>
                @endif
                <h2 class="text-lg font-black text-gray-900">{{ auth()->user()->business_name ?? auth()->user()->first_name }}</h2>
                <p class="text-xs text-gray-500">{{ auth()->user()->business_type ?? 'Business' }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ auth()->user()->address ?? '' }}</p>
                <p class="text-xs text-gray-400">{{ auth()->user()->phone ?? '' }}</p>
            </div>
            <div class="text-center mb-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500">Receipt</p>
                <p class="text-xs text-gray-400 mt-0.5" id="receiptTxId">TX-00000000</p>
            </div>
            <div class="space-y-1.5 mb-4 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">Date</span><span class="font-medium text-gray-900" id="receiptDate">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Customer</span><span class="font-medium text-gray-900 text-right" id="receiptCustomer">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Type</span><span class="font-medium" id="receiptType">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Method</span><span class="font-medium text-gray-900" id="receiptMethod">-</span></div>
            </div>
            <table class="w-full text-xs mb-4">
                <thead><tr class="border-b-2 border-dashed border-gray-300">
                    <th class="text-left py-2 font-bold text-gray-700">Item</th>
                    <th class="text-right py-2 font-bold text-gray-700">Qty</th>
                    <th class="text-right py-2 font-bold text-gray-700">Price</th>
                    <th class="text-right py-2 font-bold text-gray-700">Total</th>
                </tr></thead>
                <tbody id="receiptItems" class="text-gray-700"><tr><td colspan="4" class="py-2 text-center text-gray-400">No items</td></tr></tbody>
            </table>
            <div class="border-t-2 border-dashed border-gray-300 pt-3 space-y-1.5 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium" id="receiptSubtotal">TSh 0</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Discount</span><span class="font-medium text-red-500" id="receiptDiscount">-TSh 0</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tax</span><span class="font-medium" id="receiptTax">TSh 0</span></div>
                <div class="flex justify-between pt-2 border-t border-dashed border-gray-200">
                    <span class="font-bold text-gray-900">TOTAL</span>
                    <span class="font-black text-emerald-700 text-base" id="receiptTotal">TSh 0</span>
                </div>
            </div>
            <div class="text-center mt-6 pt-4 border-t-2 border-dashed border-gray-300">
                <p class="text-[10px] text-gray-400">{{ auth()->user()->receipt_footer ?? 'Thank you for your business!' }}</p>
                <p class="text-[9px] text-gray-300 mt-1">Powered by SalamaPay</p>
            </div>
        </div>
        <div class="bg-gray-50 border-t p-4 flex gap-2">
            <button onclick="closeReceipt()" class="flex-1 py-2.5 border rounded-xl text-xs font-bold text-gray-600 hover:bg-white transition-colors">Close</button>
            <button onclick="printReceipt()" class="flex-1 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </button>
        </div>
    </div>
</div>

<script>
let searchTimeout;
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('saleSearch');
    if (searchInput) searchInput.addEventListener('input', function() { clearTimeout(searchTimeout); searchTimeout = setTimeout(doSearch, 300); });
});

function doSearch() {
    const search = document.getElementById('saleSearch')?.value || '';
    const url = new URL(window.location.href);
    if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
    fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => {
        document.getElementById('salesTableBody').innerHTML = html;
        const pag = document.getElementById('salesPagination');
        if (pag) pag.style.display = 'none';
    });
}

function toggleExportDropdown() { document.getElementById('exportDropdown').classList.toggle('hidden'); }
document.addEventListener('click', function(e) {
    const c = document.getElementById('exportDropdownContainer');
    if (c && !c.contains(e.target)) document.getElementById('exportDropdown').classList.add('hidden');
});
function printSales() { document.getElementById('exportDropdown').classList.add('hidden'); window.print(); }
function exportCSV() {
    document.getElementById('exportDropdown').classList.add('hidden');
    const rows = document.querySelectorAll('#salesTableBody tr');
    let csv = 'Transaction,Customer,Amount,Method,Date,Type\n';
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
            const tx = cells[0].innerText.replace(/\n/g, ' ').trim();
            const customer = cells[1].innerText.replace(/\n/g, ' ').trim();
            const amount = cells[2].innerText.replace(/[^0-9]/g, '').trim();
            const method = cells[3].innerText.trim();
            const date = cells[4].innerText.trim();
            csv += '"' + tx + '","' + customer + '","' + amount + '","' + method + '","' + date + '"\n';
        }
    });
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'sales_{{ now()->format('Y-m-d') }}.csv';
    link.click();
}
function exportPDF() {
    document.getElementById('exportDropdown').classList.add('hidden');
    const rows = document.querySelectorAll('#salesTableBody tr');
    let html = `<html><head><title>Sales Report</title><style>body{font-family:Arial,sans-serif;padding:40px;}h1{color:#059669;font-size:24px;margin-bottom:8px;}.subtitle{color:#6b7280;font-size:12px;margin-bottom:24px;}table{width:100%;border-collapse:collapse;margin-top:16px;}th{background:#059669;color:white;padding:10px;text-align:left;font-size:11px;text-transform:uppercase;}td{padding:10px;border-bottom:1px solid #e5e7eb;font-size:11px;}tr:nth-child(even){background:#f9fafb;}.footer{margin-top:30px;font-size:10px;color:#9ca3af;border-top:1px solid #e5e7eb;padding-top:12px;}.badge{padding:2px 8px;border-radius:999px;font-size:10px;font-weight:bold;}.badge-green{background:#d1fae5;color:#065f46;}.badge-blue{background:#dbeafe;color:#1e40af;}.badge-gray{background:#f3f4f6;color:#4b5563;}</style></head><body><h1>Sales Report</h1><div class="subtitle">Generated on {{ now()->format('F d, Y H:i') }}</div><table><thead><tr><th>Transaction</th><th>Customer</th><th>Amount</th><th>Method</th><th>Date</th><th>Type</th></tr></thead><tbody>`;
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
            const tx = cells[0].innerText.replace(/\n/g, ' ').trim();
            const customer = cells[1].innerText.replace(/\n/g, ' ').trim();
            const amount = cells[2].innerText.trim();
            const method = cells[3].innerText.trim();
            const date = cells[4].innerText.trim();
            html += '<tr><td>' + tx + '</td><td>' + customer + '</td><td>' + amount + '</td><td>' + method + '</td><td>' + date + '</td></tr>';
        }
    });
    html += `</tbody></table><div class="footer"><strong>{{ auth()->user()->business_name ?? auth()->user()->first_name }}</strong> | Sales Report<br>Printed on {{ now()->format('F d, Y H:i') }}</div></body></html>`;
    const win = window.open('', '_blank'); win.document.write(html); win.document.close();
    setTimeout(() => win.print(), 500);
}

// Receipt Modal
function viewSale(row) {
    const data = JSON.parse(row.dataset.sale);
    document.getElementById('receiptTxId').textContent = data.tx_id;
    document.getElementById('receiptDate').textContent = data.processed_at || '-';
    document.getElementById('receiptCustomer').textContent = data.customer_name || 'Guest';
    document.getElementById('receiptMethod').textContent = data.method || '-';
    const typeColors = { product: 'text-emerald-600', service: 'text-blue-600', other: 'text-gray-500' };
    const typeLabels = { product: 'Product Sale', service: 'Service Sale', other: 'Other' };
    const typeEl = document.getElementById('receiptType');
    typeEl.textContent = typeLabels[data.source_type] || 'Sale';
    typeEl.className = 'font-medium ' + (typeColors[data.source_type] || 'text-gray-500');

    // Items
    const itemsBody = document.getElementById('receiptItems');
    const items = data.items || [];
    if (items.length > 0) {
        itemsBody.innerHTML = items.map(item =>
            '<tr><td class="py-1.5">' + (item.name || 'Item') + '</td><td class="text-right py-1.5">' + (item.qty || 1) + '</td><td class="text-right py-1.5">TSh ' + Number(item.price || 0).toLocaleString() + '</td><td class="text-right py-1.5 font-medium">TSh ' + (Number(item.price || 0) * Number(item.qty || 1)).toLocaleString() + '</td></tr>'
        ).join('');
    } else {
        itemsBody.innerHTML = '<tr><td colspan="4" class="py-2 text-center text-gray-400">No item details available</td></tr>';
    }

    document.getElementById('receiptSubtotal').textContent = 'TSh ' + Number(data.amount + (data.discount || 0) - (data.tax || 0)).toLocaleString();
    document.getElementById('receiptDiscount').textContent = '-TSh ' + Number(data.discount || 0).toLocaleString();
    document.getElementById('receiptTax').textContent = 'TSh ' + Number(data.tax || 0).toLocaleString();
    document.getElementById('receiptTotal').textContent = 'TSh ' + Number(data.amount).toLocaleString();

    const m = document.getElementById('receiptModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closeReceipt() { const m = document.getElementById('receiptModal'); m.classList.add('hidden'); m.classList.remove('flex'); }
function printReceipt() { window.print(); }

function deleteSale(id, txId) {
    saConfirm({
        title: 'Delete Sale?',
        text: 'Are you sure you want to delete sale "' + txId + '"? This cannot be undone.',
        icon: 'danger',
        confirmText: 'Delete',
        confirmColor: 'red',
        onConfirm: function() {
            const form = document.getElementById('deleteSaleForm');
            form.action = '{{ url('sales') }}/' + id;
            form.submit();
        }
    });
}
</script>
@endsection
