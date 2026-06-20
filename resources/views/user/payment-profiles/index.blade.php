@extends('layouts.user')

@section('title', 'Payment Profiles - SalamaPay')
@section('page_title', 'Payment Profiles')

@section('content')
<style>
    .profile-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .profile-card:hover { transform: translateY(-3px); box-shadow: 0 16px 48px -12px rgba(0,0,0,0.12); }
    .animate-fade-up { animation: fadeUp 0.4s ease-out both; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.06s; }
    .delay-2 { animation-delay: 0.12s; }
    .delay-3 { animation-delay: 0.18s; }
    .modal-overlay { opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
    .modal-overlay.open { opacity: 1; pointer-events: auto; }
    .modal-panel { transform: translateX(100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
    .modal-overlay.open .modal-panel { transform: translateX(0); }
    .type-badge.catalog { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .type-badge.fixed { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .logo-preview { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; }
    .page-type-btn { transition: all 0.15s; }
    .page-type-btn.active { border-color: #024938; background: #f0fdf4; }
    .page-type-btn.active .pt-check { opacity: 1; transform: scale(1); }
    .pt-check { opacity: 0; transform: scale(0.5); transition: all 0.15s; }
</style>

@include('user.partials.alert')

{{-- Header + Filter --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 animate-fade-up">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Payment Profiles</h1>
        <p class="text-xs text-gray-500 mt-0.5">Manage business profiles shown on your payment pages</p>
    </div>
    <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('user.payment-profiles') }}" class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search profiles..." class="pl-9 pr-4 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 outline-none w-56">
        </form>
        <button onclick="openModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-800 text-white text-sm font-semibold rounded-lg hover:bg-emerald-900 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Profile
        </button>
    </div>
</div>

{{-- Profiles Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">
    @forelse($profiles as $profile)
    <div class="profile-card animate-fade-up delay-{{ $loop->iteration > 3 ? 3 : $loop->iteration }} bg-white rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden flex flex-col">
        <div class="h-2" style="background-color: {{ $profile->color }}"></div>
        <div class="p-5 flex-1">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    @if($profile->logo)
                        <img src="{{ asset('storage/' . $profile->logo) }}" alt="" class="logo-preview shadow-sm">
                    @else
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-sm" style="background: linear-gradient(135deg, {{ $profile->color }} 0%, {{ $profile->color }}dd 100%)">
                            {{ strtoupper(substr($profile->business_name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $profile->name }}</h3>
                        <p class="text-xs text-gray-400 truncate">{{ $profile->business_name }}</p>
                    </div>
                </div>
                @if($profile->is_default)
                <span class="shrink-0 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Default</span>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mb-3">
                <span class="type-badge {{ $profile->page_type }} inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border">{{ ucfirst($profile->page_type) }}</span>
                @if($profile->page_type === 'fixed' && $profile->allow_custom_amount)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-50 text-gray-600 border border-gray-200">Custom Amount</span>
                @endif
                @if($profile->page_type === 'catalog' && !empty($profile->products))
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-50 text-gray-600 border border-gray-200">{{ count($profile->products) }} Products</span>
                @endif
            </div>

            <div class="space-y-1.5 text-xs text-gray-500 mb-3">
                @if($profile->business_type)<p><span class="text-gray-400">Type:</span> <span class="text-gray-700 font-medium">{{ $profile->business_type }}</span></p>@endif
                @if($profile->phone)<p><span class="text-gray-400">Phone:</span> <span class="text-gray-700 font-medium">{{ $profile->phone }}</span></p>@endif
                @if($profile->email)<p><span class="text-gray-400">Email:</span> <span class="text-gray-700 font-medium">{{ $profile->email }}</span></p>@endif
            </div>

            @if($profile->description)
            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $profile->description }}</p>
            @endif
        </div>

        <div class="px-5 py-3 border-t border-gray-50 flex items-center gap-2">
            <button type="button" onclick="copyLink('{{ url('/pay/' . ($profile->paymentLinks->first()->slug ?? 'demo')) }}')" class="flex-1 px-3 py-1.5 text-[11px] font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-all flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Copy Link
            </button>
            <form action="{{ route('user.payment-profiles.update', $profile->id) }}" method="POST" class="flex-1">
                @csrf @method('PUT')
                <input type="hidden" name="name" value="{{ $profile->name }}">
                <input type="hidden" name="business_name" value="{{ $profile->business_name }}">
                <input type="hidden" name="page_type" value="{{ $profile->page_type }}">
                <input type="hidden" name="is_default" value="1">
                @if(!$profile->is_default)
                <button type="submit" class="w-full px-3 py-1.5 text-[11px] font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">Set Default</button>
                @else
                <span class="block w-full text-center px-3 py-1.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-lg">Default</span>
                @endif
            </form>
            <form action="{{ route('user.payment-profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Delete this profile?')" class="shrink-0">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-1.5 text-[11px] font-semibold text-red-600 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-all">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="md:col-span-2 xl:col-span-3 flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-gray-100 border-dashed">
        <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></svg>
        </div>
        <p class="text-sm font-semibold text-gray-700">No profiles found</p>
        <p class="text-xs text-gray-400 mt-1 max-w-xs text-center">Create a profile to customize how customers see your business on payment pages.</p>
        <button onclick="openModal()" class="mt-4 px-4 py-2 bg-emerald-800 text-white text-sm font-semibold rounded-lg hover:bg-emerald-900 transition-colors">Create Profile</button>
    </div>
    @endforelse
</div>

{{-- Create Modal Overlay --}}
<div id="createModal" class="modal-overlay fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex justify-end">
    <div class="modal-panel w-full max-w-xl bg-white h-full overflow-y-auto shadow-2xl">
        <div class="sticky top-0 z-10 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900">Create New Profile</h3>
                <p class="text-xs text-gray-400">Set up a business profile for your payment pages</p>
            </div>
            <button onclick="closeModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('user.payment-profiles.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Logo Upload --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Profile Logo</label>
                <div class="flex items-center gap-4">
                    <div id="logoPreview" class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 shrink-0 overflow-hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="logo" id="logoInput" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" onchange="previewLogo(this)">
                        <p class="text-[10px] text-gray-400 mt-1">PNG, JPG or WEBP. Max 2MB.</p>
                    </div>
                </div>
            </div>

            {{-- Name & Business --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Profile Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none transition-all" placeholder="e.g. Main Store">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business Name <span class="text-red-400">*</span></label>
                    <input type="text" name="business_name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none transition-all" placeholder="e.g. SalamaPay Ltd">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business Type</label>
                    <select name="business_type" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none bg-white transition-all">
                        <option value="">Select type</option>
                        <option value="Sole Proprietorship">Sole Proprietorship</option>
                        <option value="Partnership">Partnership</option>
                        <option value="Limited Company">Limited Company</option>
                        <option value="NGO">NGO</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Phone</label>
                    <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none transition-all" placeholder="+255...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none transition-all" placeholder="business@example.com">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Business TIN</label>
                    <input type="text" name="business_tin" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none transition-all" placeholder="123-456-789">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Brand Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="color" id="colorPicker" value="#024938" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-0.5 bg-white">
                        <input type="text" id="colorText" value="#024938" oninput="document.getElementById('colorPicker').value = this.value" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none transition-all font-mono" placeholder="#024938">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:border-emerald-800 outline-none resize-none transition-all" placeholder="Short description shown on payment pages"></textarea>
            </div>

            {{-- Page Type --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2.5">Page Type</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="page-type-btn active cursor-pointer border-2 border-gray-200 rounded-xl p-4 hover:border-gray-300" onclick="selectPageType(this, 'fixed')">
                        <div class="flex items-start justify-between mb-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <svg class="pt-check w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900">Fixed</p>
                        <p class="text-[11px] text-gray-500 mt-0.5 leading-relaxed">Collect payment for one specific item, service, fee or contribution</p>
                        <input type="radio" name="page_type" value="fixed" class="hidden" checked onchange="togglePageType('fixed')">
                    </label>
                    <label class="page-type-btn cursor-pointer border-2 border-gray-200 rounded-xl p-4 hover:border-gray-300" onclick="selectPageType(this, 'catalog')">
                        <div class="flex items-start justify-between mb-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <svg class="pt-check w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900">Catalog</p>
                        <p class="text-[11px] text-gray-500 mt-0.5 leading-relaxed">Sell multiple products or services. Customers browse, choose and pay</p>
                        <input type="radio" name="page_type" value="catalog" class="hidden" onchange="togglePageType('catalog')">
                    </label>
                </div>
            </div>

            {{-- Fixed-specific: Allow custom amount --}}
            <div id="fixedOptions">
                <label class="flex items-center gap-2.5 cursor-pointer p-3 rounded-lg border border-gray-200 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="allow_custom_amount" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-800 focus:ring-emerald-800">
                    <div>
                        <span class="text-sm font-medium text-gray-900">Allow customers to enter their own amount</span>
                        <p class="text-[11px] text-gray-400">Useful for donations, tips, or pay-what-you-want services</p>
                    </div>
                </label>
            </div>

            {{-- Catalog-specific: Products builder --}}
            <div id="catalogOptions" class="hidden">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-gray-700">Products / Services</label>
                    <button type="button" onclick="addProduct()" class="text-[11px] font-semibold text-emerald-700 hover:text-emerald-800">+ Add Product</button>
                </div>
                <div id="productsList" class="space-y-2"></div>
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_default" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-800 focus:ring-emerald-800">
                <span class="text-xs font-semibold text-gray-700">Set as default profile</span>
            </label>

            <div class="sticky bottom-0 bg-white pt-2 pb-1 border-t border-gray-100 flex items-center gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-bold bg-emerald-800 text-white rounded-lg hover:bg-emerald-900 transition-colors shadow-sm">Create Profile</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() { document.getElementById('createModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeModal() { document.getElementById('createModal').classList.remove('open'); document.body.style.overflow = ''; }

function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
    }).catch(() => {
        const ta = document.createElement('textarea'); ta.value = url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta); alert('Link copied!');
    });
}

function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">'; };
        reader.readAsDataURL(input.files[0]);
    }
}

function selectPageType(el, type) {
    document.querySelectorAll('.page-type-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    togglePageType(type);
}

function togglePageType(type) {
    document.getElementById('fixedOptions').classList.toggle('hidden', type !== 'fixed');
    document.getElementById('catalogOptions').classList.toggle('hidden', type !== 'catalog');
}

let productIdx = 0;
function addProduct() {
    productIdx++;
    const div = document.createElement('div');
    div.className = 'grid grid-cols-12 gap-2 items-center';
    div.innerHTML = '<div class="col-span-5"><input type="text" name="products[' + productIdx + '][name]" required placeholder="Product name" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm outline-none focus:border-emerald-800"></div><div class="col-span-3"><input type="number" name="products[' + productIdx + '][price]" required placeholder="Price" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm outline-none focus:border-emerald-800"></div><div class="col-span-3"><input type="text" name="products[' + productIdx + '][currency]" value="TZS" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm outline-none focus:border-emerald-800"></div><div class="col-span-1"><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div>';
    document.getElementById('productsList').appendChild(div);
}

// Close modal on overlay click
document.getElementById('createModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
