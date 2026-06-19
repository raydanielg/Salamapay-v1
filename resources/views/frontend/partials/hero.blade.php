{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
    {{-- Background Effects --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-salama-gold/8 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[600px] h-[600px] bg-salama-accent/5 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-salama-gold/3 rounded-full blur-[150px]"></div>
    </div>

    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Left Content --}}
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-salama-gold/10 border border-salama-gold/20 text-salama-gold text-sm font-medium mb-6 animate-fade-up">
                    <span class="w-2 h-2 rounded-full bg-salama-gold animate-pulse"></span>
                    Trusted by 2M+ users worldwide
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-tight mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                    <span class="gradient-text">The Future</span><br>
                    <span class="text-white">of Digital</span><br>
                    <span class="gradient-text">Payments</span>
                </h1>

                <p class="text-lg text-gray-400 max-w-xl mb-8 leading-relaxed animate-fade-up" style="animation-delay: 0.2s;">
                    Accept payments globally, send money instantly, and manage your finances with bank-grade security. Built for Africa, trusted worldwide.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start animate-fade-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold bg-gradient-to-r from-salama-gold to-salama-gold-dark rounded-xl hover:shadow-xl hover:shadow-salama-gold/30 hover:scale-105 transition-all text-salama-darker text-center">
                        Start for Free
                    </a>
                    <a href="#how-it-works" class="w-full sm:w-auto px-8 py-4 text-base font-medium border border-white/10 rounded-xl hover:bg-white/5 hover:border-salama-gold/30 transition-all text-center flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        How It Works
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="flex items-center gap-6 mt-10 justify-center lg:justify-start animate-fade-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-5 h-5 text-salama-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Bank-grade security
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-5 h-5 text-salama-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Instant transfers
                    </div>
                </div>
            </div>

            {{-- Right Content - App Preview --}}
            <div class="relative hidden lg:block animate-fade-up" style="animation-delay: 0.3s;">
                <div class="relative mx-auto w-full max-w-md">
                    {{-- Phone Frame --}}
                    <div class="relative bg-gradient-to-b from-salama-card to-salama-dark rounded-[2.5rem] p-4 border border-white/10 shadow-2xl shadow-salama-gold/10">
                        {{-- Screen --}}
                        <div class="bg-salama-darker rounded-[2rem] p-6 overflow-hidden">
                            {{-- App Header --}}
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-salama-gold to-salama-accent flex items-center justify-center">
                                        <img src="{{ asset('icons8-logo-32.png') }}" alt="" class="w-5 h-5">
                                    </div>
                                    <span class="text-sm font-semibold">Salamapay</span>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </div>
                            </div>

                            {{-- Balance Card --}}
                            <div class="bg-gradient-to-br from-salama-gold/20 to-salama-accent/10 rounded-2xl p-5 mb-4 border border-salama-gold/20">
                                <p class="text-xs text-gray-400 mb-1">Total Balance</p>
                                <p class="text-2xl font-bold gradient-text">$24,500.00</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-xs text-salama-accent flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                        +12.5%
                                    </span>
                                    <span class="text-xs text-gray-500">this month</span>
                                </div>
                            </div>

                            {{-- Quick Actions --}}
                            <div class="grid grid-cols-4 gap-3 mb-4">
                                <div class="text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-salama-gold/10 flex items-center justify-center mb-1"><svg class="w-5 h-5 text-salama-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg></div>
                                    <span class="text-[10px] text-gray-400">Send</span>
                                </div>
                                <div class="text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-salama-accent/10 flex items-center justify-center mb-1"><svg class="w-5 h-5 text-salama-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a1 1 0 11-2 0 1 1 0 012 0z"/></svg></div>
                                    <span class="text-[10px] text-gray-400">Receive</span>
                                </div>
                                <div class="text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-blue-500/10 flex items-center justify-center mb-1"><svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg></div>
                                    <span class="text-[10px] text-gray-400">Cards</span>
                                </div>
                                <div class="text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-purple-500/10 flex items-center justify-center mb-1"><svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                                    <span class="text-[10px] text-gray-400">Analytics</span>
                                </div>
                            </div>

                            {{-- Recent Transactions --}}
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Recent</p>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-2 rounded-lg bg-white/5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center"><svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg></div>
                                            <div><p class="text-xs font-medium">Received</p><p class="text-[10px] text-gray-500">from John D.</p></div>
                                        </div>
                                        <span class="text-xs font-semibold text-green-400">+$500</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 rounded-lg bg-white/5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center"><svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg></div>
                                            <div><p class="text-xs font-medium">Sent</p><p class="text-[10px] text-gray-500">to Sarah M.</p></div>
                                        </div>
                                        <span class="text-xs font-semibold text-red-400">-$200</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating Elements --}}
                    <div class="absolute -top-4 -right-4 bg-salama-card border border-salama-gold/20 rounded-xl p-3 shadow-xl animate-float" style="animation-delay: 0s;">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center"><svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            <div><p class="text-xs font-semibold">Payment Sent</p><p class="text-[10px] text-gray-500">$1,250 to vendor</p></div>
                        </div>
                    </div>

                    <div class="absolute -bottom-4 -left-4 bg-salama-card border border-white/10 rounded-xl p-3 shadow-xl animate-float" style="animation-delay: 1.5s;">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-salama-gold/20 flex items-center justify-center"><svg class="w-4 h-4 text-salama-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div><p class="text-xs font-semibold">New Feature</p><p class="text-[10px] text-gray-500">Instant P2P transfers</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
