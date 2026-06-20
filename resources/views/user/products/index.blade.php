@extends('layouts.user')

@section('title', 'Products - SalamaPay')
@section('page_title', 'Products')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Products', 'subtitle' => 'Manage your product catalog'])

{{-- Out of Stock Alert Banner --}}
@if($stats['lowStock'] > 0)
<div class="mb-4 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl p-4 text-white flex items-center gap-3 shadow-sm animate-fade">
    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-3.93 6.659a9.955 9.955 0 01-4.56-3.348 9.955 9.955 0 01-1.552-5.503 9.954 9.954 0 013.654-7.608 9.953 9.953 0 017.552-2.106 9.954 9.954 0 017.608 3.654 9.955 9.955 0 012.106 7.552 9.955 9.955 0 01-3.348 4.56M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold">{{ $stats['lowStock'] }} product{{ $stats['lowStock'] > 1 ? 's' : '' }} running low on stock!</p>
        <p class="text-[11px] text-red-100">Restock soon to avoid losing sales.</p>
    </div>
    <a href="{{ route('user.products') }}?status=active" class="px-3 py-1.5 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-bold transition-colors">View</a>
</div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Products</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['total'] }}</p>
        <p class="text-[10px] text-emerald-200 mt-1">All products</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Active</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['active'] }}</p>
        <p class="text-[10px] text-blue-200 mt-1">Available for sale</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Draft</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['draft'] }}</p>
        <p class="text-[10px] text-amber-100 mt-1">Not yet published</p>
    </div>
    <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-red-100">Low Stock</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $stats['lowStock'] }}</p>
        <p class="text-[10px] text-red-100 mt-1">5 or less in stock</p>
    </div>
</div>

{{-- Filters + Add --}}
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-4">
    <form method="GET" action="{{ route('user.products') }}" class="flex-1 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1 max-w-sm">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
        </div>
        <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 border rounded-xl text-xs font-medium text-gray-600 outline-none focus:border-emerald-500 cursor-pointer">
            <option value="all">All Status</option>
            <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
            <option value="draft" {{ request('status')==='draft'?'selected':'' }}>Draft</option>
            <option value="archived" {{ request('status')==='archived'?'selected':'' }}>Archived</option>
        </select>
        @if($categories->count())
        <select name="category" onchange="this.form.submit()" class="px-3 py-2.5 border rounded-xl text-xs font-medium text-gray-600 outline-none focus:border-emerald-500 cursor-pointer">
            <option value="all">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>
        @endif
        @if(request()->hasAny(['search','status','category']))
        <a href="{{ route('user.products') }}" class="px-3 py-2.5 border rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-50 flex items-center gap-1.5 whitespace-nowrap">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Clear
        </a>
        @endif
    </form>
    <div class="flex gap-2">
        <button onclick="openProductSettingsDrawer()" class="px-4 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Settings
        </button>
        <button onclick="openProductDrawer()" class="px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5 active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </button>
    </div>
</div>

{{-- Products Table --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Product</th>
                    <th class="text-left px-5 py-3 font-semibold">SKU</th>
                    <th class="text-left px-5 py-3 font-semibold">Price</th>
                    <th class="text-left px-5 py-3 font-semibold">Stock</th>
                    <th class="text-left px-5 py-3 font-semibold">Status</th>
                    <th class="text-left px-5 py-3 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs">
                                {{ strtoupper(substr($product->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-xs">{{ $product->name }}</p>
                                @if($product->category)
                                <p class="text-[10px] text-gray-400">{{ $product->category }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-xs font-mono text-gray-500">{{ $product->sku ?? '—' }}</td>
                    <td class="px-5 py-3.5 font-bold text-gray-900 text-xs">TSh {{ number_format($product->price) }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs font-bold {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-700' }}">{{ $product->stock }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($product->status === 'active')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                        @elseif($product->status === 'draft')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">Draft</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">Archived</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="openEditProductDrawer({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description ?? '') }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->category ?? '' }}', '{{ $product->sku ?? '' }}', '{{ $product->status }}')" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded-md transition-colors">Edit</button>
                            <button onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')" class="text-[10px] font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-md transition-colors">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-500">No products found</p>
                            <p class="text-xs text-gray-400 mt-0.5">Add your first product to get started.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-5 py-3 border-t">{{ $products->links() }}</div>
    @endif
</div>

{{-- Slide-in Product Drawer --}}
<style>
#productDrawer { transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
#productDrawer.overlay-open { transform: translateX(0); }
#productDrawer.overlay-closed { transform: translateX(100%); }
.drawer-backdrop { transition: opacity 0.3s ease; }
.drawer-backdrop.open { opacity: 1; pointer-events: auto; }
.drawer-backdrop.closed { opacity: 0; pointer-events: none; }
</style>

<div id="drawerBackdrop" class="drawer-backdrop closed fixed inset-0 bg-black/40 backdrop-blur-sm z-[50]" onclick="closeProductDrawer()"></div>
<div id="productDrawer" class="fixed inset-y-0 right-0 z-[55] w-full max-w-lg bg-white shadow-2xl flex flex-col overlay-closed">
    {{-- Drawer Header --}}
    <div class="px-6 py-4 border-b flex items-center justify-between bg-white shrink-0">
        <div>
            <h3 class="text-base font-black text-gray-900" id="drawerTitle">Add Product</h3>
            <p class="text-[10px] text-gray-400">Manage your product details and settings</p>
        </div>
        <button onclick="closeProductDrawer()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Tabs --}}
    <div class="flex border-b bg-gray-50/50 shrink-0">
        <button onclick="switchDrawerTab('product')" id="tabProduct" class="flex-1 py-3 text-xs font-bold text-emerald-600 border-b-2 border-emerald-600 bg-white transition-colors">Product</button>
        <button onclick="switchDrawerTab('settings')" id="tabSettings" class="flex-1 py-3 text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">Settings</button>
    </div>

    {{-- Drawer Content --}}
    <div class="flex-1 overflow-y-auto">
        {{-- Tab: Product Form --}}
        <div id="panelProduct" class="p-6 space-y-4">
            <form id="productForm" method="POST" action="{{ route('user.products.store') }}">
                @csrf
                <div id="methodField"></div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Product Name</label>
                    <input type="text" name="name" id="prodName" required class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Premium Plan">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Price (TSh)</label>
                        <input type="number" name="price" id="prodPrice" required min="0" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Stock</label>
                        <input type="number" name="stock" id="prodStock" required min="0" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="0">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                        <input type="text" name="category" id="prodCategory" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. Software">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">SKU</label>
                        <input type="text" name="sku" id="prodSku" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="e.g. PRD-001">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" id="prodStatus" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 transition-all">
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Description</label>
                    <textarea name="description" id="prodDesc" rows="3" class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all resize-none" placeholder="Optional description..."></textarea>
                </div>
                <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-2">
                    <button type="button" onclick="closeProductDrawer()" class="flex-1 py-3 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Product</button>
                </div>
            </form>
        </div>

        {{-- Tab: Settings --}}
        <div id="panelSettings" class="p-6 space-y-5 hidden">
            <form method="POST" action="{{ route('user.tools.update') }}">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Product Categories</label>
                    <div id="drawerCategoriesList" class="space-y-2 mb-2">
                        @php
                            $cats = json_decode(auth()->user()->settings['product_categories'] ?? '[]', true) ?: ['Drinks','Snacks','Electronics','Clothing','Food'];
                        @endphp
                        @foreach($cats as $cat)
                        <div class="flex items-center gap-2 cat-row">
                            <input type="text" name="product_categories[]" value="{{ $cat }}" class="flex-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                            <button type="button" onclick="this.closest('.cat-row').remove()" class="p-2 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addDrawerCategoryRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Category
                    </button>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Units of Measurement</label>
                    <div id="drawerUnitsList" class="space-y-2 mb-2">
                        @php
                            $units = json_decode(auth()->user()->settings['product_units'] ?? '[]', true) ?: ['Piece','Kg','Litre','Pack','Box'];
                        @endphp
                        @foreach($units as $unit)
                        <div class="flex items-center gap-2 unit-row">
                            <input type="text" name="product_units[]" value="{{ $unit }}" class="flex-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                            <button type="button" onclick="this.closest('.unit-row').remove()" class="p-2 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addDrawerUnitRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Unit
                    </button>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Low Stock Alert Threshold</label>
                    <div class="flex items-center gap-3">
                        <input type="number" name="low_stock_threshold" value="{{ auth()->user()->settings['low_stock_threshold'] ?? 5 }}" min="1" max="100" class="w-24 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                        <span class="text-xs text-gray-400">items or less triggers alert</span>
                    </div>
                </div>
                <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-2">
                    <button type="button" onclick="closeProductDrawer()" class="flex-1 py-3 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Form --}}
<form id="deleteProductForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

<script>
function openProductSettingsModal() {
    const m = document.getElementById('productSettingsModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closeProductSettingsModal() {
    const m = document.getElementById('productSettingsModal');
    m.classList.add('hidden'); m.classList.remove('flex');
}
function addCategoryRow() {
    const list = document.getElementById('categoriesList');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2 cat-row';
    div.innerHTML = '<input type="text" name="product_categories[]" placeholder="Category name" class="flex-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"><button type="button" onclick="this.closest(\'.cat-row\').remove()" class="p-2 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>';
    list.appendChild(div);
}
function addUnitRow() {
    const list = document.getElementById('unitsList');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2 unit-row';
    div.innerHTML = '<input type="text" name="product_units[]" placeholder="Unit name" class="flex-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"><button type="button" onclick="this.closest(\'.unit-row\').remove()" class="p-2 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>';
    list.appendChild(div);
}

function openProductModal() {
    document.getElementById('productForm').action = '{{ route('user.products.store') }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('modalTitle').textContent = 'Add Product';
    ['prodName','prodPrice','prodStock','prodCategory','prodSku','prodDesc'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('prodStatus').value = 'active';
    const m = document.getElementById('productModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function openEditProductModal(id, name, description, price, stock, category, sku, status) {
    document.getElementById('productForm').action = '{{ url('products') }}/' + id;
    document.getElementById('methodField').innerHTML = '@method('PUT')';
    document.getElementById('modalTitle').textContent = 'Edit Product';
    document.getElementById('prodName').value = name;
    document.getElementById('prodDesc').value = description;
    document.getElementById('prodPrice').value = price;
    document.getElementById('prodStock').value = stock;
    document.getElementById('prodCategory').value = category;
    document.getElementById('prodSku').value = sku;
    document.getElementById('prodStatus').value = status;
    const m = document.getElementById('productModal');
    m.classList.remove('hidden'); m.classList.add('flex');
}
function closeProductModal() {
    const m = document.getElementById('productModal');
    m.classList.add('hidden'); m.classList.remove('flex');
}
function deleteProduct(id, name) {
    saConfirm({
        title: 'Delete Product?',
        text: 'Are you sure you want to delete "' + name + '"? This cannot be undone.',
        icon: 'danger',
        confirmText: 'Delete',
        confirmColor: 'red',
        onConfirm: function() {
            const form = document.getElementById('deleteProductForm');
            form.action = '{{ url('products') }}/' + id;
            form.submit();
        }
    });
}
</script>
@endsection
