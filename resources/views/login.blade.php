<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>Sign In · {{ config('app.name') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --maroon-950: #3d0d14;
      --maroon-900: #5a1420;
      --maroon-800: #701a29;
      --maroon-700: #8a2033;
      --gold-500: #c9a227;
      --gold-400: #d9b94a;
      --gold-100: #f2e6bf;
      --cream: #fbf3e2;
      --cream-deep: #f4e9d0;
      --ink: #2b1a12;
      --ink-soft: #6b5748;
      --shadow-card: 0 20px 40px -12px rgba(61, 13, 20, 0.18);
    }

    body {
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      background: var(--cream);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .stage {
      width: 100%;
      max-width: 1280px;
      min-height: 90vh;
      display: grid;
      grid-template-columns: 1.05fr 1fr;
      border-radius: 32px;
      overflow: hidden;
      box-shadow: 0 24px 56px -16px rgba(0, 0, 0, 0.25);
      background: var(--cream);
      transition: box-shadow 0.2s;
    }

    /* ---------- LEFT PANEL ---------- */
    .panel {
      position: relative;
      background:
        radial-gradient(circle at 20% 20%, rgba(217, 185, 74, 0.18), transparent 45%),
        radial-gradient(circle at 80% 85%, rgba(217, 185, 74, 0.12), transparent 40%),
        linear-gradient(145deg, var(--maroon-950) 0%, var(--maroon-900) 60%, var(--maroon-800) 100%);
      color: var(--gold-100);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 56px 48px;
      isolation: isolate;
    }

    .panel::before {
      content: '';
      position: absolute;
      inset: 20px;
      border: 1px solid rgba(217, 185, 74, 0.25);
      pointer-events: none;
      border-radius: 12px;
    }

    .panel::after {
      content: '';
      position: absolute;
      inset: 30px;
      border: 1px solid rgba(217, 185, 74, 0.12);
      pointer-events: none;
      border-radius: 8px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
      position: relative;
      z-index: 2;
    }

    .brand-mark {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      background: radial-gradient(circle at 30% 30%, var(--gold-400), var(--gold-500) 75%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 27px;
      color: var(--maroon-950);
      flex-shrink: 0;
      box-shadow: 0 0 0 3px rgba(217, 185, 74, 0.2);
    }

    .brand-text .name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 28px;
      font-weight: 600;
      letter-spacing: 0.3px;
      color: #fff;
      line-height: 1.1;
    }

    .brand-text .tag {
      font-size: 10px;
      letter-spacing: 2px;
      color: rgba(242, 230, 191, 0.5);
      margin-top: 3px;
      text-transform: uppercase;
    }

    .panel-body {
      position: relative;
      z-index: 2;
      max-width: 420px;
      margin: auto 0;
    }

    .panel-body .kicker {
      font-size: 12px;
      font-weight: 500;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--gold-400);
      margin-bottom: 16px;
      opacity: 0.8;
    }

    .panel-body h1 {
      font-family: 'Cormorant Garamond', serif;
      font-weight: 500;
      font-size: 44px;
      line-height: 1.2;
      margin: 0 0 18px;
      color: #fff;
    }

    .panel-body p {
      font-size: 15px;
      line-height: 1.7;
      color: rgba(242, 230, 191, 0.7);
      margin: 0;
    }

    .panel-stats {
      position: relative;
      z-index: 2;
      display: flex;
      gap: 40px;
      border-top: 1px solid rgba(217, 185, 74, 0.2);
      padding-top: 28px;
      margin-top: 12px;
    }

    .panel-stats div .num {
      font-family: 'Cormorant Garamond', serif;
      font-size: 30px;
      font-weight: 600;
      color: var(--gold-400);
      line-height: 1.2;
    }

    .panel-stats div .label {
      font-size: 12px;
      color: rgba(242, 230, 191, 0.5);
      margin-top: 2px;
      letter-spacing: 0.3px;
    }

    /* ---------- RIGHT FORM ---------- */
    .form-side {
      background: var(--cream);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 40px;
    }

    .form-wrap {
      width: 100%;
      max-width: 380px;
    }

    .form-wrap .eyebrow {
      font-size: 13px;
      font-weight: 500;
      color: var(--ink-soft);
      margin-bottom: 4px;
      letter-spacing: 0.5px;
    }

    .form-wrap h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 34px;
      font-weight: 600;
      margin: 0 0 28px;
      color: var(--maroon-900);
      letter-spacing: -0.3px;
    }

    /* role switcher */
    .role-switch {
      display: flex;
      background: var(--cream-deep);
      border-radius: 10px;
      padding: 4px;
      margin-bottom: 24px;
      gap: 4px;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .role-switch button {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 12px;
      border: none;
      border-radius: 8px;
      background: transparent;
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      font-weight: 600;
      color: var(--ink-soft);
      cursor: pointer;
      transition: background 0.2s ease, color 0.2s, box-shadow 0.2s;
      letter-spacing: 0.2px;
    }

    .role-switch button .icon {
      font-size: 15px;
      line-height: 1;
    }

    .role-switch button.active {
      background: #ffffff;
      color: var(--maroon-900);
      box-shadow: 0 4px 10px -4px rgba(61, 13, 20, 0.12), 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .role-switch button:not(.active):hover {
      background: rgba(255, 255, 255, 0.4);
    }

    .role-note {
      font-size: 12.5px;
      color: var(--ink-soft);
      margin: -12px 0 26px;
      min-height: 18px;
      padding-left: 2px;
      border-left: 2px solid var(--gold-400);
      padding-left: 12px;
    }

    .field {
      margin-bottom: 20px;
    }

    .field label {
      display: block;
      font-size: 12px;
      font-weight: 500;
      color: var(--ink-soft);
      margin-bottom: 6px;
      letter-spacing: 0.3px;
    }

    .field input {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid #e6dbc8;
      background: #ffffff;
      border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: var(--ink);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .field input::placeholder {
      color: #b9ab97;
      font-weight: 400;
    }

    .field input:focus {
      border-color: var(--gold-500);
      box-shadow: 0 0 0 4px rgba(201, 162, 39, 0.12);
    }

    .field.password {
      position: relative;
    }

    .field-error {
      color: #b3261e;
      font-size: 12px;
      margin-top: 6px;
    }

    .form-alert {
      background: #fdecea;
      border: 1px solid #f3c2be;
      color: #7a2119;
      font-size: 13px;
      padding: 12px 14px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .form-alert.success {
      background: #e9f7ef;
      border-color: #bfe6cd;
      color: #1e6b3c;
    }

    .toggle-vis {
      position: absolute;
      right: 16px;
      top: 38px;
      background: none;
      border: none;
      font-size: 12px;
      font-weight: 500;
      color: var(--maroon-700);
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      padding: 4px 8px;
      border-radius: 6px;
      transition: background 0.1s;
    }

    .toggle-vis:hover {
      background: rgba(90, 20, 32, 0.06);
    }

    .row-between {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 6px 0 28px;
      font-size: 13px;
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--ink-soft);
      cursor: pointer;
    }

    .remember input {
      accent-color: var(--maroon-800);
      width: 16px;
      height: 16px;
      margin: 0;
      cursor: pointer;
    }

    .row-between a {
      color: var(--maroon-800);
      text-decoration: none;
      font-weight: 500;
      font-size: 13px;
      transition: color 0.15s;
    }

    .row-between a:hover {
      color: var(--maroon-700);
      text-decoration: underline;
    }

    .btn-signin {
      width: 100%;
      padding: 15px 16px;
      border: none;
      border-radius: 10px;
      background: var(--maroon-900);
      color: var(--gold-100);
      font-family: 'Inter', sans-serif;
      font-size: 14.5px;
      font-weight: 600;
      letter-spacing: 0.3px;
      cursor: pointer;
      transition: background 0.2s, transform 0.08s, box-shadow 0.2s;
      box-shadow: 0 4px 12px -4px rgba(61, 13, 20, 0.25);
    }

    .btn-signin:hover {
      background: var(--maroon-800);
      box-shadow: 0 8px 20px -6px rgba(61, 13, 20, 0.35);
    }

    .btn-signin:active {
      transform: translateY(2px);
      box-shadow: 0 2px 8px -4px rgba(61, 13, 20, 0.3);
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 14px;
      margin: 28px 0 24px;
      color: #b9ab97;
      font-size: 12px;
      font-weight: 500;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--cream-deep);
    }

    .footer-note {
      text-align: center;
      font-size: 13px;
      color: var(--ink-soft);
      margin-top: 4px;
    }

    .footer-note a {
      color: var(--maroon-800);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s;
    }

    .footer-note a:hover {
      color: var(--maroon-700);
      text-decoration: underline;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 880px) {
      .stage {
        grid-template-columns: 1fr;
        border-radius: 24px;
        min-height: auto;
      }
      .panel {
        display: none;
      }
      .form-side {
        padding: 40px 24px;
        border-radius: 24px;
      }
      .form-wrap {
        max-width: 100%;
      }
    }

    @media (max-width: 460px) {
      .form-side {
        padding: 32px 18px;
      }
      .form-wrap h2 {
        font-size: 30px;
      }
      .role-switch button {
        font-size: 12px;
        padding: 8px 6px;
      }
      .btn-signin {
        font-size: 13.5px;
        padding: 14px;
      }
    }

    :focus-visible {
      outline: 2px solid var(--gold-500);
      outline-offset: 2px;
    }
  </style>
</head>
<body>

<div class="stage">

  <!-- LEFT PANEL -->
  <div class="panel">
    <div class="brand">
      <div class="brand-mark">ॐ</div>
      <div class="brand-text">
        <div class="name">{{ config('app.name', 'TempleMitra') }}</div>
        <div class="tag">Vazhipad Management</div>
      </div>
    </div>

    <div class="panel-body">
      <div class="kicker" id="panelKicker">Temple administration</div>
      <h1 id="panelHeadline">Every offering,<br />recorded with care.</h1>
      <p id="panelCopy">Sign in to manage vazhipad bookings, devotee records, and daily prasadam — all in one place, kept as orderly as the sanctum itself.</p>
    </div>

    <div class="panel-stats">
      <div>
        <div class="num">155</div>
        <div class="label">Vazhipad today</div>
      </div>
      <div>
        <div class="num">3,642</div>
        <div class="label">Bookings this month</div>
      </div>
      <div>
        <div class="num">27</div>
        <div class="label">Pending approvals</div>
      </div>
    </div>
  </div>

  <!-- RIGHT FORM -->
  <div class="form-side">
    <div class="form-wrap">
      <div class="eyebrow">Welcome back</div>
      <h2 id="formHeadline">Sign in to your account</h2>

      @if (session('status'))
        <div class="form-alert success">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
        <div class="form-alert">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="role-switch" role="tablist" aria-label="Choose login type">
        <button type="button" class="{{ old('login_type', 'temple') === 'temple' ? 'active' : '' }}" id="tabTemple" role="tab" aria-selected="{{ old('login_type', 'temple') === 'temple' ? 'true' : 'false' }}" onclick="setRole('temple')">
          <span class="icon">ॐ</span> Temple Dashboard
        </button>
        <button type="button" class="{{ old('login_type') === 'admin' ? 'active' : '' }}" id="tabAdmin" role="tab" aria-selected="{{ old('login_type') === 'admin' ? 'true' : 'false' }}" onclick="setRole('admin')">
          <span class="icon">⚙</span> Admin Dashboard
        </button>
      </div>
      <div class="role-note" id="roleNote">Access vazhipad, devotees, prasadam and daily temple operations.</div>

      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf
        <input type="hidden" name="login_type" id="loginType" value="{{ old('login_type', 'temple') }}" />

        <div class="field">
          <label for="username" id="usernameLabel">Username or email</label>
          <input
            type="text"
            id="username"
            name="email"
            value="{{ old('email') }}"
            placeholder="anand@sreemahaganapathi.org"
            autocomplete="email"
            required
            autofocus
          />
          @error('email')
            <div class="field-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="field password">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            autocomplete="current-password"
            required
          />
          <button type="button" class="toggle-vis" onclick="const p=document.getElementById('password'); const on=p.type==='password'; p.type= on ? 'text':'password'; this.textContent = on ? 'Hide':'Show';">Show</button>
          @error('password')
            <div class="field-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="row-between">
          <label class="remember">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} />
            Remember me
          </label>
          <a href="{{ route('password.request') ?? '#' }}">Forgot password?</a>
        </div>

        <button type="submit" class="btn-signin" id="signinBtn">Sign in to Temple Dashboard</button>
      </form>

      <div class="divider">or</div>

      <p class="footer-note" id="footerNote">New to the temple office? <a href="#">Request access</a></p>
    </div>
  </div>
</div>

<script>
  const content = {
    temple: {
      kicker: 'Temple administration',
      headline: 'Every offering,<br />recorded with care.',
      copy: 'Sign in to manage vazhipad bookings, devotee records, and daily prasadam — all in one place, kept as orderly as the sanctum itself.',
      stats: [
        { num: '155', label: 'Vazhipad today' },
        { num: '3,642', label: 'Bookings this month' },
        { num: '27', label: 'Pending approvals' }
      ],
      roleNote: 'Access vazhipad, devotees, prasadam and daily temple operations.',
      usernameLabel: 'Username or email',
      placeholder: 'anand@sreemahaganapathi.org',
      btnText: 'Sign in to Temple Dashboard',
      footer: 'New to the temple office? <a href="#">Request access</a>'
    },
    admin: {
      kicker: 'System administration',
      headline: 'One account,<br />full oversight.',
      copy: 'Sign in to manage staff access, temple settings, integrations, and reporting across every vazhipad center under your care.',
      stats: [
        { num: '6', label: 'Temples managed' },
        { num: '42', label: 'Staff accounts' },
        { num: '99.9%', label: 'System uptime' }
      ],
      roleNote: 'Access user roles, temple settings, integrations and system reports.',
      usernameLabel: 'Admin username or email',
      placeholder: 'admin@sreemahaganapathi.org',
      btnText: 'Sign in to Admin Dashboard',
      footer: 'Need admin access? <a href="#">Contact IT support</a>'
    }
  };

  function setRole(role) {
    const c = content[role];

    document.getElementById('panelKicker').textContent = c.kicker;
    document.getElementById('panelHeadline').innerHTML = c.headline;
    document.getElementById('panelCopy').textContent = c.copy;

    const statEls = document.querySelectorAll('.panel-stats > div');
    c.stats.forEach((s, i) => {
      statEls[i].querySelector('.num').textContent = s.num;
      statEls[i].querySelector('.label').textContent = s.label;
    });

    document.getElementById('roleNote').textContent = c.roleNote;
    document.getElementById('usernameLabel').textContent = c.usernameLabel;
    document.getElementById('username').placeholder = c.placeholder;
    document.getElementById('signinBtn').textContent = c.btnText;
    document.getElementById('footerNote').innerHTML = c.footer;

    document.getElementById('tabTemple').classList.toggle('active', role === 'temple');
    document.getElementById('tabAdmin').classList.toggle('active', role === 'admin');
    document.getElementById('tabTemple').setAttribute('aria-selected', role === 'temple');
    document.getElementById('tabAdmin').setAttribute('aria-selected', role === 'admin');

    // Keep the hidden field in sync so the controller knows which
    // dashboard was requested.
    document.getElementById('loginType').value = role;
  }

  // Re-apply the correct tab styling/content on load in case validation
  // failed and the page reloaded with `old('login_type')`.
  document.addEventListener('DOMContentLoaded', () => {
    setRole(document.getElementById('loginType').value || 'temple');
  });
</script>

</body>
</html>