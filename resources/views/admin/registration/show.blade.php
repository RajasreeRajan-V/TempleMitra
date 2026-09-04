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
                            <p class="temple-profile-reg">Reg. No: {{ $temple->registration_number }}</p>
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
                    <div class="info-item">
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
                        <div class="meta-item">
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

            <!-- Quick Actions -->
            <div class="details-card">
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
                        <a href="#" class="action-card action-card--print" onclick="window.print()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M18 9h3v6h-3"/>
                                <path d="M6 15H3V9h3"/>
                                <rect x="6" y="15" width="12" height="7" rx="1"/>
                                <line x1="9" y1="18" x2="15" y2="18"/>
                            </svg>
                            <span>Print Details</span>
                        </a>
                        <form method="POST" action="{{ route('admin.temples-registration.destroy', $temple->id) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this temple?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-card action-card--danger">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/>
                                    <path d="M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                                <span>Delete Temple</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section (Optional) -->
    @if($temple->latitude && $temple->longitude)
        <div class="details-card" style="margin-top: 24px;">
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
                    <!-- Map implementation would go here -->
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--ink-400);">
                        <p>Map integration requires Google Maps or Leaflet implementation</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
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

        .action-card--print:hover {
            border-color: #2980b9;
            background: #ebf5fb;
        }

        .action-card--print svg {
            color: #2980b9;
        }

        .action-card--danger {
            border-color: #fee;
        }

        .action-card--danger:hover {
            border-color: #c0392b;
            background: #fee;
        }

        .action-card--danger svg {
            color: #c0392b;
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
        }

        /* Print Styles */
        @media print {
            .page-header-actions,
            .action-grid,
            .details-card--main .details-card-header .status-badge {
                display: none !important;
            }

            .details-card {
                break-inside: avoid;
                border: 1px solid #ddd !important;
            }

            .details-card-header {
                background: #f8f8f8 !important;
            }
        }
    </style>
@endpush