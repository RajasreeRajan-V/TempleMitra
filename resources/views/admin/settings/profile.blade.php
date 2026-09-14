@extends('layouts.app')

@section('title', 'Update Profile')

@section('content')
<style>
    /* Scoped styles for the profile page */
    .page-wrapper {
        padding: 30px;
        background-color: #fcf9f2; /* Matches the cream background in your screenshot */
        min-height: 100vh;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #4a1c1c; /* Dark maroon matching your sidebar */
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
    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 15px;
        color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        background-color: #ffffff;
    }

    .form-input:focus {
        border-color: #8b1c1c; /* Maroon focus color */
        box-shadow: 0 0 0 3px rgba(139, 28, 28, 0.1);
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
        background-color: #8b1c1c; /* Matches your sidebar maroon */
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
        <h2 class="page-title">Update Profile</h2>
        <p class="page-subtitle">Update your name and email address</p>
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

    <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-row">
            <label for="name" class="form-label">
                Full Name <span class="required">*</span>
            </label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $admin->name) }}"
                   class="form-input"
                   required>
        </div>

        <div class="form-row">
            <label for="email" class="form-label">
                Email Address <span class="required">*</span>
            </label>
            <input type="email"
                   name="email"
                   id="email"
                   value="{{ old('email', $admin->email) }}"
                   class="form-input"
                   required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary">Save Changes</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection