<aside class="sidebar" id="templeSidebar">
    <div class="sidebar-brand">
        <button type="button" class="sidebar-close-btn" id="sidebarClose" aria-label="Close sidebar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <a href="{{ route('temple') }}" class="sidebar-brand-link">
            <div class="sidebar-emblem">ॐ</div>
            <h1 class="sidebar-title">{{ config('app.name', 'TempleMitra') }}</h1>
            <p class="sidebar-subtitle">VAZHIPAD MANAGEMENT</p>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('temple') }}"
           class="nav-link {{ request()->routeIs('temple') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('temple.vazhipad.index') }}"
           class="nav-link {{ request()->routeIs('temple.vazhipad.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                    <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
                </svg>
            </span>
            <span>Vazhipad</span>
        </a>

        <a href="{{ route('temple.receipts.index') }}" class="nav-link {{ request()->routeIs('temple.receipts.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <path d="M3 9h18M8 2v4M16 2v4M9 14l2 2 4-4"/>
                </svg>
            </span>
            <span>receipts</span>
            @if(isset($pendingreceiptssCount) || true)
                <span class="nav-badge">{{ $pendingreceiptssCount ?? 12 }}</span>
            @endif
        </a>

        <a href="{{ route('temple.receipt-printing.index') }}" class="nav-link {{ request()->routeIs('temple.receipt-printing.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </span>
            <span>Print Receipts</span>
        </a>

        <p class="nav-section-label">Management</p>

{{-- Reports Dropdown --}}
<div class="nav-dropdown {{ request()->routeIs('temple.reports.*') ? 'nav-dropdown--active' : '' }}">

    <button type="button"
            class="nav-link nav-dropdown-toggle"
            onclick="toggleReportsDropdown()">

        <span class="nav-icon">
            <svg viewBox="0 0 24 24" fill="none"
                 stroke="currentColor"
                 stroke-width="1.8"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M3 3v18h18"/>
                <path d="m19 9-5 5-4-4-4 4"/>
            </svg>
        </span>

        <span>Reports</span>

        <svg class="dropdown-arrow"
             id="reportsArrow"
             width="16"
             height="16"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"/>
        </svg>

    </button>


    <div class="nav-dropdown-menu {{ request()->routeIs('temple.reports.*') ? 'is-open' : '' }}" id="reportsDropdown">

        {{-- Reports Dashboard --}}
        <a href="{{ route('temple.reports.index') }}"
           class="nav-dropdown-item {{ request()->routeIs('temple.reports.index') ? 'active' : '' }}">

            <span>📊</span>
            <span>Report Dashboard</span>

        </a>


        {{-- Receipt Reports --}}
        <a href="{{ route('temple.reports.receipts') }}"
           class="nav-dropdown-item {{ request()->routeIs('temple.reports.receipts') ? 'active' : '' }}">

            <span>🧾</span>
            <span>Receipt Reports</span>

        </a>


        {{-- Collection Reports --}}
        <a href="{{ route('temple.reports.collections') }}"
           class="nav-dropdown-item {{ request()->routeIs('temple.reports.collections') ? 'active' : '' }}">

            <span>💰</span>
            <span>Collection Reports</span>

        </a>


        {{-- Vazhipad Reports --}}
        <a href="{{ route('temple.reports.vazhipads') }}"
           class="nav-dropdown-item {{ request()->routeIs('temple.reports.vazhipads') ? 'active' : '' }}">

            <span>🛕</span>
            <span>Vazhipad Reports</span>

        </a>


        {{-- Devotee Reports --}}
        <a href="{{ route('temple.reports.devotees') }}"
           class="nav-dropdown-item {{ request()->routeIs('temple.reports.devotees') ? 'active' : '' }}">

            <span>👤</span>
            <span>Devotee Reports</span>

        </a>


        {{-- Daily Report --}}
        <a href="{{ route('temple.reports.daily') }}"
           class="nav-dropdown-item {{ request()->routeIs('temple.reports.daily') ? 'active' : '' }}">

            <span>📅</span>
            <span>Daily Report</span>

        </a>

    </div>

</div>
        <a href="#" class="nav-link {{ request()->routeIs('transactions.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 3h9l6 6v12H6z"/>
                    <path d="M15 3v6h6M9 13h6M9 17h6"/>
                </svg>
            </span>
            <span>Transactions</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('notifications.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.7 21a2 2 0 0 1-3.4 0"/>
                </svg>
            </span>
            <span>Notifications</span>
            @if(isset($unreadNotificationsCount) || true)
                <span class="nav-badge">{{ $unreadNotificationsCount ?? 5 }}</span>
            @endif
        </a>

        <p class="nav-section-label">System</p>

        <a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9c.13.32.35.6.63.82.28.22.61.36.97.42H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>
                </svg>
            </span>
            <span>Settings</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('support.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/>
                    <path d="M12 17h.01"/>
                </svg>
            </span>
            <span>Help & Support</span>
        </a>
    </nav>

    @if (Route::has('logout'))
    <form method="POST" action="{{ route('logout') }}" class="sidebar-logout">
        @csrf
        <button type="submit" class="nav-link nav-link--logout">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path d="m16 17 5-5-5-5M21 12H9"/>
                </svg>
            </span>
            <span>Logout</span>
        </button>
    </form>
    @endif
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    (function () {
        const sidebar  = document.getElementById('templeSidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            if (sidebar) sidebar.classList.add('is-open');
            if (overlay) overlay.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            if (sidebar) sidebar.classList.remove('is-open');
            if (overlay) overlay.classList.remove('is-visible');
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('#sidebarToggle')) openSidebar();
        });

        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function () {
            if (window.innerWidth > 900) closeSidebar();
        });
    })();

    // ---------- Reports dropdown toggle (this was missing) ----------
    function toggleReportsDropdown() {
        const dropdown = document.getElementById('reportsDropdown');
        if (!dropdown) return;

        const wrapper = dropdown.closest('.nav-dropdown');

        dropdown.classList.toggle('is-open');
        if (wrapper) wrapper.classList.toggle('is-open');
    }
</script>