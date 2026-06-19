<section class="relative min-h-[90vh] flex items-center overflow-hidden pt-[68px]" id="hero">
    <div class="absolute inset-0">
        {{-- Base gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700"></div>

        {{-- Glow orbs --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-gold-400/10 blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-emerald-400/10 blur-[100px]"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] rounded-full bg-emerald-300/5 blur-[80px]"></div>

        {{-- Grid lines --}}
        <svg class="absolute inset-0 w-full h-full opacity-15" xmlns="http://www.w3.org/2000/svg">
            <defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="1"/></pattern></defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>

        {{-- Dots pattern --}}
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 30px 30px;"></div>

        {{-- Animated fintech lines --}}
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:rgba(2,73,56,0);"/>
                    <stop offset="50%" style="stop-color:rgba(249,172,0,0.4);"/>
                    <stop offset="100%" style="stop-color:rgba(2,73,56,0);"/>
                </linearGradient>
            </defs>
            <line class="flow-line-h" x1="-10%" y1="20%" x2="110%" y2="20%" stroke="url(#lineGrad)" stroke-width="1"/>
            <line class="flow-line-h delay-1" x1="-10%" y1="35%" x2="110%" y2="35%" stroke="url(#lineGrad)" stroke-width="0.5"/>
            <line class="flow-line-h delay-2" x1="-10%" y1="50%" x2="110%" y2="50%" stroke="url(#lineGrad)" stroke-width="1"/>
            <line class="flow-line-h delay-3" x1="-10%" y1="65%" x2="110%" y2="65%" stroke="url(#lineGrad)" stroke-width="0.5"/>
            <line class="flow-line-h delay-4" x1="-10%" y1="80%" x2="110%" y2="80%" stroke="url(#lineGrad)" stroke-width="0.7"/>
            <path class="wave-path" d="M-100,300 Q200,200 500,300 T1100,300 T1700,300" fill="none" stroke="rgba(249,172,0,0.15)" stroke-width="1"/>
            <path class="wave-path delay-2" d="M-100,450 Q300,350 600,450 T1200,450" fill="none" stroke="rgba(2,73,56,0.12)" stroke-width="1"/>
        </svg>

        {{-- Floating particles --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle" style="top:10%;left:20%;width:4px;height:4px;background:rgba(249,172,0,0.5);border-radius:50%;animation:particle-float 8s ease-in-out infinite;"></div>
            <div class="particle" style="top:25%;left:70%;width:3px;height:3px;background:rgba(2,73,56,0.5);border-radius:50%;animation:particle-float 10s ease-in-out infinite 2s;"></div>
            <div class="particle" style="top:40%;left:40%;width:5px;height:5px;background:rgba(249,172,0,0.4);border-radius:50%;animation:particle-float 12s ease-in-out infinite 4s;"></div>
            <div class="particle" style="top:60%;left:80%;width:3px;height:3px;background:rgba(2,73,56,0.4);border-radius:50%;animation:particle-float 9s ease-in-out infinite 1s;"></div>
            <div class="particle" style="top:75%;left:15%;width:4px;height:4px;background:rgba(249,172,0,0.3);border-radius:50%;animation:particle-float 11s ease-in-out infinite 3s;"></div>
            <div class="particle" style="top:15%;left:55%;width:3px;height:3px;background:rgba(2,73,56,0.3);border-radius:50%;animation:particle-float 7s ease-in-out infinite 5s;"></div>
            <div class="particle" style="top:85%;left:60%;width:4px;height:4px;background:rgba(249,172,0,0.4);border-radius:50%;animation:particle-float 13s ease-in-out infinite 2s;"></div>
            <div class="particle" style="top:50%;left:90%;width:3px;height:3px;background:rgba(2,73,56,0.5);border-radius:50%;animation:particle-float 10s ease-in-out infinite 6s;"></div>
        </div>

        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full"><path fill="white" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path></svg>
        </div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <a href="#" class="animate-fade-up delay-1 inline-flex justify-between items-center py-1 pr-4 pl-1 mb-6 text-xs text-emerald-100 bg-white/10 backdrop-blur-sm border border-emerald-400/30 rounded-full hover:bg-white/15 hover:border-emerald-400/50 transition-all">
                    <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 mr-2 uppercase tracking-wide">New</span>
                    <span class="font-medium" data-en="SalamaPay v1 is live" data-sw="SalamaPay v1 imetoka">SalamaPay v1 is live</span>
                    <svg class="ml-1.5 w-3.5 h-3.5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </a>
                <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    <span data-en="Pay With Ease," data-sw="Lipa kwa">Pay With Ease,</span> <span class="text-gold-300" data-en="Business Receives Fast" data-sw="Urahisi">Business Receives Fast</span>
                </h1>
                <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-xl mx-auto lg:mx-0 mb-8 leading-relaxed">
                    <span data-en="SalamaPay is the bridge between the paying customer and the receiving business. Pay via M-Pesa, Airtel Money, bank or card - everything in one place." data-sw="SalamaPay ni daraja kati ya mteja anayelipa na biashara inayopokea pesa. Lipa kwa M-Pesa, Airtel Money, benki au kadi - kila kitu kimoja.">SalamaPay is the bridge between the paying customer and the receiving business. Pay via M-Pesa, Airtel Money, bank or card - everything in one place.</span>
                </p>
                <div class="animate-fade-up delay-4 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start mb-10">
                    <a href="{{ route('register') }}" class="group inline-flex items-center gap-1 px-4 py-2 text-xs font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-md shadow-lg shadow-gold-500/30 hover:shadow-gold-500/40 transition-all duration-300 hover:-translate-y-0.5">
                        <span data-en="Get Started" data-sw="Anza Sasa">Get Started</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#how-it-works" class="inline-flex items-center gap-1 px-4 py-2 text-xs font-semibold text-white border border-white/30 hover:border-white/60 rounded-md backdrop-blur-sm transition-all hover:-translate-y-0.5">
                        <span data-en="How It Works" data-sw="Jinsi Inavyofanya Kazi">How It Works</span>
                    </a>
                </div>
                <div class="animate-fade-up delay-5 flex flex-wrap items-center gap-4 justify-center lg:justify-start text-emerald-200/70 text-xs">
                    <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Online Payments Only</div>
                    <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>Bank-Level Security</div>
                    <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>Instant Transactions</div>
                </div>
            </div>
            <div class="hidden lg:flex items-center justify-center relative">
                <div class="relative animate-float w-[620px] h-[720px]">
                    <img src="{{ asset('cheerful-excited-woman-reading-very-good-news-her-mobile-phone.png') }}" alt="Happy user" class="absolute inset-0 w-full h-full object-contain object-bottom" style="-webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 60%, rgba(0,0,0,0) 95%); mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 60%, rgba(0,0,0,0) 95%);">
                </div>
            </div>
        </div>
    </div>
</section>
