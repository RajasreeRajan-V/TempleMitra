@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<style>
    /* Scoped styles for the password page (matches profile page styling) */
    .page-wrapper {
        padding: 30px;
        background-color: #fcf9f2; /* Matches the cream background */
        min-height: 100vh;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #4a1c1c; /* Dark maroon */
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    /* Form Card Styling */
    .form-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        max-width: 600px; /* Prevents the form from stretching too wide */
        border: 1px solid #e5e7eb;
    }

    .form-row {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .required {
        color: #dc2626;
    }

    /* Input Styling */
    .input-wrapper {
        position: relative;
    }

    .form-input {
        width: 100%;
        padding: 10px 44px 10px 14px; /* extra right padding for the toggle icon */
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 15px;
        color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        background-color: #ffffff;
        box-sizing: border-box; /* Ensures padding doesn't break width */
    }

    .form-input:focus {
        border-color: #8b1c1c; /* Maroon focus color */
        box-shadow: 0 0 0 3px rgba(139, 28, 28, 0.1);
    }

    .form-hint {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #6b7280;
    }

    /* Password show/hide toggle */
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
    }

    .toggle-password:hover {
        color: #4a1c1c;
    }

    .toggle-password svg {
        width: 18px;
        height: 18px;
    }

    .toggle-password .icon-eye-off {
        display: none;
    }

    .toggle-password.is-visible .icon-eye {
        display: none;
    }

    .toggle-password.is-visible .icon-eye-off {
        display: block;
    }

    /* Button & Action Styling */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn--primary {
        background-color: #8b1c1c; /* Maroon */
        color: #ffffff;
    }

    .btn--primary:hover {
        background-color: #6e1515;
    }

    .btn--ghost {
        background-color: transparent;
        color: #4b5563;
        border: 1px solid #d1d5db;
    }

    .btn--ghost:hover {
        background-color: #f3f4f6;
        color: #111827;
    }

    /* Alert Styling */
    .alert {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        max-width: 600px;
    }
    .alert--success {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert--error {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .alert ul {
        margin: 0;
        padding-left: 20px;
    }
</style>

<div class="page-wrapper">
    <div class="page-header">
        <h2 class="page-title">Change Password</h2>
        <p class="page-subtitle">Update your account password</p>
    </div>

    @if (session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert--error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.password.update') }}" method="POST" class="form-card">
        @csrf
        @method('PUT')


        <div class="form-row">
            <label for="password" class="form-label">
                New Password <span class="required">*</span>
            </label>
            <div class="input-wrapper">
                <input type="password"
                       name="password"
                       id="password"
                       class="form-input"
                       required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Show new password">
                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>
            <small class="form-hint">Minimum 8 characters with letters &amp; numbers.</small>
        </div>

        <div class="form-row">
            <label for="password_confirmation" class="form-label">
                Confirm New Password <span class="required">*</span>
            </label>
            <div class="input-wrapper">
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="form-input"
                       required>
                <button type="button" class="toggle-password" data-target="password_confirmation" aria-label="Show password confirmation">
                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary">Update Password</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = btn.getAttribute('data-target');
            var input = document.getElementById(targetId);
            var isVisible = input.type === 'text';

            input.type = isVisible ? 'password' : 'text';
            btn.classList.toggle('is-visible', !isVisible);
            btn.setAttribute('aria-label', isVisible ? 'Show password' : 'Hide password');
        });
    });
</script>
@endsection