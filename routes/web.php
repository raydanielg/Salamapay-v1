<?php

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

Route::get('/blog/{slug}', function ($slug) {
    return view('frontend.blog-detail', ['slug' => $slug]);
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
