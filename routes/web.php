<?php

use App\Models\PaymentLink;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pricing', function () {
    return view('frontend.pricing');
})->name('pricing');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

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
    return view('frontend.docs', ['page' => $page]);
})->name('docs');

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

    // Settings
    Route::get('/settings', [App\Http\Controllers\User\SettingsController::class, 'index'])->name('user.settings');
    Route::put('/settings/account', [App\Http\Controllers\User\SettingsController::class, 'updateAccount'])->name('user.settings.account');
    Route::put('/settings/password', [App\Http\Controllers\User\SettingsController::class, 'updatePassword'])->name('user.settings.password');
});
