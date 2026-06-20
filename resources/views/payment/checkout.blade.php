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
                            @else
                                <input type="number" name="amount" id="amountInput" min="100" value="{{ old('amount') }}" placeholder="1,000" class="tabular w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-200 text-base font-semibold text-gray-900 bg-white outline-none input-field transition-all" required>
                            @endif
                        </div>
                        <p class="text-gray-400 mt-1.5 text-xs">Between TSh 1,000 and TSh 500,000</p>
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
                    <form action="{{ route('payment.process', $link->slug) }}" method="POST" id="paymentForm" class="space-y-5">
                        @csrf

                        {{-- Payment Method --}}
                        <div>
                            <p class="text-sm leading-none font-medium mb-2 text-gray-900">Payment method</p>
                            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                <div class="grid gap-0">
                                    <label class="pm-option flex cursor-pointer items-center justify-between px-4 py-3.5 border-b border-gray-100 {{ old('payment_method') === 'mobile_money' ? 'active' : '' }}" onclick="selectPm(this)">
                                        <div class="flex-1 space-y-0.5">
                                            <p class="text-sm leading-none font-medium text-gray-900">Mobile Money</p>
                                            <p class="text-gray-500 text-xs">M-Pesa, Tigo Pesa, Airtel Money</p>
                                        </div>
                                        <div class="pm-radio w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center ml-3">
                                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                        </div>
                                        <input type="radio" name="payment_method" value="mobile_money" class="hidden" {{ old('payment_method') === 'mobile_money' ? 'checked' : '' }}>
                                    </label>
                                    <label class="pm-option flex cursor-pointer items-center justify-between px-4 py-3.5 bg-gray-50/50 {{ old('payment_method') === 'card' || !old('payment_method') ? 'active' : '' }}" onclick="selectPm(this)">
                                        <div class="flex-1 space-y-0.5">
                                            <p class="text-sm leading-none font-medium text-gray-900">Card</p>
                                            <p class="text-gray-500 text-xs">Visa, Mastercard</p>
                                        </div>
                                        <div class="pm-radio w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center ml-3">
                                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                        </div>
                                        <input type="radio" name="payment_method" value="card" class="hidden" {{ old('payment_method') === 'card' || !old('payment_method') ? 'checked' : '' }}>
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <p class="text-sm leading-none font-medium mb-2.5 text-gray-900">Phone number</p>
                            <div class="flex items-center border border-gray-200 rounded-lg bg-white overflow-hidden focus-within:border-emerald-800 focus-within:ring-1 focus-within:ring-emerald-800/20 transition-all">
                                <span class="text-sm text-gray-500 px-3 py-2.5 border-r border-gray-200 bg-gray-50/50 font-medium">+255</span>
                                <input type="tel" id="phoneDisplay" maxlength="9" class="flex-1 py-2.5 px-3 text-sm outline-none bg-transparent tabular" placeholder="712 345 678" value="{{ old('phone') ? substr(old('phone'), 3) : '' }}">
                                <input type="hidden" name="phone" id="phoneHidden" value="{{ old('phone') }}">
                            </div>
                            @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Contact Information --}}
                        <div>
                            <p class="text-sm leading-none font-medium mb-2.5 text-gray-900">Contact Information</p>
                            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Full name" class="w-full px-4 py-3 text-sm outline-none border-0 border-b border-gray-100 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                <input type="email" name="customer_email" value="{{ old('customer_email') }}" required placeholder="Email address" class="w-full px-4 py-3 text-sm outline-none border-0 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                            </div>
                        </div>

                        {{-- Custom Fields --}}
                        @if(!empty($link->custom_fields))
                        <div>
                            <p class="text-sm leading-none font-medium mb-2.5 text-gray-900">Additional Information</p>
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

                        {{-- Billing Information --}}
                        <div>
                            <p class="text-sm leading-none font-medium mb-2.5 text-gray-900">Billing Information</p>
                            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                <div class="grid grid-cols-2">
                                    <input type="text" name="billing_first_name" placeholder="First Name" class="w-full px-4 py-3 text-sm outline-none border-0 border-b border-r border-gray-100 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                    <input type="text" name="billing_last_name" placeholder="Last Name" class="w-full px-4 py-3 text-sm outline-none border-0 border-b border-gray-100 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                </div>
                                <input type="text" name="billing_address" placeholder="Address" class="w-full px-4 py-3 text-sm outline-none border-0 border-b border-gray-100 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                <input type="text" name="billing_city" placeholder="City" class="w-full px-4 py-3 text-sm outline-none border-0 border-b border-gray-100 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                <div class="grid grid-cols-2">
                                    <input type="text" name="billing_state" placeholder="State / Region" class="w-full px-4 py-3 text-sm outline-none border-0 border-r border-gray-100 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
                                    <input type="text" name="billing_postcode" placeholder="Postal Code" class="w-full px-4 py-3 text-sm outline-none border-0 focus:bg-gray-50/50 transition-colors placeholder:text-gray-400/70">
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
    function selectPm(el) {
        document.querySelectorAll('.pm-option').forEach(opt => opt.classList.remove('active'));
        el.classList.add('active');
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

    // Amount sync for custom amount links
    const amountInput = document.getElementById('amountInput');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            document.getElementById('payBtn').innerHTML = 'Pay TSh ' + parseInt(this.value || 0).toLocaleString();
        });
    }
    </script>
</body>
</html>
