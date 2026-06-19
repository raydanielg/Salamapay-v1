<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Support Center - SalamaPay</title>
    <meta name="description" content="SalamaPay support center. Find answers to common questions and get help.">
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

{{-- Hero --}}
<section class="relative pt-[68px] pb-16 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8 text-center">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-emerald-400/30 text-emerald-100 text-xs font-medium mb-6">
            <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 uppercase tracking-wide">Support</span>
            <span>Help Center</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4">How can we help?</h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto mb-8">Find answers to common questions or get in touch with our support team.</p>

        {{-- Search --}}
        <div class="animate-fade-up delay-3 max-w-xl mx-auto relative">
            <input type="text" placeholder="Search for answers..." class="w-full px-5 py-3.5 pl-12 rounded-xl border border-emerald-400/30 bg-white/10 backdrop-blur-sm text-white placeholder-emerald-200/70 focus:outline-none focus:bg-white/15 focus:border-emerald-400/50 transition-all">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>
</section>

{{-- Quick Links Cards --}}
<section class="py-12 bg-emerald-50 relative -mt-6 z-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-6">
            <a href="#getting-started" class="animate-fade-up delay-1 p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all text-center group">
                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 flex items-center justify-center mb-4 group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Getting Started</h3>
                <p class="text-sm text-gray-500">Setup guides and onboarding</p>
            </a>
            <a href="#payments" class="animate-fade-up delay-2 p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all text-center group">
                <div class="w-12 h-12 mx-auto rounded-xl bg-gold-100 flex items-center justify-center mb-4 group-hover:bg-gold-200 transition-colors">
                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Payments</h3>
                <p class="text-sm text-gray-500">Transactions and fees</p>
            </a>
            <a href="#account" class="animate-fade-up delay-3 p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all text-center group">
                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 flex items-center justify-center mb-4 group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Account</h3>
                <p class="text-sm text-gray-500">Profile and security</p>
            </a>
        </div>
    </div>
</section>

{{-- FAQs --}}
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div id="getting-started" class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></span>
                Getting Started
            </h2>
            <div class="space-y-3">
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        How do I create a SalamaPay account?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Simply click "Get Started" and fill in your business details. Verification takes less than 24 hours.</p>
                </details>
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        What documents do I need?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">You will need a business registration certificate, TIN number, and a valid ID of the business owner.</p>
                </details>
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        How long does verification take?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Most accounts are verified within 24 hours. Some may take up to 48 hours if additional review is needed.</p>
                </details>
            </div>
        </div>

        <div id="payments" class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-gold-100 flex items-center justify-center"><svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                Payments
            </h2>
            <div class="space-y-3">
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        What payment methods are supported?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">M-Pesa, Airtel Money, Halopesa, Mixx by Yas, TIPS Dynamic QR, Visa, and Mastercard.</p>
                </details>
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        How much are the transaction fees?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Mobile money transactions are 0.5%. Card payments are 3.0%. Payouts are TZS 1,500 per transaction.</p>
                </details>
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        When do I receive my money?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Mobile money settlements are instant. Card settlements are processed by the next business day.</p>
                </details>
            </div>
        </div>

        <div id="account" class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                Account
            </h2>
            <div class="space-y-3">
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        How do I reset my password?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Click "Forgot Password" on the login page and follow the instructions sent to your email.</p>
                </details>
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        Can I have multiple users on my account?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Yes! You can invite team members and assign different permission levels from your dashboard.</p>
                </details>
                <details class="group p-5 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-emerald-200 transition-colors">
                    <summary class="flex items-center justify-between font-semibold text-gray-900">
                        How do I enable two-factor authentication?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">Go to Settings &gt; Security in your dashboard and follow the setup instructions for 2FA.</p>
                </details>
            </div>
        </div>
    </div>
</section>

{{-- Still Need Help --}}
<section class="py-16 bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="p-8 md:p-12 rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-700 shadow-xl">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Still need help?</h3>
            <p class="text-emerald-100 mb-6">Our support team is available 24/7 to assist you.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-emerald-900 bg-white hover:bg-gray-100 rounded-lg shadow-lg transition-all">Contact Support</a>
                <a href="mailto:support@salamapay.co.tz" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white border border-white/30 hover:border-white/60 rounded-lg backdrop-blur-sm transition-all">Email Us</a>
            </div>
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
