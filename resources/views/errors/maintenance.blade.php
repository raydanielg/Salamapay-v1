<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance — SalamaPay</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-emerald-900 min-h-screen flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="w-20 h-20 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-gold-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </div>
        <h1 class="text-2xl font-bold text-white mb-3">Under Maintenance</h1>
        <p class="text-emerald-200 text-sm leading-relaxed mb-8">{{ $message ?? 'We are currently performing scheduled maintenance. Please check back soon.' }}</p>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-emerald-300 text-xs">
            <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
            Back shortly
        </div>
    </div>
</body>
</html>
