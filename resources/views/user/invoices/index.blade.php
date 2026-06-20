@extends('layouts.user')

@section('title', 'Invoices - SalamaPay')
@section('page_title', 'Invoices')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Invoices', 'subtitle' => 'Manage and track all your invoices'])

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Invoices</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['total']) }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">All invoices</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Paid</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ number_format($stats['paid']) }}</p>
        <p class="text-[10px] text-blue-200 mt-1">TSh {{ number_format($stats['totalAmount']) }}</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Pending / Overdue</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-2xl font-black">{{ number_format($stats['pending'] + $stats['overdue']) }}</p>
            <span class="text-[10px] text-amber-100">pending</span>
        </div>
        <p class="text-[10px] text-amber-100 mt-1">TSh {{ number_format($stats['pendingAmount']) }}</p>
    </div>
</div>

{{-- Filters + Add --}}
<div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3 mb-4">
    <div class="relative flex-1 max-w-sm">
        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="invoiceSearch" placeholder="Search invoices..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
    </div>
    <select id="invoiceStatus" onchange="doInvoiceSearch()" class="px-3 py-2.5 border rounded-xl text-xs font-medium text-gray-600 outline-none focus:border-emerald-500 cursor-pointer">
        <option value="all">All Status</option>
        <option value="draft" {{ request('status')==='draft'?'selected':'' }}>Draft</option>
        <option value="sent" {{ request('status')==='sent'?'selected':'' }}>Sent</option>
        <option value="paid" {{ request('status')==='paid'?'selected':'' }}>Paid</option>
        <option value="overdue" {{ request('status')==='overdue'?'selected':'' }}>Overdue</option>
        <option value="cancelled" {{ request('status')==='cancelled'?'selected':'' }}>Cancelled</option>
    </select>
    <div class="flex gap-2">
        <div class="relative" id="exportDropdownContainer">
            <button onclick="toggleExportDropdown()" class="px-4 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </button>
            <div id="exportDropdown" class="hidden absolute right-0 top-full mt-2 w-48 bg-white rounded-xl border shadow-lg py-1.5 z-50">
                <button onclick="printInvoices()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print
                </button>
                <button onclick="exportInvoiceCSV()" class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 transition-colors">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </button>
            </div>
        </div>
        <button onclick="openInvoiceDrawer()" class="px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Invoice
        </button>
    </div>
</div>

{{-- Printable Area --}}
<div id="printableArea">
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Invoice</th>
                    <th class="text-left px-5 py-3 font-semibold">Customer</th>
                    <th class="text-left px-5 py-3 font-semibold">Amount</th>
                    <th class="text-left px-5 py-3 font-semibold">Status</th>
                    <th class="text-left px-5 py-3 font-semibold">Date</th>
                    <th class="text-left px-5 py-3 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="invoiceTableBody">
                @include('user.invoices._table')
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
    <div class="px-5 py-3 border-t" id="invoicePagination">{{ $invoices->links() }}</div>
    @endif
</div>
</div>

@include('user.invoices._drawer')

<script>
// Products & Services data for drawer
const productsData = @json($products);
const servicesData = @json($services);
const taxRateInvoice = {{ (auth()->user()->tax_rate ?? 18) / 100 }};
let invoiceItems = [];
let searchTimeoutInvoice;

// Invoice Drawer
function openInvoiceDrawer() {
    document.getElementById('invoiceForm').action = '{{ route('user.invoices.store') }}';
    document.getElementById('invMethodField').innerHTML = '';
    document.getElementById('invDrawerTitle').textContent = 'Create Invoice';
    ['invCustomerName','invCustomerEmail','invCustomerPhone','invNotes'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
    document.getElementById('invIssueDate').value = new Date().toISOString().split('T')[0];
    const due = new Date(); due.setDate(due.getDate() + 7);
    document.getElementById('invDueDate').value = due.toISOString().split('T')[0];
    document.getElementById('invStatus').value = 'sent';
    invoiceItems = [];
    renderInvoiceItems();
    const backdrop = document.getElementById('invoiceBackdrop');
    const drawer = document.getElementById('invoiceDrawer');
    backdrop.classList.remove('closed'); backdrop.classList.add('open');
    drawer.classList.remove('overlay-closed'); drawer.classList.add('overlay-open');
}

function closeInvoiceDrawer() {
    const backdrop = document.getElementById('invoiceBackdrop');
    const drawer = document.getElementById('invoiceDrawer');
    backdrop.classList.remove('open'); backdrop.classList.add('closed');
    drawer.classList.remove('overlay-open'); drawer.classList.add('overlay-closed');
}

// Item selector update
function updateItemOptions() {
    const type = document.getElementById('itemTypeSelector').value;
    const selector = document.getElementById('itemSelector');
    selector.innerHTML = '';
    if (type === 'product') {
        productsData.forEach(p => {
            selector.innerHTML += '<option value="' + p.id + '" data-name="' + p.name.replace(/"/g, '&quot;') + '" data-price="' + p.price + '" data-type="product">' + p.name + ' - TSh ' + Number(p.price).toLocaleString() + '</option>';
        });
    } else {
        servicesData.forEach(s => {
            selector.innerHTML += '<option value="' + s.id + '" data-name="' + s.name.replace(/"/g, '&quot;') + '" data-price="' + s.price + '" data-type="service">' + s.name + ' - TSh ' + Number(s.price).toLocaleString() + '</option>';
        });
    }
}

// Add item to invoice
function addInvoiceItem() {
    const selector = document.getElementById('itemSelector');
    const option = selector.options[selector.selectedIndex];
    const qty = parseInt(document.getElementById('itemQty').value) || 1;
    const item = {
        type: document.getElementById('itemTypeSelector').value,
        id: parseInt(selector.value),
        name: option.dataset.name,
        price: parseFloat(option.dataset.price),
        qty: qty
    };
    // Check if already exists
    const existing = invoiceItems.find(i => i.type === item.type && i.id === item.id);
    if (existing) {
        existing.qty += qty;
    } else {
        invoiceItems.push(item);
    }
    renderInvoiceItems();
    document.getElementById('itemQty').value = 1;
}

function removeInvoiceItem(index) {
    invoiceItems.splice(index, 1);
    renderInvoiceItems();
}

function renderInvoiceItems() {
    const list = document.getElementById('invoiceItemsList');
    if (invoiceItems.length === 0) {
        list.innerHTML = '<p class="text-xs text-gray-400 text-center py-2">No items added</p>';
    } else {
        list.innerHTML = invoiceItems.map((item, i) =>
            '<div class="flex items-center gap-2 bg-gray-50 rounded-lg p-2">' +
            '<div class="w-7 h-7 rounded-md ' + (item.type === 'product' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700') + ' flex items-center justify-center text-[10px] font-bold shrink-0">' + (item.type === 'product' ? 'P' : 'S') + '</div>' +
            '<div class="flex-1 min-w-0"><p class="text-xs font-bold text-gray-900 truncate">' + item.name + '</p><p class="text-[10px] text-gray-400">' + item.qty + ' x TSh ' + Number(item.price).toLocaleString() + '</p></div>' +
            '<p class="text-xs font-bold text-gray-900">TSh ' + Number(item.price * item.qty).toLocaleString() + '</p>' +
            '<button type="button" onclick="removeInvoiceItem(' + i + ')" class="p-1 text-gray-400 hover:text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>' +
            '<input type="hidden" name="items[' + i + '][type]" value="' + item.type + '"><input type="hidden" name="items[' + i + '][id]" value="' + item.id + '"><input type="hidden" name="items[' + i + '][name]" value="' + item.name + '"><input type="hidden" name="items[' + i + '][price]" value="' + item.price + '"><input type="hidden" name="items[' + i + '][qty]" value="' + item.qty + '">' +
            '</div>'
        ).join('');
    }
    calculateInvoiceTotals();
}

function calculateInvoiceTotals() {
    const subtotal = invoiceItems.reduce((s, i) => s + (i.price * i.qty), 0);
    let discount = parseFloat(document.getElementById('invDiscountInput').value) || 0;
    const discountType = document.getElementById('invDiscountType').value;
    if (discountType === 'percent') discount = Math.round(subtotal * (discount / 100));
    const taxable = Math.max(0, subtotal - discount);
    const tax = Math.round(taxable * taxRateInvoice);
    const total = taxable + tax;

    document.getElementById('invSubtotal').textContent = 'TSh ' + subtotal.toLocaleString();
    document.getElementById('invTaxDisplay').textContent = 'TSh ' + tax.toLocaleString();
    document.getElementById('invTotalDisplay').textContent = 'TSh ' + total.toLocaleString();

    document.getElementById('invSubtotalInput').value = subtotal;
    document.getElementById('invDiscountHidden').value = discount;
    document.getElementById('invTaxInput').value = tax;
    document.getElementById('invTotalInput').value = total;
}

// AJAX Search & Filter
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('invoiceSearch');
    if (searchInput) searchInput.addEventListener('input', function() { clearTimeout(searchTimeoutInvoice); searchTimeoutInvoice = setTimeout(doInvoiceSearch, 300); });
});

function doInvoiceSearch() {
    const search = document.getElementById('invoiceSearch')?.value || '';
    const status = document.getElementById('invoiceStatus')?.value || 'all';
    const url = new URL('{{ route('user.invoices') }}');
    if (search) url.searchParams.set('search', search);
    if (status && status !== 'all') url.searchParams.set('status', status);
    fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => {
        document.getElementById('invoiceTableBody').innerHTML = html;
        const pag = document.getElementById('invoicePagination');
        if (pag) pag.style.display = 'none';
    });
}

// Export
document.addEventListener('click', function(e) {
    const c = document.getElementById('exportDropdownContainer');
    if (c && !c.contains(e.target)) document.getElementById('exportDropdown').classList.add('hidden');
});
function toggleExportDropdown() { document.getElementById('exportDropdown').classList.toggle('hidden'); }
function printInvoices() { document.getElementById('exportDropdown').classList.add('hidden'); window.print(); }
function exportInvoiceCSV() {
    document.getElementById('exportDropdown').classList.add('hidden');
    const rows = document.querySelectorAll('#invoiceTableBody tr');
    let csv = 'Invoice,Customer,Amount,Status,Date\n';
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
            const inv = cells[0].innerText.replace(/\n/g, ' ').trim();
            const customer = cells[1].innerText.replace(/\n/g, ' ').trim();
            const amount = cells[2].innerText.replace(/[^0-9]/g, '').trim();
            const status = cells[3].innerText.trim();
            const date = cells[4].innerText.trim();
            csv += '"' + inv + '","' + customer + '","' + amount + '","' + status + '","' + date + '"\n';
        }
    });
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'invoices_{{ now()->format('Y-m-d') }}.csv';
    link.click();
}

// View Invoice
function viewInvoice(row) {
    const data = JSON.parse(row.dataset.invoice);
    document.getElementById('viewInvNumber').textContent = data.invoice_number;
    document.getElementById('viewInvIssueDate').textContent = data.issue_date || '-';
    document.getElementById('viewInvDueDate').textContent = data.due_date || '-';
    document.getElementById('viewInvCustomer').textContent = data.customer_name || 'Guest';
    const statusEl = document.getElementById('viewInvStatus');
    const statusColors = { paid: 'text-emerald-600', sent: 'text-blue-600', draft: 'text-gray-500', overdue: 'text-red-600', cancelled: 'text-gray-400' };
    statusEl.textContent = (data.status || 'Draft').charAt(0).toUpperCase() + (data.status || 'Draft').slice(1);
    statusEl.className = 'font-medium ' + (statusColors[data.status] || 'text-gray-500');

    const itemsBody = document.getElementById('viewInvItems');
    const items = data.items || [];
    if (items.length > 0) {
        itemsBody.innerHTML = items.map(item =>
            '<tr><td class="py-1.5">' + (item.name || 'Item') + '</td><td class="text-right py-1.5">' + (item.qty || 1) + '</td><td class="text-right py-1.5">TSh ' + Number(item.price || 0).toLocaleString() + '</td><td class="text-right py-1.5 font-medium">TSh ' + (Number(item.price || 0) * Number(item.qty || 1)).toLocaleString() + '</td></tr>'
        ).join('');
    } else {
        itemsBody.innerHTML = '<tr><td colspan="4" class="py-2 text-center text-gray-400">No items</td></tr>';
    }

    document.getElementById('viewInvSubtotal').textContent = 'TSh ' + Number(data.subtotal || 0).toLocaleString();
    document.getElementById('viewInvDiscount').textContent = '-TSh ' + Number(data.discount || 0).toLocaleString();
    document.getElementById('viewInvTax').textContent = 'TSh ' + Number(data.tax || 0).toLocaleString();
    document.getElementById('viewInvTotal').textContent = 'TSh ' + Number(data.amount || 0).toLocaleString();
    document.getElementById('viewInvNotes').textContent = data.notes || '';

    const m = document.getElementById('viewInvoiceModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closeViewInvoice() { const m = document.getElementById('viewInvoiceModal'); m.classList.add('hidden'); m.classList.remove('flex'); }
function printInvoiceView() { window.print(); }

// Pay Invoice (AJAX)
function payInvoice(id, invNumber) {
    saConfirm({
        title: 'Mark as Paid?',
        text: 'Record payment for invoice "' + invNumber + '"? This will create a sale entry.',
        icon: 'success',
        confirmText: 'Pay Now',
        confirmColor: 'emerald',
        onConfirm: function() {
            fetch('{{ url('invoices') }}/' + id + '/pay', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    doInvoiceSearch();
                    if (typeof saAlert === 'function') {
                        saAlert({ title: 'Paid!', text: 'Invoice paid and recorded in sales.', icon: 'success' });
                    }
                }
            })
            .catch(err => { console.error(err); alert('Failed to process payment.'); });
        }
    });
}

// Delete Invoice
function deleteInvoice(id, invNumber) {
    saConfirm({
        title: 'Delete Invoice?',
        text: 'Are you sure you want to delete invoice "' + invNumber + '"?',
        icon: 'danger',
        confirmText: 'Delete',
        confirmColor: 'red',
        onConfirm: function() {
            fetch('{{ url('invoices') }}/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) { doInvoiceSearch(); }
            })
            .catch(err => { console.error(err); alert('Failed to delete invoice.'); });
        }
    });
}
</script>
@endsection
