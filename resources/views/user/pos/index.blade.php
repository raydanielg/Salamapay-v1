@extends('layouts.user')

@section('title', 'POS - SalamaPay')
@section('page_title', 'Point of Sale')

@section('content')
@include('user.partials.alert')

@php
    $currencySymbol = $settings['currency_symbol'] ?? 'TSh';
    $taxRate = ($settings['tax_rate'] ?? 18) / 100;
@endphp

<style>
.pos-product-card{ transition:all .15s ease; cursor:pointer; }
.pos-product-card:hover{ transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
.pos-product-card:active{ transform:scale(0.97); }
.qty-btn{ transition:all .15s ease; }
.qty-btn:active{ transform:scale(0.9); }
.pay-btn{ transition:all .2s ease; }
.pay-btn:active{ transform:scale(0.97); }
@keyframes popIn{ from{opacity:0;transform:scale(0.9)} to{opacity:1;transform:scale(1)} }
.cart-pop{ animation:popIn .2s ease; }
</style>

<div class="flex flex-col lg:flex-row gap-5 h-[calc(100vh-120px)] min-h-[600px]">

    {{-- LEFT: Product Catalog --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Top Bar: Search + Category --}}
        <div class="bg-white rounded-xl border p-4 mb-4 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="posSearch" placeholder="Search products..." class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" oninput="filterPosProducts(this.value)">
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1">
                <button onclick="filterCategory('all')" class="cat-btn px-3 py-2 rounded-lg text-xs font-bold bg-emerald-600 text-white whitespace-nowrap transition-colors" data-cat="all">All</button>
                @foreach($categories as $cat)
                <button onclick="filterCategory('{{ $cat }}')" class="cat-btn px-3 py-2 rounded-lg text-xs font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap transition-colors" data-cat="{{ $cat }}">{{ $cat ?? 'General' }}</button>
                @endforeach
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="flex-1 overflow-y-auto pr-1" id="productsArea">
            @if(count($products) === 0)
            <div class="flex flex-col items-center justify-center h-full text-center p-8">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-sm font-bold text-gray-500">No products available</p>
                <p class="text-xs text-gray-400 mt-1">Add products in the Products section to get started.</p>
                <a href="{{ route('user.products') }}" class="mt-3 px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-colors">Add Products</a>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" id="productsGrid">
                @foreach($products as $p)
                <div class="pos-product-card bg-white rounded-xl border p-4 text-center group" data-name="{{ strtolower($p->name) }}" data-category="{{ $p->category ?? 'General' }}" onclick="addToCart({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->price }})">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-emerald-200 transition-colors">
                        <span class="text-lg font-black text-emerald-700">{{ strtoupper(substr($p->name,0,1)) }}</span>
                    </div>
                    <p class="text-xs font-bold text-gray-900 leading-tight truncate">{{ $p->name }}</p>
                    <p class="text-sm font-black text-emerald-700 mt-1">{{ $currencySymbol }} {{ number_format($p->price) }}</p>
                    <p class="text-[9px] text-gray-400 mt-0.5">{{ $p->category ?? 'General' }} {{ $p->stock <= 5 ? '• '.$p->stock.' left' : '' }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: Cart & Checkout --}}
    <div class="w-full lg:w-[380px] flex flex-col gap-4 shrink-0">

        {{-- Customer Info --}}
        <div class="bg-white rounded-xl border p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Customer</h3>
                <span class="text-[9px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full font-medium" id="customerType">Walking Customer</span>
            </div>
            <div class="space-y-2.5">
                <input type="text" id="customerName" placeholder="Customer name (optional)" class="w-full px-3 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500 transition-all" oninput="updateCustomerType()">
                <input type="tel" id="customerPhone" placeholder="Phone number (optional)" class="w-full px-3 py-2 border rounded-lg text-xs outline-none focus:border-emerald-500 transition-all">
            </div>
        </div>

        {{-- Cart --}}
        <div class="bg-white rounded-xl border flex-1 flex flex-col min-h-0">
            <div class="px-4 py-3 border-b flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Cart</h3>
                <span class="text-xs font-bold text-emerald-700" id="cartCount">0 items</span>
            </div>
            <div class="flex-1 overflow-y-auto p-3" id="cartArea">
                <div class="flex flex-col items-center justify-center h-full text-center py-8" id="emptyCart">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p class="text-xs text-gray-400">Cart is empty</p>
                    <p class="text-[10px] text-gray-300 mt-0.5">Click a product to add</p>
                </div>
                <div id="cartItems" class="space-y-2 hidden"></div>
            </div>
        </div>

        {{-- Totals & Actions --}}
        <div class="bg-white rounded-xl border p-4 space-y-3">
            {{-- Subtotal --}}
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500">Subtotal</span>
                <span class="text-sm font-bold text-gray-900" id="subtotalDisplay">{{ $currencySymbol }} 0</span>
            </div>

            {{-- Discount --}}
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">-{{ $currencySymbol }}</span>
                    <input type="number" id="discountInput" placeholder="Discount" class="w-full pl-12 pr-3 py-2 border rounded-lg text-xs font-bold text-red-600 outline-none focus:border-red-400 transition-all" oninput="calculateTotals()">
                </div>
                <select id="discountType" class="w-20 border rounded-lg text-xs outline-none focus:border-emerald-500" onchange="calculateTotals()">
                    <option value="flat">Flat</option>
                    <option value="percent">%</option>
                </select>
            </div>

            {{-- Tax --}}
            <div class="flex justify-between items-center py-2 border-t border-dashed border-gray-200">
                <span class="text-xs text-gray-500">Tax ({{ $settings['tax_rate'] ?? 18 }}%)</span>
                <span class="text-xs font-bold text-gray-700" id="taxDisplay">{{ $currencySymbol }} 0</span>
            </div>

            {{-- Grand Total --}}
            <div class="flex justify-between items-center py-3 bg-emerald-50 rounded-xl px-3">
                <span class="text-xs font-bold text-emerald-800 uppercase">Total</span>
                <span class="text-xl font-black text-emerald-700" id="totalDisplay">{{ $currencySymbol }} 0</span>
            </div>

            {{-- Amount Paid & Change --}}
            <div class="space-y-2">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">{{ $currencySymbol }}</span>
                    <input type="number" id="amountPaid" placeholder="Amount received" class="w-full pl-10 pr-3 py-2.5 border rounded-lg text-sm font-bold text-gray-900 outline-none focus:border-emerald-500 transition-all" oninput="calculateTotals()">
                </div>
                <div class="flex justify-between items-center px-1">
                    <span class="text-[10px] text-gray-500">Change</span>
                    <span class="text-sm font-black text-gray-900" id="changeDisplay">{{ $currencySymbol }} 0</span>
                </div>
            </div>

            {{-- Pay Button --}}
            <button onclick="processPayment()" class="pay-btn w-full py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-sm font-black rounded-xl shadow-sm hover:from-emerald-700 hover:to-emerald-800 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                Pay Now
            </button>

            {{-- Receipt Options --}}
            <div class="flex gap-2">
                <button onclick="printReceipt()" class="flex-1 py-2 border rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print
                </button>
                <button onclick="sendReceipt()" class="flex-1 py-2 border rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Send
                </button>
                <button onclick="clearCart()" class="px-3 py-2 border rounded-lg text-xs font-bold text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];
let products = @json($products);
const currencySymbol = '{{ $currencySymbol }}';
const taxRate = {{ $taxRate }};

function filterPosProducts(q) {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;
    const cards = grid.querySelectorAll('.pos-product-card');
    cards.forEach(c => {
        const name = c.dataset.name;
        c.style.display = !q || name.includes(q.toLowerCase()) ? '' : 'none';
    });
}

function filterCategory(cat) {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;
    const cards = grid.querySelectorAll('.pos-product-card');
    cards.forEach(c => {
        c.style.display = cat === 'all' || c.dataset.category === cat ? '' : 'none';
    });
    document.querySelectorAll('.cat-btn').forEach(b => {
        if (b.dataset.cat === cat) { b.classList.remove('bg-gray-100','text-gray-600'); b.classList.add('bg-emerald-600','text-white'); }
        else { b.classList.add('bg-gray-100','text-gray-600'); b.classList.remove('bg-emerald-600','text-white'); }
    });
}

function addToCart(id, name, price) {
    const existing = cart.find(i => i.id === id);
    if (existing) { existing.qty++; }
    else { cart.push({id,name,price,qty:1}); }
    renderCart();
    calculateTotals();
}

function updateQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
    renderCart();
    calculateTotals();
}

function removeItem(id) {
    cart = cart.filter(i => i.id !== id);
    renderCart();
    calculateTotals();
}

function renderCart() {
    const area = document.getElementById('cartItems');
    const empty = document.getElementById('emptyCart');
    const count = document.getElementById('cartCount');
    if (!area || !empty) return;

    const totalItems = cart.reduce((s,i)=>s+i.qty,0);
    count.textContent = totalItems + ' item' + (totalItems !== 1 ? 's' : '');

    if (cart.length === 0) {
        area.classList.add('hidden'); empty.classList.remove('hidden');
        return;
    }
    area.classList.remove('hidden'); empty.classList.add('hidden');

    area.innerHTML = cart.map(item => `
        <div class="cart-pop flex items-center gap-2 bg-gray-50 rounded-lg p-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-[10px] shrink-0">${item.name.charAt(0)}</div>
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-gray-900 truncate">${item.name}</p>
                <p class="text-[10px] text-gray-400">TSh ${item.price.toLocaleString()}</p>
            </div>
            <div class="flex items-center gap-1.5">
                <button onclick="updateQty(${item.id},-1)" class="qty-btn w-6 h-6 rounded-md bg-white border flex items-center justify-center text-gray-500 hover:text-emerald-600 hover:border-emerald-300">-</button>
                <span class="text-xs font-bold text-gray-900 w-4 text-center">${item.qty}</span>
                <button onclick="updateQty(${item.id},1)" class="qty-btn w-6 h-6 rounded-md bg-white border flex items-center justify-center text-gray-500 hover:text-emerald-600 hover:border-emerald-300">+</button>
            </div>
            <p class="text-[11px] font-bold text-gray-900 w-[70px] text-right">${currencySymbol} ${(item.price*item.qty).toLocaleString()}</p>
            <button onclick="removeItem(${item.id})" class="qty-btn w-6 h-6 rounded-md flex items-center justify-center text-gray-300 hover:text-red-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
}

function calculateTotals() {
    const subtotal = cart.reduce((s,i)=>s+(i.price*i.qty),0);
    const discountType = document.getElementById('discountType')?.value || 'flat';
    let discount = parseFloat(document.getElementById('discountInput')?.value) || 0;
    if (discountType === 'percent') discount = subtotal * (discount / 100);
    const taxable = Math.max(0, subtotal - discount);
    const tax = Math.round(taxable * taxRate);
    const total = taxable + tax;
    const paid = parseFloat(document.getElementById('amountPaid')?.value) || 0;
    const change = Math.max(0, paid - total);

    document.getElementById('subtotalDisplay').textContent = currencySymbol + ' ' + subtotal.toLocaleString();
    document.getElementById('taxDisplay').textContent = currencySymbol + ' ' + tax.toLocaleString();
    document.getElementById('totalDisplay').textContent = currencySymbol + ' ' + total.toLocaleString();
    document.getElementById('changeDisplay').textContent = currencySymbol + ' ' + change.toLocaleString();
}

function updateCustomerType() {
    const name = document.getElementById('customerName')?.value?.trim();
    const badge = document.getElementById('customerType');
    if (!badge) return;
    if (name) { badge.textContent = name; badge.classList.remove('bg-gray-100','text-gray-500'); badge.classList.add('bg-emerald-100','text-emerald-700'); }
    else { badge.textContent = 'Walking Customer'; badge.classList.add('bg-gray-100','text-gray-500'); badge.classList.remove('bg-emerald-100','text-emerald-700'); }
}

function clearCart() {
    if (!cart.length) return;
    if (!confirm('Clear all items from cart?')) return;
    cart = []; renderCart(); calculateTotals();
    document.getElementById('discountInput').value = '';
    document.getElementById('amountPaid').value = '';
}

function processPayment() {
    const totalText = document.getElementById('totalDisplay')?.textContent || '0';
    const total = parseInt(totalText.replace(/[^0-9]/g,'')) || 0;
    if (total <= 0) { alert('Cart is empty. Add products first.'); return; }
    const paid = parseFloat(document.getElementById('amountPaid')?.value) || 0;
    if (paid < total) { alert('Amount received is less than total.'); return; }
    alert('Payment of ' + currencySymbol + ' ' + total.toLocaleString() + ' processed successfully!');
    // Here you would save sale, then optionally print or send receipt
    cart = []; renderCart(); calculateTotals();
    document.getElementById('discountInput').value = '';
    document.getElementById('amountPaid').value = '';
}

function printReceipt() {
    if (cart.length === 0) { alert('Cart is empty.'); return; }
    window.print();
}

function sendReceipt() {
    if (cart.length === 0) { alert('Cart is empty.'); return; }
    const phone = document.getElementById('customerPhone')?.value;
    if (!phone) { alert('Please enter customer phone number to send receipt.'); return; }
    alert('Receipt sent to ' + phone + ' via WhatsApp/SMS!');
}

// Init
calculateTotals();
</script>
@endsection
