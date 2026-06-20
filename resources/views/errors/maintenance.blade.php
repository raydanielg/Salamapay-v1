<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Under Maintenance — SalamaPay</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-emerald-900 min-h-screen flex flex-col items-center justify-center px-4 py-10">
    <div class="text-center max-w-md">
        {{-- Logo --}}
        <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-8 mx-auto mb-6 brightness-0 invert opacity-70">

        {{-- Maintenance Image --}}
        <div class="mb-6">
            <img src="{{ asset('maintaincce.png') }}" alt="Under Maintenance" class="w-48 h-auto mx-auto drop-shadow-2xl">
        </div>

        <h1 class="text-2xl font-bold text-white mb-3 tracking-tight">Under Maintenance</h1>
        <p class="text-emerald-200 text-sm leading-relaxed mb-6">{{ $message ?? 'We are currently performing scheduled maintenance to improve your experience. Please check back soon.' }}</p>

        {{-- Status indicator --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-emerald-300 text-xs font-medium mb-8">
            <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
            We'll be back shortly
        </div>

        {{-- Support contact --}}
        <div class="space-y-2">
            <p class="text-xs text-emerald-400">Need urgent help?</p>
            <a href="mailto:support@salamapay.com" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white/10 text-emerald-100 text-xs font-medium hover:bg-white/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Contact Support
            </a>
        </div>
    </div>

    {{-- Footer --}}
    <div class="fixed bottom-4 text-center w-full">
        <p class="text-[10px] text-emerald-500">&copy; {{ date('Y') }} SalamaPay. All rights reserved.</p>
    </div>
</body>
</html>
