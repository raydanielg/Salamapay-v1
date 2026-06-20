<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->business_name ?? $link->merchantName() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @php
    $profile = $link->profile;
    $settings = $profile->template_settings ?? [];
    $primary = $profile->color ?? '#024938';
    $accent = $settings['accent_color'] ?? '#f9ac00';
    $dark = $settings['dark_mode'] ?? false;
    @endphp
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-primary { color: {{ $primary }}; }
        .brand-bg { background-color: {{ $primary }}; }
        .accent-bg { background-color: {{ $accent }}; }
        .hero-gradient { background: linear-gradient(135deg, {{ $primary }}08 0%, {{ $accent }}08 100%); }
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="{{ $dark ? 'bg-gray-900 text-white' : 'bg-white text-gray-900' }}">

    <header class="sticky top-0 z-50 {{ $dark ? 'bg-gray-900/80 border-gray-700' : 'bg-white/80 border-gray-100' }} backdrop-blur-md border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <a href="#" class="flex items-center gap-2.5">
                    @if(($settings['show_logo'] ?? true) && $profile->logo)
                    <img src="{{ asset('storage/'.$profile->logo) }}" class="h-8 w-auto object-contain">
                    @else
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background: {{ $primary }};">
                        {{ strtoupper(substr($profile->business_name ?? 'B', 0, 1)) }}
                    </div>
                    @endif
                    <span class="text-sm font-bold tracking-tight">{{ $profile->business_name ?? 'Business' }}</span>
                </a>
                <nav class="hidden md:flex items-center gap-6">
                    <a href="#hero" class="text-xs font-medium {{ $dark ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Home</a>
                    <a href="#features" class="text-xs font-medium {{ $dark ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Features</a>
                    <a href="#testimonials" class="text-xs font-medium {{ $dark ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Reviews</a>
                    <a href="#payment" class="text-xs font-medium {{ $dark ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Payment</a>
                </nav>
                <a href="#payment" class="px-4 py-2 text-xs font-bold text-white rounded-lg transition-all hover:opacity-90 active:scale-95" style="background: {{ $primary }};">
                    {{ $settings['cta_text'] ?? 'Pay Now' }}
                </a>
            </div>
        </div>
    </header>

    <section id="hero" class="relative overflow-hidden">
        <div class="hero-gradient">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16 lg:py-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight mb-5">{{ $settings['hero_title'] ?? 'Welcome to ' . ($profile->business_name ?? 'Our Business') }}</h1>
                        <p class="text-sm sm:text-base {{ $dark ? 'text-gray-300' : 'text-gray-500' }} leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">{{ $settings['hero_text'] ?? ($profile->description ?? 'We provide the best services for you. Pay securely and conveniently.') }}</p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                            <a href="#payment" class="px-6 py-3 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90 active:scale-95 shadow-lg" style="background: {{ $primary }};">{{ $settings['cta_text'] ?? 'Pay Now' }}</a>
                            <a href="#features" class="px-6 py-3 text-sm font-bold rounded-xl border transition-all hover:bg-gray-50 {{ $dark ? 'border-gray-600 text-gray-300 hover:bg-gray-800' : 'border-gray-200 text-gray-600' }}">Learn More</a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl {{ $dark ? 'bg-gray-800' : 'bg-gray-100' }}">
                            @if($profile->logo)
                            <div class="w-full h-full flex items-center justify-center">
                                <img src="{{ asset('storage/'.$profile->logo) }}" class="max-w-[60%] max-h-[60%] object-contain">
                            </div>
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-gray-100">
                                <div class="w-24 h-24 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg" style="background: {{ $primary }};">
                                    {{ strtoupper(substr($profile->business_name ?? 'B', 0, 1)) }}
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="absolute -bottom-4 -right-4 {{ $dark ? 'bg-gray-800 border-gray-600' : 'bg-white border-gray-100' }} border rounded-2xl p-4 shadow-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-xs" style="background: {{ $accent }};">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Trusted Payments</p>
                                    <p class="text-[10px] text-gray-400">100% Secure</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS / SOCIAL PROOF --}}
    <section class="py-10 {{ $dark ? 'bg-gray-800/30' : 'bg-white' }} border-b {{ $dark ? 'border-gray-700' : 'border-gray-100' }}">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold brand-primary">10K+</p>
                    <p class="text-[11px] {{ $dark ? 'text-gray-400' : 'text-gray-400' }} mt-1">Payments Processed</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold brand-primary">99.9%</p>
                    <p class="text-[11px] {{ $dark ? 'text-gray-400' : 'text-gray-400' }} mt-1">Uptime Guarantee</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold brand-primary">500+</p>
                    <p class="text-[11px] {{ $dark ? 'text-gray-400' : 'text-gray-400' }} mt-1">Happy Merchants</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold brand-primary">24/7</p>
                    <p class="text-[11px] {{ $dark ? 'text-gray-400' : 'text-gray-400' }} mt-1">Support Available</p>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-16 lg:py-20 {{ $dark ? 'bg-gray-800/50' : 'bg-gray-50' }}">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-3" style="background: {{ $primary }}15; color: {{ $primary }};">Features</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">Why Choose Us</h2>
                <p class="text-sm {{ $dark ? 'text-gray-400' : 'text-gray-500' }} max-w-md mx-auto">Everything you need for a seamless payment experience</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} p-6 hover:shadow-lg transition-all group">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: {{ $primary }}10;">
                        <svg class="w-6 h-6" style="color: {{ $primary }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold mb-2">Fast Payments</h3>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }} leading-relaxed">Complete your payment in seconds with our streamlined checkout.</p>
                </div>
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} p-6 hover:shadow-lg transition-all group">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: {{ $primary }}10;">
                        <svg class="w-6 h-6" style="color: {{ $primary }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-base font-bold mb-2">Secure & Trusted</h3>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }} leading-relaxed">Your data is encrypted and protected with bank-level security.</p>
                </div>
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} p-6 hover:shadow-lg transition-all group">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: {{ $primary }}10;">
                        <svg class="w-6 h-6" style="color: {{ $primary }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h3 class="text-base font-bold mb-2">Multiple Methods</h3>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }} leading-relaxed">Pay with Mobile Money or Card — whichever works best for you.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="py-16 lg:py-20 {{ $dark ? 'bg-gray-800/30' : 'bg-white' }}">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-3" style="background: {{ $primary }}15; color: {{ $primary }};">How It Works</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">Simple 3-Step Process</h2>
                <p class="text-sm {{ $dark ? 'text-gray-400' : 'text-gray-500' }} max-w-md mx-auto">Pay in under a minute</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                {{-- Connector line --}}
                <div class="hidden md:block absolute top-8 left-[16.67%] right-[16.67%] h-0.5 {{ $dark ? 'bg-gray-700' : 'bg-gray-200' }}"></div>

                <div class="relative text-center">
                    <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center text-white font-bold text-lg mb-4 relative z-10 shadow-lg" style="background: {{ $primary }};">1</div>
                    <h3 class="text-base font-bold mb-2">Choose Method</h3>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">Select Mobile Money or Card payment option that suits you best.</p>
                </div>
                <div class="relative text-center">
                    <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center text-white font-bold text-lg mb-4 relative z-10 shadow-lg" style="background: {{ $primary }};">2</div>
                    <h3 class="text-base font-bold mb-2">Fill Details</h3>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">Enter your phone number, name, and any required information.</p>
                </div>
                <div class="relative text-center">
                    <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center text-white font-bold text-lg mb-4 relative z-10 shadow-lg" style="background: {{ $accent }};">3</div>
                    <h3 class="text-base font-bold mb-2">Confirm Payment</h3>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">Review and confirm. You will receive an instant confirmation.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-16 lg:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-3" style="background: {{ $accent }}15; color: {{ $accent }};">Testimonials</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">What Our Clients Say</h2>
                <p class="text-sm {{ $dark ? 'text-gray-400' : 'text-gray-500' }} max-w-md mx-auto">Real feedback from real people</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/30' : 'border-gray-200 bg-white' }} p-6 relative">
                    <svg class="w-8 h-8 mb-4 opacity-20" style="color: {{ $primary }};" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    <p class="text-sm {{ $dark ? 'text-gray-300' : 'text-gray-600' }} leading-relaxed mb-4">"The payment process was so smooth and fast. Highly recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-xs" style="background: {{ $primary }};">J</div>
                        <div>
                            <p class="text-xs font-bold">John Doe</p>
                            <p class="text-[10px] text-gray-400">Customer</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/30' : 'border-gray-200 bg-white' }} p-6 relative">
                    <svg class="w-8 h-8 mb-4 opacity-20" style="color: {{ $primary }};" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    <p class="text-sm {{ $dark ? 'text-gray-300' : 'text-gray-600' }} leading-relaxed mb-4">"Best payment experience I have had. The interface is beautiful and easy to use."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-xs" style="background: {{ $primary }};">J</div>
                        <div>
                            <p class="text-xs font-bold">Jane Smith</p>
                            <p class="text-[10px] text-gray-400">Business Owner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ / ACCORDION --}}
    <section class="py-16 lg:py-20 {{ $dark ? 'bg-gray-800/30' : 'bg-white' }}">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-3" style="background: {{ $primary }}15; color: {{ $primary }};">FAQ</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">Frequently Asked Questions</h2>
                <p class="text-sm {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">Everything you need to know before paying</p>
            </div>
            <div class="space-y-3" x-data="{ open: null }">
                @php
                $faqs = $settings['faqs'] ?? [
                    ['q'=>'Is my payment information secure?','a'=>'Yes. All transactions are encrypted with bank-level SSL security. We never store your card details.'],
                    ['q'=>'What payment methods are accepted?','a'=>'We accept all major Mobile Money providers (M-Pesa, Tigo Pesa, Airtel Money) as well as Visa and Mastercard.'],
                    ['q'=>'How long does it take to confirm?','a'=>'Mobile Money payments are confirmed instantly. Card payments are processed within seconds.'],
                    ['q'=>'Can I get a refund?','a'=>'Yes, refunds are available according to the merchant\'s refund policy. Contact the merchant directly for refund requests.'],
                ];
                @endphp
                @foreach($faqs as $i => $faq)
                <div class="rounded-xl border {{ $dark ? 'border-gray-700 bg-gray-800/30' : 'border-gray-200 bg-white' }} overflow-hidden">
                    <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.faq-icon').classList.toggle('rotate-180');" class="w-full flex items-center justify-between p-4 text-left">
                        <span class="text-sm font-semibold pr-4">{{ $faq['q'] }}</span>
                        <svg class="faq-icon w-4 h-4 shrink-0 transition-transform duration-200 {{ $dark ? 'text-gray-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="hidden px-4 pb-4">
                        <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }} leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="payment" class="py-16 lg:py-20 {{ $dark ? 'bg-gray-800/50' : 'bg-gray-50' }}">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-3" style="background: {{ $primary }}15; color: {{ $primary }};">Payment</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">Complete Your Payment</h2>
                <p class="text-sm {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">Secure, fast, and hassle-free</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
                {{-- Order Summary --}}
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} overflow-hidden">
                        <div class="p-5">
                            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Order Summary</h3>
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <p class="text-sm font-semibold">{{ $link->title ?? 'Payment' }}</p>
                                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }} mt-0.5">{{ $link->description ?? 'Complete your payment securely' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t {{ $dark ? 'border-gray-700' : 'border-gray-100' }}">
                                <span class="text-sm {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">Total</span>
                                <span class="text-xl font-bold brand-primary">{{ number_format($link->amount, 0) }} {{ $link->currency ?? 'TZS' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-center gap-4 text-[10px] text-gray-400">
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>SSL Secure</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>Encrypted</span>
                    </div>
                </div>

                {{-- Payment Form --}}
                <div class="lg:col-span-3">
                    <div class="rounded-2xl border {{ $dark ? 'border-gray-700 bg-gray-800/50' : 'border-gray-200 bg-white' }} p-6">
                        <form action="{{ route('payment.process', $link->slug) }}" method="POST" id="paymentForm" class="space-y-5">
                            @csrf
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
                                                <p class="text-[11px] {{ $dark ? 'text-gray-400' : 'text-gray-500' }} mt-1">M-Pesa, Tigo, Airtel</p>
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
                                                <p class="text-[11px] {{ $dark ? 'text-gray-400' : 'text-gray-500' }} mt-1">Visa, Mastercard</p>
                                            </div>
                                        </div>
                                        <input type="radio" name="payment_method_type" value="card" class="hidden">
                                    </label>
                                </div>
                            </div>

                            <input type="hidden" name="payment_method" id="paymentMethodHidden" value="mobile_money">

                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Phone Number</p>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+255</div>
                                    <input type="tel" id="phoneDisplay" maxlength="12" placeholder="7XX XXX XXX" class="w-full pl-14 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};" required>
                                    <input type="hidden" name="phone" id="phoneHidden" value="">
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customer Details</p>
                                <div class="space-y-3">
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                                        <input type="text" name="customer_name" placeholder="Full name" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};" required>
                                    </div>
                                    @if($profile->require_email ?? true)
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg></div>
                                        <input type="email" name="customer_email" placeholder="Email address" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all" style="--tw-ring-color: {{ $primary }};" required>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div id="cardDetails" class="hidden">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Card Details</p>
                                <div class="space-y-3">
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg></div>
                                        <input type="text" name="card_number" maxlength="19" placeholder="0000 0000 0000 0000" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="relative">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                            <input type="text" name="card_expiry" maxlength="5" placeholder="MM / YY" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};">
                                        </div>
                                        <div class="relative">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                                            <input type="text" name="card_cvv" maxlength="4" placeholder="CVV" class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $dark ? 'border-gray-600 bg-gray-700 text-white placeholder-gray-400' : 'border-gray-200 bg-white' }} text-sm outline-none focus:ring-2 focus:ring-opacity-20 transition-all font-mono" style="--tw-ring-color: {{ $primary }};">
                                        </div>
                                    </div>
                                </div>
                            </div>

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

                            <button type="submit" class="w-full py-3.5 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90 active:scale-[0.98] shadow-lg" style="background: {{ $primary }};">Pay {{ number_format($link->amount, 0) }} {{ $link->currency ?? 'TZS' }}</button>
                            <p class="text-center text-[10px] text-gray-400">Secured by SalamaPay</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t {{ $dark ? 'border-gray-700 bg-gray-800/30' : 'border-gray-100 bg-gray-50' }} py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    @if(($settings['show_logo'] ?? true) && $profile->logo)
                    <img src="{{ asset('storage/'.$profile->logo) }}" class="h-6 w-auto object-contain">
                    @else
                    <div class="w-6 h-6 rounded-md flex items-center justify-center text-white font-bold text-[10px]" style="background: {{ $primary }};">{{ strtoupper(substr($profile->business_name ?? 'B', 0, 1)) }}</div>
                    @endif
                    <span class="text-xs font-semibold">{{ $profile->business_name ?? 'Business' }}</span>
                </div>
                <p class="text-[11px] text-gray-400">{{ $settings['footer_text'] ?? 'All rights reserved. Powered by SalamaPay.' }}</p>
            </div>
        </div>
    </footer>

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
