{{-- Footer --}}
<footer id="contact" class="border-t border-white/5 py-16 bg-salama-darker">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-salama-gold to-salama-accent flex items-center justify-center">
                    <img src="{{ asset('icons8-logo-32.png') }}" alt="Salamapay" class="w-5 h-5">
                </div>
                <span class="text-lg font-black">Salama<span class="text-salama-gold">pay</span></span>
            </div>
            <div class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Salamapay. All rights reserved.
            </div>
            <div class="flex items-center gap-6 text-sm text-gray-500">
                <a href="#" class="hover:text-white transition-colors">Privacy</a>
                <a href="#" class="hover:text-white transition-colors">Terms</a>
                <a href="#" class="hover:text-white transition-colors">Support</a>
            </div>
        </div>
    </div>
</footer>
