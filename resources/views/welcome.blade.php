<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Salamapay') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons8-logo-96.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons8-logo-96.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
            *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
            body{font-family:'Inter',sans-serif;background:#000;color:#fff;min-height:100vh}
            a{text-decoration:none}
        </style>
    @endif
    <style>
        .gradient-text{background:linear-gradient(135deg,#10b981 0%,#34d399 50%,#059669 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .gradient-border{position:relative}
        .gradient-border::before{content:'';position:absolute;inset:0;border-radius:inherit;padding:1px;background:linear-gradient(135deg,#10b981,#34d399,#059669);-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
        .animate-fade-up{animation:fadeUp 0.8s ease-out forwards;opacity:0}
        @keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
        .animate-float{animation:float 4s ease-in-out infinite}
        @keyframes glow{0%,100%{box-shadow:0 0 20px rgba(16,185,129,0.2)}50%{box-shadow:0 0 40px rgba(16,185,129,0.4)}}
        .animate-glow{animation:glow 3s ease-in-out infinite}
        .glass-card{background:rgba(17,17,17,0.8);backdrop-filter:blur(20px);border:1px solid rgba(31,31,31,0.5)}
    </style>
</head>
<body class="bg-sp-black text-white antialiased overflow-x-hidden">

@include('frontend.partials.header')
@include('frontend.partials.hero')
@include('frontend.partials.trust')
@include('frontend.partials.features')
@include('frontend.partials.how-it-works')
@include('frontend.partials.payments')
@include('frontend.partials.security')
@include('frontend.partials.stats')
@include('frontend.partials.testimonials')
@include('frontend.partials.cta')
@include('frontend.partials.footer')

</body>
</html>
