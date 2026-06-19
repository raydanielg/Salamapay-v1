<header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <nav class="max-w-screen-xl mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[68px]">
            <a href="/" class="flex items-center flex-shrink-0">
                <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-14 w-auto object-contain">
            </a>
            <div class="hidden md:flex items-center space-x-1">
                <a href="/" class="px-4 py-2 text-sm font-medium text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Home</a>
                <a href="{{ route('pricing') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">Pricing</a>
                <a href="{{ route('docs') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">Docs</a>
                <a href="{{ route('about') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">About</a>
                <div class="relative group">
                    <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-1">
                        More
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-40 py-1 bg-white rounded-xl shadow-lg border border-gray-100 hidden group-hover:block">
                        <a href="{{ route('blog') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Blog</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Careers</a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Contact</a>
                        <a href="{{ route('support') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Support</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="tel:+255000000000" class="hidden lg:inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 hover:border-emerald-300 rounded-md transition-all duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Talk to sales
                </a>
                <button id="langToggle" class="hidden lg:flex items-center gap-1 px-2 py-1.5 text-xs font-medium text-gray-600 hover:text-emerald-600 rounded-md hover:bg-gray-50 transition-colors" onclick="toggleLang()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="langLabel">EN</span>
                </button>
                <a href="{{ route('login') }}" class="px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm hover:shadow-md transition-all duration-200">
                    Get Started
                </a>
                <button id="mobileMenuToggle" type="button" class="md:hidden p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors ml-1">
                    <svg class="w-5 h-5" id="menu-open-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-5 h-5 hidden" id="menu-close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div class="md:hidden hidden pb-4 border-t border-gray-100 mt-1" id="mobile-menu">
            <div class="pt-3 space-y-1">
                <a href="/" class="block px-4 py-2.5 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg">Home</a>
                <a href="{{ route('pricing') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Pricing</a>
                <a href="{{ route('docs') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Docs</a>
                <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">About</a>
                <div class="px-4 py-1">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">More</div>
                    <a href="{{ route('blog') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Blog</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Careers</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Contact</a>
                    <a href="{{ route('support') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Support</a>
                </div>
                <div class="pt-2 border-t border-gray-100 flex items-center gap-2 px-1">
                    <a href="tel:+255000000000" class="flex-1 text-center py-2 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md hover:bg-emerald-100 transition-colors">Talk to sales</a>
                    <a href="{{ route('login') }}" class="flex-1 text-center py-2 text-xs font-semibold text-white bg-emerald-600 rounded-md hover:bg-emerald-700 transition-colors">Get Started</a>
                </div>
            </div>
        </div>
    </nav>
</header>
<script>
(function(){var t=document.getElementById('mobileMenuToggle'),m=document.getElementById('mobile-menu'),o=document.getElementById('menu-open-icon'),c=document.getElementById('menu-close-icon');t&&t.addEventListener('click',function(){m.classList.toggle('hidden');o.classList.toggle('hidden');c.classList.toggle('hidden');});m&&m.querySelectorAll('a').forEach(function(l){l.addEventListener('click',function(){m.classList.add('hidden');o.classList.remove('hidden');c.classList.add('hidden');});});var h=document.getElementById('main-header');window.addEventListener('scroll',function(){if(window.scrollY>10){h.classList.add('shadow-md');h.classList.remove('shadow-sm');}else{h.classList.remove('shadow-md');h.classList.add('shadow-sm');}},{passive:true});})();
</script>
