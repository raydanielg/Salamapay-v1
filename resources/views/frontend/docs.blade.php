<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documentation - SalamaPay</title>
    <meta name="description" content="SalamaPay API documentation and guides.">
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
                <div class="mb-4">
                    <button class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-gray-900 rounded-lg hover:bg-gray-100 transition-colors group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        Getting Started
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('docs', 'introduction') }}" class="block px-3 py-1.5 text-sm {{ $page == 'introduction' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Introduction</a>
                        <a href="{{ route('docs', 'quickstart') }}" class="block px-3 py-1.5 text-sm {{ $page == 'quickstart' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Quick Start</a>
                        <a href="{{ route('docs', 'authentication') }}" class="block px-3 py-1.5 text-sm {{ $page == 'authentication' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Authentication</a>
                    </div>
                </div>

                <div class="mb-4">
                    <button class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-gray-900 rounded-lg hover:bg-gray-100 transition-colors group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        Payments
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('docs', 'collect-payments') }}" class="block px-3 py-1.5 text-sm {{ $page == 'collect-payments' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Collect Payments</a>
                        <a href="{{ route('docs', 'payouts') }}" class="block px-3 py-1.5 text-sm {{ $page == 'payouts' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Payouts</a>
                        <a href="{{ route('docs', 'webhooks') }}" class="block px-3 py-1.5 text-sm {{ $page == 'webhooks' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Webhooks</a>
                    </div>
                </div>

                <div class="mb-4">
                    <button class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-gray-900 rounded-lg hover:bg-gray-100 transition-colors group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        API Reference
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('docs', 'api-overview') }}" class="block px-3 py-1.5 text-sm {{ $page == 'api-overview' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Overview</a>
                        <a href="{{ route('docs', 'errors') }}" class="block px-3 py-1.5 text-sm {{ $page == 'errors' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Errors</a>
                        <a href="{{ route('docs', 'pagination') }}" class="block px-3 py-1.5 text-sm {{ $page == 'pagination' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Pagination</a>
                    </div>
                </div>

                <div class="mb-4">
                    <button class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-gray-900 rounded-lg hover:bg-gray-100 transition-colors group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        SDKs
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="ml-3 mt-1 space-y-1 hidden">
                        <a href="{{ route('docs', 'php-sdk') }}" class="block px-3 py-1.5 text-sm {{ $page == 'php-sdk' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">PHP</a>
                        <a href="{{ route('docs', 'js-sdk') }}" class="block px-3 py-1.5 text-sm {{ $page == 'js-sdk' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">JavaScript</a>
                        <a href="{{ route('docs', 'python-sdk') }}" class="block px-3 py-1.5 text-sm {{ $page == 'python-sdk' ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-600 hover:text-emerald-600' }} rounded-lg transition-colors">Python</a>
                    </div>
                </div>
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
                <span class="text-emerald-600 font-medium capitalize">{{ str_replace('-', ' ', $page) }}</span>
            </div>

            {{-- Content --}}
            <div class="docs-content">
                @if($page == 'introduction')
<x-markdown>
# Introduction

Welcome to the SalamaPay API documentation. This guide will help you integrate SalamaPay into your application and start accepting payments in minutes.

## What is SalamaPay?

SalamaPay is a digital payment platform built for African businesses. We enable you to:

- Accept payments via M-Pesa, Airtel Money, and card
- Send payouts to mobile money and bank accounts
- Track transactions in real-time
- Automate reconciliation

## Getting Started

To start using the SalamaPay API, you will need:

1. A SalamaPay account - [Sign up here]({{ route('register') }})
2. API keys from your dashboard
3. Your preferred programming language (we support PHP, JavaScript, Python, and more)

## Base URL

All API requests should be made to:

```
https://api.salamapay.co.tz/v1
```

> All requests must be made over HTTPS. Calls made over plain HTTP will fail.

## Support

Need help? Contact us at [support@salamapay.co.tz](mailto:support@salamapay.co.tz) or visit our [Support Center]({{ route('support') }}).
</x-markdown>

                @elseif($page == 'quickstart')
<x-markdown>
# Quick Start

This guide will walk you through making your first payment with SalamaPay in under 5 minutes.

## Step 1: Get Your API Keys

Log in to your [SalamaPay Dashboard]({{ route('login') }}) and navigate to **Settings > API Keys**. Copy your:

- **Public Key** - Used for client-side operations
- **Secret Key** - Used for server-side operations

> Keep your Secret Key safe. Never expose it in client-side code.

## Step 2: Install the SDK

### PHP (Composer)

```bash
composer require salamapay/salamapay-php
```

### JavaScript (NPM)

```bash
npm install @salamapay/js-sdk
```

## Step 3: Initialize the SDK

```php
use SalamaPay\SalamaPay;

$salamaPay = new SalamaPay([
    'secret_key' => 'sk_test_xxxxxxxxxx',
    'environment' => 'sandbox' // or 'production'
]);
```

## Step 4: Collect a Payment

```php
$payment = $salamaPay->payments->create([
    'amount' => 50000,
    'currency' => 'TZS',
    'provider' => 'mpesa',
    'phone_number' => '255712345678',
    'description' => 'Payment for Order #123'
]);

echo $payment->status; // "pending"
```

That is it! You have just initiated your first payment. Check the [Webhooks]({{ route('docs', 'webhooks') }}) guide to learn how to handle payment confirmations.
</x-markdown>

                @elseif($page == 'authentication')
<x-markdown>
# Authentication

The SalamaPay API uses API keys to authenticate requests. You can view and manage your API keys in the Dashboard.

## API Keys

Your API keys carry many privileges. Keep them secure! Do not share your secret API keys in publicly accessible areas such as GitHub, client-side code, etc.

| Key Type | Usage | Prefix |
|----------|-------|--------|
| Secret Key | Server-side API calls | `sk_` |
| Public Key | Client-side initialization | `pk_` |

## Making Authenticated Requests

Include your secret key in the `Authorization` header of all API requests:

```bash
curl https://api.salamapay.co.tz/v1/payments \
  -H "Authorization: Bearer sk_test_xxxxxxxxxx" \
  -H "Content-Type: application/json"
```

## Test vs Live Keys

- **Test keys** - Prefixed with `sk_test_` or `pk_test_`. Use these for development.
- **Live keys** - Prefixed with `sk_live_` or `pk_live_`. Use these for production.

Test mode payments do not process real money. Use test credentials provided in your dashboard to simulate transactions.
</x-markdown>

                @elseif($page == 'collect-payments')
<x-markdown>
# Collect Payments

Learn how to accept payments from customers using various payment methods.

## Supported Payment Methods

| Method | Type | Fee |
|--------|------|-----|
| M-Pesa | Mobile Money | 0.5% |
| Airtel Money | Mobile Money | 0.5% |
| Halopesa | Mobile Money | 0.5% |
| Mixx by Yas | Mobile Money | 0.5% |
| Visa/Mastercard | Card | 3.0% |

## Initiate a Payment

```php
$payment = $salamaPay->payments->create([
    'amount' => 100000,
    'currency' => 'TZS',
    'provider' => 'mpesa',
    'phone_number' => '255712345678',
    'description' => 'Payment for Invoice #456',
    'metadata' => [
        'order_id' => 'ORDER-123',
        'customer_id' => 'CUST-456'
    ]
]);
```

## Payment Status

After initiating a payment, poll for status or use webhooks:

```php
$status = $salamaPay->payments->getStatus($payment->id);

if ($status === 'success') {
    // Payment completed - fulfill order
} elseif ($status === 'failed') {
    // Payment failed - notify customer
}
```

## Payment Links

Create a shareable payment link without writing code:

```php
$link = $salamaPay->paymentLinks->create([
    'amount' => 50000,
    'currency' => 'TZS',
    'title' => 'Service Payment',
    'redirect_url' => 'https://yourapp.com/thank-you'
]);

echo $link->url; // https://pay.salamapay.co.tz/pl_xxxxxx
```
</x-markdown>

                @elseif($page == 'payouts')
<x-markdown>
# Payouts

Send money to mobile money wallets and bank accounts.

## Send Money to Mobile Money

```php
$payout = $salamaPay->payouts->create([
    'amount' => 50000,
    'currency' => 'TZS',
    'provider' => 'mpesa',
    'phone_number' => '255712345678',
    'reason' => 'Supplier Payment'
]);
```

## Send Money to Bank

```php
$payout = $salamaPay->payouts->create([
    'amount' => 500000,
    'currency' => 'TZS',
    'provider' => 'bank_transfer',
    'bank_code' => 'CRDB',
    'account_number' => '1234567890',
    'account_name' => 'John Doe'
]);
```

## Payout Fees

| Method | Fee |
|--------|-----|
| Mobile Money | TZS 1,500 |
| Bank Transfer | TZS 1,500 |

## Bulk Payouts

Send money to multiple recipients in one request:

```php
$payouts = $salamaPay->payouts->bulkCreate([
    'items' => [
        ['phone_number' => '255712345678', 'amount' => 50000],
        ['phone_number' => '255723456789', 'amount' => 75000],
    ]
]);
```
</x-markdown>

                @elseif($page == 'webhooks')
<x-markdown>
# Webhooks

Webhooks allow SalamaPay to notify your application when events happen in your account.

## Events

We send webhooks for the following events:

| Event | Description |
|-------|-------------|
| `payment.success` | Payment completed successfully |
| `payment.failed` | Payment failed |
| `payout.success` | Payout completed |
| `payout.failed` | Payout failed |

## Setting Up Webhooks

Configure your webhook URL in the Dashboard under **Settings > Webhooks**.

## Webhook Payload

```json
{
  "event": "payment.success",
  "data": {
    "id": "pay_123456789",
    "amount": 50000,
    "currency": "TZS",
    "provider": "mpesa",
    "status": "success",
    "phone_number": "255712345678",
    "created_at": "2026-06-20T10:00:00Z"
  }
}
```

## Verifying Signatures

Verify that webhooks are sent by SalamaPay:

```php
$signature = $_SERVER['HTTP_X_SALAMAPAY_SIGNATURE'];
$payload = file_get_contents('php://input');

$expected = hash_hmac('sha256', $payload, 'whsec_xxxxxxxxxx');

if (!hash_equals($expected, $signature)) {
    http_response_code(400);
    exit('Invalid signature');
}
```
</x-markdown>

                @else
<x-markdown>
# {{ ucfirst(str_replace('-', ' ', $page)) }}

This documentation section is coming soon. We are working hard to provide comprehensive guides for all SalamaPay features.

In the meantime, you can:

- Visit our [Support Center]({{ route('support') }}) for common questions
- Contact us at [support@salamapay.co.tz](mailto:support@salamapay.co.tz)
- Check out the [Quick Start]({{ route('docs', 'quickstart') }}) guide

## Need Help?

Our developer support team is available Monday-Friday, 9AM-6PM EAT.
</x-markdown>
                @endif
            </div>

            {{-- Footer Nav --}}
            <div class="mt-16 pt-8 border-t border-gray-100 flex items-center justify-between">
                @if($page != 'introduction')
                <a href="{{ route('docs', 'introduction') }}" class="text-sm text-gray-500 hover:text-emerald-600 transition-colors">&larr; Introduction</a>
                @else
                <span></span>
                @endif
                <a href="{{ route('docs', 'quickstart') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Quick Start &rarr;</a>
            </div>
        </div>
    </main>

    {{-- Right Sidebar - On this page (desktop only) --}}
    <aside class="hidden xl:block w-64 sticky top-[68px] h-[calc(100vh-68px)] border-l border-gray-200 overflow-y-auto p-6">
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">On this page</div>
        <nav class="space-y-2">
            <a href="#" class="block text-sm text-gray-500 hover:text-emerald-600 transition-colors">Overview</a>
            <a href="#" class="block text-sm text-gray-500 hover:text-emerald-600 transition-colors">Getting Started</a>
            <a href="#" class="block text-sm text-gray-500 hover:text-emerald-600 transition-colors">Authentication</a>
            <a href="#" class="block text-sm text-gray-500 hover:text-emerald-600 transition-colors">API Reference</a>
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
</script>

</body>
</html>
