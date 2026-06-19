<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricing - SalamaPay</title>
    <meta name="description" content="SalamaPay pricing - Simple, transparent pricing. No hidden fees.">
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
        .delay-4 { animation-delay:.7s }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')

{{-- Pricing Hero --}}
<section class="relative pt-[68px] pb-16 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8 text-center">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-emerald-400/30 text-emerald-100 text-sm font-medium mb-6">
            <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 uppercase tracking-wide">Pricing</span>
            <span>Simple and Transparent</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4">We earn only when you earn</h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto">Simple, transparent pricing. No hidden fees, no surprises. Only pay for what you use.</p>
    </div>
</section>

{{-- Pricing Table --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="animate-fade-up delay-1 overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 rounded-tl-xl">Payment method</th>
                        <th scope="col" class="px-6 py-4">How your customer pays</th>
                        <th scope="col" class="px-6 py-4">Collection Fee</th>
                        <th scope="col" class="px-6 py-4">Payout Fee</th>
                        <th scope="col" class="px-6 py-4 rounded-tr-xl">Settlement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Mobile Money</td>
                        <td class="px-6 py-4 text-gray-600">M-Pesa</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">0.5%</td>
                        <td class="px-6 py-4 text-gray-600">TZS 1,500</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Instant</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Mobile Money</td>
                        <td class="px-6 py-4 text-gray-600">Airtel Money</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">0.5%</td>
                        <td class="px-6 py-4 text-gray-600">TZS 1,500</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Instant</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Mobile Money</td>
                        <td class="px-6 py-4 text-gray-600">Halopesa</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">0.5%</td>
                        <td class="px-6 py-4 text-gray-600">TZS 1,500</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Instant</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Mobile Money</td>
                        <td class="px-6 py-4 text-gray-600">Mixx by Yas</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">0.5%</td>
                        <td class="px-6 py-4 text-gray-600">TZS 1,500</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Instant</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">QR Code</td>
                        <td class="px-6 py-4 text-gray-600">TIPS Dynamic QR</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">0.5%</td>
                        <td class="px-6 py-4 text-gray-400">-</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Instant</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Cards</td>
                        <td class="px-6 py-4 text-gray-600">Visa / Mastercard</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">3.0%</td>
                        <td class="px-6 py-4 text-gray-400">-</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gold-100 text-gold-800">Next business day</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Payouts</td>
                        <td class="px-6 py-4 text-gray-600">Mobile Money (MNO)</td>
                        <td class="px-6 py-4 text-gray-400">-</td>
                        <td class="px-6 py-4 text-gray-600">TZS 1,500</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Instant</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 rounded-bl-xl">Payouts</td>
                        <td class="px-6 py-4 text-gray-600">Bank Transfer</td>
                        <td class="px-6 py-4 text-gray-400">-</td>
                        <td class="px-6 py-4 text-gray-600">TZS 1,500</td>
                        <td class="px-6 py-4 rounded-br-xl"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">1-2 business days</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Everything Included --}}
<section class="py-16 bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold-100 text-gold-700 text-sm font-semibold mb-4">All Features</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Everything included</h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">No tiers, no upsells, no "contact sales for that feature." Every SalamaPay account gets the full platform from day one.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Instant settlement</h3>
                <p class="text-sm text-gray-500">Get your money as soon as payments come in.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Real-time dashboard</h3>
                <p class="text-sm text-gray-500">Monitor transactions, track revenue, and export reports.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">API access and SDKs</h3>
                <p class="text-sm text-gray-500">Comprehensive documentation and SDKs to integrate payments in minutes.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Webhook notifications</h3>
                <p class="text-sm text-gray-500">Get real-time updates on every payment event, delivered reliably.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Automated reconciliation</h3>
                <p class="text-sm text-gray-500">Every transaction recorded with double-entry accounting. Balances always match.</p>
            </div>
        </div>
    </div>
</section>

{{-- High Volume CTA --}}
<section class="py-12 bg-emerald-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="p-8 md:p-12 rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-700 shadow-xl">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Have more than TZS 500M in sales per year?</h3>
            <p class="text-emerald-100 mb-6">Sounds great! Contact us to learn about our offer for high-volume sellers.</p>
            <a href="tel:+255000000000" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-emerald-900 bg-gold-400 hover:bg-gold-500 rounded-lg shadow-lg transition-all">Contact Sales</a>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-10">Frequently Asked Questions</h2>
        <div class="space-y-4">
            <details class="group p-6 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer">
                <summary class="flex items-center justify-between font-semibold text-gray-900">
                    How much does SalamaPay cost?
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <p class="mt-3 text-gray-600 text-sm">0.5% per transaction for mobile money, no monthly charges. You only pay when you get paid. Card payments are 3.0%.</p>
            </details>
            <details class="group p-6 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer">
                <summary class="flex items-center justify-between font-semibold text-gray-900">
                    How fast do I get my money?
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <p class="mt-3 text-gray-600 text-sm">Mobile money settlements are instant. Card settlements take up to the next business day.</p>
            </details>
            <details class="group p-6 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer">
                <summary class="flex items-center justify-between font-semibold text-gray-900">
                    Can I sell physical products?
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <p class="mt-3 text-gray-600 text-sm">Yes! SalamaPay supports both digital and physical product sales through our payment links and API.</p>
            </details>
            <details class="group p-6 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer">
                <summary class="flex items-center justify-between font-semibold text-gray-900">
                    How do developers get started?
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <p class="mt-3 text-gray-600 text-sm">Check our Docs section for comprehensive API documentation, SDKs, and integration guides.</p>
            </details>
            <details class="group p-6 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer">
                <summary class="flex items-center justify-between font-semibold text-gray-900">
                    What payment methods are supported?
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <p class="mt-3 text-gray-600 text-sm">M-Pesa, Airtel Money, Halopesa, Mixx by Yas, TIPS Dynamic QR, Visa and Mastercard.</p>
            </details>
            <details class="group p-6 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer">
                <summary class="flex items-center justify-between font-semibold text-gray-900">
                    Is there a limit on withdrawals?
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </summary>
                <p class="mt-3 text-gray-600 text-sm">No limits on withdrawals. Withdraw your funds anytime with instant settlement for mobile money.</p>
            </details>
        </div>
    </div>
</section>

{{-- Final CTA --}}
<section class="py-16 bg-gradient-to-b from-white to-emerald-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Ready to get started?</h2>
        <p class="text-lg text-gray-500 mb-8 max-w-xl mx-auto">Join other businesses growing with SalamaPay. Accept payments, send payouts, and scale your operations.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg transition-all">Get Started Free</a>
            <a href="tel:+255000000000" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-semibold text-emerald-700 border border-emerald-200 hover:bg-emerald-50 rounded-lg transition-all">Talk to Sales</a>
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
