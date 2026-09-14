@extends('layouts.app')

@section('title', 'Admin Dashboard')

@php
    $breadcrumb = 'Dashboard';
@endphp

@section('content')
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                {{-- Landmark / Temple icon --}}
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="22" x2="21" y2="22"/>
                    <line x1="6" y1="18" x2="6" y2="11"/>
                    <line x1="10" y1="18" x2="10" y2="11"/>
                    <line x1="14" y1="18" x2="14" y2="11"/>
                    <line x1="18" y1="18" x2="18" y2="11"/>
                    <polygon points="12 2 20 7 4 7"/>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Admin Dashboard</h1>
                <p class="page-subtitle">
                    Welcome back, {{ Auth::user()->name ?? 'Admin' }}. Here's the platform overview.
                </p>
            </div>
        </div>

        <div class="page-header-actions">
           
            <a href="{{ route('admin.temples-registration.create') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Register Temple
            </a>
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    {{-- Landmark / Temple icon --}}
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="22" x2="21" y2="22"/>
                        <line x1="6" y1="18" x2="6" y2="11"/>
                        <line x1="10" y1="18" x2="10" y2="11"/>
                        <line x1="14" y1="18" x2="14" y2="11"/>
                        <line x1="18" y1="18" x2="18" y2="11"/>
                        <polygon points="12 2 20 7 4 7"/>
                    </svg>
                </div>
                @if($growthPercentage != 0)
                    <span class="stat-delta {{ $growthPercentage > 0 ? '' : 'stat-delta--down' }}">
                        {{ $growthPercentage > 0 ? '▲' : '▼' }} {{ abs($growthPercentage) }}%
                    </span>
                @endif
            </div>
            <div class="stat-value">{{ number_format($totalTemples) }}</div>
            <div class="stat-label">Total Temples</div>
        </div>

        <div class="stat-card stat-card--green">
            <div class="stat-top">
                <div class="stat-icon stat-icon--green">
                    {{-- Check-circle icon --}}
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <span class="stat-delta">+{{ $newTemplesThisMonth }} this month</span>
            </div>
            <div class="stat-value">{{ number_format($activeTemples) }}</div>
            <div class="stat-label">Active Temples</div>
        </div>

        <div class="stat-card stat-card--orange">
            <div class="stat-top">
                <div class="stat-icon stat-icon--orange">
                    {{-- Clipboard / Receipt icon --}}
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                        <line x1="8" y1="11" x2="16" y2="11"/>
                        <line x1="8" y1="15" x2="13" y2="15"/>
                    </svg>
                </div>
                <span class="stat-delta">{{ $inactivePercentage }}% inactive</span>
            </div>
            <div class="stat-value">{{ number_format($todaysReceipts) }}</div>
            <div class="stat-label">Today's Receipts</div>
        </div>
    </div>

    {{-- ===== REVENUE TREND CHART ===== --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                {{-- Trending-up icon --}}
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px;margin-right:6px;">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                    <polyline points="17 6 23 6 23 12"/>
                </svg>
                Revenue Trend – Last 7 Days
            </h2>
            <span class="legend-dot">Revenue</span>
        </div>
        <canvas id="revenueTrendChart" height="90"></canvas>
    </div>

    {{-- ===== BOTTOM PANELS ===== --}}
    <div class="dashboard-row">
        {{-- Recent Temple Registrations --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    {{-- Landmark icon --}}
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px;margin-right:6px;">
                        <line x1="3" y1="22" x2="21" y2="22"/>
                        <line x1="6" y1="18" x2="6" y2="11"/>
                        <line x1="10" y1="18" x2="10" y2="11"/>
                        <line x1="14" y1="18" x2="14" y2="11"/>
                        <line x1="18" y1="18" x2="18" y2="11"/>
                        <polygon points="12 2 20 7 4 7"/>
                    </svg>
                    Recent Temple Registrations
                </h2>
                <a href="{{ route('admin.temples-registration.index') }}" class="btn btn-outline btn-sm">View All</a>
            </div>

            @if($recentTemples->count())
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Temple</th>
                            <th>District</th>
                            <th>Status</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTemples as $temple)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.temples-registration.show', $temple->id) }}">
                                        {{ $temple->temple_name }}
                                    </a>
                                </td>
                                <td>{{ $temple->district ?? '—' }}</td>
                                <td>
                                    <span class="badge badge--{{ $temple->status === 'active' ? 'green' : 'orange' }}">
                                        {{ ucfirst($temple->status) }}
                                    </span>
                                </td>
                                <td>{{ $temple->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty-state">No temples registered yet.</p>
            @endif
        </div>

        {{-- District-wise Temples --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    {{-- Map-pin icon --}}
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px;margin-right:6px;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Top Districts by Temples
                </h2>
            </div>

            @if($districtWiseTemples->count())
                <ul class="district-list">
                    @foreach($districtWiseTemples as $row)
                        <li>
                            <span class="district-name">{{ $row->district }}</span>
                            <span class="district-count">{{ $row->count }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="empty-state">No district data available.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const ctx = document.getElementById('revenueTrendChart');
        const chartLabels = {!! json_encode($chartLabels) !!};
        const chartValues = {!! json_encode($chartValues) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Revenue',
                    data: chartValues,
                    borderColor: '#7c1f2c',
                    backgroundColor: 'rgba(124,31,44,0.08)',
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#7c1f2c',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { callback: v => '₹' + (v / 1000) + 'k' }, grid: { color: '#efe3c8' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
@endpush