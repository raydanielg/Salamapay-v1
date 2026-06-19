{{-- Header / Navbar --}}
<nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" style="background: rgba(0,0,0,0.9); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(16,185,129,0.1);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sp-green to-sp-green-dark flex items-center justify-center shadow-lg shadow-sp-green/20 group-hover:shadow-sp-green/40 transition-all animate-glow">
                    <img src="{{ asset('icons8-logo-32.png') }}" alt="Salamapay" class="w-6 h-6">
                </div>
                <span class="text-xl font-black tracking-tight">Salama<span class="text-sp-green">pay</span></span>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="#about" class="px-4 py-2 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">About</a>
                <a href="#features" class="px-4 py-2 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Features</a>
                <a href="#payments" class="px-4 py-2 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Payments</a>
                <a href="#pricing" class="px-4 py-2 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Pricing</a>
                <a href="#developers" class="px-4 py-2 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Developers</a>
                <a href="#contact" class="px-4 py-2 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Contact</a>
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden lg:flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="px-5 py-2.5 text-sm font-semibold bg-gradient-to-r from-sp-green to-sp-green-dark rounded-xl hover:shadow-lg hover:shadow-sp-green/30 transition-all text-white">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-medium text-gray-400 hover:text-sp-green transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold bg-gradient-to-r from-sp-green to-sp-green-dark rounded-xl hover:shadow-lg hover:shadow-sp-green/30 transition-all text-white">
                                Get Started
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobileMenuBtn" class="lg:hidden p-2 text-gray-400 hover:text-sp-green">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="lg:hidden hidden pb-4">
            <div class="flex flex-col gap-2">
                <a href="#about" class="px-4 py-3 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">About</a>
                <a href="#features" class="px-4 py-3 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Features</a>
                <a href="#payments" class="px-4 py-3 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Payments</a>
                <a href="#pricing" class="px-4 py-3 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Pricing</a>
                <a href="#developers" class="px-4 py-3 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Developers</a>
                <a href="#contact" class="px-4 py-3 text-sm text-gray-400 hover:text-sp-green hover:bg-sp-green/5 rounded-lg transition-all">Contact</a>
                <div class="flex gap-3 pt-3 border-t border-sp-border">
                    <a href="{{ route('login') }}" class="flex-1 px-4 py-2.5 text-sm font-medium text-center text-gray-400 border border-sp-border rounded-xl hover:bg-sp-green/5 transition-all">Log in</a>
                    <a href="{{ route('register') }}" class="flex-1 px-4 py-2.5 text-sm font-semibold text-center bg-gradient-to-r from-sp-green to-sp-green-dark rounded-xl text-white">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('mobileMenuBtn').addEventListener('click', function() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
});
</script>
