<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Sign In' }} | {{ config('app.name', 'TempleMitra') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --maroon: #7c1f2c;
            --maroon-dark: #5c1620;
            --gold: #b8862f;
            --sand: #efe3c8;
            --cream: #fdfaf3;
            --ink: #1c1310;
            --ink-soft: #6b5f52;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
            padding: 32px 20px;
            background: var(--cream);
            background-image:
                radial-gradient(circle at 12% 8%, rgba(124,31,44,0.05), transparent 40%),
                radial-gradient(circle at 88% 92%, rgba(184,134,47,0.08), transparent 40%);
            font-family: 'Inter', sans-serif;
            color: var(--ink);
        }

        .guest-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: inherit;
        }

        .guest-emblem {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--maroon);
            color: var(--sand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 6px 16px rgba(124,31,44,0.25);
        }

        .guest-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .guest-tagline {
            margin: 0;
            font-size: 13px;
            color: var(--ink-soft);
        }

        .guest-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border: 1px solid var(--sand);
            border-radius: 14px;
            padding: 32px 30px;
            box-shadow: 0 18px 40px -20px rgba(28,19,16,0.25);
        }

        .guest-card :is(h1, h2) {
            font-family: 'Cormorant Garamond', serif;
            margin-top: 0;
        }

        .guest-card label {
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-soft);
        }

        .guest-card input[type="text"],
        .guest-card input[type="email"],
        .guest-card input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ddd2bd;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            background: var(--cream);
            color: var(--ink);
        }

        .guest-card input:focus {
            outline: 2px solid var(--gold);
            outline-offset: 1px;
            border-color: var(--gold);
        }

        .guest-card button,
        .guest-card .btn-primary {
            width: 100%;
            padding: 11px 16px;
            border: none;
            border-radius: 8px;
            background: var(--maroon);
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .guest-card button:hover,
        .guest-card .btn-primary:hover {
            background: var(--maroon-dark);
        }

        .guest-footer {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .guest-footer a {
            color: var(--maroon);
            text-decoration: none;
        }

        .guest-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="{{ route('dashboard', [], false) ?? url('/') }}" class="guest-brand">
        <span class="guest-emblem">ॐ</span>
        <span class="guest-name">{{ config('app.name', 'TempleMitra') }}</span>
        <p class="guest-tagline">Vazhipad Management</p>
    </a>

    <div class="guest-card">
        {{ $slot }}
    </div>

    <p class="guest-footer">
        &copy; {{ date('Y') }} {{ config('app.name', 'TempleMitra') }}. All rights reserved.
    </p>

    @stack('scripts')
</body>
</html>