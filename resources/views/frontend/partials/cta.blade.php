{{-- Call To Action Section --}}
<section class="py-24 bg-salama-dark relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-salama-gold/8 rounded-full blur-[120px]"></div>
    <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative">
        <h2 class="text-4xl md:text-6xl font-black mb-6">Ready to Get <span class="gradient-text">Started</span>?</h2>
        <p class="text-gray-400 text-lg mb-10 max-w-2xl mx-auto">Join millions of users who trust Salamapay for their daily transactions. Start your financial journey today.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 text-base font-bold bg-gradient-to-r from-salama-gold to-salama-gold-dark rounded-xl hover:shadow-xl hover:shadow-salama-gold/30 hover:scale-105 transition-all text-salama-darker text-center">Create Free Account</a>
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-4 text-base font-medium border border-white/10 rounded-xl hover:bg-white/5 hover:border-salama-gold/30 transition-all text-center">Already have an account? Sign In</a>
        </div>
    </div>
</section>
