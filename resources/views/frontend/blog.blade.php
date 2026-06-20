<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - SalamaPay</title>
    <meta name="description" content="SalamaPay blog - News, insights, and updates about digital payments in Africa.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')
@include('frontend.partials.page-loader')

<section class="relative pt-[68px] pb-16 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8 text-center">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-emerald-400/30 text-emerald-100 text-xs font-medium mb-6">
            <span class="text-[10px] font-bold bg-emerald-500 rounded-full text-white px-3 py-1 uppercase tracking-wide">Blog</span>
            <span>Latest Updates</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4">Insights & News</h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto">Stay updated with the latest trends in digital payments, fintech, and business growth.</p>
    </div>
</section>

<section class="py-16 bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach(\App\Models\Blog::latest('published_at')->get() as $index => $blog)
            <article class="animate-fade-up delay-{{ ($index % 3) + 1 }} group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="relative h-48 overflow-hidden">
                    @if($blog->image)
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold {{ in_array($blog->category, ['Product','Security','Tips']) ? 'text-gold-700 bg-gold-50' : 'text-emerald-700 bg-emerald-50' }} rounded-full">{{ $blog->category }}</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <span>{{ $blog->published_at->format('M d, Y') }}</span>
                        <span>&middot;</span>
                        <span>{{ $blog->read_time }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-2">{{ $blog->title }}</h2>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
                    <a href="{{ route('blog-detail', $blog->slug) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
            @endforeach

        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-br from-emerald-50 via-white to-gold-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-8 md:p-10 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mx-auto mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Stay in the loop</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Get the latest fintech insights, payment tips, and SalamaPay updates delivered straight to your inbox. No spam, ever.</p>

            <form id="newsletterForm" class="max-w-md mx-auto">
                @csrf
                <input type="hidden" name="source" value="blog_list">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="email"
                        name="email"
                        id="newsletterEmail"
                        placeholder="Enter your email"
                        required
                        class="flex-1 px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all"
                    >
                    <button
                        type="submit"
                        id="newsletterBtn"
                        class="px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 rounded-xl shadow-lg shadow-emerald-500/25 transition-all active:scale-95 flex items-center justify-center gap-2"
                    >
                        <span id="btnText">Subscribe</span>
                        <svg id="btnSpinner" class="w-4 h-4 hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </div>
                <p id="newsletterMessage" class="mt-3 text-sm min-h-[20px]"></p>
            </form>

            <p class="text-xs text-gray-400 mt-4">Join 2,000+ subscribers. Unsubscribe anytime.</p>
        </div>
    </div>
</section>

<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
    </div>
</footer>

<script>
document.getElementById('newsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const email = document.getElementById('newsletterEmail');
    const btn = document.getElementById('newsletterBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const msg = document.getElementById('newsletterMessage');

    msg.className = 'mt-3 text-sm min-h-[20px]';
    msg.textContent = '';
    email.style.borderColor = '';

    if (!email.value || !email.value.includes('@')) {
        email.style.borderColor = '#f87171';
        msg.textContent = 'Please enter a valid email address.';
        msg.className = 'mt-3 text-sm min-h-[20px] text-red-600 font-medium';
        return;
    }

    btn.disabled = true;
    btnText.textContent = 'Subscribing...';
    btnSpinner.classList.remove('hidden');
    btn.classList.add('opacity-75');

    fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            email: email.value,
            source: form.querySelector('[name="source"]').value
        })
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btnText.textContent = 'Subscribe';
        btnSpinner.classList.add('hidden');
        btn.classList.remove('opacity-75');

        if (data.success) {
            msg.textContent = data.message;
            msg.className = 'mt-3 text-sm min-h-[20px] text-emerald-600 font-medium';
            msg.style.animation = 'pop 0.4s ease';
            email.value = '';
            btnText.textContent = 'Subscribed!';
        } else {
            throw new Error(data.message || 'Something went wrong.');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btnText.textContent = 'Subscribe';
        btnSpinner.classList.add('hidden');
        btn.classList.remove('opacity-75');
        msg.textContent = err.message || 'Network error. Please try again.';
        msg.className = 'mt-3 text-sm min-h-[20px] text-red-600 font-medium';
        email.style.borderColor = '#f87171';
    });
});
</script>

</body>
</html>
