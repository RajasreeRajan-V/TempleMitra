<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-emblem">ॐ</div>
        <h1 class="sidebar-title">{{ config('app.name', 'TempleMitra') }}</h1>
        <p class="sidebar-subtitle">Vazhipad Management</p>
    </div>

    <nav class="sidebar-nav">
        <a href="#" class="nav-link {{ request()->routeIs('vazhipad.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/><path d="M6 21v-3a6 6 0 0 1 12 0v3"/></svg>
            </span>
            <span>Vazhipad</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('bookings.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 2v4M16 2v4M9 14l2 2 4-4"/></svg>
            </span>
            <span>Bookings</span>
            @if($pendingBookingsCount ?? 12)
                <span class="nav-badge">{{ $pendingBookingsCount ?? 12 }}</span>
            @endif
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('devotees.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
            <span>Devotees</span>
        </a>

        <p class="nav-section-label">Management</p>

        <a href="#" class="nav-link {{ request()->routeIs('prasadam.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="8" width="18" height="13" rx="1"/><path d="M3 12h18M12 8v13M7.5 8a2.5 2.5 0 0 1 0-5C10 3 12 8 12 8s2-5 4.5-5a2.5 2.5 0 0 1 0 5"/></svg>
            </span>
            <span>Prasadam</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-4 4"/></svg>
            </span>
            <span>Reports</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('transactions.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 3h9l6 6v12H6z"/><path d="M15 3v6h6M9 13h6M9 17h6"/></svg>
            </span>
            <span>Transactions</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('notifications.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
            </span>
            <span>Notifications</span>
            @if($unreadNotificationsCount ?? 5)
                <span class="nav-badge">{{ $unreadNotificationsCount ?? 5 }}</span>
            @endif
        </a>

        <p class="nav-section-label">System</p>

        <a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9c.13.32.35.6.63.82.28.22.61.36.97.42H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
            </span>
            <span>Settings</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('support.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><path d="M12 17h.01"/></svg>
            </span>
            <span>Help &amp; Support</span>
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="sidebar-logout">
        @csrf
        <button type="submit" class="nav-link nav-link--logout">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
            </span>
            <span>Logout</span>
        </button>
    </form>
</aside>