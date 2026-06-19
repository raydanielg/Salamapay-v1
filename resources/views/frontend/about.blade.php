<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - SalamaPay</title>
    <meta name="description" content="About SalamaPay - The future of digital payments in Africa.">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
        @keyframes fade-up { 0%{opacity:0;transform:translateY(40px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
        .delay-4 { animation-delay:.7s }
        .delay-5 { animation-delay:.9s }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .animate-float { animation: float 5s ease-in-out infinite; }
        @keyframes pulse-ring { 0%{transform:scale(.8);opacity:1} 100%{transform:scale(1.4);opacity:0} }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
        @keyframes count-up { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .stat-count { animation: count-up 1s ease-out both; }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')
@include('frontend.partials.page-loader')

{{-- Hero Section --}}
<section class="relative min-h-[70vh] flex items-center overflow-hidden pt-[68px]">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-gold-400/10 blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-emerald-400/10 blur-[80px]"></div>
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <div class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-emerald-400/30 text-emerald-100 text-xs font-medium mb-6">
                    <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 uppercase tracking-wide">About</span>
                    <span>Who We Are</span>
                </div>
                <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    Building the future of <span class="text-gold-300">digital payments</span> in Africa
                </h1>
                <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    SalamaPay is a modern payment platform built for African businesses. We make it easy to accept payments, send payouts, and grow your business.
                </p>
            </div>
            <div class="hidden lg:flex items-center justify-center">
                <div class="relative animate-float">
                    <img src="{{ asset('end (1).png') }}" alt="SalamaPay Team" class="relative w-[420px] h-auto object-contain rounded-2xl shadow-2xl shadow-emerald-900/50" style="-webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0) 100%); mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0) 100%);">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<section class="py-12 bg-emerald-50 relative -mt-10 z-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="animate-fade-up delay-1 text-center p-6 rounded-2xl bg-white border border-gray-100 shadow-sm">
                <div class="text-3xl md:text-4xl font-extrabold text-emerald-600 mb-1 stat-count">2M+</div>
                <div class="text-sm text-gray-500 font-medium">Transactions Monthly</div>
            </div>
            <div class="animate-fade-up delay-2 text-center p-6 rounded-2xl bg-white border border-gray-100 shadow-sm">
                <div class="text-3xl md:text-4xl font-extrabold text-emerald-600 mb-1 stat-count">2,000+</div>
                <div class="text-sm text-gray-500 font-medium">Active Businesses</div>
            </div>
            <div class="animate-fade-up delay-3 text-center p-6 rounded-2xl bg-white border border-gray-100 shadow-sm">
                <div class="text-3xl md:text-4xl font-extrabold text-emerald-600 mb-1 stat-count">99.9%</div>
                <div class="text-sm text-gray-500 font-medium">Uptime</div>
            </div>
            <div class="animate-fade-up delay-4 text-center p-6 rounded-2xl bg-white border border-gray-100 shadow-sm">
                <div class="text-3xl md:text-4xl font-extrabold text-emerald-600 mb-1 stat-count">&lt;3s</div>
                <div class="text-sm text-gray-500 font-medium">Avg. Speed</div>
            </div>
        </div>
    </div>
</section>

{{-- Our Story --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="animate-fade-up delay-1">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold-100 text-gold-700 text-sm font-semibold mb-4">Our Story</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">From a simple idea to a payment revolution</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    SalamaPay was founded with a clear mission: to make digital payments accessible, affordable, and reliable for every business in Africa.
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    We started by solving one problem - helping small businesses accept mobile money payments online. Today, we power thousands of businesses across Tanzania, from local shops to growing enterprises.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Our team is dedicated to building financial infrastructure that works for Africa. No complicated setups, no hidden fees - just simple, powerful payments.
                </p>
            </div>
            <div class="animate-fade-up delay-2 grid grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">2021</div>
                    <div class="text-sm text-gray-500">Founded</div>
                </div>
                <div class="p-6 rounded-2xl bg-gradient-to-br from-gold-50 to-white border border-gold-100 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-gold-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">50+</div>
                    <div class="text-sm text-gray-500">Team Members</div>
                </div>
                <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">5+</div>
                    <div class="text-sm text-gray-500">Countries</div>
                </div>
                <div class="p-6 rounded-2xl bg-gradient-to-br from-gold-50 to-white border border-gold-100 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-gold-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">6</div>
                    <div class="text-sm text-gray-500">Payment Methods</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values / Why Choose Us --}}
<section class="py-20 bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold mb-4">Why Us</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Why businesses choose SalamaPay</h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">We are more than a payment processor. We are your growth partner.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="animate-fade-up delay-1 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Instant Settlements</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Get your money immediately after each transaction. No waiting, no delays.</p>
            </div>
            <div class="animate-fade-up delay-2 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-gold-100 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Bank-Level Security</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Your money and data are protected with enterprise-grade encryption.</p>
            </div>
            <div class="animate-fade-up delay-3 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Developer Friendly</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Powerful APIs and SDKs to integrate payments in minutes, not days.</p>
            </div>
            <div class="animate-fade-up delay-4 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-gold-100 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Built for Africa</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Designed for local businesses with local payment methods and support.</p>
            </div>
            <div class="animate-fade-up delay-5 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Transparent Pricing</h3>
                <p class="text-gray-500 text-sm leading-relaxed">No hidden fees. No monthly charges. You only pay when you get paid.</p>
            </div>
            <div class="animate-fade-up delay-5 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-gold-100 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Our team is always available to help you succeed, any time of day.</p>
            </div>
        </div>
    </div>
</section>

{{-- Team Section --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold-100 text-gold-700 text-sm font-semibold mb-4">Our Team</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Meet the people behind SalamaPay</h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">A passionate team dedicated to transforming payments in Africa.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="animate-fade-up delay-1 group text-center">
                <div class="relative mx-auto w-32 h-32 mb-4 rounded-full overflow-hidden border-4 border-emerald-100 group-hover:border-emerald-300 transition-colors">
                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-3xl font-bold">JD</div>
                </div>
                <h3 class="text-lg font-bold text-gray-900">James Daudi</h3>
                <p class="text-sm text-emerald-600 font-medium mb-2">CEO & Co-Founder</p>
                <p class="text-sm text-gray-500 max-w-xs mx-auto">Visionary leader with 10+ years in fintech and digital payments.</p>
            </div>
            <div class="animate-fade-up delay-2 group text-center">
                <div class="relative mx-auto w-32 h-32 mb-4 rounded-full overflow-hidden border-4 border-gold-100 group-hover:border-gold-300 transition-colors">
                    <div class="w-full h-full bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center text-white text-3xl font-bold">SM</div>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Sarah Mushi</h3>
                <p class="text-sm text-gold-600 font-medium mb-2">CTO & Co-Founder</p>
                <p class="text-sm text-gray-500 max-w-xs mx-auto">Engineering leader passionate about building scalable financial systems.</p>
            </div>
            <div class="animate-fade-up delay-3 group text-center">
                <div class="relative mx-auto w-32 h-32 mb-4 rounded-full overflow-hidden border-4 border-emerald-100 group-hover:border-emerald-300 transition-colors">
                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-3xl font-bold">DK</div>
                </div>
                <h3 class="text-lg font-bold text-gray-900">David Kweka</h3>
                <p class="text-sm text-emerald-600 font-medium mb-2">Head of Operations</p>
                <p class="text-sm text-gray-500 max-w-xs mx-auto">Operations expert ensuring smooth payment flows for all merchants.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-gradient-to-b from-white to-emerald-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Ready to grow with us?</h2>
        <p class="text-lg text-gray-500 mb-8 max-w-xl mx-auto">Join thousands of businesses using SalamaPay to accept payments and scale their operations.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg transition-all">Get Started Free</a>
            <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-semibold text-emerald-700 border border-emerald-200 hover:bg-emerald-50 rounded-lg transition-all">View Pricing</a>
        </div>
    </div>
</section>

{{-- Simple Footer --}}
<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
    </div>
</footer>

<script>
document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',e=>{e.preventDefault();const t=document.querySelector(a.getAttribute('href'));if(t){window.scrollTo({top:t.getBoundingClientRect().top+window.pageYOffset-80,behavior:'smooth'})}})});
</script>
</body>
</html>
