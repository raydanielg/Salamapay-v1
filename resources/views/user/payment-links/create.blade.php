@extends('layouts.user')

@section('title', 'New Payment Link - SalamaPay')
@section('page_title', 'New Payment Link')

@section('content')
<style>
    .form-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .form-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -12px rgba(2,73,56,0.15); }
    .form-input:focus { box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
    .tip-card { background: linear-gradient(135deg, #024938 0%, #013028 100%); }
    .animate-slide-up { animation: slideUp 0.5s ease-out both; }
    @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
</style>

@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'New Payment Link', 'subtitle' => 'Create a shareable link to accept payments'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="form-card animate-slide-up bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Link Details</h3>
                    <p class="text-xs text-gray-400">Configure your shareable payment link</p>
                </div>
            </div>
            <form action="{{ route('user.payment-links.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Link Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="e.g. Monthly Subscription" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Profile</label>
                    <select name="profile_id" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all">
                        @forelse($profiles as $p)
                            <option value="{{ $p->id }}" {{ $p->is_default ? 'selected' : '' }}>{{ $p->name }} — {{ $p->business_name }}</option>
                        @empty
                            <option value="" disabled selected>No profiles yet</option>
                        @endforelse
                    </select>
                    <p class="text-[10px] text-gray-400 mt-1">Select which business profile to show on the public page</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description (optional)</label>
                    <textarea name="description" rows="3" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none resize-none transition-all" placeholder="What is this payment for?">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Amount (TZS)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">TZS</span>
                            <input type="number" name="amount" value="{{ old('amount') }}" class="form-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all" placeholder="Leave empty for custom" min="100">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Leave empty to let customer enter amount</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Custom Slug (optional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none font-mono transition-all" placeholder="my-link">
                        <p class="text-[10px] text-gray-400 mt-1">Auto-generated if left blank</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Currency</label>
                        <select name="currency" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none bg-white transition-all">
                            <option value="TZS" selected>TZS — Tanzanian Shilling</option>
                            <option value="USD">USD — US Dollar</option>
                            <option value="KES">KES — Kenyan Shilling</option>
                            <option value="UGX">UGX — Ugandan Shilling</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Expires At (optional)</label>
                        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="form-input w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 outline-none transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Leave empty for no expiry</p>
                    </div>
                </div>
                {{-- Custom Fields Builder --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Custom Fields</label>
                    <p class="text-[10px] text-gray-400 mb-2">Collect extra info from customers at checkout (name, phone, notes, etc.)</p>
                    <div id="customFieldsContainer" class="space-y-2"></div>
                    <button type="button" onclick="addCustomField()" class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Add Custom Field
                    </button>
                    <input type="hidden" name="custom_fields" id="customFieldsJson" value="">
                </div>

                <script>
                let customFields = [];
                const fieldTypes = [
                    { value: 'text', label: 'Text' },
                    { value: 'email', label: 'Email' },
                    { value: 'tel', label: 'Phone' },
                    { value: 'textarea', label: 'Notes' },
                    { value: 'number', label: 'Number' },
                ];

                function addCustomField(data = null) {
                    const idx = customFields.length;
                    const field = data || { label: '', type: 'text', required: false };
                    customFields.push(field);
                    renderFields();
                }

                function removeCustomField(idx) {
                    customFields.splice(idx, 1);
                    renderFields();
                }

                function updateField(idx, key, value) {
                    customFields[idx][key] = value;
                    if (key === 'label') {
                        customFields[idx].name = value.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/(^_|_$)/g, '');
                    }
                    renderFields();
                }

                function renderFields() {
                    const container = document.getElementById('customFieldsContainer');
                    container.innerHTML = customFields.map((f, i) => `
                        <div class="flex items-center gap-2 p-2 rounded-lg bg-gray-50 border border-gray-100">
                            <input type="text" value="${f.label}" onchange="updateField(${i}, 'label', this.value)" placeholder="Field label" class="flex-1 min-w-0 px-2 py-1.5 rounded-md border border-gray-200 text-xs outline-none focus:border-emerald-500">
                            <select onchange="updateField(${i}, 'type', this.value)" class="px-2 py-1.5 rounded-md border border-gray-200 text-xs outline-none focus:border-emerald-500 bg-white">
                                ${fieldTypes.map(t => `<option value="${t.value}" ${f.type === t.value ? 'selected' : ''}>${t.label}</option>`).join('')}
                            </select>
                            <label class="flex items-center gap-1 text-[10px] text-gray-500 cursor-pointer shrink-0">
                                <input type="checkbox" onchange="updateField(${i}, 'required', this.checked)" ${f.required ? 'checked' : ''} class="rounded">
                                Req
                            </label>
                            <button type="button" onclick="removeCustomField(${i})" class="text-red-400 hover:text-red-600 transition-colors shrink-0 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    `).join('');
                    document.getElementById('customFieldsJson').value = JSON.stringify(customFields);
                }

                // Pre-fill if old value exists
                const oldCustomFields = @json(old('custom_fields'));
                if (oldCustomFields && Array.isArray(oldCustomFields)) {
                    customFields = oldCustomFields;
                    renderFields();
                }
                </script>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5">Create Link</button>
                    <a href="{{ route('user.payment-links') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium px-3 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview --}}
    <div class="space-y-4">
        <div class="tip-card animate-slide-up delay-1 rounded-2xl p-6 text-white shadow-lg shadow-emerald-900/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-white">How it works</h3>
            </div>
            <ul class="space-y-3 text-xs text-emerald-200/90">
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">1.</span><span>Create a link with a fixed or custom amount</span></li>
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">2.</span><span>Share the link via WhatsApp, SMS, or email</span></li>
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">3.</span><span>Customer pays directly on the page</span></li>
                <li class="flex items-start gap-2"><span class="text-gold-300 font-bold mt-0.5">4.</span><span>Money arrives in your SalamaPay wallet</span></li>
            </ul>
        </div>
        <div class="form-card animate-slide-up delay-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Link URL Preview</h3>
                    <p class="text-xs text-gray-400">What customers will see</p>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <code class="text-xs font-mono text-gray-600 break-all">{{ url('/pay/your-link-slug') }}</code>
            </div>
            <p class="text-[10px] text-gray-400 mt-3">Customers will see a secure checkout page when they visit this link.</p>
        </div>
    </div>
</div>
@endsection
