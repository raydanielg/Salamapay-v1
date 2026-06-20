<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>How It Works - SalamaPay</title>
    <meta name="description" content="Learn how SalamaPay works in 6 simple steps. Pay with ease, business receives fast.">
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
        @keyframes fade-up { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        @keyframes fade-left { 0%{opacity:0;transform:translateX(-40px)} 100%{opacity:1;transform:translateX(0)} }
        @keyframes fade-right { 0%{opacity:0;transform:translateX(40px)} 100%{opacity:1;transform:translateX(0)} }
        @keyframes scale-in { 0%{opacity:0;transform:scale(0.85)} 100%{opacity:1;transform:scale(1)} }
        @keyframes pulse-glow { 0%,100%{box-shadow:0 0 0 0 rgba(2,73,56,0.3)} 50%{box-shadow:0 0 0 12px rgba(2,73,56,0)} }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes slide-line { 0%{height:0} 100%{height:100%} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .animate-fade-left { animation: fade-left .9s ease-out both; }
        .animate-fade-right { animation: fade-right .9s ease-out both; }
        .animate-scale-in { animation: scale-in .6s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
        .delay-4 { animation-delay:.7s }
        .delay-5 { animation-delay:.9s }
        .delay-6 { animation-delay:1.1s }
        .step-pulse { animation: pulse-glow 2s infinite; }
        .step-float { animation: float 4s ease-in-out infinite; }
        .line-grow { animation: slide-line 1.2s ease-out both; }
        .step-card:hover { transform: translateY(-8px) scale(1.02); }
        .step-number { transition: all .3s ease; }
        .step-card:hover .step-number { transform: scale(1.15) rotate(5deg); }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')
@include('frontend.partials.page-loader')

{{-- Hero --}}
<section class="relative pt-[88px] lg:pt-[96px] xl:pt-[116px] pb-20 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-gold-400/10 blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-emerald-400/10 blur-[100px]"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8 text-center">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-emerald-400/30 text-emerald-100 text-sm font-medium mb-6">
            <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 uppercase tracking-wide">How It Works</span>
            <span>6 Simple Steps</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white leading-tight mb-6">
            Pay With Ease,<br><span class="text-gold-300">Business Receives Fast</span>
        </h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto">
            Hatua chache tu na unamaliza. SalamaPay inasimamia mchakato wote kwa usalama na haraka.
        </p>
    </div>
</section>

{{-- Steps Section --}}
<section class="py-20 md:py-28 bg-white relative overflow-hidden">
    <div class="max-w-6xl 2xl:max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">

        {{-- Section Header --}}
        <div class="text-center mb-20">
            <span class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold mb-4">Rahisi sana</span>
            <h2 class="animate-fade-up delay-2 text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-slate-900 mb-4">Jinsi Inavyofanya Kazi</h2>
            <p class="animate-fade-up delay-3 text-lg xl:text-xl text-slate-500 max-w-2xl mx-auto">
                Mchakato wa malipo unaofuata hatua zifuatazo. Kila hatua inakusaidia kufikia malengo yako kwa haraka.
            </p>
        </div>

        {{-- Steps Grid --}}
        <div class="relative">
            {{-- Connecting vertical line (desktop) --}}
            <div class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-emerald-200 via-gold-300 to-emerald-200 rounded-full -translate-x-1/2"></div>

            {{-- Step 1 --}}
            <div class="relative mb-12 lg:mb-0 lg:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div class="animate-fade-left delay-1 order-2 lg:order-1">
                        <div class="step-card relative p-8 xl:p-10 rounded-3xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 shadow-lg shadow-emerald-100/30 hover:shadow-2xl hover:shadow-emerald-200/50 transition-all duration-500 cursor-default">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="step-number w-14 h-14 xl:w-16 xl:h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-xl xl:text-2xl font-bold shadow-lg shadow-emerald-500/30">1</div>
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl xl:text-3xl font-bold text-slate-900 mb-3">Chagua Bidhaa</h3>
                            <p class="text-slate-500 xl:text-lg leading-relaxed">Mteja anachagua bidhaa au huduma anayotaka kwenye website au app ya biashara.</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center justify-center order-1 lg:order-2 relative">
                        <div class="step-pulse w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 border-4 border-white shadow-lg z-10"></div>
                    </div>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="relative mb-12 lg:mb-0 lg:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div class="hidden lg:flex items-center justify-center relative">
                        <div class="step-pulse w-6 h-6 rounded-full bg-gradient-to-br from-gold-400 to-gold-500 border-4 border-white shadow-lg z-10"></div>
                    </div>
                    <div class="animate-fade-right delay-2">
                        <div class="step-card relative p-8 xl:p-10 rounded-3xl bg-gradient-to-br from-gold-50 to-white border border-gold-100 shadow-lg shadow-gold-100/30 hover:shadow-2xl hover:shadow-gold-200/50 transition-all duration-500 cursor-default">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="step-number w-14 h-14 xl:w-16 xl:h-16 rounded-2xl bg-gradient-to-br from-gold-400 to-gold-500 text-white flex items-center justify-center text-xl xl:text-2xl font-bold shadow-lg shadow-gold-500/30">2</div>
                                <div class="w-12 h-12 rounded-xl bg-gold-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl xl:text-3xl font-bold text-slate-900 mb-3">Bonyeza Lipa</h3>
                            <p class="text-slate-500 xl:text-lg leading-relaxed">Mteja anabonyeza "Lipa Sasa" na kuchagua njia ya kulipa inayomfaa zaidi.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="relative mb-12 lg:mb-0 lg:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div class="animate-fade-left delay-3 order-2 lg:order-1">
                        <div class="step-card relative p-8 xl:p-10 rounded-3xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 shadow-lg shadow-emerald-100/30 hover:shadow-2xl hover:shadow-emerald-200/50 transition-all duration-500 cursor-default">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="step-number w-14 h-14 xl:w-16 xl:h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-xl xl:text-2xl font-bold shadow-lg shadow-emerald-500/30">3</div>
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl xl:text-3xl font-bold text-slate-900 mb-3">Chagua Njia ya Kulipa</h3>
                            <p class="text-slate-500 xl:text-lg leading-relaxed">M-Pesa, Airtel Money, benki au kadi. Chagua ile unayoipenda na ulipa.</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center justify-center order-1 lg:order-2 relative">
                        <div class="step-pulse w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 border-4 border-white shadow-lg z-10"></div>
                    </div>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="relative mb-12 lg:mb-0 lg:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div class="hidden lg:flex items-center justify-center relative">
                        <div class="step-pulse w-6 h-6 rounded-full bg-gradient-to-br from-gold-400 to-gold-500 border-4 border-white shadow-lg z-10"></div>
                    </div>
                    <div class="animate-fade-right delay-4">
                        <div class="step-card relative p-8 xl:p-10 rounded-3xl bg-gradient-to-br from-gold-50 to-white border border-gold-100 shadow-lg shadow-gold-100/30 hover:shadow-2xl hover:shadow-gold-200/50 transition-all duration-500 cursor-default">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="step-number w-14 h-14 xl:w-16 xl:h-16 rounded-2xl bg-gradient-to-br from-gold-400 to-gold-500 text-white flex items-center justify-center text-xl xl:text-2xl font-bold shadow-lg shadow-gold-500/30">4</div>
                                <div class="w-12 h-12 rounded-xl bg-gold-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl xl:text-3xl font-bold text-slate-900 mb-3">Lipa Kwa Simu</h3>
                            <p class="text-slate-500 xl:text-lg leading-relaxed">Thibitisha malipo kupitia simu yako kwa namba yako ya siri (PIN) kwa usalama.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 5 --}}
            <div class="relative mb-12 lg:mb-0 lg:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div class="animate-fade-left delay-5 order-2 lg:order-1">
                        <div class="step-card relative p-8 xl:p-10 rounded-3xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 shadow-lg shadow-emerald-100/30 hover:shadow-2xl hover:shadow-emerald-200/50 transition-all duration-500 cursor-default">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="step-number w-14 h-14 xl:w-16 xl:h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-xl xl:text-2xl font-bold shadow-lg shadow-emerald-500/30">5</div>
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl xl:text-3xl font-bold text-slate-900 mb-3">Biashara Inapokea</h3>
                            <p class="text-slate-500 xl:text-lg leading-relaxed">Biashara inapokea taarifa ya malipo mara moja kwenye dashibodi yao.</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center justify-center order-1 lg:order-2 relative">
                        <div class="step-pulse w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 border-4 border-white shadow-lg z-10"></div>
                    </div>
                </div>
            </div>

            {{-- Step 6 --}}
            <div class="relative">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div class="hidden lg:flex items-center justify-center relative">
                        <div class="step-pulse w-6 h-6 rounded-full bg-gradient-to-br from-gold-400 to-gold-500 border-4 border-white shadow-lg z-10"></div>
                    </div>
                    <div class="animate-fade-right delay-6">
                        <div class="step-card relative p-8 xl:p-10 rounded-3xl bg-gradient-to-br from-gold-50 to-white border border-gold-100 shadow-lg shadow-gold-100/30 hover:shadow-2xl hover:shadow-gold-200/50 transition-all duration-500 cursor-default">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="step-number w-14 h-14 xl:w-16 xl:h-16 rounded-2xl bg-gradient-to-br from-gold-400 to-gold-500 text-white flex items-center justify-center text-xl xl:text-2xl font-bold shadow-lg shadow-gold-500/30">6</div>
                                <div class="w-12 h-12 rounded-xl bg-gold-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl xl:text-3xl font-bold text-slate-900 mb-3">Pokea Bidhaa</h3>
                            <p class="text-slate-500 xl:text-lg leading-relaxed">Mteja anapokea bidhaa au huduma yake. Mwisho wa mchakato - rahisi!</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Features Banner --}}
<section class="py-20 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-gold-400/10 blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] rounded-full bg-emerald-400/10 blur-[80px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="animate-fade-up delay-1 text-center p-8 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/10">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Haraka</h3>
                <p class="text-emerald-200/80">Malipo yanafika kwa sekunde chache tu.</p>
            </div>
            <div class="animate-fade-up delay-2 text-center p-8 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/10">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-gold-400 to-gold-500 flex items-center justify-center mb-6 shadow-lg shadow-gold-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Salama</h3>
                <p class="text-emerald-200/80">Ulinzi wa kiwango cha benki kwa kila muamala.</p>
            </div>
            <div class="animate-fade-up delay-3 text-center p-8 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/10">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Rahisi</h3>
                <p class="text-emerald-200/80">Mchakato rahisi bila hatua nyingi za ziada.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 md:py-28 bg-gradient-to-b from-white to-emerald-50">
    <div class="max-w-5xl 2xl:max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="animate-fade-up relative p-10 md:p-16 xl:p-20 rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-700 overflow-hidden text-center shadow-2xl shadow-emerald-500/30">
            <div class="absolute top-0 right-0 w-[300px] h-[300px] rounded-full bg-gold-400/20 blur-[80px]"></div>
            <div class="absolute bottom-0 left-0 w-[200px] h-[200px] rounded-full bg-emerald-400/20 blur-[60px]"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white mb-4">Anza Kutumia SalamaPay Leo</h2>
                <p class="text-lg md:text-xl xl:text-2xl text-emerald-100/80 max-w-2xl xl:max-w-3xl mx-auto mb-8 xl:mb-10">Jiunge na maelfu ya biashara zinazotumia SalamaPay kupokea malipo kwa urahisi. Usajili ni bure!</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="group inline-flex items-center gap-2 xl:gap-3 px-8 py-4 xl:px-10 xl:py-5 text-base xl:text-lg font-bold text-emerald-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-xl shadow-xl shadow-gold-500/30 hover:shadow-gold-500/40 transition-all duration-300 hover:-translate-y-0.5">
                        Jiandikishe Bure
                        <svg class="w-5 h-5 xl:w-6 xl:h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 xl:gap-3 px-8 py-4 xl:px-10 xl:py-5 text-base xl:text-lg font-semibold text-white border border-white/30 hover:border-white/60 rounded-xl backdrop-blur-sm transition-all hover:-translate-y-0.5">
                        Wasiliana Nasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
@include('frontend.partials.footer')

<script>
document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',e=>{e.preventDefault();const t=document.querySelector(a.getAttribute('href'));if(t){window.scrollTo({top:t.getBoundingClientRect().top+window.pageYOffset-80,behavior:'smooth'})}})});
</script>
</body>
</html>
