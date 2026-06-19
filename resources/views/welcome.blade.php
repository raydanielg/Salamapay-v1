<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @import url('https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap');
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Figtree', sans-serif; background: #f8fafc; color: #1f2937; }
            a { text-decoration: none; }
        </style>
    @endif
</head>
<body class="antialiased">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-green-500 selection:text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4">Laravel</h1>
                <p class="text-lg text-gray-600 mb-8">Welcome to your Laravel application.</p>
                <div class="flex items-center justify-center gap-4">
                    <a href="https://laravel.com/docs" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Documentation</a>
                    <a href="https://laracasts.com" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition">Laracasts</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
