<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay {{ $link->merchantName() }} — SalamaPay</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .pm-option { transition: all 0.15s ease; cursor: pointer; }
        .pm-option:hover { background: #f8fafc; }
        .pm-option.active { border-color: #024938; background: #f0fdf4; }
        .pm-option.active .pm-radio { border-color: #024938; background: #024938; }
        .pm-radio { transition: all 0.15s ease; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        .anim-fade-up { animation: fadeUp 0.35s ease both; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .input-field:focus { border-color: #024938; box-shadow: 0 0 0 3px rgba(2,73,56,0.08); }
        .tabular { font-variant-numeric: tabular-nums; }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col">

    {{-- Sticky Header --}}
    <div class="sticky top-0 z-10 bg-white/95 backdrop-blur-sm border-b border-gray-100">
        <div class="w-full lg:w-1/2 lg:flex lg:justify-end">
            <div class="w-full max-w-lg px-5 py-4 md:px-6 md:py-5 lg:px-10 lg:py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($link->profile && $link->profile->logo)
                            <img src="{{ $link->profile->logo }}" alt="{{ $link->merchantName() }}" class="h-8 w-auto object-contain">
                        @else
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background: {{ $link->profile->color ?? '#024938' }}">
                                {{ strtoupper(substr($link->merchantName(), 0, 1)) }}
                            </div>
                        @endif
                        <p class="text-base font-semibold text-gray-900">{{ $link->merchantName() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-md w-[90%]">
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-lg anim-fade-up">
            <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <main class="flex flex-1 flex-col lg:flex-row">
        {{-- Left Column: Amount & Merchant Info --}}
        <div class="w-full lg:w-1/2 lg:flex lg:items-start lg:justify-end">
            <div class="w-full max-w-lg px-5 pt-5 pb-6 md:px-6 md:pt-6 lg:h-full lg:px-10 lg:pt-8 lg:pb-10">
                <div class="flex h-full flex-col">

                    {{-- Amount Section --}}
                    <div class="anim-fade-up">
                        <p class="text-sm text-gray-500 mb-1">Pay</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">TZS</span>
                            @if($link->amount)
                                <input type="text" readonly value="{{ number_format($link->amount) }}" class="tabular w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-200 text-base font-semibold text-gray-900 bg-gray-50 outline-none">
                            @elseif($link->profile && $link->profile->page_type === 'catalog' && !empty($link->profile->products))
                                <input type="text" id="amountInput" readonly value="{{ number_format($link->profile->products[0]['price'] ?? 0) }}" class="tabular w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-200 text-base font-semibold text-gray-900 bg-gray-50 outline-none">
                            @else
                                <input type="number" name="amount" id="amountInput" min="100" value="{{ old('amount') }}" placeholder="1,000" class="tabular w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-200 text-base font-semibold text-gray-900 bg-white outline-none input-field transition-all" required>
                            @endif
                        </div>
                        @if($link->profile && $link->profile->page_type === 'catalog' && !empty($link->profile->products))
                            <p class="text-gray-400 mt-1.5 text-xs">Price based on selected product</p>
                        @elseif(!$link->amount)
                            <p class="text-gray-400 mt-1.5 text-xs">Between TSh 1,000 and TSh 500,000</p>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div class="mt-5 md:mt-8 anim-fade-up delay-1">
                        <h3 class="text-xl tracking-tight md:text-2xl font-medium leading-relaxed text-gray-900">{{ $link->title }}</h3>
                        @if($link->description)
                            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">{{ $link->description }}</p>
                        @endif
                    </div>

                    {{-- Profile Info --}}
                    @if($link->profile && $link->profile->description)
                    <div class="mt-4 anim-fade-up delay-1">
                        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-2 h-2 rounded-full" style="background: {{ $link->profile->color ?? '#024938' }}"></span>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">About {{ $link->profile->business_name }}</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $link->profile->description }}</p>
                            @if($link->profile->business_type || $link->profile->phone)
                            <div class="mt-3 pt-3 border-t border-gray-200/60 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
                                @if($link->profile->business_type)<span>Type: <span class="font-medium text-gray-700">{{ $link->profile->business_type }}</span></span>@endif
                                @if($link->profile->phone)<span>Phone: <span class="font-medium text-gray-700">{{ $link->profile->phone }}</span></span>@endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Catalog Products --}}
                    @if($link->profile && $link->profile->page_type === 'catalog' && !empty($link->profile->products))
                    <div class="mt-4 anim-fade-up delay-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Products & Services</p>
                        <div class="space-y-2">
                            @foreach($link->profile->products as $product)
                            <label class="product-option flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white cursor-pointer hover:bg-gray-50/50 transition-all" onclick="selectProduct({{ $product['price'] ?? 0 }})">
                                <input type="radio" name="selected_product" value="{{ $loop->index }}" class="w-4 h-4 text-emerald-800 border-gray-300 focus:ring-emerald-800" {{ $loop->first ? 'checked' : '' }}>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $product['name'] }}</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900 tabular">{{ ($product['currency'] ?? 'TZS') }} {{ number_format($product['price'] ?? 0) }}</p>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Custom Fields Preview --}}
                    @if(!empty($link->custom_fields))
                    <div class="mt-4 anim-fade-up delay-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Additional Info Required</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($link->custom_fields as $field)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-50 border border-gray-200 text-xs text-gray-600">
                                {{ $field['label'] }}
                                @if($field['required'])<span class="text-red-400 text-[10px]">*</span>@endif
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Bottom: Secured by --}}
                    <div class="mt-auto hidden items-center justify-between pt-6 lg:flex anim-fade-up delay-2">
                        <div class="text-right w-full">
                            <p class="text-gray-400 text-xs">Secured by <span class="font-semibold text-gray-600">SalamaPay</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Payment Form --}}
        <div class="flex w-full flex-col bg-gray-50/30 lg:w-1/2 lg:items-start lg:justify-center border-t lg:border-t-0 lg:border-l border-gray-100">
            <div class="w-full max-w-lg lg:h-full">
                <div class="flex h-full flex-col px-5 pt-6 pb-10 lg:p-10">
                    @php
                    $brandColor = $link->profile->color ?? '#024938';
                    $isMobile = old('payment_method') !== 'card';
                    $isCard = old('payment_method') === 'card';
                    $isMpesa = old('payment_method') === 'mpesa' || !old('payment_method');
                    $isTigo = old('payment_method') === 'tigopesa';
                    $isAirtel = old('payment_method') === 'airtelmoney';
                    @endphp

                    <form action="{{ route('payment.process', $link->slug) }}" method="POST" id="paymentForm" class="space-y-5">
                        @csrf

                        {{-- Hidden amount for catalog products --}}
                        @if($link->profile && $link->profile->page_type === 'catalog' && !empty($link->profile->products))
                            <input type="hidden" name="amount" id="catalogAmount" value="{{ $link->profile->products[0]['price'] ?? 0 }}">
                        @endif

                        {{-- Payment Method Selector --}}
                        <div>
                            <p class="text-sm font-semibold mb-2.5 text-gray-900">Payment method</p>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="pm-card group cursor-pointer rounded-xl border-2 p-4 transition-all {{ $isMobile ? 'active' : 'border-gray-200 hover:border-gray-300' }}" onclick="selectMethod('mobile')" style="{{ $isMobile ? 'border-color:'.$brandColor.'; background:'.$brandColor.'0D' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 transition-colors" style="background: {{ $isMobile ? $brandColor : '#f3f4f6' }};">
                                            <svg class="w-5 h-5 {{ $isMobile ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 leading-none">Mobile Money</p>
                                            <p class="text-[11px] text-gray-500 mt-1">M-Pesa, Tigo, Airtel</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="payment_method_type" value="mobile" class="hidden" {{ $isMobile ? 'checked' : '' }}>
                                </label>
                                <label class="pm-card group cursor-pointer rounded-xl border-2 p-4 transition-all {{ $isCard ? 'active' : 'border-gray-200 hover:border-gray-300' }}" onclick="selectMethod('card')" style="{{ $isCard ? 'border-color:'.$brandColor.'; background:'.$brandColor.'0D' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 transition-colors" style="background: {{ $isCard ? $brandColor : '#f3f4f6' }};">
                                            <svg class="w-5 h-5 {{ $isCard ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 leading-none">Card</p>
                                            <p class="text-[11px] text-gray-500 mt-1">Visa, Mastercard</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="payment_method_type" value="card" class="hidden" {{ $isCard ? 'checked' : '' }}>
                                </label>
                            </div>
                        </div>

                        {{-- Mobile Money Providers --}}
                        <div id="mobileProviders" class="{{ $isCard ? 'hidden' : '' }}">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Select Provider</p>
                            <div class="flex items-center gap-2">
                                <label class="provider-chip cursor-pointer rounded-full border px-4 py-2 text-center transition-all {{ $isMpesa ? 'active' : 'border-gray-200 hover:border-gray-300' }}" onclick="selectProvider(this, 'mpesa')" style="{{ $isMpesa ? 'border-color:'.$brandColor.'; background:'.$brandColor.'1A; color:'.$brandColor : '' }}">
                                    <span class="text-xs font-semibold">M-Pesa</span>
                                    <input type="radio" name="payment_method" value="mpesa" class="hidden" {{ $isMpesa ? 'checked' : '' }}>
                                </label>
                                <label class="provider-chip cursor-pointer rounded-full border px-4 py-2 text-center transition-all {{ $isTigo ? 'active' : 'border-gray-200 hover:border-gray-300' }}" onclick="selectProvider(this, 'tigopesa')" style="{{ $isTigo ? 'border-color:'.$brandColor.'; background:'.$brandColor.'1A; color:'.$brandColor : '' }}">
                                    <span class="text-xs font-semibold">Tigo Pesa</span>
                                    <input type="radio" name="payment_method" value="tigopesa" class="hidden" {{ $isTigo ? 'checked' : '' }}>
                                </label>
                                <label class="provider-chip cursor-pointer rounded-full border px-4 py-2 text-center transition-all {{ $isAirtel ? 'active' : 'border-gray-200 hover:border-gray-300' }}" onclick="selectProvider(this, 'airtelmoney')" style="{{ $isAirtel ? 'border-color:'.$brandColor.'; background:'.$brandColor.'1A; color:'.$brandColor : '' }}">
                                    <span class="text-xs font-semibold">Airtel Money</span>
                                    <input type="radio" name="payment_method" value="airtelmoney" class="hidden" {{ $isAirtel ? 'checked' : '' }}>
                                </label>
                            </div>
                        </div>

                        {{-- Card Details --}}
                        <div id="cardDetails" class="{{ old('payment_method') === 'card' ? '' : 'hidden' }}">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Card Details</p>
                            <div class="space-y-2.5">
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <input type="text" name="card_number" maxlength="19" placeholder="0000 0000 0000 0000" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70 font-mono tabular" style="--tw-ring-color: {{ $link->profile->color ?? '#024938' }}33;">
                                </div>
                                <div class="grid grid-cols-2 gap-2.5">
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <input type="text" name="card_expiry" maxlength="5" placeholder="MM / YY" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70 font-mono tabular">
                                    </div>
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </div>
                                        <input type="text" name="card_cvv" maxlength="4" placeholder="CVV" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70 font-mono tabular">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Customer Details --}}
                        <div>
                            <p class="text-sm font-semibold mb-2.5 text-gray-900">Customer Details</p>
                            <div class="space-y-2.5">
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Full name" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70">
                                </div>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" required placeholder="Email address" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70">
                                </div>
                            </div>
                            @error('customer_email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <p class="text-sm font-semibold mb-2.5 text-gray-900">Phone Number</p>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="flex items-center pl-10 border border-gray-200 rounded-lg bg-white overflow-hidden focus-within:border-emerald-800 focus-within:ring-1 focus-within:ring-emerald-800/20 transition-all">
                                    <span class="text-sm text-gray-500 px-2 py-2.5 border-r border-gray-200 bg-gray-50/50 font-medium">+255</span>
                                    <input type="tel" id="phoneDisplay" maxlength="9" class="flex-1 py-2.5 px-3 text-sm outline-none bg-transparent tabular" placeholder="712 345 678" value="{{ old('phone') ? substr(old('phone'), 3) : '' }}">
                                </div>
                                <input type="hidden" name="phone" id="phoneHidden" value="{{ old('phone') }}">
                            </div>
                            @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Custom Fields --}}
                        @if(!empty($link->custom_fields))
                        <div>
                            <p class="text-sm font-semibold mb-2.5 text-gray-900">Additional Information</p>
                            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                @foreach($link->custom_fields as $field)
                                    @if($field['type'] === 'textarea')
                                        <textarea name="custom_{{ $field['name'] }}" {{ $field['required'] ? 'required' : '' }} rows="2" placeholder="{{ $field['label'] }}" class="w-full px-4 py-3 text-sm outline-none border-0 border-b border-gray-100 focus:bg-gray-50/50 transition-colors resize-none placeholder:text-gray-400/70">{{ old('custom_' . $field['name']) }}</textarea>
                                    @else
                                        <input type="{{ $field['type'] }}" name="custom_{{ $field['name'] }}" value="{{ old('custom_' . $field['name']) }}" {{ $field['required'] ? 'required' : '' }} placeholder="{{ $field['label'] }}" class="w-full px-4 py-3 text-sm outline-none border-0 {{ !$loop->last ? 'border-b border-gray-100' : '' }} focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Billing Information (Card only) --}}
                        <div id="billingInfo" class="{{ old('payment_method') !== 'card' ? 'hidden' : '' }}">
                            <p class="text-sm font-semibold mb-2.5 text-gray-900">Billing Address</p>
                            <div class="space-y-2.5">
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <input type="text" name="billing_address" placeholder="Street address" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70">
                                </div>
                                <div class="grid grid-cols-2 gap-2.5">
                                    <input type="text" name="billing_city" placeholder="City" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70">
                                    <input type="text" name="billing_postcode" placeholder="Postal code" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none bg-white focus:border-emerald-800 focus:ring-1 focus:ring-emerald-800/20 transition-all placeholder:text-gray-400/70">
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button type="submit" id="payBtn" class="w-full py-3 text-sm font-semibold bg-emerald-800 text-white rounded-lg hover:bg-emerald-900 transition-colors flex items-center justify-center gap-2 shadow-md shadow-emerald-900/10">
                                Pay TSh {{ $link->amount ? number_format($link->amount) : '___' }}
                            </button>
                        </div>
                    </form>

                    {{-- Supported Providers --}}
                    <div class="mt-6">
                        <div class="flex flex-col items-center gap-2">
                            <p class="text-gray-400 text-xs py-2">Supported payment providers</p>
                            <div class="flex flex-wrap items-center justify-center gap-3">
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 rounded">M-Pesa</span>
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 rounded">Tigo Pesa</span>
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 rounded">Airtel Money</span>
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 rounded">Visa</span>
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 rounded">Mastercard</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-6 mb-2 lg:hidden">
                        <p class="text-gray-400 text-xs">Secured by <span class="font-semibold text-gray-600">SalamaPay</span></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    // Merchant brand color
    const brandColor = '{{ $link->profile->color ?? '#024938' }}';

    // Payment method switching
    function selectMethod(type) {
        document.querySelectorAll('.pm-card').forEach(c => {
            c.style.borderColor = '';
            c.style.backgroundColor = '';
            c.classList.remove('active');
            c.classList.add('border-gray-200');
            const iconBox = c.querySelector('.w-10');
            if (iconBox) { iconBox.style.backgroundColor = '#f3f4f6'; }
            const iconSvg = c.querySelector('svg');
            if (iconSvg) { iconSvg.classList.remove('text-white'); iconSvg.classList.add('text-gray-400'); }
        });

        const activeCard = document.querySelector('.pm-card[onclick*="' + type + '"]');
        if (activeCard) {
            activeCard.classList.add('active');
            activeCard.classList.remove('border-gray-200');
            activeCard.style.borderColor = brandColor;
            activeCard.style.backgroundColor = brandColor + '0D'; // 5% opacity
            const iconBox = activeCard.querySelector('.w-10');
            if (iconBox) { iconBox.style.backgroundColor = brandColor; }
            const iconSvg = activeCard.querySelector('svg');
            if (iconSvg) { iconSvg.classList.remove('text-gray-400'); iconSvg.classList.add('text-white'); }
        }

        const mobileProviders = document.getElementById('mobileProviders');
        const cardDetails = document.getElementById('cardDetails');
        const billingInfo = document.getElementById('billingInfo');

        if (type === 'mobile') {
            mobileProviders?.classList.remove('hidden');
            cardDetails?.classList.add('hidden');
            billingInfo?.classList.add('hidden');
            // Ensure first provider is selected
            const firstProvider = document.querySelector('input[name="payment_method"]');
            if (firstProvider) firstProvider.checked = true;
            // Reset and select first provider
            document.querySelectorAll('.provider-chip').forEach(b => {
                b.classList.remove('active');
                b.classList.add('border-gray-200');
                b.style.borderColor = '';
                b.style.backgroundColor = '';
                b.style.color = '';
            });
            const firstBtn = document.querySelector('.provider-chip');
            if (firstBtn) {
                firstBtn.classList.add('active');
                firstBtn.classList.remove('border-gray-200');
                firstBtn.style.borderColor = brandColor;
                firstBtn.style.backgroundColor = brandColor + '1A';
                firstBtn.style.color = brandColor;
            }
        } else {
            mobileProviders?.classList.add('hidden');
            cardDetails?.classList.remove('hidden');
            billingInfo?.classList.remove('hidden');
            // Set card as payment method
            const cardRadio = document.querySelector('input[name="payment_method"][value="card"]');
            if (cardRadio) cardRadio.checked = true;
        }
    }

    function selectProvider(el, val) {
        document.querySelectorAll('.provider-chip').forEach(b => {
            b.classList.remove('active');
            b.classList.add('border-gray-200');
            b.style.borderColor = '';
            b.style.backgroundColor = '';
            b.style.color = '';
        });
        el.classList.add('active');
        el.classList.remove('border-gray-200');
        el.style.borderColor = brandColor;
        el.style.backgroundColor = brandColor + '1A';
        el.style.color = brandColor;
        const radio = el.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }

    // Phone input sync
    const phoneDisplay = document.getElementById('phoneDisplay');
    const phoneHidden = document.getElementById('phoneHidden');
    if (phoneDisplay && phoneHidden) {
        phoneDisplay.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 9);
            phoneHidden.value = '255' + this.value;
        });
    }

    // Card number formatting
    const cardNumberInput = document.querySelector('input[name="card_number"]');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 16);
            this.value = this.value.replace(/(\d{4})(?=\d)/g, '$1 ');
        });
    }

    // Card expiry formatting
    const cardExpiryInput = document.querySelector('input[name="card_expiry"]');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 4);
            if (this.value.length >= 2) {
                this.value = this.value.substring(0, 2) + '/' + this.value.substring(2);
            }
        });
    }

    // Amount sync for custom amount links
    const amountInput = document.getElementById('amountInput');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            document.getElementById('payBtn').innerHTML = 'Pay TSh ' + parseInt(this.value || 0).toLocaleString();
        });
    }

    // Catalog product selection
    function selectProduct(price) {
        const btn = document.getElementById('payBtn');
        const hiddenAmount = document.getElementById('catalogAmount');
        if (hiddenAmount) hiddenAmount.value = price;
        if (btn) btn.innerHTML = 'Pay TSh ' + price.toLocaleString();
        if (amountInput) { amountInput.value = price; amountInput.readOnly = true; }
    }

    // Auto-select first product on load
    @if($link->profile && $link->profile->page_type === 'catalog' && !empty($link->profile->products))
        (function() {
            const firstPrice = {{ $link->profile->products[0]['price'] ?? 0 }};
            selectProduct(firstPrice);
        })();
    @endif
    </script>
</body>
</html>
