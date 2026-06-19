<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - SalamaPay</title>
    <meta name="description" content="SalamaPay blog - News, insights, and updates about digital payments in Africa.">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
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
        html { scroll-behavior: smooth; }
        @keyframes fade-up { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')

<section class="relative pt-[68px] pb-16 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8 text-center">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-emerald-400/30 text-emerald-100 text-xs font-medium mb-6">
            <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 uppercase tracking-wide">Blog</span>
            <span>Latest Updates</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4">Insights & News</h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto">Stay updated with the latest trends in digital payments, fintech, and business growth.</p>
    </div>
</section>

<section class="py-16 bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            <article class="animate-fade-up delay-1 group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('Karibu salamapay (1).png') }}" alt="Karibu SalamaPay" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-emerald-700 bg-white/90 backdrop-blur rounded-full">Payments</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>Jun 15, 2026</span>
                        <span>&middot;</span>
                        <span>5 min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Welcome to SalamaPay: The Future of Payments</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">Discover how SalamaPay is transforming digital payments for businesses across Tanzania and beyond.</p>
                    <a href="{{ route('blog-detail', 'welcome-to-salamapay') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="animate-fade-up delay-2 group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('app (1).png') }}" alt="App Feature" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-gold-700 bg-white/90 backdrop-blur rounded-full">Product</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>Jun 10, 2026</span>
                        <span>&middot;</span>
                        <span>4 min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">New App Features: Faster, Smarter Payments</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">Explore the latest features in the SalamaPay app designed to make your payment experience seamless.</p>
                    <a href="{{ route('blog-detail', 'new-app-features') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="animate-fade-up delay-3 group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('cheerful-excited-woman-reading-very-good-news-her-mobile-phone.png') }}" alt="Happy Customer" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-emerald-700 bg-white/90 backdrop-blur rounded-full">Success Story</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>Jun 5, 2026</span>
                        <span>&middot;</span>
                        <span>6 min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">How Small Businesses Are Growing with Digital Payments</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">Real stories from entrepreneurs who transformed their businesses using SalamaPay.</p>
                    <a href="{{ route('blog-detail', 'small-business-growth') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="animate-fade-up delay-1 group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('end (1).png') }}" alt="Security" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-gold-700 bg-white/90 backdrop-blur rounded-full">Security</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>May 28, 2026</span>
                        <span>&middot;</span>
                        <span>5 min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Keeping Your Money Safe: Our Security Standards</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">Learn about the bank-level security measures we use to protect every transaction.</p>
                    <a href="{{ route('blog-detail', 'security-standards') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="animate-fade-up delay-2 group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-emerald-700 bg-white/90 backdrop-blur rounded-full">Fintech</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>May 20, 2026</span>
                        <span>&middot;</span>
                        <span>7 min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">The State of Fintech in Tanzania 2026</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">An in-depth look at how financial technology is reshaping commerce across the country.</p>
                    <a href="{{ route('blog-detail', 'fintech-tanzania-2026') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            <article class="animate-fade-up delay-3 group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-gold-700 bg-white/90 backdrop-blur rounded-full">Tips</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>May 15, 2026</span>
                        <span>&middot;</span>
                        <span>3 min read</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">5 Tips to Reduce Payment Processing Costs</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">Simple strategies to optimize your payment flow and save money on every transaction.</p>
                    <a href="{{ route('blog-detail', 'reduce-payment-costs') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Ready to grow your business?</h2>
        <p class="text-lg text-gray-500 mb-8">Join thousands of businesses using SalamaPay.</p>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg transition-all">Get Started Free</a>
    </div>
</section>

<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
