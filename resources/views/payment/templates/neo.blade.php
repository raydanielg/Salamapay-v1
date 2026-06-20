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

    <footer class="border-t {{ $dark ? 'border-gray-700 bg-gray-800/30' : 'border-gray-100 bg-gray-50' }} pt-12 pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        @if(($settings['show_logo'] ?? true) && $profile->logo)
                        <img src="{{ asset('storage/'.$profile->logo) }}" class="h-6 w-auto object-contain">
                        @else
                        <div class="w-6 h-6 rounded-md flex items-center justify-center text-white font-bold text-[10px]" style="background: {{ $primary }};">{{ strtoupper(substr($profile->business_name ?? 'B', 0, 1)) }}</div>
                        @endif
                        <span class="text-sm font-bold">{{ $profile->business_name ?? 'Business' }}</span>
                    </div>
                    <p class="text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }} leading-relaxed max-w-xs">{{ $profile->description ?? 'Secure payment solutions for your business.' }}</p>
                </div>
                {{-- Quick Links --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider mb-4">Quick Links</h4>
                    <div class="space-y-2">
                        <a href="#hero" class="block text-xs {{ $dark ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Home</a>
                        <a href="#features" class="block text-xs {{ $dark ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Features</a>
                        <a href="#payment" class="block text-xs {{ $dark ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Make Payment</a>
                        <a href="#" class="block text-xs {{ $dark ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Contact</a>
                    </div>
                </div>
                {{-- Contact --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider mb-4">Contact</h4>
                    <div class="space-y-2">
                        @if($profile->phone)
                        <div class="flex items-center gap-2 text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $profile->phone }}
                        </div>
                        @endif
                        @if($profile->email)
                        <div class="flex items-center gap-2 text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $profile->email }}
                        </div>
                        @endif
                        @if($profile->website_url)
                        <div class="flex items-center gap-2 text-xs {{ $dark ? 'text-gray-400' : 'text-gray-500' }}">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            {{ $profile->website_url }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="pt-6 border-t {{ $dark ? 'border-gray-700' : 'border-gray-200' }} flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-[11px] text-gray-400">{{ $settings['footer_text'] ?? 'All rights reserved. Powered by SalamaPay.' }}</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                </div>
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
