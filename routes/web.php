<?php

use App\Models\PaymentLink;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Public Payment Link Routes (rate limited)
Route::get('/pay/{slug}', [App\Http\Controllers\PaymentLinkController::class, 'show'])->name('payment.link');
Route::post('/pay/{slug}', [App\Http\Controllers\PaymentLinkController::class, 'process'])->middleware('throttle:10,1')->name('payment.process');
Route::get('/pay/{slug}/success', [App\Http\Controllers\PaymentLinkController::class, 'success'])->name('payment.success');
Route::get('/pay/{slug}/receipt', [App\Http\Controllers\PaymentLinkController::class, 'receipt'])->name('payment.receipt');

// Support Chat Widget (Public)
Route::post('/support/message', [App\Http\Controllers\SupportMessageController::class, 'store'])->name('support.message.store');
Route::get('/support/history', [App\Http\Controllers\SupportMessageController::class, 'history'])->name('support.message.history');

// Newsletter AJAX subscription
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|max:255|unique:newsletter_subscribers,email',
        'name' => 'nullable|string|max:100',
        'source' => 'nullable|string|max:50',
    ]);

    $subscriber = \App\Models\NewsletterSubscriber::create([
        'email' => $validated['email'],
        'name' => $validated['name'] ?? null,
        'source' => $validated['source'] ?? 'blog',
        'ip_address' => $request->ip(),
        'subscribed_at' => now(),
    ]);

    // Notify admin
    $admin = \App\Models\User::where('role', 'admin')->first();
    if ($admin) {
        \Illuminate\Support\Facades\Mail::raw(
            "New Newsletter Subscriber\n\nEmail: {$subscriber->email}\nName: " . ($subscriber->name ?? 'N/A') . "\nSource: {$subscriber->source}\nIP: {$subscriber->ip_address}\nTime: {$subscriber->subscribed_at}",
            function ($message) use ($admin) {
                $message->to($admin->email)
                    ->subject('New Newsletter Subscription - SalamaPay');
            }
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Thank you for subscribing! Check your inbox for confirmation.',
    ]);
})->middleware('throttle:5,1')->name('newsletter.subscribe');

Auth::routes();

Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'showSuccess'])->name('register.success');

Route::get('/receipt/{txId}', [App\Http\Controllers\ReceiptController::class, 'show'])->name('receipt.public');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pricing', function () {
    return view('frontend.pricing');
})->name('pricing');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Route::get('/how-it-works', function () {
    return view('frontend.how-it-works');
})->name('how-it-works');

Route::get('/blog', function () {
    return view('frontend.blog');
})->name('blog');

Route::get('/blog/{blog:slug}', function (\App\Models\Blog $blog) {
    return view('frontend.blog-detail', ['blog' => $blog]);
})->name('blog-detail');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

Route::get('/support', function () {
    return view('frontend.support');
})->name('support');

Route::get('/docs/{page?}', function ($page = 'introduction') {
    $doc = \App\Models\DocumentationPage::published()->where('slug', $page)->first();

    if (!$doc) {
        $doc = \App\Models\DocumentationPage::published()->ordered()->first();
    }

    $allPages = \App\Models\DocumentationPage::published()->ordered()->get()->groupBy('category');

    return view('frontend.docs', ['doc' => $doc, 'allPages' => $allPages, 'currentSlug' => $doc?->slug ?? $page]);
})->name('docs');

// Public Machine-Readable Docs API (CORS-enabled for AI/LLM access)
Route::get('/api/docs', function () {
    $pages = \App\Models\DocumentationPage::published()->ordered()->get();
    return response()->json([
        'meta' => [
            'project' => 'SalamaPay',
            'description' => 'Developer documentation and API reference for SalamaPay payment platform.',
            'version' => '1.0',
            'generated_at' => now()->toDateTimeString(),
            'total_pages' => $pages->count(),
            'formats' => ['json', 'markdown', 'text'],
            'machine_readable' => true,
            'llm_endpoints' => [
                'llms.txt' => url('/llms.txt'),
                'llms_full' => url('/llms-full.txt'),
            ],
        ],
        'pages' => $pages->map(fn($p) => [
            'title' => $p->title,
            'slug' => $p->slug,
            'category' => $p->category,
            'sort_order' => $p->sort_order,
            'is_published' => $p->is_published,
            'updated_at' => $p->updated_at->toDateTimeString(),
            'content' => $p->content,
        ])->toArray(),
    ])->withHeaders([
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        'X-LLM-Compatible' => 'true',
    ]);
});

Route::get('/api/docs/{slug}', function ($slug) {
    $page = \App\Models\DocumentationPage::published()->where('slug', $slug)->first();
    if (!$page) {
        return response()->json(['error' => 'Page not found'], 404);
    }
    return response()->json([
        'meta' => [
            'project' => 'SalamaPay',
            'machine_readable' => true,
            'llm_endpoints' => [
                'llms.txt' => url('/llms.txt'),
                'llms_full' => url('/llms-full.txt'),
            ],
        ],
        'page' => [
            'title' => $page->title,
            'slug' => $page->slug,
            'category' => $page->category,
            'sort_order' => $page->sort_order,
            'updated_at' => $page->updated_at->toDateTimeString(),
            'content' => $page->content,
        ]
    ])->withHeaders([
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        'X-LLM-Compatible' => 'true',
    ]);
});

Route::get('/docs/export.md', function () {
    $pages = \App\Models\DocumentationPage::published()->ordered()->get();
    $markdown = "# SalamaPay Documentation\n\n"
        . "> Complete developer documentation.\n"
        . "> URL: " . url('/api/docs') . "\n"
        . "> Generated: " . now()->toDateTimeString() . "\n\n---\n\n";
    foreach ($pages as $page) {
        $markdown .= "# {$page->title}\n\n"
            . "**Category:** " . ucfirst(str_replace('_', ' ', $page->category)) . "\n"
            . "**Slug:** `{$page->slug}`\n"
            . "**Updated:** " . $page->updated_at->toDateTimeString() . "\n\n"
            . $page->content . "\n\n---\n\n";
    }
    return response($markdown)->header('Content-Type', 'text/markdown; charset=utf-8');
});

// LLM Discovery Standard (llms.txt)
Route::get('/llms.txt', function () {
    $pages = \App\Models\DocumentationPage::published()->ordered()->get();
    $text = "# SalamaPay Developer Documentation\n\n"
        . "> LLM-optimized documentation index for AI training and inference.\n"
        . "> Updated: " . now()->toDateTimeString() . "\n"
        . "> Pages: " . $pages->count() . "\n\n";

    foreach ($pages as $page) {
        $text .= "## {$page->title}\n"
            . "- Slug: `{$page->slug}`\n"
            . "- Category: " . ucfirst(str_replace('_', ' ', $page->category)) . "\n"
            . "- Updated: " . $page->updated_at->toDateTimeString() . "\n"
            . "- JSON: " . url('/api/docs/' . $page->slug) . "\n"
            . "- Web: " . route('docs', $page->slug) . "\n"
            . "- Markdown: " . route('admin.documentation.export', $page->id) . "\n\n";
    }

    $text .= "## Endpoints for Machines\n"
        . "- Full JSON API: " . url('/api/docs') . "\n"
        . "- Single Page JSON: " . url('/api/docs/{slug}') . "\n"
        . "- Full Markdown Export: " . url('/docs/export.md') . "\n"
        . "- Complete LLM Feed: " . url('/llms-full.txt') . "\n";

    return response($text)->header('Content-Type', 'text/plain; charset=utf-8');
});

// LLM Full Content Feed (llms-full.txt) — all docs in one markdown file for AI ingestion
Route::get('/llms-full.txt', function () {
    $pages = \App\Models\DocumentationPage::published()->ordered()->get();
    $text = "# SalamaPay — Complete Developer Documentation for LLMs\n\n"
        . "> This file contains ALL SalamaPay documentation in plain markdown.\n"
        . "> It is designed for AI training, RAG systems, and LLM context windows.\n"
        . "> Project: SalamaPay Payment Platform (Tanzania)\n"
        . "> URL: https://salamapay.com/docs\n"
        . "> API Base: " . url('/api/docs') . "\n"
        . "> Generated: " . now()->toDateTimeString() . "\n"
        . "> Total Pages: " . $pages->count() . "\n"
        . "> Format: Markdown\n"
        . "> License: Open for AI training and indexing\n\n"
        . "---\n\n";

    foreach ($pages as $page) {
        $text .= "# {$page->title}\n\n"
            . "**Category:** " . ucfirst(str_replace('_', ' ', $page->category)) . "\n"
            . "**Slug:** `{$page->slug}`\n"
            . "**Updated:** " . $page->updated_at->toDateTimeString() . "\n"
            . "**URL:** " . route('docs', $page->slug) . "\n\n"
            . $page->content . "\n\n---\n\n";
    }

    return response($text)->header('Content-Type', 'text/plain; charset=utf-8');
});

// Sitemap for search engines and AI crawlers
Route::get('/sitemap.xml', function () {
    $pages = \App\Models\DocumentationPage::published()->ordered()->get();
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
        . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n"
        . '  <url><loc>' . url('/') . '</loc><priority>1.0</priority></url>' . "\n"
        . '  <url><loc>' . route('docs') . '</loc><priority>0.9</priority></url>' . "\n"
        . '  <url><loc>' . url('/api/docs') . '</loc><priority>0.8</priority></url>' . "\n"
        . '  <url><loc>' . url('/llms.txt') . '</loc><priority>0.8</priority></url>' . "\n"
        . '  <url><loc>' . url('/llms-full.txt') . '</loc><priority>0.8</priority></url>' . "\n";

    foreach ($pages as $page) {
        $xml .= '  <url>' . "\n"
            . '    <loc>' . route('docs', $page->slug) . '</loc>' . "\n"
            . '    <lastmod>' . $page->updated_at->toDateString() . '</lastmod>' . "\n"
            . '    <changefreq>weekly</changefreq>' . "\n"
            . '    <priority>0.7</priority>' . "\n"
            . '  </url>' . "\n";
    }

    $xml .= '</urlset>';
    return response($xml)->header('Content-Type', 'application/xml; charset=utf-8');
});

// Admin Dashboard Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Merchants
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    Route::put('/users/{id}/status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('admin.users.status');

    // Payments
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments');
    Route::get('/payments/{id}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');

    // Settlements
    Route::get('/settlements', [App\Http\Controllers\Admin\SettlementController::class, 'index'])->name('admin.settlements');
    Route::put('/settlements/{id}/status', [App\Http\Controllers\Admin\SettlementController::class, 'updateStatus'])->name('admin.settlements.status');

    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');

    // Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('admin.settings.store');

    // KYC Verification
    Route::get('/kyc', [App\Http\Controllers\Admin\KycController::class, 'index'])->name('admin.kyc');
    Route::get('/kyc/{id}', [App\Http\Controllers\Admin\KycController::class, 'show'])->name('admin.kyc.show');
    Route::post('/kyc/{id}/approve', [App\Http\Controllers\Admin\KycController::class, 'approve'])->name('admin.kyc.approve');
    Route::post('/kyc/{id}/reject', [App\Http\Controllers\Admin\KycController::class, 'reject'])->name('admin.kyc.reject');

    // Blog Management
    Route::get('/blogs', [App\Http\Controllers\Admin\BlogManagementController::class, 'index'])->name('admin.blogs');
    Route::get('/blogs/create', [App\Http\Controllers\Admin\BlogManagementController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs', [App\Http\Controllers\Admin\BlogManagementController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/{id}/edit', [App\Http\Controllers\Admin\BlogManagementController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/blogs/{id}', [App\Http\Controllers\Admin\BlogManagementController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/{id}', [App\Http\Controllers\Admin\BlogManagementController::class, 'destroy'])->name('admin.blogs.destroy');

    // Documentation
    Route::get('/documentation', [App\Http\Controllers\Admin\DocumentationController::class, 'index'])->name('admin.documentation');
    Route::get('/documentation/create', [App\Http\Controllers\Admin\DocumentationController::class, 'create'])->name('admin.documentation.create');
    Route::post('/documentation', [App\Http\Controllers\Admin\DocumentationController::class, 'store'])->name('admin.documentation.store');
    Route::get('/documentation/{id}/edit', [App\Http\Controllers\Admin\DocumentationController::class, 'edit'])->name('admin.documentation.edit');
    Route::put('/documentation/{id}', [App\Http\Controllers\Admin\DocumentationController::class, 'update'])->name('admin.documentation.update');
    Route::delete('/documentation/{id}', [App\Http\Controllers\Admin\DocumentationController::class, 'destroy'])->name('admin.documentation.destroy');
    Route::get('/documentation/{id}/export.md', [App\Http\Controllers\Admin\DocumentationController::class, 'exportMarkdown'])->name('admin.documentation.export');
    Route::get('/documentation/export-all.md', [App\Http\Controllers\Admin\DocumentationController::class, 'exportAllMarkdown'])->name('admin.documentation.export-all');

    // Website Templates
    Route::get('/templates', [App\Http\Controllers\Admin\TemplateController::class, 'index'])->name('admin.templates');
    Route::post('/templates', [App\Http\Controllers\Admin\TemplateController::class, 'store'])->name('admin.templates.store');
    Route::put('/templates/{id}', [App\Http\Controllers\Admin\TemplateController::class, 'update'])->name('admin.templates.update');
    Route::delete('/templates/{id}', [App\Http\Controllers\Admin\TemplateController::class, 'destroy'])->name('admin.templates.destroy');
    Route::get('/templates/{id}/users', [App\Http\Controllers\Admin\TemplateController::class, 'users'])->name('admin.templates.users');
});

// User/Merchant Dashboard Routes
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', function () {
        $userId = auth()->id();
        $today = now()->startOfDay();
        $lastWeek = now()->subDays(7)->startOfDay();

        // Stats
        $totalBalance = Transaction::where('user_id', $userId)->where('status', 'success')->sum('amount');
        $lastWeekBalance = Transaction::where('user_id', $userId)->where('status', 'success')->whereBetween('processed_at', [$lastWeek, $today])->sum('amount');
        $balanceChange = $lastWeekBalance > 0 ? round((($totalBalance - $lastWeekBalance) / $lastWeekBalance) * 100, 1) : 0;

        $totalTransactions = Transaction::where('user_id', $userId)->count();
        $lastWeekTransactions = Transaction::where('user_id', $userId)->whereBetween('processed_at', [$lastWeek, $today])->count();
        $txChange = $lastWeekTransactions > 0 ? round((($totalTransactions - $lastWeekTransactions) / $lastWeekTransactions) * 100, 1) : 0;

        $activePaymentLinks = PaymentLink::where('user_id', $userId)->where('is_active', true)->count();
        $newPaymentLinks = PaymentLink::where('user_id', $userId)->where('is_active', true)->where('created_at', '>=', $today->subDays(7))->count();

        $revenueToday = Transaction::where('user_id', $userId)->where('status', 'success')->whereDate('processed_at', $today)->sum('amount');
        $revenueYesterday = Transaction::where('user_id', $userId)->where('status', 'success')->whereDate('processed_at', $today->copy()->subDay())->sum('amount');
        $todayChange = $revenueYesterday > 0 ? round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100, 1) : 0;

        // Revenue by day (last 7 days)
        $revenueDays = [];
        $volumeDays = [];
        $dayLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayLabels[] = $date->format('D');
            $revenue = Transaction::where('user_id', $userId)->where('status', 'success')->whereDate('processed_at', $date)->sum('amount');
            $volume = Transaction::where('user_id', $userId)->whereDate('processed_at', $date)->count();
            $revenueDays[] = $revenue;
            $volumeDays[] = $volume;
        }

        $weeklyRevenue = array_sum($revenueDays);
        $weeklyRevenueChange = $revenueDays[0] > 0 ? round((($revenueDays[6] - $revenueDays[0]) / $revenueDays[0]) * 100, 1) : 0;

        // Recent transactions
        $recentTransactions = Transaction::where('user_id', $userId)->orderBy('processed_at', 'desc')->take(10)->get();

        return view('user.dashboard', compact(
            'totalBalance', 'balanceChange',
            'totalTransactions', 'txChange',
            'activePaymentLinks', 'newPaymentLinks',
            'revenueToday', 'todayChange',
            'weeklyRevenue', 'weeklyRevenueChange',
            'revenueDays', 'volumeDays', 'dayLabels',
            'recentTransactions'
        ));
    })->name('user.dashboard');

    // Payments
    Route::get('/payments', [App\Http\Controllers\User\PaymentController::class, 'index'])->name('user.payments');
    Route::get('/payments/create', [App\Http\Controllers\User\PaymentController::class, 'create'])->name('user.payments.create');
    Route::get('/payments/{id}', [App\Http\Controllers\User\PaymentController::class, 'show'])->name('user.payments.show');

    // Payment Profiles
    Route::get('/payment-profiles', [App\Http\Controllers\User\PaymentProfileController::class, 'index'])->name('user.payment-profiles');
    Route::post('/payment-profiles', [App\Http\Controllers\User\PaymentProfileController::class, 'store'])->name('user.payment-profiles.store');
    Route::put('/payment-profiles/{id}', [App\Http\Controllers\User\PaymentProfileController::class, 'update'])->name('user.payment-profiles.update');
    Route::delete('/payment-profiles/{id}', [App\Http\Controllers\User\PaymentProfileController::class, 'destroy'])->name('user.payment-profiles.destroy');

    // Payment Links
    Route::get('/payment-links', [App\Http\Controllers\User\PaymentLinkController::class, 'index'])->name('user.payment-links');
    Route::get('/payment-links/create', [App\Http\Controllers\User\PaymentLinkController::class, 'create'])->name('user.payment-links.create');
    Route::post('/payment-links', [App\Http\Controllers\User\PaymentLinkController::class, 'store'])->name('user.payment-links.store');
    Route::get('/payment-links/{id}', [App\Http\Controllers\User\PaymentLinkController::class, 'show'])->name('user.payment-links.show');
    Route::put('/payment-links/{id}', [App\Http\Controllers\User\PaymentLinkController::class, 'update'])->name('user.payment-links.update');
    Route::delete('/payment-links/{id}', [App\Http\Controllers\User\PaymentLinkController::class, 'destroy'])->name('user.payment-links.destroy');

    // Wallet
    Route::get('/wallet', [App\Http\Controllers\User\WalletController::class, 'index'])->name('user.wallet');
    Route::get('/wallet/withdraw', [App\Http\Controllers\User\WalletController::class, 'withdraw'])->name('user.wallet.withdraw');
    Route::post('/wallet/withdraw', [App\Http\Controllers\User\WalletController::class, 'storeWithdrawal'])->name('user.wallet.withdraw.store');

    // Settlements
    Route::get('/settlements', [App\Http\Controllers\User\SettlementController::class, 'index'])->name('user.settlements');

    // My Business
    Route::get('/business', [App\Http\Controllers\User\BusinessController::class, 'index'])->name('user.business');
    Route::put('/business', [App\Http\Controllers\User\BusinessController::class, 'update'])->name('user.business.update');
    Route::get('/business/banks', [App\Http\Controllers\User\BusinessController::class, 'banks'])->name('user.business.banks');
    Route::post('/business/banks', [App\Http\Controllers\User\BusinessController::class, 'storeBank'])->name('user.business.banks.store');
    Route::delete('/business/banks/{id}', [App\Http\Controllers\User\BusinessController::class, 'destroyBank'])->name('user.business.banks.destroy');

    // API Access
    Route::get('/api', [App\Http\Controllers\User\ApiAccessController::class, 'index'])->name('user.api');
    Route::post('/api', [App\Http\Controllers\User\ApiAccessController::class, 'storeKey'])->name('user.api.store');
    Route::delete('/api/{id}', [App\Http\Controllers\User\ApiAccessController::class, 'revokeKey'])->name('user.api.revoke');
    Route::get('/api/webhooks', [App\Http\Controllers\User\ApiAccessController::class, 'webhooks'])->name('user.api.webhooks');
    Route::post('/api/webhooks', [App\Http\Controllers\User\ApiAccessController::class, 'storeWebhook'])->name('user.api.webhooks.store');
    Route::delete('/api/webhooks/{id}', [App\Http\Controllers\User\ApiAccessController::class, 'destroyWebhook'])->name('user.api.webhooks.destroy');

    // Reports
    Route::get('/reports', [App\Http\Controllers\User\ReportController::class, 'index'])->name('user.reports');

    // Support / Messages
    Route::get('/support', [App\Http\Controllers\SupportMessageController::class, 'index'])->name('user.support');
    Route::post('/support/{supportMessage}/reply', [App\Http\Controllers\SupportMessageController::class, 'reply'])->name('user.support.reply');
    Route::post('/support/{supportMessage}/close', [App\Http\Controllers\SupportMessageController::class, 'close'])->name('user.support.close');

    // Business Tools
    Route::get('/invoices', [App\Http\Controllers\User\InvoiceController::class, 'index'])->name('user.invoices');
    Route::post('/invoices', [App\Http\Controllers\User\InvoiceController::class, 'store'])->name('user.invoices.store');
    Route::put('/invoices/{invoice}', [App\Http\Controllers\User\InvoiceController::class, 'update'])->name('user.invoices.update');
    Route::delete('/invoices/{invoice}', [App\Http\Controllers\User\InvoiceController::class, 'destroy'])->name('user.invoices.destroy');
    Route::post('/invoices/{invoice}/pay', [App\Http\Controllers\User\InvoiceController::class, 'pay'])->name('user.invoices.pay');
    Route::get('/sales', [App\Http\Controllers\User\SaleController::class, 'index'])->name('user.sales');
    Route::delete('/sales/{transaction}', [App\Http\Controllers\User\SaleController::class, 'destroy'])->name('user.sales.destroy');
    Route::get('/pos', [App\Http\Controllers\User\PosController::class, 'index'])->name('user.pos');
    Route::post('/pos/store', [App\Http\Controllers\User\PosController::class, 'store'])->name('user.pos.store');

    // Products
    Route::get('/products', [App\Http\Controllers\User\ProductController::class, 'index'])->name('user.products');
    Route::post('/products', [App\Http\Controllers\User\ProductController::class, 'store'])->name('user.products.store');
    Route::put('/products/{product}', [App\Http\Controllers\User\ProductController::class, 'update'])->name('user.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\User\ProductController::class, 'destroy'])->name('user.products.destroy');

    // Services
    Route::get('/services', [App\Http\Controllers\User\ServiceController::class, 'index'])->name('user.services');
    Route::post('/services', [App\Http\Controllers\User\ServiceController::class, 'store'])->name('user.services.store');
    Route::put('/services/{service}', [App\Http\Controllers\User\ServiceController::class, 'update'])->name('user.services.update');
    Route::delete('/services/{service}', [App\Http\Controllers\User\ServiceController::class, 'destroy'])->name('user.services.destroy');

    Route::get('/tools/settings', [App\Http\Controllers\User\ToolsSettingsController::class, 'index'])->name('user.tools.settings');
    Route::put('/tools/settings/business', [App\Http\Controllers\User\ToolsSettingsController::class, 'updateBusiness'])->name('user.tools.business.update');
    Route::put('/tools/settings/tools', [App\Http\Controllers\User\ToolsSettingsController::class, 'updateTools'])->name('user.tools.update');

    // Settings
    Route::get('/settings', [App\Http\Controllers\User\SettingsController::class, 'index'])->name('user.settings');
    Route::put('/settings/account', [App\Http\Controllers\User\SettingsController::class, 'updateAccount'])->name('user.settings.account');
    Route::put('/settings/password', [App\Http\Controllers\User\SettingsController::class, 'updatePassword'])->name('user.settings.password');

    // Website Builder / Templates
    Route::get('/website-builder', [App\Http\Controllers\User\TemplateBuilderController::class, 'index'])->name('user.templates');
    Route::get('/website-builder/{profileId}/customize', [App\Http\Controllers\User\TemplateBuilderController::class, 'customize'])->name('user.templates.customize');
    Route::put('/website-builder/{profileId}', [App\Http\Controllers\User\TemplateBuilderController::class, 'update'])->name('user.templates.update');
    Route::get('/website-builder/{profileId}/preview', [App\Http\Controllers\User\TemplateBuilderController::class, 'preview'])->name('user.templates.preview');
});
