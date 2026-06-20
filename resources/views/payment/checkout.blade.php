<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay {{ $merchant->business_name ?? $merchant->first_name }} — SalamaPay</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: { 50:'#e6f5f1',100:'#b3e0d4',200:'#80cbc0',300:'#4db5a8',400:'#1a9f8e',500:'#024938',600:'#023d30',700:'#013028',800:'#01241f',900:'#001816' },
                        gold: { 50:'#fff5e0',100:'#ffe6b3',200:'#ffd680',300:'#ffc64d',400:'#ffb71a',500:'#f9ac00',600:'#d49700',700:'#b07c00',800:'#8c6100',900:'#684600' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .payment-card { transition: all 0.2s ease; }
        .payment-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .payment-card.selected { border-color: #024938; background: #e6f5f1; }
        @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        .animate-slide-up { animation: slideUp 0.4s ease both; }
        .animate-delay-1 { animation-delay: 0.05s; }
        .animate-delay-2 { animation-delay: 0.1s; }
        .animate-delay-3 { animation-delay: 0.15s; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- Top Bar --}}
<div class="bg-emerald-900 h-1.5"></div>

<div class="max-w-5xl mx-auto px-4 py-6 sm:py-10">
    {{-- Header --}}
    <div class="text-center mb-8 animate-slide-up">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-100 mb-3">
            <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-8 w-auto">
        </div>
        <h1 class="text-lg sm:text-xl font-bold text-gray-900">{{ $link->title }}</h1>
        <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">{{ $link->description }}</p>
        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border text-xs text-gray-600">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Paying <span class="font-semibold text-gray-900">{{ $merchant->business_name ?? $merchant->first_name . ' ' . $merchant->last_name }}</span>
        </div>
    </div>

    @if(session('error'))
    <div class="max-w-lg mx-auto mb-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 animate-slide-up">
        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 max-w-4xl mx-auto">
        {{-- Left: Amount & Merchant Info --}}
        <div class="lg:col-span-2 space-y-4 animate-slide-up animate-delay-1">
            {{-- Amount Card --}}
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2">Amount to Pay</p>
                @if($link->amount)
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">TZS {{ number_format($link->amount) }}</p>
                <p class="text-xs text-gray-400 mt-1">Fixed amount set by merchant</p>
                @else
                <p class="text-sm text-gray-500 mb-2">Enter the amount you want to pay</p>
                @endif
            </div>

            {{-- Merchant Info --}}
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-3">Merchant</p>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm">
                        {{ strtoupper(substr($merchant->first_name ?? 'M', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $merchant->business_name ?? $merchant->first_name . ' ' . $merchant->last_name }}</p>
                        <p class="text-xs text-gray-500">{{ $merchant->email }}</p>
                    </div>
                </div>
                @if($merchant->business_name)
                <div class="mt-3 pt-3 border-t space-y-1 text-xs text-gray-500">
                    @if($merchant->business_type)<p>Type: <span class="text-gray-700">{{ $merchant->business_type }}</span></p>@endif
                    @if($merchant->phone)<p>Phone: <span class="text-gray-700">{{ $merchant->phone }}</span></p>@endif
                </div>
                @endif
            </div>

            {{-- Security Badge --}}
            <div class="bg-emerald-900 rounded-2xl p-4 text-white text-center">
                <svg class="w-6 h-6 mx-auto mb-1 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <p class="text-xs font-medium">Secure payment powered by SalamaPay</p>
                <p class="text-[10px] text-emerald-300 mt-0.5">SSL encrypted & PCI compliant</p>
            </div>
        </div>

        {{-- Right: Payment Form --}}
        <div class="lg:col-span-3 animate-slide-up animate-delay-2">
            <div class="bg-white rounded-2xl border p-5 sm:p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Payment Details</h2>

                <form action="{{ route('payment.process', $link->slug) }}" method="POST" id="paymentForm">
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
