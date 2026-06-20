<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - SalamaPay')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
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
        @keyframes fadeIn { from { opacity:0 } to { opacity:1 } }
        .animate-fade { animation: fadeIn 0.3s ease-out both; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,0.06); }
        .sidebar-link.active { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-submenu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .sidebar-submenu.open { max-height: 500px; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #01241f; }
        ::-webkit-scrollbar-thumb { background: #024938; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #f9ac00; }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-gray-50 text-slate-800">

    {{-- Mobile Overlay --}}
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="userSidebar" class="fixed top-0 left-0 z-50 w-64 h-screen bg-emerald-900 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
        {{-- Brand --}}
        <div class="h-16 flex items-center px-6 border-b border-emerald-800/50 flex-shrink-0">
            <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-8 w-auto brightness-0 invert">
            <span class="ml-2 text-white font-bold text-sm tracking-wide">MERCHANT</span>
        </div>

        {{-- Menu --}}
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

            {{-- Dashboard --}}
            <div class="sidebar-group">
                <a href="{{ route('user.dashboard') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
            </div>

            {{-- Payments --}}
            <div class="sidebar-group">
                <button onclick="toggleMenu('menu-payments')" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.payments*') || request()->routeIs('user.payment-links*') || request()->routeIs('user.payment-profiles*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Payments</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" id="arrow-payments" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-payments" class="sidebar-submenu pl-11 space-y-0.5 {{ request()->routeIs('user.payments*') || request()->routeIs('user.payment-links*') || request()->routeIs('user.payment-profiles*') ? 'open' : '' }}">
                    <a href="{{ route('user.payments.create') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.payments.create') ? 'text-white font-medium' : '' }}">New Payment</a>
                    <a href="{{ route('user.payments') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.payments') ? 'text-white font-medium' : '' }}">All Payments</a>
                    <a href="{{ route('user.payment-links') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.payment-links*') ? 'text-white font-medium' : '' }}">Payment Links</a>
                    <a href="{{ route('user.payment-profiles') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.payment-profiles*') ? 'text-white font-medium' : '' }}">Payment Profiles</a>
                </div>
            </div>

            {{-- Wallet --}}
            <div class="sidebar-group">
                <button onclick="toggleMenu('menu-wallet')" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.wallet*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Wallet</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" id="arrow-wallet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-wallet" class="sidebar-submenu pl-11 space-y-0.5 {{ request()->routeIs('user.wallet*') ? 'open' : '' }}">
                    <a href="{{ route('user.wallet') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.wallet') ? 'text-white font-medium' : '' }}">Wallet Overview</a>
                    <a href="{{ route('user.wallet.withdraw') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.wallet.withdraw') ? 'text-white font-medium' : '' }}">Withdraw Funds</a>
                </div>
            </div>

            {{-- Settlements --}}
            <div class="sidebar-group">
                <a href="{{ route('user.settlements') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.settlements') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    <span>Settlements</span>
                </a>
            </div>

            {{-- My Business --}}
            <div class="sidebar-group">
                <button onclick="toggleMenu('menu-business')" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.business*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>My Business</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" id="arrow-business" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-business" class="sidebar-submenu pl-11 space-y-0.5 {{ request()->routeIs('user.business*') ? 'open' : '' }}">
                    <a href="{{ route('user.business') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.business') && !request()->routeIs('user.business.banks') ? 'text-white font-medium' : '' }}">Business Profile</a>
                    <a href="{{ route('user.business.banks') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.business.banks') ? 'text-white font-medium' : '' }}">Bank Accounts</a>
                </div>
            </div>

            {{-- API Access --}}
            <div class="sidebar-group">
                <button onclick="toggleMenu('menu-api')" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.api*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <span>API Access</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" id="arrow-api" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-api" class="sidebar-submenu pl-11 space-y-0.5 {{ request()->routeIs('user.api*') ? 'open' : '' }}">
                    <a href="{{ route('user.api') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.api') && !request()->routeIs('user.api.webhooks') ? 'text-white font-medium' : '' }}">API Keys</a>
                    <a href="{{ route('user.api.webhooks') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.api.webhooks') ? 'text-white font-medium' : '' }}">Webhook Configuration</a>
                </div>
            </div>

            {{-- Business Tools --}}
            <div class="sidebar-group">
                <button onclick="toggleMenu('menu-tools')" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.invoices*') || request()->routeIs('user.sales*') || request()->routeIs('user.pos*') || request()->routeIs('user.products*') || request()->routeIs('user.services*') || request()->routeIs('user.tools.settings*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Business Tools</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" id="arrow-tools" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-tools" class="sidebar-submenu pl-11 space-y-0.5 {{ request()->routeIs('user.invoices*') || request()->routeIs('user.sales*') || request()->routeIs('user.pos*') || request()->routeIs('user.products*') || request()->routeIs('user.services*') || request()->routeIs('user.tools.settings*') ? 'open' : '' }}">
                    <a href="{{ route('user.invoices') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.invoices*') ? 'text-white font-medium' : '' }}">Invoices</a>
                    <a href="{{ route('user.sales') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.sales*') ? 'text-white font-medium' : '' }}">Sales</a>
                    <a href="{{ route('user.pos') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.pos*') ? 'text-white font-medium' : '' }}">POS</a>
                    <a href="{{ route('user.products') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.products*') ? 'text-white font-medium' : '' }}">Products</a>
                    <a href="{{ route('user.services') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.services*') ? 'text-white font-medium' : '' }}">Services</a>
                    <a href="{{ route('user.tools.settings') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('user.tools.settings*') ? 'text-white font-medium' : '' }}">Settings</a>
                </div>
            </div>

            {{-- Reports --}}
            <div class="sidebar-group">
                <a href="{{ route('user.reports') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.reports') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Reports</span>
                </a>
            </div>

            {{-- Website Builder --}}
            <div class="sidebar-group">
                <a href="{{ route('user.templates') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.templates*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    <span>Website Builder</span>
                    <span class="ml-auto px-1.5 py-0.5 bg-amber-400/90 text-white text-[9px] font-extrabold uppercase tracking-wide rounded-md shadow-sm">New</span>
                </a>
            </div>

            {{-- Settings --}}
            <div class="sidebar-group">
                <a href="{{ route('user.settings') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('user.settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Settings</span>
                </a>
            </div>

        </div>

        {{-- Bottom User --}}
        <div class="p-4 border-t border-emerald-800/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->first_name ? Auth::user()->first_name . ' ' . Auth::user()->last_name : (Auth::user()->name ?? 'Merchant User') }}</p>
                    <p class="text-xs text-emerald-300/60">Merchant</p>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('user-logout').submit();" class="text-emerald-300/60 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </a>
                <form id="user-logout" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-bold text-gray-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3 sm:gap-4">
                {{-- Search --}}
                <div class="hidden md:flex items-center bg-gray-50 rounded-xl px-3 py-2 border border-gray-200 focus-within:border-emerald-300 focus-within:ring-2 focus-within:ring-emerald-100 transition-all">
                    <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="globalSearch" placeholder="Search transactions..." class="bg-transparent text-sm outline-none w-48 text-gray-700 placeholder-gray-400">
                </div>

                {{-- Notifications --}}
                <div class="relative" id="notifContainer">
                    <button onclick="toggleNotifications()" class="relative p-2 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span id="notifBadge" class="absolute top-1 right-1 w-4 h-4 bg-gold-400 rounded-full text-[8px] font-bold text-white flex items-center justify-center shadow-sm">3</span>
                    </button>

                    {{-- Notification Dropdown --}}
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50 origin-top-right transition-all">
                        <div class="px-4 py-3 border-b border-gray-50 flex items-center justify-between">
                            <h4 class="text-sm font-bold text-gray-900">Notifications</h4>
                            <button onclick="markAllRead()" class="text-[11px] text-emerald-600 font-medium hover:text-emerald-700">Mark all read</button>
                        </div>
                        <div class="max-h-72 overflow-y-auto" id="notifList">
                            {{-- Recent transaction notifications --}}
                            @php
                                $notifTxs = \App\Models\Transaction::where('user_id', auth()->id())->orderBy('processed_at', 'desc')->take(5)->get();
                            @endphp
                            @forelse($notifTxs as $ntx)
                            <div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5
                                    @if($ntx->status === 'success') bg-emerald-100 text-emerald-600
                                    @elseif($ntx->status === 'pending') bg-amber-100 text-amber-600
                                    @else bg-red-100 text-red-600 @endif">
                                    @if($ntx->status === 'success')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @elseif($ntx->status === 'pending')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-900 truncate">
                                        @if($ntx->status === 'success') Payment received
                                        @elseif($ntx->status === 'pending') Payment pending
                                        @else Payment failed @endif
                                    </p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">TSh {{ number_format($ntx->amount) }} from {{ $ntx->customer_name }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $ntx->processed_at?->diffForHumans() }}</p>
                                </div>
                                @if($loop->index < 3)
                                <span class="w-1.5 h-1.5 bg-gold-400 rounded-full shrink-0 mt-2"></span>
                                @endif
                            </div>
                            @empty
                            <div class="px-4 py-8 text-center">
                                <div class="w-12 h-12 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </div>
                                <p class="text-xs text-gray-400">No notifications yet</p>
                            </div>
                            @endforelse
                        </div>
                        <a href="{{ route('user.payments') }}" class="block px-4 py-2.5 border-t border-gray-50 text-xs font-medium text-emerald-600 text-center hover:bg-emerald-50 transition-colors">
                            View all activity
                        </a>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 animate-fade">
            @yield('content')
        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('userSidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        function toggleMenu(id) {
            const menu = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id.replace('menu-', ''));
            menu.classList.toggle('open');
            if (arrow) arrow.classList.toggle('rotate-180');
        }

        // Notification dropdown
        function toggleNotifications() {
            const dd = document.getElementById('notifDropdown');
            dd.classList.toggle('hidden');
        }
        function markAllRead() {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.style.display = 'none';
            const dots = document.querySelectorAll('#notifList .bg-gold-400');
            dots.forEach(d => d.style.display = 'none');
        }
        // Close notification when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('notifContainer');
            if (container && !container.contains(e.target)) {
                document.getElementById('notifDropdown')?.classList.add('hidden');
            }
        });

        // Global search: filter transactions table on dashboard
        (function() {
            const searchInput = document.getElementById('globalSearch');
            if (!searchInput) return;
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const q = this.value.toLowerCase().trim();
                searchTimeout = setTimeout(function() {
                    const rows = document.querySelectorAll('.tx-row');
                    rows.forEach(function(row) {
                        const text = (row.dataset.searchText || row.innerText).toLowerCase();
                        if (!q || text.includes(q)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    // Show/hide no results row if exists
                    const tbody = document.querySelector('table tbody');
                    if (tbody) {
                        const visible = Array.from(rows).filter(r => r.style.display !== 'none');
                        let noRes = document.getElementById('searchNoResults');
                        if (visible.length === 0 && rows.length > 0) {
                            if (!noRes) {
                                noRes = document.createElement('tr');
                                noRes.id = 'searchNoResults';
                                noRes.innerHTML = '<td colspan="6" class="px-5 py-8 text-center text-gray-400"><p class="text-sm font-medium">No transactions match your search</p></td>';
                                tbody.appendChild(noRes);
                            } else {
                                noRes.style.display = '';
                            }
                        } else if (noRes) {
                            noRes.style.display = 'none';
                        }
                    }
                }, 200);
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
