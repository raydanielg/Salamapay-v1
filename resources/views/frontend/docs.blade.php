<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documentation - SalamaPay</title>
    <meta name="description" content="SalamaPay API documentation and guides.">
    <meta property="og:site_name" content="SalamaPay">
    <meta name="twitter:card" content="summary_large_image">
    @if($doc)
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $doc->title }} — SalamaPay Docs">
    <meta property="og:description" content="{{ strip_tags(Illuminate\Support\Str::markdown($doc->content)) }}">
    <meta property="og:url" content="{{ route('docs', $doc->slug) }}">
    <meta property="og:updated_time" content="{{ $doc->updated_at->toIso8601String() }}">
    <meta name="twitter:title" content="{{ $doc->title }} — SalamaPay Docs">
    <meta name="twitter:description" content="{{ strip_tags(Illuminate\Support\Str::markdown($doc->content)) }}">
    <meta name="doc-title" content="{{ $doc->title }}">
    <meta name="doc-slug" content="{{ $doc->slug }}">
    <meta name="doc-category" content="{{ $doc->category }}">
    <meta name="doc-updated" content="{{ $doc->updated_at->toIso8601String() }}">
    <link rel="alternate" type="application/json" href="{{ url('/api/docs/' . $doc->slug) }}" title="{{ $doc->title }} — JSON">
    @php
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'TechArticle',
        'headline' => $doc->title,
        'description' => strip_tags(Illuminate\Support\Str::markdown($doc->content)),
        'url' => route('docs', $doc->slug),
        'dateModified' => $doc->updated_at->toIso8601String(),
        'author' => ['@type' => 'Organization', 'name' => 'SalamaPay'],
        'publisher' => ['@type' => 'Organization', 'name' => 'SalamaPay'],
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => route('docs', $doc->slug)],
        'isAccessibleForFree' => true,
        'educationalLevel' => 'developer',
        'genre' => ucfirst(str_replace('_', ' ', $doc->category)),
    ];
    @endphp
    <script type="application/ld+json">
{!! json_encode($ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @endif
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
        .docs-sidebar::-webkit-scrollbar { width: 5px; }
        .docs-sidebar::-webkit-scrollbar-track { background: transparent; }
        .docs-sidebar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .docs-content h1 { font-size: 2.25rem; font-weight: 800; color: #111827; margin-bottom: 1.5rem; line-height: 1.2; }
        .docs-content h2 { font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 2.5rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb; }
        .docs-content h3 { font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-top: 2rem; margin-bottom: 0.75rem; }
        .docs-content p { color: #4b5563; line-height: 1.75; margin-bottom: 1.25rem; }
        .docs-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #4b5563; }
        .docs-content ul li { margin-bottom: 0.5rem; }
        .docs-content code { background: #f3f4f6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-family: monospace; font-size: 0.875rem; color: #024938; }
        .docs-content pre { background: #1f2937; padding: 1.25rem; border-radius: 0.75rem; overflow-x: auto; margin-bottom: 1.5rem; }
        .docs-content pre code { background: transparent; color: #e5e7eb; padding: 0; }
        .docs-content blockquote { border-left: 4px solid #f9ac00; padding-left: 1rem; color: #4b5563; font-style: italic; margin-bottom: 1.25rem; }
        .docs-content a { color: #024938; font-weight: 600; text-decoration: underline; }
        .docs-content table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        .docs-content th { background: #f9fafb; padding: 0.75rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; }
        .docs-content td { padding: 0.75rem; border-bottom: 1px solid #e5e7eb; color: #4b5563; }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')
@include('frontend.partials.page-loader')

{{-- Main Layout --}}
<div class="pt-[68px] min-h-screen flex">

    {{-- Mobile Sidebar Toggle --}}
    <button id="docsSidebarToggle" type="button" class="lg:hidden fixed bottom-6 right-6 z-50 w-12 h-12 bg-emerald-600 text-white rounded-full shadow-lg flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>

    {{-- Sidebar --}}
    <aside id="docsSidebar" class="docs-sidebar fixed lg:sticky top-[68px] left-0 z-40 w-72 h-[calc(100vh-68px)] bg-gray-50 border-r border-gray-200 overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="p-6">
            {{-- Search --}}
            <div class="relative mb-6">
                <input type="text" placeholder="Search docs..." class="w-full px-4 py-2 pl-9 text-sm bg-white border border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Nav --}}
            <nav class="space-y-1">
                @forelse($allPages as $category => $catPages)
                <div class="mb-4">
                    <button class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-gray-900 rounded-lg hover:bg-gray-100 transition-colors group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        {{ ucfirst(str_replace('_', ' ', $category)) }}
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="ml-3 mt-1 space-y-1">
                        @foreach($catPages as $pg)
                        <a href="{{ route('docs', $pg->slug) }}" class="block px-3 py-1.5 text-sm {{ $currentSlug == $pg->slug ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">{{ $pg->title }}</a>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-xs text-gray-400">No docs yet</p>
                </div>
                @endforelse
            </nav>
        </div>
    </aside>

    {{-- Mobile Sidebar Overlay --}}
    <div id="docsSidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="document.getElementById('docsSidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>

    {{-- Content Area --}}
    <main class="flex-1 min-w-0">
        <div class="max-w-4xl mx-auto px-6 py-10 lg:px-12">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <span>Docs</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-emerald-600 font-medium">{{ $doc?->title ?? 'Documentation' }}</span>
            </div>

            {{-- Content --}}
            @if($doc)
            <div class="flex items-center gap-2 mb-6">
                <button type="button" onclick="copyDocMd()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Copy Markdown
                </button>
                <a href="{{ url('/api/docs/' . $doc->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    JSON
                </a>
                <a href="{{ url('/docs/export.md') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export .md
                </a>
            </div>
            @endif

            <div class="docs-content">
                @if($doc)
                    {!! Illuminate\Support\Str::markdown($doc->content) !!}
                @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h2 class="text-lg font-bold text-gray-900 mb-1">No Documentation Yet</h2>
                    <p class="text-sm text-gray-500">Check back soon or visit our <a href="{{ route('support') }}" class="text-emerald-600 hover:underline">Support Center</a>.</p>
                </div>
                @endif
            </div>

            {{-- Footer Nav --}}
            <div class="mt-16 pt-8 border-t border-gray-100 flex items-center justify-between">
                @php
                    $flatPages = $allPages->flatten();
                    $currentIndex = $flatPages->search(fn($p) => $p->slug === $currentSlug);
                    $prevPage = $currentIndex > 0 ? $flatPages[$currentIndex - 1] : null;
                    $nextPage = $currentIndex !== false && $currentIndex < $flatPages->count() - 1 ? $flatPages[$currentIndex + 1] : null;
                @endphp
                @if($prevPage)
                <a href="{{ route('docs', $prevPage->slug) }}" class="text-sm text-gray-500 hover:text-emerald-600 transition-colors">&larr; {{ $prevPage->title }}</a>
                @else
                <span></span>
                @endif
                @if($nextPage)
                <a href="{{ route('docs', $nextPage->slug) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">{{ $nextPage->title }} &rarr;</a>
                @else
                <span></span>
                @endif
            </div>
        </div>
    </main>

    {{-- Right Sidebar - On this page (desktop only) --}}
    <aside class="hidden xl:block w-64 sticky top-[68px] h-[calc(100vh-68px)] border-l border-gray-200 overflow-y-auto p-6">
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">On this page</div>
        <nav class="space-y-2">
            <a href="#" class="block text-sm text-gray-500 hover:text-emerald-600 transition-colors">Overview</a>
            @if($doc)
            <a href="#" class="block text-sm text-gray-500 hover:text-emerald-600 transition-colors">{{ $doc->title }}</a>
            @endif
        </nav>
    </aside>
</div>

<script>
// Mobile sidebar toggle
document.getElementById('docsSidebarToggle').addEventListener('click', function() {
    var sidebar = document.getElementById('docsSidebar');
    var overlay = document.getElementById('docsSidebarOverlay');
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
});

function copyDocMd() {
    const title = document.querySelector('meta[name="doc-title"]')?.content || 'Documentation';
    const slug = document.querySelector('meta[name="doc-slug"]')?.content || '';
    const category = document.querySelector('meta[name="doc-category"]')?.content || 'general';
    const contentEl = document.querySelector('.docs-content');
    // Convert HTML content back to approximate markdown
    let text = contentEl ? contentEl.innerText : '';
    const md = '# ' + title + '\n\n'
        + '**Category:** ' + category + '\n'
        + '**Slug:** `' + slug + '`\n'
        + '**URL:** ' + window.location.href + '\n\n---\n\n'
        + text + '\n';
    navigator.clipboard.writeText(md).then(() => {
        alert('Markdown copied to clipboard!');
    }).catch(() => {
        const ta = document.createElement('textarea'); ta.value = md; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta); alert('Markdown copied!');
    });
}
</script>

</body>
</html>
