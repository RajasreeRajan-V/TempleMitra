@extends('layouts.app')

@section('title', 'Temple Details - ' . $temple->temple_name)

@php
    $breadcrumb = 'Temple Details';
@endphp

@section('content')
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                <i class="fa-solid fa-gopuram"></i>
            </div>
            <div>
                <h1 class="page-title">{{ $temple->temple_name }}</h1>
                <p class="page-subtitle">View complete details of the registered temple.</p>
            </div>
        </div>

        <div class="page-header-actions">
            <button class="btn btn-outline" onclick="window.location.href='{{ route('admin.temples-registration.index') }}'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to List
            </button>
            <a href="{{ route('admin.temples-registration.edit', $temple->id) }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                </svg>
                Edit Temple
            </a>
        </div>
    </div>

    <!-- Temple Details Grid -->
    <div class="details-grid">
        <!-- Left Column - Temple Info -->
        <div class="details-card details-card--main">
            <div class="details-card-header">
                <h2 class="details-card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="2" width="6" height="4" rx="1"/>
                        <path d="M9 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3"/>
                    </svg>
                    Temple Information
                </h2>
                <span class="status-badge status-{{ $temple->status }}">
                    {{ ucfirst($temple->status) }}
                </span>
            </div>

            <div class="details-card-body">
                <div class="temple-profile">
                    <div class="temple-logo-large">
                        @if ($temple->logo)
                            <img src="{{ asset('storage/' . $temple->logo) }}" 
                                 alt="{{ $temple->temple_name }}" 
                                 class="temple-logo-img">
                        @else
                            <div class="temple-logo-placeholder-large">
                                <i class="fa-solid fa-gopuram" style="font-size: 48px; color: var(--ink-300);"></i>
                            </div>
                        @endif
                    </div>
                    <div class="temple-profile-info">
                        <h3 class="temple-profile-name">{{ $temple->temple_name }}</h3>
                        @if($temple->registration_number)
                            <p class="temple-profile-reg print-hide">Reg. No: {{ $temple->registration_number }}</p>
                        @endif
                        <p class="temple-profile-location">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            {{ $temple->location ?? 'Location not specified' }}, {{ $temple->district }}
                        </p>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Temple Name</label>
                        <p class="info-value">{{ $temple->temple_name }}</p>
                    </div>
                    <div class="info-item print-hide">
                        <label class="info-label">Registration Number</label>
                        <p class="info-value">{{ $temple->registration_number ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label class="info-label">District</label>
                        <p class="info-value">{{ $temple->district }}</p>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Location</label>
                        <p class="info-value">{{ $temple->location ?? 'Not specified' }}</p>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Contact Number</label>
                        <p class="info-value">{{ $temple->contact_number ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Email</label>
                        <p class="info-value">{{ $temple->email ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item full-width">
                        <label class="info-label">Address</label>
                        <p class="info-value">{{ $temple->address ?? 'Not specified' }}</p>
                    </div>
                    
                    <!-- Password Display (hidden on print) -->
                    <div class="info-item full-width password-section print-hide">
                        <label class="info-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-3px;">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Login Password
                        </label>
                        <div class="password-display-wrapper">
                            <div class="password-value" id="passwordDisplay">
                                @php
                                    $decryptedPassword = '';
                                    try {
                                        $decryptedPassword = \Illuminate\Support\Facades\Crypt::decryptString($temple->password);
                                    } catch (\Exception $e) {
                                        $decryptedPassword = 'Unable to decrypt password';
                                    }
                                @endphp
                                <span id="passwordText" class="password-hidden">••••••••••••</span>
                                <span id="passwordRevealed" class="password-revealed" style="display: none;">
                                    {{ $decryptedPassword }}
                                </span>
                            </div>
                            <div class="password-actions">
                                <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Toggle password visibility">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                                <button type="button" class="password-copy-btn" id="copyPasswordBtn" title="Copy password">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <small class="password-hint">Password is encrypted and stored securely.</small>
                    </div>
                    
                    @if($temple->description)
                        <div class="info-item full-width">
                            <label class="info-label">Description</label>
                            <p class="info-value">{{ $temple->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Additional Info -->
        <div class="details-sidebar">
            <!-- Status & Meta Info -->
            <div class="details-card">
                <div class="details-card-header">
                    <h2 class="details-card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Meta Information
                    </h2>
                </div>
                <div class="details-card-body">
                    <div class="meta-list">
                        <div class="meta-item">
                            <span class="meta-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </span>
                            <div>
                                <span class="meta-label">Registered On</span>
                                <span class="meta-value">{{ $temple->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    <polyline points="12 12 12 16 15 18"/>
                                </svg>
                            </span>
                            <div>
                                <span class="meta-label">Status</span>
                                <span class="meta-value">
                                    <span class="status-badge status-{{ $temple->status }}">
                                        {{ ucfirst($temple->status) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <div>
                                <span class="meta-label">Last Updated</span>
                                <span class="meta-value">{{ $temple->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="meta-item print-hide">
                            <span class="meta-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </span>
                            <div>
                                <span class="meta-label">Temple ID</span>
                                <span class="meta-value">#{{ $temple->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (hidden on print) -->
            <div class="details-card print-hide" id="quickActionsCard">
                <div class="details-card-header">
                    <h2 class="details-card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="22 3 22 15 16 15 16 21 2 21 2 3"/>
                            <line x1="16" y1="9" x2="22" y2="9"/>
                            <line x1="16" y1="13" x2="22" y2="13"/>
                            <line x1="6" y1="9" x2="12" y2="9"/>
                            <line x1="6" y1="13" x2="12" y2="13"/>
                        </svg>
                        Quick Actions
                    </h2>
                </div>
                <div class="details-card-body">
                    <div class="action-grid">
                        <a href="{{ route('admin.temples-registration.edit', $temple->id) }}" class="action-card">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                            </svg>
                            <span>Edit Temple</span>
                        </a>
                        
                        <!-- Change Password Button -->
                        <button type="button" class="action-card action-card--password" id="openChangePasswordModal">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                <circle cx="12" cy="16" r="1"/>
                            </svg>
                            <span>Change Password</span>
                        </button>
                        
                        <a href="#" class="action-card action-card--print" id="printDetailsBtn" onclick="window.print(); return false;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M18 9h3v6h-3"/>
                                <path d="M6 15H3V9h3"/>
                                <rect x="6" y="15" width="12" height="7" rx="1"/>
                                <line x1="9" y1="18" x2="15" y2="18"/>
                            </svg>
                            <span>Print Details</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section (Optional, hidden on print) -->
    @if($temple->latitude && $temple->longitude)
        <div class="details-card print-hide" style="margin-top: 24px;">
            <div class="details-card-header">
                <h2 class="details-card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                    </svg>
                    Location Map
                </h2>
            </div>
            <div class="details-card-body">
                <div id="temple-map" style="height: 300px; border-radius: 12px; background: var(--cream-100);">
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--ink-400);">
                        <p>Map integration requires Google Maps or Leaflet implementation</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal-overlay" style="display: none;">
        <div class="modal-container modal-container--password">
            <div class="modal-header">
                <h2 class="modal-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Change Password
                </h2>
                <button type="button" class="modal-close" id="closeChangePasswordModal">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.temples-registration.change-password', $temple->id) }}" id="changePasswordForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="password-change-info">
                        <p>Change the login password for <strong>{{ $temple->temple_name }}</strong></p>
                        <p style="font-size: 13px; color: var(--ink-400);">The new password will be encrypted and stored securely.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="password" class="form-input" required minlength="8" placeholder="Enter new password (min 8 characters)">
                        <small class="form-hint">Minimum 8 characters</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm Password</label>
                        <input type="password" id="new_password_confirmation" name="password_confirmation" class="form-input" required placeholder="Confirm new password">
                    </div>
                    
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar">
                            <div class="strength-level" id="strengthLevel" style="width: 0%;"></div>
                        </div>
                        <span class="strength-text" id="strengthText">Password strength: <span id="strengthLabel">Weak</span></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancelChangePassword">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitPasswordChange">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6"/>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Copy Toast Notification -->
    <div id="copyToast" class="copy-toast">Copied to clipboard</div>
@endsection

@push('styles')
    <style>
        /* Layout */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            margin-top: 24px;
        }

        /* Cards */
        .details-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--line);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .details-card--main {
            grid-row: span 2;
        }

        .details-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--cream-50);
        }

        .details-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
            color: var(--ink-900);
            margin: 0;
        }

        .details-card-title svg {
            color: var(--maroon-600);
        }

        .details-card-body {
            padding: 24px;
        }

        /* Temple Profile */
        .temple-profile {
            display: flex;
            gap: 24px;
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--line);
        }

        .temple-logo-large {
            flex-shrink: 0;
        }

        .temple-logo-img {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid var(--line);
        }

        .temple-logo-placeholder-large {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            background: var(--cream-100);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed var(--line);
        }

        .temple-profile-info {
            flex: 1;
        }

        .temple-profile-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--ink-900);
            margin: 0 0 4px 0;
        }

        .temple-profile-reg {
            font-size: 14px;
            color: var(--ink-400);
            margin: 0 0 8px 0;
        }

        .temple-profile-location {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--ink-600);
            margin: 0;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-item.full-width {
            grid-column: 1 / -1;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--ink-400);
        }

        .info-value {
            font-size: 15px;
            color: var(--ink-900);
            margin: 0;
            line-height: 1.6;
        }

        /* Password Display */
        .password-section {
            background: var(--cream-50);
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid var(--line);
        }

        .password-display-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 4px;
        }

        .password-value {
            flex: 1;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Courier New', monospace;
            color: var(--ink-900);
            letter-spacing: 1px;
            padding: 6px 0;
        }

        .password-hidden {
            letter-spacing: 4px;
            color: var(--ink-500);
        }

        .password-revealed {
            color: var(--maroon-700);
            word-break: break-all;
        }

        .password-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        .password-toggle-btn,
        .password-copy-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--ink-600);
            transition: all 0.15s ease;
        }

        .password-toggle-btn:hover,
        .password-copy-btn:hover {
            background: var(--cream-100);
            border-color: var(--maroon-600);
            color: var(--maroon-600);
        }

        .password-toggle-btn:active,
        .password-copy-btn:active {
            transform: scale(0.95);
        }

        .password-hint {
            font-size: 12px;
            color: var(--ink-400);
            margin-top: 6px;
            display: block;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-active {
            background: var(--green-100);
            color: var(--green-600);
        }

        .status-inactive {
            background: #fee;
            color: #c0392b;
        }

        /* Meta List */
        .meta-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .meta-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--cream-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-600);
            flex-shrink: 0;
        }

        .meta-item div {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .meta-label {
            font-size: 12px;
            color: var(--ink-400);
        }

        .meta-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink-900);
        }

        /* Action Grid */
        .action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 16px 12px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: #fff;
            text-decoration: none;
            color: var(--ink-700);
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
            width: 100%;
        }

        .action-card:hover {
            border-color: var(--maroon-600);
            background: var(--cream-50);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .action-card svg {
            color: var(--maroon-600);
        }

        .action-card--password:hover {
            border-color: #f39c12;
            background: #fef9e7;
        }

        .action-card--password:hover svg {
            color: #f39c12;
        }

        .action-card--print:hover {
            border-color: #2980b9;
            background: #ebf5fb;
        }

        .action-card--print svg {
            color: #2980b9;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-container {
            background: #fff;
            border-radius: 16px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            overflow: hidden;
        }

        .modal-container--password {
            max-width: 450px;
        }

        .modal-container form {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
            height: 100%;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--cream-50);
            flex-shrink: 0;
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 700;
            color: var(--ink-900);
            margin: 0;
        }

        .modal-title svg {
            color: var(--maroon-600);
        }

        .modal-close {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: var(--ink-400);
            border-radius: 8px;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: #fee;
            color: #c0392b;
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: var(--cream-50);
            flex-shrink: 0;
            margin-top: auto;
        }

        .password-change-info {
            margin-bottom: 20px;
        }

        .password-change-info p {
            margin: 0 0 4px 0;
            color: var(--ink-700);
        }

        /* Form Styles */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 16px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-600);
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 14px;
            background: #fff;
            color: var(--ink-900);
            font-family: inherit;
            width: 100%;
            transition: all 0.15s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--maroon-600);
            box-shadow: 0 0 0 3px rgba(124, 31, 44, 0.1);
        }

        .form-input.error {
            border-color: #c0392b !important;
            box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.15) !important;
        }

        .form-hint {
            font-size: 12px;
            color: var(--ink-400);
        }

        /* Password Strength */
        .password-strength {
            margin-top: 8px;
        }

        .strength-bar {
            width: 100%;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-level {
            height: 100%;
            border-radius: 2px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .strength-text {
            font-size: 12px;
            color: var(--ink-400);
            margin-top: 4px;
            display: block;
        }

        .strength-text #strengthLabel {
            font-weight: 600;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            background: #fff;
            color: var(--ink-700);
        }

        .btn-outline {
            border-color: var(--line);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--cream-50);
            border-color: var(--ink-400);
        }

        .btn-primary {
            background: var(--maroon-700);
            color: #fff;
            border-color: var(--maroon-700);
        }

        .btn-primary:hover {
            background: var(--maroon-800);
            border-color: var(--maroon-800);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 31, 44, 0.2);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Copy Toast */
        .copy-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2c3e50;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .copy-toast.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .details-card--main {
                grid-row: auto;
            }
        }

        @media (max-width: 768px) {
            .temple-profile {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .temple-profile-location {
                justify-content: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-grid {
                grid-template-columns: 1fr 1fr;
            }

            .password-display-wrapper {
                flex-wrap: wrap;
            }

            .modal-container {
                max-width: 100%;
                max-height: 100vh;
                border-radius: 0;
                margin: 0;
            }
        }

        @media (max-width: 480px) {
            .action-grid {
                grid-template-columns: 1fr;
            }

            .page-header-actions {
                flex-direction: column;
            }

            .page-header-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .modal-header {
                padding: 16px 20px;
            }

            .modal-body {
                padding: 16px;
            }

            .modal-footer {
                padding: 16px 20px;
                flex-direction: column;
            }

            .modal-footer .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* ============================
           Print Styles — single page
           ============================ */
        @media print {
            @page {
                size: A4;
                margin: 10mm 12mm;
            }

            html, body {
                background: #fff !important;
                font-size: 11px !important;
            }

            /* Hide everything that isn't part of the printable report
               (print-hide covers: registration number, password section,
               quick actions, map, page header) */
            .page-header,
            .page-header-actions,
            #quickActionsCard,
            .print-hide,
            .details-card--main .details-card-header .status-badge,
            .modal-overlay,
            .copy-toast {
                display: none !important;
            }

            /* Keep the two-column layout on paper — stacking to one column
               makes the sheet run long. Side-by-side uses far less height. */
            .details-grid {
                display: grid !important;
                grid-template-columns: 1fr 230px !important;
                gap: 12px !important;
                margin-top: 0 !important;
            }

            .details-card--main {
                grid-row: auto !important;
            }

            .details-card {
                break-inside: avoid;
                page-break-inside: avoid;
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                border-radius: 6px !important;
                margin-bottom: 10px !important;
            }

            .details-card-header {
                padding: 8px 12px !important;
                background: #f8f8f8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .details-card-title {
                font-size: 13px !important;
                gap: 6px !important;
            }

            .details-card-title svg {
                width: 14px !important;
                height: 14px !important;
            }

            .details-card-body {
                padding: 10px 12px !important;
            }

            /* Compact the temple profile block */
            .temple-profile {
                gap: 12px !important;
                padding-bottom: 10px !important;
                margin-bottom: 10px !important;
            }

            .temple-logo-img,
            .temple-logo-placeholder-large {
                width: 64px !important;
                height: 64px !important;
                border-radius: 8px !important;
            }

            .temple-logo-placeholder-large svg,
            .temple-logo-placeholder-large i {
                font-size: 24px !important;
            }

            .temple-profile-name {
                font-size: 15px !important;
                margin: 0 0 2px 0 !important;
            }

            .temple-profile-reg {
                font-size: 10px !important;
                margin: 0 0 4px 0 !important;
            }

            .temple-profile-location {
                font-size: 10px !important;
            }

            /* Compact the info grid */
            .info-grid {
                gap: 8px 16px !important;
            }

            .info-item {
                gap: 1px !important;
            }

            .info-label {
                font-size: 8.5px !important;
            }

            .info-value {
                font-size: 10.5px !important;
                line-height: 1.35 !important;
            }

            /* Compact the meta list */
            .meta-list {
                gap: 8px !important;
            }

            .meta-icon {
                width: 22px !important;
                height: 22px !important;
            }

            .meta-icon svg {
                width: 13px !important;
                height: 13px !important;
            }

            .meta-label {
                font-size: 8.5px !important;
            }

            .meta-value {
                font-size: 10.5px !important;
            }

            .status-badge {
                padding: 2px 8px !important;
                font-size: 10px !important;
            }

            .temple-profile,
            .info-grid,
            .meta-item {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            /* Avoid clipping/scroll on long content */
            .modal-body,
            .details-card-body {
                overflow: visible !important;
            }

            a[href]:after {
                content: "" !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle and copy functionality
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const copyBtn = document.getElementById('copyPasswordBtn');
            const passwordText = document.getElementById('passwordText');
            const passwordRevealed = document.getElementById('passwordRevealed');
            const toast = document.getElementById('copyToast');
            let isVisible = false;

            // Toggle password visibility
            toggleBtn.addEventListener('click', function() {
                isVisible = !isVisible;
                if (isVisible) {
                    passwordText.style.display = 'none';
                    passwordRevealed.style.display = 'inline';
                    this.innerHTML = `
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    `;
                    this.title = 'Hide password';
                } else {
                    passwordText.style.display = 'inline';
                    passwordRevealed.style.display = 'none';
                    this.innerHTML = `
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    `;
                    this.title = 'Toggle password visibility';
                }
            });

            // Copy password
            copyBtn.addEventListener('click', function() {
                const password = passwordRevealed.textContent.trim();
                if (password && password !== 'Unable to decrypt password') {
                    navigator.clipboard.writeText(password).then(() => {
                        showToast();
                    }).catch(() => {
                        const tempInput = document.createElement('input');
                        tempInput.value = password;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);
                        showToast();
                    });
                } else {
                    alert('Unable to copy password. Please check if the password is valid.');
                }
            });

            function showToast() {
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 2000);
            }

            // =============================================
            // PRINT BUTTON (belt-and-braces JS handler)
            // =============================================
            const printBtn = document.getElementById('printDetailsBtn');
            if (printBtn) {
                printBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.print();
                });
            }

            // =============================================
            // CHANGE PASSWORD MODAL FUNCTIONALITY
            // =============================================
            const modal = document.getElementById('changePasswordModal');
            const openModalBtn = document.getElementById('openChangePasswordModal');
            const closeModalBtn = document.getElementById('closeChangePasswordModal');
            const cancelBtn = document.getElementById('cancelChangePassword');
            const passwordForm = document.getElementById('changePasswordForm');
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const submitBtn = document.getElementById('submitPasswordChange');

            // Password strength elements
            const strengthLevel = document.getElementById('strengthLevel');
            const strengthLabel = document.getElementById('strengthLabel');

            // Open modal
            openModalBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                newPasswordInput.value = '';
                confirmPasswordInput.value = '';
                strengthLevel.style.width = '0%';
                strengthLabel.textContent = 'Weak';
                strengthLevel.style.backgroundColor = '#dc3545';
                newPasswordInput.classList.remove('error');
                confirmPasswordInput.classList.remove('error');
            });

            // Close modal functions
            function closeModal() {
                modal.style.display = 'none';
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close on outside click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeModal();
                }
            });

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                let label = 'Weak';
                let color = '#dc3545';
                let width = 25;

                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
                if (/\d/.test(password)) strength += 1;
                if (/[^a-zA-Z0-9]/.test(password)) strength += 1;

                if (strength <= 2) {
                    label = 'Weak';
                    color = '#dc3545';
                    width = 25;
                } else if (strength === 3) {
                    label = 'Fair';
                    color = '#f39c12';
                    width = 50;
                } else if (strength === 4) {
                    label = 'Good';
                    color = '#3498db';
                    width = 75;
                } else if (strength >= 5) {
                    label = 'Strong';
                    color = '#27ae60';
                    width = 100;
                }

                return { label, color, width };
            }

            // Update password strength on input
            newPasswordInput.addEventListener('input', function() {
                const password = this.value;
                if (password.length === 0) {
                    strengthLevel.style.width = '0%';
                    strengthLabel.textContent = 'Weak';
                    strengthLevel.style.backgroundColor = '#dc3545';
                    return;
                }

                const result = checkPasswordStrength(password);
                strengthLevel.style.width = result.width + '%';
                strengthLevel.style.backgroundColor = result.color;
                strengthLabel.textContent = result.label;
            });

            // Form validation
            passwordForm.addEventListener('submit', function(e) {
                let isValid = true;
                const password = newPasswordInput.value;
                const confirm = confirmPasswordInput.value;

                // Validate password length
                if (password.length < 8) {
                    newPasswordInput.classList.add('error');
                    isValid = false;
                } else {
                    newPasswordInput.classList.remove('error');
                }

                // Validate password match
                if (password !== confirm) {
                    confirmPasswordInput.classList.add('error');
                    isValid = false;
                } else {
                    confirmPasswordInput.classList.remove('error');
                }

                if (!isValid) {
                    e.preventDefault();
                    if (password.length < 8) {
                        alert('Password must be at least 8 characters long.');
                    } else if (password !== confirm) {
                        alert('Passwords do not match.');
                    }
                }
            });

            // Clear errors on input
            newPasswordInput.addEventListener('input', function() {
                this.classList.remove('error');
            });

            confirmPasswordInput.addEventListener('input', function() {
                this.classList.remove('error');
            });
        });
    </script>
@endpush