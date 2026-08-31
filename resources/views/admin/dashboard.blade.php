@extends('layouts.app')

@section('title', 'Dashboard')

@php
    $breadcrumb = 'Dashboard';
@endphp

@section('content')
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">🎨</div>
            <div>
                <h1 class="page-title">Dashboard Overview</h1>
                <p class="page-subtitle">Welcome back, {{ Auth::user()->name ?? 'Anand' }}. Here's today's temple activity summary.</p>
            </div>
        </div>

        <div class="page-header-actions">
            <a href="#" class="btn btn-outline">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12m0 0-4-4m4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                Export Report
            </a>
            <a href="#" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                New Vazhipad
            </a>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">🙏</div>
                <span class="stat-delta">▲ +12%</span>
            </div>
            <div class="stat-value">{{ $todaysVazhipad ?? 155 }}</div>
            <div class="stat-label">Today's Vazhipad</div>
        </div>

        <div class="stat-card stat-card--gold">
            <div class="stat-top">
                <div class="stat-icon stat-icon--gold">₹</div>
            </div>
            <div class="stat-value">₹{{ number_format($todaysRevenue ?? 91669) }}</div>
            <div class="stat-label">Today's Revenue</div>
        </div>

        <div class="stat-card stat-card--orange">
            <div class="stat-top">
                <div class="stat-icon stat-icon--orange">📋</div>
                <span class="stat-delta">▲ +5.2%</span>
            </div>
            <div class="stat-value">{{ number_format($monthlyBookings ?? 3642) }}</div>
            <div class="stat-label">Monthly Bookings</div>
        </div>

        <div class="stat-card stat-card--green">
            <div class="stat-top">
                <div class="stat-icon stat-icon--green">⏱</div>
            </div>
            <div class="stat-value">{{ $pendingApprovals ?? 27 }}</div>
            <div class="stat-label">Pending Approvals</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">📈 Revenue Trend – Last 7 Days</h2>
            <span class="legend-dot">Vazhipad</span>
        </div>
        <canvas id="revenueTrendChart" height="90"></canvas>
    </div>
@endsection

@php
    $chartLabels = $revenueTrend['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $chartValues = $revenueTrend['values'] ?? [78000, 74000, 71000, 69000, 72000, 85000, 91669];
@endphp

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