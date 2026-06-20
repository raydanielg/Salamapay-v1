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

</body>
</html>
