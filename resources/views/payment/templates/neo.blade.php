<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $link->merchantName() }} - Pay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @php
    $profile = $link->profile;
    $settings = $profile->template_settings ?? [];
    $primary = $profile->color ?? '#024938';
    $accent = $settings['accent_color'] ?? '#f9ac00';
    $bg = $settings['bg_color'] ?? '#ffffff';
    $dark = $settings['dark_mode'] ?? false;
    @endphp
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-primary { color: {{ $primary }}; }
        .brand-bg { background-color: {{ $primary }}; }
        .brand-border { border-color: {{ $primary }}; }
        .brand-ring:focus { --tw-ring-color: {{ $primary }}; }
        .accent-bg { background-color: {{ $accent }}; }
    </style>
</head>
<body class="{{ $dark ? 'bg-gray-900 text-white' : 'bg-gray-50 text-gray-900' }} min-h-screen">

    {{-- Top Bar --}}
    <div class="w-full h-1 brand-bg"></div>

    <div class="max-w-5xl mx-auto px-4 py-8 lg:py-12">
        {{-- Hero / Brand Section --}}
        <div class="text-center mb-10">
            @if(($settings['show_logo'] ?? true) && $profile->logo)
            <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden shadow-md {{ $dark ? 'bg-white/10' : 'bg-white' }} p-2">
                <img src="{{ asset('storage/'.$profile->logo) }}" class="w-full h-full object-contain">
            </div>
            @endif
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">{{ $profile->business_name ?? $link->merchantName() }}</h1>
            @if(($settings['show_description'] ?? true) && $profile->description)
            <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto {{ $dark ? 'text-gray-400' : '' }}">{{ $profile->description }}</p>
            @endif
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
            {{-- Left: Order Summary --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} overflow-hidden">
                    @if($settings['cover_image'] ?? false)
                    <div class="w-full h-40 overflow-hidden">
                        <img src="{{ asset('storage/'.$settings['cover_image']) }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="p-5">
                        <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Order Summary</h2>
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-sm font-semibold">{{ $link->title ?? 'Payment' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 {{ $dark ? 'text-gray-400' : '' }}">{{ $link->description ?? 'Complete your payment securely' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t {{ $dark ? 'border-gray-700' : 'border-gray-100' }}">
                            <span class="text-sm text-gray-500 {{ $dark ? 'text-gray-400' : '' }}">Total</span>
                            <span class="text-xl font-bold brand-primary">{{ number_format($link->amount, 0) }} {{ $link->currency ?? 'TZS' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div class="mt-4 flex items-center justify-center gap-4 text-[10px] text-gray-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        SSL Secure
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Encrypted
                    </span>
                </div>
            </div>

            {{-- Right: Payment Form --}}
            <div class="lg:col-span-3">
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} p-6">
                    <form action="{{ route('payment.process', $link->slug) }}" method="POST" id="paymentForm" class="space-y-5">
                        @csrf

                        {{-- Payment Method --}}
                        <div>
                            <p class="text-sm font-semibold mb-3">Payment Method</p>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="pm-card cursor-pointer rounded-xl border-2 p-4 transition-all" onclick="selectMethod('mobile')" style="border-color: {{ $primary }}; background: {{ $primary }}0D;">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: {{ $primary }};">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold leading-none">Mobile Money</p>
                                            <p class="text-[11px] text-gray-500 mt-1 {{ $dark ? 'text-gray-400' : '' }}">M-Pesa, Tigo, Airtel</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="payment_method_type" value="mobile" class="hidden" checked>
                                </label>
                                <label class="pm-card cursor-pointer rounded-xl border-2 border-gray-200 p-4 transition-all hover:border-gray-300" onclick="selectMethod('card')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold leading-none">Card</p>
                                            <p class="text-[11px] text-gray-500 mt-1 {{ $dark ? 'text-gray-400' : '' }}">Visa, Mastercard</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="payment_method_type" value="card" class="hidden">
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="payment_method" id="paymentMethodHidden" value="mobile_money">

                        {{-- Phone Number --}}
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Phone Number</p>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+255</div>
                                <input type="tel" id="phoneDisplay" maxlength="12" placeholder="7XX XXX XXX" class="w-full pl-14 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};" required>
                                <input type="hidden" name="phone" id="phoneHidden" value="">
                            </div>
                        </div>

                        {{-- Customer Details --}}
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customer Details</p>
                            <div class="space-y-3">
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <input type="text" name="customer_name" placeholder="Full name" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};" required>
                                </div>
                                @if($profile->require_email ?? true)
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                    </div>
                                    <input type="email" name="customer_email" placeholder="Email address" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};" required>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Card Details --}}
                        <div id="cardDetails" class="hidden">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Card Details</p>
                            <div class="space-y-3">
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <input type="text" name="card_number" maxlength="19" placeholder="0000 0000 0000 0000" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <input type="text" name="card_expiry" maxlength="5" placeholder="MM / YY" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};">
                                    </div>
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </div>
                                        <input type="text" name="card_cvv" maxlength="4" placeholder="CVV" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Billing Address --}}
                        <div id="billingInfo" class="hidden">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Billing Address</p>
                            <div class="space-y-3">
                                <input type="text" name="billing_address" placeholder="Street address" class="w-full px-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};">
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="billing_city" placeholder="City" class="w-full px-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};">
                                    <input type="text" name="billing_postal" placeholder="Postal code" class="w-full px-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};">
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full py-3.5 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90 active:scale-[0.98] shadow-lg" style="background: {{ $primary }};">
                            Pay {{ number_format($link->amount, 0) }} {{ $link->currency ?? 'TZS' }}
                        </button>

                        <p class="text-center text-[10px] text-gray-400">Secured by SalamaPay</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    const brandColor = '{{ $primary }}';
    function selectMethod(type) {
        document.querySelectorAll('.pm-card').forEach(c => {
            c.style.borderColor = '';
            c.style.backgroundColor = '';
            const iconBox = c.querySelector('.w-10');
            if (iconBox) { iconBox.style.backgroundColor = ''; }
            const iconSvg = c.querySelector('svg');
            if (iconSvg) { iconSvg.classList.remove('text-white'); iconSvg.classList.add('text-gray-400'); }
        });
        const activeCard = document.querySelector('.pm-card[onclick*="' + type + '"]');
        if (activeCard) {
            activeCard.style.borderColor = brandColor;
            activeCard.style.backgroundColor = brandColor + '0D';
            const iconBox = activeCard.querySelector('.w-10');
            if (iconBox) { iconBox.style.backgroundColor = brandColor; }
            const iconSvg = activeCard.querySelector('svg');
            if (iconSvg) { iconSvg.classList.remove('text-gray-400'); iconSvg.classList.add('text-white'); }
        }
        const cardDetails = document.getElementById('cardDetails');
        const billingInfo = document.getElementById('billingInfo');
        const hiddenMethod = document.getElementById('paymentMethodHidden');
        if (type === 'mobile') {
            cardDetails?.classList.add('hidden');
            billingInfo?.classList.add('hidden');
            if (hiddenMethod) hiddenMethod.value = 'mobile_money';
        } else {
            cardDetails?.classList.remove('hidden');
            billingInfo?.classList.remove('hidden');
            if (hiddenMethod) hiddenMethod.value = 'card';
        }
    }

    const phoneDisplay = document.getElementById('phoneDisplay');
    const phoneHidden = document.getElementById('phoneHidden');
    if (phoneDisplay && phoneHidden) {
        phoneDisplay.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 9);
            phoneHidden.value = '255' + this.value;
        });
    }

    // Card formatting
    document.querySelector('input[name="card_number"]')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim().substring(0, 19);
    });
    document.querySelector('input[name="card_expiry"]')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2').substring(0, 5);
    });
    document.querySelector('input[name="card_cvv"]')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 4);
    });
    </script>
</body>
</html>
