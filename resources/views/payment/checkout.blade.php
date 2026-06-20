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

                    {{-- Amount Input (if not fixed) --}}
                    @if(!$link->amount)
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Amount (TZS)</label>
                        <input type="number" name="amount" min="100" value="{{ old('amount') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. 50000" required>
                    </div>
                    @endif

                    {{-- Customer Info --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="john@example.com" required>
                        </div>
                    </div>

                    {{-- Custom Fields --}}
                    @if(!empty($link->custom_fields))
                    <div class="mb-4 space-y-3">
                        <p class="text-xs font-medium text-gray-700">Additional Information</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($link->custom_fields as $field)
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">{{ $field['label'] }}</label>
                                @if($field['type'] === 'textarea')
                                    <textarea name="custom_{{ $field['name'] }}" {{ $field['required'] ? 'required' : '' }} rows="2" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none resize-none" placeholder="{{ $field['label'] }}">{{ old('custom_' . $field['name']) }}</textarea>
                                @else
                                    <input type="{{ $field['type'] }}" name="custom_{{ $field['name'] }}" value="{{ old('custom_' . $field['name']) }}" {{ $field['required'] ? 'required' : '' }} class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="{{ $field['label'] }}">
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Payment Method Selection --}}
                    <p class="text-xs font-medium text-gray-700 mb-2">Select Payment Method</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-4">
                        @foreach([
                            ['id'=>'mpesa','label'=>'M-Pesa','icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                            ['id'=>'tigopesa','label'=>'Tigo Pesa','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['id'=>'airtelmoney','label'=>'Airtel Money','icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                            ['id'=>'card','label'=>'Card','icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                            ['id'=>'bank','label'=>'Bank Transfer','icon'=>'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
                        ] as $pm)
                        <label class="payment-card cursor-pointer border border-gray-200 rounded-xl p-3 flex flex-col items-center gap-2 {{ old('payment_method') === $pm['id'] ? 'selected' : '' }}" onclick="selectMethod('{{ $pm['id'] }}')">
                            <input type="radio" name="payment_method" value="{{ $pm['id'] }}" class="hidden" {{ old('payment_method') === $pm['id'] ? 'checked' : '' }}>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $pm['icon'] }}"/></svg>
                            <span class="text-[11px] font-medium text-gray-700">{{ $pm['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('payment_method')<p class="text-xs text-red-500 mb-2">{{ $message }}</p>@enderror

                    {{-- Mobile Money Fields --}}
                    <div id="mobileFields" class="mb-4 {{ old('payment_method') && in_array(old('payment_method'), ['mpesa','tigopesa','airtelmoney']) ? '' : 'hidden' }}">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number</label>
                        <div class="flex items-center border border-gray-200 rounded-xl px-3 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-200">
                            <span class="text-sm text-gray-500 pr-2 border-r border-gray-200 mr-2 py-2">+255</span>
                            <input type="tel" id="phoneDisplay" maxlength="9" class="flex-1 py-2.5 text-sm outline-none bg-transparent" placeholder="712345678" value="{{ old('phone') ? substr(old('phone'), 3) : '' }}">
                            <input type="hidden" name="phone" id="phoneHidden" value="{{ old('phone') }}">
                        </div>
                        @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Card Fields --}}
                    <div id="cardFields" class="mb-4 space-y-3 {{ old('payment_method') === 'card' ? '' : 'hidden' }}">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Card Number</label>
                            <input type="text" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Expiry</label>
                                <input type="text" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="MM/YY">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">CVC</label>
                                <input type="text" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="123">
                            </div>
                        </div>
                    </div>

                    {{-- Bank Fields --}}
                    <div id="bankFields" class="mb-4 space-y-3 {{ old('payment_method') === 'bank' ? '' : 'hidden' }}">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Bank Name</label>
                            <select class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white">
                                <option>CRDB Bank</option>
                                <option>NBC Bank</option>
                                <option>NMB Bank</option>
                                <option>EXIM Bank</option>
                                <option>Standard Chartered</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Account Number</label>
                            <input type="text" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="Your account number">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="payBtn" class="w-full py-3 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Pay Now — TZS {{ $link->amount ? number_format($link->amount) : '___' }}
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-2">By paying, you agree to our terms of service</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectMethod(id) {
    document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected'));
    event.currentTarget.classList.add('selected');

    document.getElementById('mobileFields').classList.add('hidden');
    document.getElementById('cardFields').classList.add('hidden');
    document.getElementById('bankFields').classList.add('hidden');

    if (['mpesa','tigopesa','airtelmoney'].includes(id)) {
        document.getElementById('mobileFields').classList.remove('hidden');
    } else if (id === 'card') {
        document.getElementById('cardFields').classList.remove('hidden');
    } else if (id === 'bank') {
        document.getElementById('bankFields').classList.remove('hidden');
    }
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
</script>
</body>
</html>
