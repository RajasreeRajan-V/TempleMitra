<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title ?? 'Temple Dashboard') | {{ config('app.name', 'TempleMitra') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/temple_main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/temple.css') }}">
    <link rel="stylesheet" href="{{ asset('css/temple_password.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

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

        /* Profile Page Container */
        .profile-page {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 5px 0;
        }

        .page-header p {
            font-size: 14px;
            color: #7f8c8d;
            margin: 0;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Card Styling */
        .profile-card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
            padding: 30px;
        }

        /* Profile Header (Logo + Title) */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .profile-logo {
            flex-shrink: 0;
        }

        .profile-logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f0f0;
        }

        .profile-logo-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #800000;
            /* Match your theme color */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            border: 3px solid #f0f0f0;
        }

        .profile-title {
            flex-grow: 1;
        }

        .profile-title label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Grid Layout */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-field {
            display: flex;
            flex-direction: column;
        }

        .profile-field-full {
            grid-column: span 2;
        }

        /* Form Labels & Inputs */
        .profile-field label {
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #800000;
            box-shadow: 0 0 0 3px rgba(128, 0, 0, 0.1);
            background-color: #fff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* Action Buttons */
        .profile-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #800000;
            /* Match your sidebar theme */
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #660000;
        }

        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        /* Responsive for smaller screens */
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-field-full {
                grid-column: span 1;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            flex-shrink: 0;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>

                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('temple.dashboard') }}">Temple</a>
                        <span>&rsaquo;</span>
                        <span class="current">@yield('title', $breadcrumb ?? 'Dashboard')</span>
                    </nav>
                </div>

                <div class="topbar-actions">
                    <label class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="search" placeholder="Search offerings, receiptss..">
                    </label>

                    <button type="button" class="icon-btn" aria-label="Notifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                        </svg>
                        <span class="dot"></span>
                    </button>

                    @php
                        $temple = \App\Models\TemplesRegistration::find(session('temple_id'));
                    @endphp

                    <a href="{{ route('temple.profile') }}" class="avatar"
                        title="{{ $temple->temple_name ?? 'Temple' }}">

                        @if ($temple && $temple->logo)
                            <img src="{{ asset('storage/' . $temple->logo) }}" alt="{{ $temple->temple_name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <span>
                                {{ $temple ? Str::substr($temple->temple_name, 0, 2) : 'TM' }}
                            </span>
                        @endif

                    </a>
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
