<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found — SalamaPay</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
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
        body { font-family: 'Nunito', sans-serif; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .animate-float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-6 w-auto">
                <span class="font-bold text-sm text-gray-900 tracking-tight">SalamaPay</span>
            </a>
            <a href="javascript:history.back()" class="text-xs font-medium text-gray-600 hover:text-emerald-600 transition-colors flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Go Back
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 flex items-center justify-center px-4 py-12 sm:py-16">
        <div class="text-center max-w-lg">
            {{-- 404 Graphic --}}
            <div class="mb-8 relative">
                <div class="text-[120px] sm:text-[160px] font-black text-emerald-100 leading-none tracking-tighter select-none">404</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="animate-float">
                        <svg class="w-20 h-20 sm:w-24 sm:h-24 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 tracking-tight">Oops! Page not found</h1>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed max-w-sm mx-auto">The page you're looking for doesn't exist or has been moved. Don't worry, let's get you back on track.</p>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-10">
                <a href="/" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Back to Home
                </a>
                <button onclick="history.back()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold border border-gray-200 bg-white text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Previous Page
                </button>
            </div>

            {{-- Helpful Links --}}
            <div class="bg-white rounded-2xl border p-5 sm:p-6 text-left">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Looking for something else?</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <a href="/" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all group">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Homepage</p>
                            <p class="text-[10px] text-gray-400">Return to landing</p>
                        </div>
                    </a>
                    <a href="{{ route('pricing') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all group">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Pricing</p>
                            <p class="text-[10px] text-gray-400">View our plans</p>
                        </div>
                    </a>
                    <a href="{{ route('support') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all group">
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-8a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Support</p>
                            <p class="text-[10px] text-gray-400">Get help from us</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Contact --}}
            <div class="mt-6 flex items-center justify-center gap-1 text-xs text-gray-400">
                <span>Still stuck?</span>
                <a href="mailto:support@salamapay.com" class="text-emerald-600 hover:text-emerald-700 font-medium">Contact our support team</a>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-[10px] text-gray-400">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
