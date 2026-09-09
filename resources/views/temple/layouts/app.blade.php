<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title ?? 'Temple Dashboard') | {{ config('app.name', 'TempleMitra') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/temple_main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/temple.css') }}">
    <link
    href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css"
    rel="stylesheet"
>

    <style>
        .sidebar-brand {
            position: relative;
        }

        .sidebar-brand-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .sidebar-close-btn {
            display: none;
            position: absolute;
            right: 4px;
            top: 4px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .sidebar-close-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            color: var(--gold-300);
        }

        .sidebar-toggle-btn {
            display: none;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 8px;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            color: var(--maroon-900);
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: background 0.15s ease, border-color 0.15s ease;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            background: var(--cream-50);
            border-color: var(--gold-400);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(44, 24, 16, 0.6);
            backdrop-filter: blur(2px);
            z-index: 35;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-overlay.is-visible {
            opacity: 1;
            pointer-events: auto;
        }

        @media (max-width: 900px) {
            .sidebar-close-btn {
                display: flex;
            }

            .sidebar-toggle-btn {
                display: flex;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                z-index: 40;
                transition: left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
            }

            .sidebar.is-open {
                left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        @include('temple.layouts.navigation')

        <div class="main-col">
            <header class="topbar">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Menu">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>

                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('temple') }}">Temple</a>
                        <span>&rsaquo;</span>
                        <span class="current">@yield('title', $breadcrumb ?? 'Dashboard')</span>
                    </nav>
                </div>

                <div class="topbar-actions">
                    <label class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="search" placeholder="Search offerings, receiptss..">
                    </label>

                    <button type="button" class="icon-btn" aria-label="Notifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                        <span class="dot"></span>
                    </button>

                    <div class="avatar" title="{{ Auth::user()->name ?? 'Administrator' }}">
                        {{ Auth::check() ? Str::of(Auth::user()->name)->explode(' ')->map(fn ($p) => Str::substr($p, 0, 1))->take(2)->join('') : 'TM' }}
                    </div>
                </div>
            </header>

            <main class="page-body">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>