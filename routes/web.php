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
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// User/Merchant Dashboard Routes
Route::prefix('dashboard')->group(function () {
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
});
