@extends('layouts.app')

@section('title', 'Temple Registration')

@php
    $breadcrumb = 'Temple Registration';

    // Define Kerala districts as a fallback
    $keralaDistricts = [
        'Alappuzha',
        'Ernakulam',
        'Idukki',
        'Kannur',
        'Kasaragod',
        'Kollam',
        'Kottayam',
        'Kozhikode',
        'Malappuram',
        'Palakkad',
        'Pathanamthitta',
        'Thiruvananthapuram',
        'Thrissur',
        'Wayanad',
    ];

    // Use passed districts or fallback to Kerala districts
    $districtList = isset($districts) && is_array($districts) && count($districts) > 0 ? $districts : $keralaDistricts;
@endphp

@section('content')
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                <i class="fa-solid fa-gopuram"></i>
            </div>
            <div>
                <h1 class="page-title">Temple Management</h1>
                <p class="page-subtitle">Manage temple registrations and their details.</p>
            </div>
        </div>

        <div class="page-header-actions">
            <button class="btn btn-outline" onclick="window.location.href='#'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3v12m0 0-4-4m4 4 4-4" />
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
                </svg>
                Export
            </button>
            <button type="button" class="btn btn-primary" id="openRegisterModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Register Temple
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa-solid fa-gopuram"></i>
                </div>
                <span class="stat-delta"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"
                        style="vertical-align:1px;">
                        <polygon points="12 4 20 18 4 18" />
                    </svg> +{{ $growthPercentage ?? 8 }}%</span>
            </div>
            <div class="stat-value">{{ $totalTemples ?? 0 }}</div>
            <div class="stat-label">Total Temples</div>
        </div>

        <div class="stat-card stat-card--gold">
            <div class="stat-top">
                <div class="stat-icon stat-icon--gold">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $activeTemples ?? 0 }}</div>
            <div class="stat-label">Active Temples</div>
        </div>

        <div class="stat-card stat-card--orange">
            <div class="stat-top">
                <div class="stat-icon stat-icon--orange">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <span class="stat-delta"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"
                        style="vertical-align:1px;">
                        <polygon points="12 20 4 6 20 6" />
                    </svg> -{{ $inactivePercentage ?? 2 }}%</span>
            </div>
            <div class="stat-value">{{ $inactiveTemples ?? 0 }}</div>
            <div class="stat-label">Inactive Temples</div>
        </div>

        <div class="stat-card stat-card--green">
            <div class="stat-top">
                <div class="stat-icon stat-icon--green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $districtsCount ?? 0 }}</div>
            <div class="stat-label">Districts Covered</div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="panel" style="margin-bottom: 24px;">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="vertical-align:-3px; margin-right:6px;">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                Filter Temples
            </h2>
        </div>
        <form method="GET" action="{{ route('admin.temples-registration.index') }}" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" placeholder="Temple name, location..."
                        value="{{ request('search') }}" class="filter-input">
                </div>
                <div class="filter-group">
                    <label for="filter_district">District</label>
                    <select id="filter_district" name="district" class="filter-input">
                        <option value="">All Districts</option>
                        @foreach ($districtList as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="filter_status">Status</label>
                    <select id="filter_status" name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.temples-registration.index') }}" class="btn btn-outline"
                        style="margin-top: 22px;">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Temples Table -->
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="vertical-align:-3px; margin-right:6px;">
                    <rect x="9" y="2" width="6" height="4" rx="1" />
                    <path d="M9 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3" />
                    <line x1="8" y1="11" x2="16" y2="11" />
                    <line x1="8" y1="15" x2="16" y2="15" />
                    <line x1="8" y1="19" x2="13" y2="19" />
                </svg>
                Registered Temples
            </h2>
            <span class="legend-dot">{{ $temples->total() ?? 0 }} temples</span>
        </div>

        <div class="table-wrapper">
            <table class="temples-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Temple Name</th>
                        <th>District</th>
                        <th>Location</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($temples ?? [] as $temple)
                        <tr>
                            <td>#{{ $temple->id }}</td>
                            <td>
                                <div class="temple-info">
                                    @if ($temple->logo)
                                        <img src="{{ asset('storage/' . $temple->logo) }}"
                                            alt="{{ $temple->temple_name }}" class="temple-logo-small">
                                    @else
                                        <div class="temple-logo-placeholder">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <line x1="3" y1="22" x2="21" y2="22" />
                                                <line x1="6" y1="18" x2="6" y2="11" />
                                                <line x1="10" y1="18" x2="10" y2="11" />
                                                <line x1="14" y1="18" x2="14" y2="11" />
                                                <line x1="18" y1="18" x2="18" y2="11" />
                                                <polygon points="12 2 20 9 4 9" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="temple-name">{{ $temple->temple_name }}</div>
                                        <div class="temple-reg">{{ $temple->registration_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $temple->district }}</td>
                            <td>{{ $temple->location ?? 'Not specified' }}</td>
                            <td>
                                <div class="contact-info">
                                    <div>{{ $temple->contact_number ?? 'N/A' }}</div>
                                    <div class="temple-email">{{ $temple->email ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $temple->status }}"
                                    style="display: inline-flex; align-items: center; gap: 10px;">
                                    {{ ucfirst($temple->status) }}

                                    <!-- Activate/Deactivate Button -->
                                    @if ($temple->status === 'inactive')
                                        <form method="POST"
                                            action="{{ route('admin.temples-registration.activate', $temple->id) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to activate this temple?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn action-activate" title="Activate">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                    <polyline points="22 4 12 14.01 9 11.01" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ route('admin.temples-registration.deactivate', $temple->id) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to deactivate this temple?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn action-deactivate"
                                                title="Deactivate">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </span>
                            </td>
                            <td>{{ $temple->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.temples-registration.show', $temple->id) }}"
                                        class="action-btn action-view" title="View">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form method="POST"
                                        action="{{ route('admin.temples-registration.destroy', $temple->id) }}"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this temple?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-delete" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-gopuram"></i>
                                </div>
                                <p>No temples registered yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if (isset($temples) && $temples->hasPages())
            <div class="pagination-wrapper">
                {{ $temples->links() }}
            </div>
        @endif
    </div>

    <!-- ============================================ -->
    <!-- REGISTRATION MODAL - FIXED VERSION -->
    <!-- ============================================ -->
    <div id="registrationModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-header">
                <h2 class="modal-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="12" y1="18" x2="12" y2="12" />
                        <line x1="9" y1="15" x2="15" y2="15" />
                    </svg>
                    Register New Temple
                </h2>
                <button type="button" class="modal-close" id="closeModalBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.temples-registration.store') }}" enctype="multipart/form-data"
                id="registrationForm" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="quick-form-grid">
                        <div class="form-group">
                            <label for="modal_temple_name">Temple Name *</label>
                            <input type="text" id="modal_temple_name" name="temple_name" class="form-input" required
                                placeholder="Enter temple name">
                        </div>
                        <div class="form-group">
                            <label for="modal_district">District *</label>
                            <select id="modal_district" name="district" class="form-input" required>
                                <option value="">Select District</option>
                                @foreach ($districtList as $district)
                                    <option value="{{ $district }}">{{ $district }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_location">Location</label>
                            <input type="text" id="modal_location" name="location" class="form-input"
                                placeholder="e.g., City or Area">
                        </div>
                        <div class="form-group">
                            <label for="modal_contact_number">Contact Number</label>
                            <input type="tel" id="modal_contact_number" name="contact_number" class="form-input"
                                placeholder="e.g., 9876543210 or +91 98765 43210" pattern="^[0-9+\-\s()]{10,15}$"
                                title="Please enter a valid phone number (10-15 digits, may include +, -, spaces, or parentheses)">
                            <small class="phone-hint">Enter 10-15 digits (e.g., 9876543210 or +91 98765 43210)</small>
                            <span class="phone-error"
                                style="display: none; color: #c0392b; font-size: 12px; margin-top: 4px;">
                                Please enter a valid phone number (10-15 digits, +, -, spaces, or parentheses allowed)
                            </span>
                        </div>
                        <div class="form-group full-width">
                            <label for="modal_address">Address *</label>
                            <textarea id="modal_address" name="address" class="form-input" rows="2" required placeholder="Full address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="modal_email">Email</label>
                            <input type="email" id="modal_email" name="email" class="form-input"
                                placeholder="temple@example.com">
                        </div>
                        <div class="form-group">
                            <label for="modal_registration_number">Registration Number</label>
                            <input type="text" id="modal_registration_number" name="registration_number"
                                class="form-input" placeholder="Reg. number">
                        </div>
                        <div class="form-group">
                            <label for="modal_logo">Logo</label>
                            <input type="file" id="modal_logo" name="logo" class="form-input" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="modal_status">Status</label>
                            <select id="modal_status" name="status" class="form-input">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label for="modal_description">Description</label>
                            <textarea id="modal_description" name="description" class="form-input" rows="2"
                                placeholder="Brief description of the temple"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancelModalBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6" />
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2" />
                        </svg>
                        Register Temple
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END MODAL -->
@endsection

@push('styles')
    <style>
        /* Filter Grid */
        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 16px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-600);
        }

        .filter-input {
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 14px;
            background: #fff;
            color: var(--ink-900);
            width: 100%;
            font-family: inherit;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--maroon-600);
            box-shadow: 0 0 0 3px rgba(124, 31, 44, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Table Styles */
        .table-wrapper {
            overflow-x: auto;
            margin: 0 -4px;
        }

        .temples-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .temples-table thead {
            background: var(--cream-100);
        }

        .temples-table th {
            text-align: left;
            padding: 14px 16px;
            font-weight: 600;
            color: var(--ink-600);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid var(--line);
        }

        .temples-table td {
            padding: 16px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        .temples-table tbody tr:hover {
            background: var(--cream-50);
        }

        /* Temple Info */
        .temple-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .temple-logo-small {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        .temple-logo-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--cream-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-600);
            border: 1px solid var(--line);
        }

        .temple-name {
            font-weight: 600;
            color: var(--ink-900);
        }

        .temple-reg {
            font-size: 12px;
            color: var(--ink-400);
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .temple-email {
            font-size: 12px;
            color: var(--ink-400);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
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

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
            color: var(--ink-600);
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .action-view:hover {
            border-color: var(--maroon-600);
            background: var(--cream-100);
        }

        .action-activate {
            border-color: #27ae60;
            color: #27ae60;
        }

        .action-activate:hover {
            background: #eafaf1;
            border-color: #1e8449;
            color: #1e8449;
        }

        .action-deactivate {
            border-color: #f39c12;
            color: #f39c12;
        }

        .action-deactivate:hover {
            background: #fef9e7;
            border-color: #d68910;
            color: #d68910;
        }

        .action-delete:hover {
            border-color: #c0392b;
            background: #fee;
            color: #c0392b;
        }

        /* Tooltip for action buttons */
        .action-btn {
            position: relative;
        }

        .action-btn::after {
            content: attr(title);
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            background: #2c3e50;
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .action-btn:hover::after {
            opacity: 1;
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
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            overflow: hidden;
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

        /* Quick Form inside Modal */
        .quick-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
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

        .form-input::placeholder {
            color: var(--ink-400);
        }

        /* Phone validation styles */
        .phone-hint {
            color: var(--ink-400);
            font-size: 12px;
            margin-top: 4px;
        }

        .phone-error {
            color: #c0392b;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-input.phone-valid {
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }

        .form-input.phone-invalid {
            border-color: #c0392b;
            box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.15);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--ink-400);
        }

        .empty-icon {
            margin-bottom: 16px;
            opacity: 0.5;
            display: flex;
            justify-content: center;
        }

        .empty-icon .fa-gopuram {
            font-size: 64px;
            color: var(--ink-300);
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 16px;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper nav {
            display: flex;
            gap: 4px;
        }

        .pagination-wrapper .page-item {
            display: inline;
        }

        .pagination-wrapper .page-link {
            padding: 8px 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            color: var(--ink-600);
            text-decoration: none;
            font-size: 14px;
        }

        .pagination-wrapper .page-link:hover {
            background: var(--cream-100);
        }

        .pagination-wrapper .active .page-link {
            background: var(--maroon-700);
            color: #fff;
            border-color: var(--maroon-700);
        }

        /* Scrollbar styling */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: var(--cream-50);
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: var(--line);
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: var(--ink-400);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .filter-actions {
                grid-column: 1 / -1;
                justify-content: flex-start;
            }

            .quick-form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: 1;
            }

            .temples-table {
                font-size: 13px;
            }

            .temples-table th,
            .temples-table td {
                padding: 10px 12px;
            }

            .action-buttons {
                gap: 4px;
            }

            .action-btn {
                width: 28px;
                height: 28px;
            }
        }

        @media (max-width: 600px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header-actions {
                flex-wrap: wrap;
            }

            .page-header-actions .btn {
                flex: 1;
                justify-content: center;
            }

            .modal-container {
                max-width: 100%;
                max-height: 100vh;
                border-radius: 0;
                margin: 0;
            }

            .modal-header {
                padding: 16px 20px;
            }

            .modal-body {
                padding: 16px;
            }

            .modal-footer {
                padding: 16px 20px;
            }

            .action-buttons {
                flex-wrap: wrap;
            }
        }

        .form-input.error {
            border-color: #c0392b !important;
            box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.15) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get modal elements
            const modal = document.getElementById('registrationModal');
            const openBtn = document.getElementById('openRegisterModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const form = document.getElementById('registrationForm');
            const phoneInput = document.getElementById('modal_contact_number');
            const phoneError = document.querySelector('.phone-error');

            // Phone validation regex
            const phoneRegex = /^[0-9+\-\s()]{10,15}$/;

            // Function to validate phone number
            function validatePhone(value) {
                if (!value || value.trim() === '') {
                    return true; // Empty is valid (not required)
                }
                return phoneRegex.test(value.trim());
            }

            // Function to update phone validation UI
            function updatePhoneValidation(value) {
                const trimmedValue = value.trim();

                if (!trimmedValue) {
                    phoneInput.classList.remove('phone-valid', 'phone-invalid');
                    phoneError.style.display = 'none';
                    phoneInput.setCustomValidity('');
                    return true;
                }

                const isValid = phoneRegex.test(trimmedValue);

                if (isValid) {
                    phoneInput.classList.remove('phone-invalid');
                    phoneInput.classList.add('phone-valid');
                    phoneError.style.display = 'none';
                    phoneInput.setCustomValidity('');
                } else {
                    phoneInput.classList.remove('phone-valid');
                    phoneInput.classList.add('phone-invalid');
                    phoneError.style.display = 'block';
                    phoneInput.setCustomValidity('Please enter a valid phone number');
                }
                return isValid;
            }

            // Real-time phone validation on input
            phoneInput.addEventListener('input', function() {
                updatePhoneValidation(this.value);
            });

            // Real-time phone validation on blur
            phoneInput.addEventListener('blur', function() {
                updatePhoneValidation(this.value);
            });

            // Function to open modal
            function openModal() {
                modal.style.display = 'flex';
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    phoneInput.classList.remove('phone-valid', 'phone-invalid');
                    phoneError.style.display = 'none';
                }, 100);
            }

            // Function to close modal
            function closeModal() {
                modal.style.display = 'none';
                modal.classList.remove('active');
                document.body.style.overflow = '';
                form.reset();
                document.querySelectorAll('.form-input.error, .form-input.phone-invalid, .form-input.phone-valid')
                    .forEach(el => {
                        el.classList.remove('error', 'phone-invalid', 'phone-valid');
                    });
                phoneError.style.display = 'none';
                phoneInput.setCustomValidity('');
            }

            // Event listeners
            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeModal();
                }
            });

            // Form submission handler
            form.addEventListener('submit', function(e) {
                // Validate required fields
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('error');
                        isValid = false;
                    } else {
                        field.classList.remove('error');
                    }
                });

                // Validate phone
                const phoneValue = phoneInput.value.trim();
                if (phoneValue && !validatePhone(phoneValue)) {
                    phoneInput.classList.add('error', 'phone-invalid');
                    phoneError.style.display = 'block';
                    isValid = false;
                } else {
                    phoneInput.classList.remove('error', 'phone-invalid');
                    phoneError.style.display = 'none';
                }

                // If invalid, prevent submission and show errors
                if (!isValid) {
                    e.preventDefault();
                    const firstError = form.querySelector('.form-input.error, .form-input.phone-invalid');
                    if (firstError) {
                        firstError.focus();
                    }

                    // Show appropriate error message
                    if (phoneValue && !validatePhone(phoneValue)) {
                        alert(
                            'Please enter a valid phone number (10-15 digits, +, -, spaces, or parentheses allowed)'
                        );
                    } else {
                        alert('Please fill in all required fields correctly.');
                    }
                    return;
                }

                // If valid, let the form submit normally
            });

            // Remove error state on input
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('error');
                });
            });

            // Auto-submit filter on change
            document.querySelectorAll('.filter-input').forEach(input => {
                input.addEventListener('change', function() {
                    if (this.closest('form')) {
                        this.closest('form').submit();
                    }
                });
            });

            // Confirm delete
            document.querySelectorAll('.action-delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this temple?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush