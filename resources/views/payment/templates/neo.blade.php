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

</body>
</html>
