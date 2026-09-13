@extends('temple.layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="profile-page-wrapper">
        <div class="page-header-flex">
            <div>
                <h1 class="page-title">Change Password</h1>
                <p class="page-subtitle">Update your temple account password</p>
            </div>
        </div>

        <div class="custom-card">
            @if (session('success'))
                <div class="custom-alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('temple.password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group-custom">
                    <label for="current_password" class="form-label-custom">
                        Current Password
                    </label>

                    <input type="password" id="current_password" name="current_password"
                        class="form-input-custom @error('current_password') is-invalid @enderror"
                        value="{{ $currentPassword }}" placeholder="Current password" readonly>

                    @error('current_password')
                        <span class="error-text-custom">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">New Password</label>
                    <input type="password" id="password" name="password"
                        class="form-input-custom @error('password') is-invalid @enderror" placeholder="Enter new password">
                    @error('password')
                        <span class="error-text-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group-custom">
                    <label for="password_confirmation" class="form-label-custom">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input-custom"
                        placeholder="Confirm new password">
                </div>

                <div class="form-actions-custom">
                    <a href="{{ route('temple.profile') }}" class="btn-custom btn-secondary-custom">Cancel</a>
                    <button type="submit" class="btn-custom btn-primary-custom">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
