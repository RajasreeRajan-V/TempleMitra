<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-emblem">ॐ</div>
        <h1 class="sidebar-title">
            {{ Auth::guard('admin')->user()->name ?? 'TempleMitra' }}
        </h1>
        <p class="sidebar-subtitle">Vazhipad Management</p>
    </div>

    <nav class="sidebar-nav">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="9" rx="1" />
                    <rect x="14" y="3" width="7" height="5" rx="1" />
                    <rect x="14" y="12" width="7" height="9" rx="1" />
                    <rect x="3" y="16" width="7" height="5" rx="1" />
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

        {{-- Temple Registration --}}
        <a href="{{ route('admin.temples-registration.index') }}"
            class="nav-link {{ request()->routeIs('admin.temples-registration.index') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path
                        d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z" />
                    <path d="M6 21v-3a6 6 0 0 1 12 0v3" />
                </svg>
            </span>
            <span>Temple Registration</span>
        </a>

        {{-- List of Temples --}}
        <a href="{{ route('admin.temples.list') }}"
            class="nav-link {{ request()->routeIs('admin.temples.list') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="16" rx="2" />
                    <path d="M7 9h10M7 13h10M7 17h6" />
                </svg>
            </span>
            <span>List of Temples</span>
        </a>

       {{-- Notifications --}}
@php
    use App\Models\TemplesRegistration;
    use Illuminate\Support\Carbon;

    $unreadNotificationsCount = TemplesRegistration::where(
        'created_at',
        '<=',
        Carbon::now()->subMonth()
    )
    ->whereNull('one_month_notification_sent_at')
    ->count();
@endphp

<a href="{{ route('admin.notifications') }}"
    class="nav-link {{ request()->routeIs('admin.notifications') ? 'nav-link--active' : '' }}">

    <span class="nav-icon">
        <svg viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8">

            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />

            <path d="M13.7 21a2 2 0 0 1-3.4 0" />

        </svg>
    </span>

    <span>Notifications</span>

    @if ($unreadNotificationsCount > 0)
        <span class="nav-badge">
            {{ $unreadNotificationsCount }}
        </span>
    @endif

</a>

        {{-- Settings with Submenu --}}
        <div class="nav-group {{ request()->routeIs('admin.settings.*') ? 'nav-group--active' : '' }}">
            <a href="#" class="nav-link nav-link--toggle" data-toggle="settings-submenu">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9c.13.32.35.6.63.82.28.22.61.36.97.42H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z" />
                    </svg>
                </span>
                <span>Settings</span>
                <svg class="nav-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </a>

            <div class="nav-submenu" id="settings-submenu">
    <a href="{{ route('admin.settings.profile') }}"
        class="nav-sublink {{ request()->routeIs('admin.settings.profile') ? 'nav-sublink--active' : '' }}">
        Update Profile
    </a>
    <a href="{{ route('admin.settings.password') }}"
        class="nav-sublink {{ request()->routeIs('admin.settings.password') ? 'nav-sublink--active' : '' }}">
        Change Password
    </a>
</div>
        </div>
        <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'nav-link--active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 3v18h18" />
                    <path d="m19 9-5 5-4-4-4 4" />
                </svg>
            </span>
            <span>Reports</span>
        </a>

    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('admin.logout') }}" class="sidebar-logout">
        @csrf
        <button type="submit" class="nav-link nav-link--logout">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <path d="m16 17 5-5-5-5M21 12H9" />
                </svg>
            </span>
            <span>Logout</span>
        </button>
    </form>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.querySelector('[data-toggle="settings-submenu"]');
        var submenu = document.getElementById('settings-submenu');
        if (toggle && submenu) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                submenu.classList.toggle('nav-submenu--open');
                toggle.classList.toggle('nav-link--toggle-open');
            });
        }
    });
</script>
