<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Sign In · {{ config('app.name') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

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

    /* ---------- LEFT PANEL — ADMIN (darker, more "system") ---------- */
    .panel {
      position: relative;
      background:
        radial-gradient(circle at 20% 20%, rgba(217, 185, 74, 0.14), transparent 45%),
        radial-gradient(circle at 80% 85%, rgba(217, 185, 74, 0.08), transparent 40%),
        linear-gradient(145deg, #1a0508 0%, var(--maroon-950) 55%, var(--maroon-900) 100%);
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

    .form-wrap { width: 100%; max-width: 380px; }

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

    .role-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--cream-deep);
      color: var(--maroon-900);
      font-size: 12px;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 999px;
      margin-bottom: 22px;
      letter-spacing: 0.4px;
      border: 1px solid rgba(201, 162, 39, 0.25);
    }

    .role-badge .icon { font-size: 14px; }

    .role-note {
      font-size: 12.5px;
      color: var(--ink-soft);
      margin: -12px 0 26px;
      min-height: 18px;
      border-left: 2px solid var(--gold-400);
      padding-left: 12px;
    }

    .field { margin-bottom: 20px; }

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

    .field input::placeholder { color: #b9ab97; font-weight: 400; }

    .field input:focus {
      border-color: var(--gold-500);
      box-shadow: 0 0 0 4px rgba(201, 162, 39, 0.12);
    }

    .field.password { position: relative; }

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

    .toggle-vis:hover { background: rgba(90, 20, 32, 0.06); }

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

    .row-between a:hover { color: var(--maroon-700); text-decoration: underline; }

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

    .footer-note a:hover { color: var(--maroon-700); text-decoration: underline; }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 880px) {
      .stage { grid-template-columns: 1fr; border-radius: 24px; min-height: auto; }
      .panel { display: none; }
      .form-side { padding: 40px 24px; border-radius: 24px; }
      .form-wrap { max-width: 100%; }
    }

    @media (max-width: 460px) {
      .form-side { padding: 32px 18px; }
      .form-wrap h2 { font-size: 30px; }
      .btn-signin { font-size: 13.5px; padding: 14px; }
    }

    :focus-visible { outline: 2px solid var(--gold-500); outline-offset: 2px; }
  </style>
</head>
<body>

<div class="stage">

  <!-- LEFT PANEL — ADMIN -->
  <div class="panel">
    <div class="brand">
      <div class="brand-mark">⚙</div>
      <div class="brand-text">
        <div class="name">{{ config('app.name', 'TempleMitra') }}</div>
        <div class="tag">System Administration</div>
      </div>
    </div>

    <div class="panel-body">
      <div class="kicker">System administration</div>
      <h1>One account,<br />full oversight.</h1>
      <p>Sign in to manage staff access, temple settings, integrations, and reporting across every vazhipad center under your care.</p>
    </div>

    <div class="panel-stats">
      <div>
        <div class="num">6</div>
        <div class="label">Temples managed</div>
      </div>
      <div>
        <div class="num">42</div>
        <div class="label">Staff accounts</div>
      </div>
      <div>
        <div class="num">99.9%</div>
        <div class="label">System uptime</div>
      </div>
    </div>
  </div>

  <!-- RIGHT FORM — ADMIN -->
  <div class="form-side">
    <div class="form-wrap">
      <div class="eyebrow">Administrator access</div>
      <h2>Sign in to admin panel</h2>

      <div class="role-badge">
        <span class="icon">⚙</span> Admin Dashboard
      </div>

      @if (session('status'))
        <div class="form-alert success">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
        <div class="form-alert">{{ $errors->first() }}</div>
      @endif

      <div class="role-note">
        Access user roles, temple settings, integrations and system reports.
      </div>

      {{-- Admin login form — dedicated route --}}
      <form method="POST" action="{{ route('login.store') }}" id="loginForm">
        @csrf

        <div class="field">
          <label for="username">Admin username or email</label>
          <input
            type="text"
            id="username"
            name="email"
            value="{{ old('email') }}"
            placeholder="admin@sreemahaganapathi.org"
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
          <button type="button" class="toggle-vis"
            onclick="const p=document.getElementById('password'); const on=p.type==='password'; p.type= on ? 'text':'password'; this.textContent = on ? 'Hide':'Show';">Show</button>
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

        <button type="submit" class="btn-signin">Sign in to Admin Dashboard</button>
      </form>

      <div class="divider">or</div>

      <p class="footer-note">
        Need admin access? <a href="#">Contact IT support</a>
      </p>
    </div>
  </div>
</div>

</body>
</html>