<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to SalamaPay - SalamaPay Blog</title>
    <meta name="description" content="Discover how SalamaPay is transforming digital payments for businesses across Tanzania.">
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
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')

{{-- Article Header --}}
<section class="relative pt-[68px] pb-12 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <div class="animate-fade-up delay-1 flex items-center gap-3 mb-6">
            <a href="{{ route('blog') }}" class="text-emerald-200 hover:text-white text-sm font-medium transition-colors">&larr; Back to Blog</a>
        </div>
        <span class="inline-flex px-3 py-1 text-xs font-bold text-emerald-700 bg-gold-100 rounded-full mb-4">Payments</span>
        <h1 class="animate-fade-up delay-2 text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">Welcome to SalamaPay: The Future of Payments</h1>
        <div class="animate-fade-up delay-2 flex items-center gap-4 text-emerald-100/80 text-sm">
            <span>Jun 15, 2026</span>
            <span>&middot;</span>
            <span>5 min read</span>
            <span>&middot;</span>
            <span>By James Daudi</span>
        </div>
    </div>
</section>

{{-- Featured Image --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="rounded-2xl overflow-hidden shadow-2xl">
        <img src="{{ asset('Karibu salamapay (1).png') }}" alt="Karibu SalamaPay" class="w-full h-64 md:h-80 object-cover">
    </div>
</div>

{{-- Article Content --}}
<article class="py-12 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="animate-fade-up delay-1 prose prose-lg max-w-none">
            <p class="text-gray-600 leading-relaxed mb-6">
                In today's fast-paced digital economy, businesses need payment solutions that are reliable, affordable, and easy to use. That's exactly why we built SalamaPay.
            </p>
            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Why We Started SalamaPay</h2>
            <p class="text-gray-600 leading-relaxed mb-6">
                We noticed that small and medium businesses in Tanzania struggled with accepting digital payments. The existing solutions were either too expensive, too complicated, or both. We set out to change that.
            </p>
            <p class="text-gray-600 leading-relaxed mb-6">
                SalamaPay was born from a simple idea: every business, regardless of size, deserves access to world-class payment infrastructure. Whether you are a local shop in Dar es Salaam or a growing e-commerce platform, we have got you covered.
            </p>

            <div class="my-10 p-6 rounded-2xl bg-emerald-50 border border-emerald-100">
                <h3 class="text-lg font-bold text-emerald-800 mb-3">What makes SalamaPay different?</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Instant settlements - get paid immediately</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Only 0.5% per mobile money transaction</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Multiple payment methods supported</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Developer-friendly APIs and SDKs</li>
                </ul>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Looking Ahead</h2>
            <p class="text-gray-600 leading-relaxed mb-6">
                We are just getting started. Our roadmap includes expanding to more African countries, adding new payment methods, and building tools that help businesses grow faster.
            </p>
            <p class="text-gray-600 leading-relaxed mb-6">
                Thank you for being part of this journey. Together, we are building the future of money in Africa.
            </p>
        </div>

        {{-- Share --}}
        <div class="animate-fade-up delay-2 mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Share:</span>
                <a href="#" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-emerald-100 flex items-center justify-center text-gray-600 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
            </div>
            <a href="{{ route('blog') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">&larr; Back to all articles</a>
        </div>
    </div>
</article>

{{-- Related Posts --}}
<section class="py-16 bg-gradient-to-b from-white to-emerald-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">More Articles</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('blog-detail', 'new-app-features') }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all">
                <div class="h-40 overflow-hidden">
                    <img src="{{ asset('app (1).png') }}" alt="App Features" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <span class="text-xs text-gray-400">Jun 10, 2026</span>
                    <h3 class="font-bold text-gray-900 mt-1 group-hover:text-emerald-600 transition-colors">New App Features</h3>
                </div>
            </a>
            <a href="{{ route('blog-detail', 'security-standards') }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all">
                <div class="h-40 overflow-hidden">
                    <img src="{{ asset('end (1).png') }}" alt="Security" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <span class="text-xs text-gray-400">May 28, 2026</span>
                    <h3 class="font-bold text-gray-900 mt-1 group-hover:text-emerald-600 transition-colors">Security Standards</h3>
                </div>
            </a>
            <a href="{{ route('blog-detail', 'small-business-growth') }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all">
                <div class="h-40 overflow-hidden">
                    <img src="{{ asset('cheerful-excited-woman-reading-very-good-news-her-mobile-phone.png') }}" alt="Growth" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <span class="text-xs text-gray-400">Jun 5, 2026</span>
                    <h3 class="font-bold text-gray-900 mt-1 group-hover:text-emerald-600 transition-colors">Small Business Growth</h3>
                </div>
            </a>
        </div>
    </div>
</section>

<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
