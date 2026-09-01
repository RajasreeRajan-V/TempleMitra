<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Dashboard' }} | {{ config('app.name', 'TempleMitra') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

   
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="app-shell">
        @include('layouts.navigation')

        <div class="main-col">
            <header class="topbar">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}">Home</a>
                    <span>&rsaquo;</span>
                    <span class="current">{{ $breadcrumb ?? 'Dashboard' }}</span>
                </nav>

                <div class="topbar-actions">
                    <label class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="search" placeholder="Search bookings, devotees..">
                    </label>

                    <button type="button" class="icon-btn" aria-label="Notifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                        <span class="dot"></span>
                    </button>

                    <div class="avatar">{{ Auth::check() ? Str::of(Auth::user()->name)->explode(' ')->map(fn($p) => Str::substr($p, 0, 1))->join('') : 'A' }}</div>
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