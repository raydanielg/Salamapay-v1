{{-- Slide-in Invoice Drawer --}}
<style>
#invoiceDrawer { transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
#invoiceDrawer.overlay-open { transform: translateX(0); }
#invoiceDrawer.overlay-closed { transform: translateX(100%); }
.invoice-backdrop { transition: opacity 0.3s ease; }
.invoice-backdrop.open { opacity: 1; pointer-events: auto; }
.invoice-backdrop.closed { opacity: 0; pointer-events: none; }
@media print {
    body * { visibility: hidden; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea { position: absolute; left: 0; top: 0; width: 100%; }
    #printableArea .overflow-x-auto { overflow: visible !important; }
    #printableArea table { width: 100% !important; border-collapse: collapse; }
    #printableArea th, #printableArea td { border: 1px solid #ddd; padding: 8px; }
    #printableArea button { display: none !important; }
}
</style>

<div id="invoiceBackdrop" class="invoice-backdrop closed fixed inset-0 bg-black/40 backdrop-blur-sm z-[50]" onclick="closeInvoiceDrawer()"></div>
<div id="invoiceDrawer" class="fixed inset-y-0 right-0 z-[55] w-full max-w-lg bg-white shadow-2xl flex flex-col overlay-closed">
    <div class="px-6 py-4 border-b flex items-center justify-between bg-white shrink-0">
        <div>
            <h3 class="text-base font-black text-gray-900" id="invDrawerTitle">Create Invoice</h3>
            <p class="text-[10px] text-gray-400">Add products or services to invoice</p>
        </div>
        <button onclick="closeInvoiceDrawer()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-6 space-y-4">
        <form id="invoiceForm" method="POST" action="{{ route('user.invoices.store') }}">
            @csrf
            <div id="invMethodField"></div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Customer Name</label>
                    <input type="text" name="customer_name" id="invCustomerName" required class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="Customer name">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Phone</label>
                    <input type="text" name="customer_phone" id="invCustomerPhone" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="Phone number">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                <input type="email" name="customer_email" id="invCustomerEmail" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="customer@email.com">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Issue Date</label>
                    <input type="date" name="issue_date" id="invIssueDate" required class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Due Date</label>
                    <input type="date" name="due_date" id="invDueDate" required class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                </div>
            </div>

            {{-- Line Items --}}
            <div class="pt-2 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Line Items</label>
                    <span class="text-[10px] text-gray-400">Products or Services</span>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 mb-2 space-y-2">
                    <div class="grid grid-cols-2 gap-2">
                        <select id="itemTypeSelector" class="px-2 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500" onchange="updateItemOptions()">
                            <option value="product">Product</option>
                            <option value="service">Service</option>
                        </select>
                        <select id="itemSelector" class="px-2 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500">
                            @foreach($products as $p)
                            <option value="{{ $p->id }}" data-name="{{ addslashes($p->name) }}" data-price="{{ $p->price }}" data-type="product">{{ $p->name }} - TSh {{ number_format($p->price) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <input type="number" id="itemQty" value="1" min="1" class="w-16 px-2 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500" placeholder="Qty">
                        <button type="button" onclick="addInvoiceItem()" class="flex-1 py-2 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 transition-colors">Add to Invoice</button>
                    </div>
                </div>
                <div id="invoiceItemsList" class="space-y-2 mb-2"></div>
                <div class="bg-gray-50 rounded-xl p-3 space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium" id="invSubtotal">TSh 0</span></div>
                    <div class="flex gap-2">
                        <div class="flex-1 relative">
                            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]">-TSh</span>
                            <input type="number" id="invDiscountInput" value="0" min="0" class="w-full pl-10 pr-2 py-1.5 border rounded-lg text-xs outline-none focus:border-emerald-500" oninput="calculateInvoiceTotals()" placeholder="Discount">
                        </div>
                        <select id="invDiscountType" class="w-20 border rounded-lg text-xs outline-none focus:border-emerald-500" onchange="calculateInvoiceTotals()">
                            <option value="flat">Flat</option>
                            <option value="percent">%</option>
                        </select>
                    </div>
                    <div class="flex justify-between"><span class="text-gray-500">Tax ({{ auth()->user()->tax_rate ?? 18 }}%)</span><span class="font-medium" id="invTaxDisplay">TSh 0</span></div>
                    <div class="flex justify-between pt-1.5 border-t border-dashed border-gray-200">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-black text-emerald-700 text-sm" id="invTotalDisplay">TSh 0</span>
                    </div>
                </div>
            </div>

            <input type="hidden" name="subtotal" id="invSubtotalInput" value="0">
            <input type="hidden" name="discount" id="invDiscountHidden" value="0">
            <input type="hidden" name="tax" id="invTaxInput" value="0">
            <input type="hidden" name="total" id="invTotalInput" value="0">

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Notes</label>
                <textarea name="notes" id="invNotes" rows="2" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all resize-none" placeholder="Terms, notes, or payment instructions..."></textarea>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                <select name="status" id="invStatus" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 transition-all">
                    <option value="draft">Draft</option>
                    <option value="sent" selected>Sent</option>
                </select>
            </div>

            <div class="pt-2 flex gap-3 sticky bottom-0 bg-white pb-2">
                <button type="button" onclick="closeInvoiceDrawer()" class="flex-1 py-3 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Invoice</button>
            </div>
        </form>
    </div>
</div>

{{-- View Invoice Modal --}}
<div id="viewInvoiceModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeViewInvoice()"></div>
    <div class="relative bg-white shadow-2xl w-full max-w-md overflow-hidden" style="max-height: 90vh; overflow-y: auto;">
        <div id="viewInvoiceContent" class="p-8 text-sm">
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
            </div>
            <div class="text-center mb-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500">Invoice</p>
                <p class="text-xs text-gray-400 mt-0.5" id="viewInvNumber">INV-00000000</p>
            </div>
            <div class="space-y-1.5 mb-4 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">Issue Date</span><span class="font-medium text-gray-900" id="viewInvIssueDate">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Due Date</span><span class="font-medium text-gray-900" id="viewInvDueDate">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Customer</span><span class="font-medium text-gray-900 text-right" id="viewInvCustomer">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="font-medium" id="viewInvStatus">-</span></div>
            </div>
            <table class="w-full text-xs mb-4">
                <thead><tr class="border-b-2 border-dashed border-gray-300">
                    <th class="text-left py-2 font-bold text-gray-700">Item</th>
                    <th class="text-right py-2 font-bold text-gray-700">Qty</th>
                    <th class="text-right py-2 font-bold text-gray-700">Price</th>
                    <th class="text-right py-2 font-bold text-gray-700">Total</th>
                </tr></thead>
                <tbody id="viewInvItems" class="text-gray-700"><tr><td colspan="4" class="py-2 text-center text-gray-400">No items</td></tr></tbody>
            </table>
            <div class="border-t-2 border-dashed border-gray-300 pt-3 space-y-1.5 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium" id="viewInvSubtotal">TSh 0</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Discount</span><span class="font-medium text-red-500" id="viewInvDiscount">-TSh 0</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tax</span><span class="font-medium" id="viewInvTax">TSh 0</span></div>
                <div class="flex justify-between pt-2 border-t border-dashed border-gray-200">
                    <span class="font-bold text-gray-900">TOTAL</span>
                    <span class="font-black text-emerald-700 text-base" id="viewInvTotal">TSh 0</span>
                </div>
            </div>
            <div class="text-center mt-6 pt-4 border-t-2 border-dashed border-gray-300">
                <p class="text-[10px] text-gray-400" id="viewInvNotes"></p>
            </div>
        </div>
        <div class="bg-gray-50 border-t p-4 flex gap-2">
            <button onclick="closeViewInvoice()" class="flex-1 py-2.5 border rounded-xl text-xs font-bold text-gray-600 hover:bg-white transition-colors">Close</button>
            <button onclick="printInvoiceView()" class="flex-1 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </button>
        </div>
    </div>
</div>
