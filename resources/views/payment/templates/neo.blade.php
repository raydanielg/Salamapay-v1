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

</body>
</html>
