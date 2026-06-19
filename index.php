<?php
// SalamaPay - Entry Point
// Redirect to public/index.php for Laravel application
// Or display a stylish bridge page

$publicPath = __DIR__ . '/public/index.php';
$publicDir = __DIR__ . '/public';

// Check if running from a web server
if (php_sapi_name() !== 'cli') {
    // If request is for the root, redirect to public
    if (file_exists($publicPath)) {
        // Pass through to Laravel's public index.php
        require $publicPath;
        exit;
    }
}

// Fallback: Display a stylish bridge page if public/index.php is not accessible
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SalamaPay - System Entry</title>
    <link rel="icon" type="image/png" sizes="32x32" href="public/icons8-logo-32.png">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #024938 0%, #013028 50%, #001816 100%);
            color: #fff;
            overflow: hidden;
        }
        .particles {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(249, 172, 0, 0.3);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(50px); opacity: 0; }
        }
        .card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 48px 40px;
            text-align: center;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        }
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, #f9ac00, #d49700);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 900;
            color: #024938;
            box-shadow: 0 10px 30px rgba(249, 172, 0, 0.3);
        }
        h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #fff, #f9ac00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        p.subtitle {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 32px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #f9ac00, #d49700);
            color: #024938;
            box-shadow: 0 4px 15px rgba(249, 172, 0, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 172, 0, 0.4);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.15);
            margin-left: 12px;
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        .links {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            justify-content: center;
            gap: 24px;
        }
        .links a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }
        .links a:hover {
            color: #f9ac00;
        }
        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .version {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            color: rgba(255, 255, 255, 0.3);
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <div class="card">
        <div class="logo">S</div>
        <h1>SalamaPay</h1>
        <p class="subtitle">Secure Payment Solutions for Africa</p>

        <div>
            <a href="public/" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Launch Application
            </a>
            <a href="public/docs" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Docs
            </a>
        </div>

        <div class="links">
            <a href="public/login">Login</a>
            <a href="public/register">Register</a>
            <a href="public/pricing">Pricing</a>
            <a href="public/about">About</a>
        </div>
    </div>

    <div class="version">
        <span class="status-dot"></span>
        SalamaPay v1.0.0 &mdash; System Online
    </div>

    <script>
        // Generate floating particles
        const container = document.getElementById('particles');
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.animationDelay = Math.random() * 8 + 's';
            p.style.animationDuration = (6 + Math.random() * 6) + 's';
            p.style.width = (2 + Math.random() * 4) + 'px';
            p.style.height = p.style.width;
            container.appendChild(p);
        }
    </script>
</body>
</html>
