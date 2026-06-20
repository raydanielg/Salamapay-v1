<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SalamaPay - Lipa kwa Urahisi, Biashara Ipokee Haraka</title>
    <meta name="description" content="SalamaPay ni mfumo wa kisasa wa malipo ya kidigitali unaowasaidia watu na biashara kupokea na kutuma pesa kwa urahisi.">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons8-logo-32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons8-logo-96.png') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-15px)} }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes fade-up { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
        .delay-4 { animation-delay:.7s }
        .delay-5 { animation-delay:.9s }
        @keyframes pulse-ring { 0%{transform:scale(.8);opacity:1} 100%{transform:scale(1.4);opacity:0} }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
        @keyframes flow-h { 0%{transform:translateX(-10%)} 100%{transform:translateX(10%)} }
        .flow-line-h { animation: flow-h 8s linear infinite; }
        .flow-line-h.delay-1 { animation-delay:-2s }
        .flow-line-h.delay-2 { animation-delay:-4s }
        .flow-line-h.delay-3 { animation-delay:-6s }
        .flow-line-h.delay-4 { animation-delay:-3s }
        @keyframes wave { 0%{stroke-dashoffset:1000} 100%{stroke-dashoffset:0} }
        .wave-path { stroke-dasharray:1000; animation: wave 20s linear infinite; }
        .wave-path.delay-2 { animation-delay:-8s }
        @keyframes particle-float { 0%,100%{transform:translateY(0) scale(1);opacity:.3} 50%{transform:translateY(-30px) scale(1.2);opacity:.8} }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

@include('frontend.partials.header')
@include('frontend.partials.page-loader')
@include('frontend.partials.hero')

<script>
document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',e=>{e.preventDefault();const t=document.querySelector(a.getAttribute('href'));if(t){window.scrollTo({top:t.getBoundingClientRect().top+window.pageYOffset-80,behavior:'smooth'})}})});

// Language Toggle
let currentLang = 'en';
function toggleLang() {
    currentLang = currentLang === 'en' ? 'sw' : 'en';
    document.getElementById('langLabel').textContent = currentLang.toUpperCase();
    document.querySelectorAll('[data-en][data-sw]').forEach(el => {
        el.textContent = el.getAttribute('data-' + currentLang);
    });
}
</script>
</body>
</html>
