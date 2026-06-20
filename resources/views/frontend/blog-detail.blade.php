<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $blog->title }} - SalamaPay Blog</title>
    <meta name="description" content="{{ $blog->excerpt }}">
    <meta name="keywords" content="{{ $blog->category }}, digital payments, fintech, Tanzania, SalamaPay, mobile money, M-Pesa">
    <meta name="author" content="{{ $blog->author }}">
    <meta name="robots" content="index, follow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ $blog->excerpt }}">
    <meta property="og:image" content="{{ $blog->image ? asset($blog->image) : asset('images/og-default.png') }}">
    <meta property="og:site_name" content="SalamaPay Blog">
    <meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
    <meta property="article:author" content="{{ $blog->author }}">
    <meta property="article:section" content="{{ $blog->category }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $blog->title }}">
    <meta name="twitter:description" content="{{ $blog->excerpt }}">
    <meta name="twitter:image" content="{{ $blog->image ? asset($blog->image) : asset('images/og-default.png') }}">
    <meta name="twitter:site" content="@SalamaPay">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">
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
        @keyframes shake { 0%,100%{transform:translateX(0)} 10%,30%,50%,70%,90%{transform:translateX(-4px)} 20%,40%,60%,80%{transform:translateX(4px)} }
        @keyframes pop { 0%{transform:scale(0.8);opacity:0} 50%{transform:scale(1.05)} 100%{transform:scale(1);opacity:1} }
        @keyframes slide-in { 0%{transform:translateY(20px);opacity:0} 100%{transform:translateY(0);opacity:1} }
        @keyframes pulse-green { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,0.4)} 50%{box-shadow:0 0 0 10px rgba(16,185,129,0)} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .animate-shake { animation: shake 0.5s ease-in-out; }
        .animate-pop { animation: pop 0.4s cubic-bezier(0.34,1.56,0.64,1) both; }
        .animate-slide-in { animation: slide-in 0.5s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
        .docs-content h2 { font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 2.5rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb; }
        .docs-content h3 { font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-top: 2rem; margin-bottom: 0.75rem; }
        .docs-content p { color: #4b5563; line-height: 1.75; margin-bottom: 1.25rem; }
        .docs-content strong, .docs-content b { color: #111827; font-weight: 700; }
        .docs-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #4b5563; }
        .docs-content ul li { margin-bottom: 0.5rem; }
        .docs-content img { border-radius: 0.75rem; margin: 1.5rem 0; max-width: 100%; height: auto; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .docs-content blockquote { border-left: 4px solid #f9ac00; padding-left: 1rem; color: #4b5563; font-style: italic; margin-bottom: 1.25rem; }
        .docs-content table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        .docs-content th { background: #f9fafb; padding: 0.75rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; }
        .docs-content td { padding: 0.75rem; border-bottom: 1px solid #e5e7eb; color: #4b5563; }
        .share-btn { transition: all 0.2s cubic-bezier(0.4,0,0.2,1); }
        .share-btn:hover { transform: translateY(-2px); }
        .share-btn:active { transform: scale(0.95); }
        .newsletter-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .newsletter-error { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')
@include('frontend.partials.page-loader')

{{-- Article Header --}}
<section class="relative pt-[68px] pb-12 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <div class="animate-fade-up delay-1 flex items-center gap-3 mb-6">
            <a href="{{ route('blog') }}" class="text-emerald-200 hover:text-white text-sm font-medium transition-colors">&larr; Back to Blog</a>
        </div>
        <span class="inline-flex px-3 py-1 text-xs font-bold {{ in_array($blog->category, ['Product','Security','Tips']) ? 'text-gold-700 bg-gold-100' : 'text-emerald-700 bg-emerald-100' }} rounded-full mb-4">{{ $blog->category }}</span>
        <h1 class="animate-fade-up delay-2 text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">{{ $blog->title }}</h1>
        <div class="animate-fade-up delay-2 flex items-center gap-4 text-emerald-100/80 text-sm">
            <span>{{ $blog->published_at->format('M d, Y') }}</span>
            <span>&middot;</span>
            <span>{{ $blog->read_time }}</span>
            <span>&middot;</span>
            <span>By {{ $blog->author }}</span>
        </div>
    </div>
</section>

{{-- Featured Image --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="rounded-2xl overflow-hidden shadow-2xl">
        @if($blog->image)
        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-64 md:h-80 object-cover">
        @else
        <div class="w-full h-64 md:h-80 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
            <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        @endif
    </div>
</div>

{{-- Article Content --}}
<article class="py-12 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="animate-fade-up delay-1 docs-content prose prose-lg max-w-none">
            {!! Illuminate\Support\Str::markdown($blog->content) !!}
        </div>

        {{-- Social Share --}}
        <div class="animate-fade-up delay-2 mt-12 pt-8 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-sm font-semibold text-gray-700 mb-3 block">Share this article</span>
                    <div class="flex items-center gap-2">
                        @php
                            $shareUrl = urlencode(url()->current());
                            $shareTitle = urlencode($blog->title);
                        @endphp
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="share-btn w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-sm hover:shadow-md" title="Share on WhatsApp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.13 1.588 5.931L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="share-btn w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-sm hover:shadow-md" title="Share on Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        {{-- Twitter/X --}}
                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}&via=SalamaPay" target="_blank" rel="noopener" class="share-btn w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center shadow-sm hover:shadow-md" title="Share on X/Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        {{-- LinkedIn --}}
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" class="share-btn w-10 h-10 rounded-xl bg-blue-700 text-white flex items-center justify-center shadow-sm hover:shadow-md" title="Share on LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        {{-- Telegram --}}
                        <a href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" class="share-btn w-10 h-10 rounded-xl bg-sky-500 text-white flex items-center justify-center shadow-sm hover:shadow-md" title="Share on Telegram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        </a>
                        {{-- Copy Link --}}
                        <button onclick="copyLink()" class="share-btn w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center shadow-sm hover:bg-gray-200" title="Copy link">
                            <svg id="copy-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg id="check-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </div>
                <a href="{{ route('blog') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to all articles
                </a>
            </div>
        </div>
    </div>
</article>

{{-- Newsletter Subscription --}}
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
                <input type="hidden" name="source" value="blog_detail">
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

{{-- Related Posts --}}
@php
$relatedBlogs = \App\Models\Blog::where('id', '!=', $blog->id)->latest('published_at')->take(3)->get();
@endphp
@if($relatedBlogs->count() > 0)
<section class="py-16 bg-gradient-to-b from-white to-emerald-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">More Articles</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($relatedBlogs as $related)
            <a href="{{ route('blog-detail', $related->slug) }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all">
                <div class="h-40 overflow-hidden">
                    @if($related->image)
                    <img src="{{ asset($related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <span class="text-xs text-gray-400">{{ $related->published_at->format('M d, Y') }}</span>
                    <h3 class="font-bold text-gray-900 mt-1 group-hover:text-emerald-600 transition-colors line-clamp-2">{{ $related->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
    </div>
</footer>

<script>
    // Copy link
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            document.getElementById('copy-icon').classList.add('hidden');
            document.getElementById('check-icon').classList.remove('hidden');
            setTimeout(function() {
                document.getElementById('copy-icon').classList.remove('hidden');
                document.getElementById('check-icon').classList.add('hidden');
            }, 2000);
        });
    }

    // Newsletter AJAX
    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const email = document.getElementById('newsletterEmail');
        const btn = document.getElementById('newsletterBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const msg = document.getElementById('newsletterMessage');

        // Reset
        msg.className = 'mt-3 text-sm min-h-[20px]';
        msg.textContent = '';
        email.classList.remove('animate-shake', 'border-red-400', 'ring-red-200');

        // Validate
        if (!email.value || !email.value.includes('@')) {
            email.classList.add('animate-shake', 'border-red-400', 'ring-red-200');
            msg.textContent = 'Please enter a valid email address.';
            msg.className = 'mt-3 text-sm min-h-[20px] text-red-600 font-medium';
            setTimeout(() => email.classList.remove('animate-shake'), 500);
            return;
        }

        // Loading state
        btn.disabled = true;
        btnText.textContent = 'Subscribing...';
        btnSpinner.classList.remove('hidden');
        btn.classList.add('opacity-75');

        fetch('{{ route("newsletter.subscribe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
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
                msg.className = 'mt-3 text-sm min-h-[20px] text-emerald-600 font-medium animate-pop';
                email.value = '';
                btnText.textContent = 'Subscribed!';
                btn.classList.remove('from-emerald-500', 'to-emerald-600');
                btn.classList.add('from-emerald-600', 'to-emerald-700');
            } else {
                throw new Error(data.message || 'Something went wrong.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btnText.textContent = 'Subscribe';
            btnSpinner.classList.add('hidden');
            btn.classList.remove('opacity-75');
            msg.textContent = err.message;
            msg.className = 'mt-3 text-sm min-h-[20px] text-red-600 font-medium';
            email.classList.add('animate-shake', 'border-red-400', 'ring-red-200');
            setTimeout(() => email.classList.remove('animate-shake'), 500);
        });
    });
</script>

</body>
</html>
