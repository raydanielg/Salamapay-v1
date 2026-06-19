<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $blog->title }} - SalamaPay Blog</title>
    <meta name="description" content="{{ $blog->excerpt }}">
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
        .docs-content h2 { font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 2.5rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb; }
        .docs-content h3 { font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-top: 2rem; margin-bottom: 0.75rem; }
        .docs-content p { color: #4b5563; line-height: 1.75; margin-bottom: 1.25rem; }
        .docs-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #4b5563; }
        .docs-content ul li { margin-bottom: 0.5rem; }
        .docs-content img { border-radius: 0.75rem; margin: 1.5rem 0; max-width: 100%; height: auto; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .docs-content blockquote { border-left: 4px solid #f9ac00; padding-left: 1rem; color: #4b5563; font-style: italic; margin-bottom: 1.25rem; }
        .docs-content table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        .docs-content th { background: #f9fafb; padding: 0.75rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; }
        .docs-content td { padding: 0.75rem; border-bottom: 1px solid #e5e7eb; color: #4b5563; }
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
            {!! nl2br($blog->content) !!}
        </div>

        {{-- Share --}}
        <div class="animate-fade-up delay-2 mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Share:</span>
                <a href="#" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-emerald-100 flex items-center justify-center text-gray-600 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
            </div>
            <a href="{{ route('blog') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">&larr; Back to all articles</a>
        </div>
    </div>
</article>

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

</body>
</html>
