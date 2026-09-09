@extends('temple.layouts.app')

@section('title', 'Temple Dashboard')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 9 6h6z"/>
                <path d="M7 6h10l1.2 3H5.8z"/>
                <path d="M5 9h14v2H5z"/>
                <path d="M6 11h12v9H6z"/>
                <path d="M10 20v-4h4v4"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">
                {{ $temple->name ?? 'Sree Temple' }} — Dashboard
            </h1>

            <p class="page-subtitle">
                Namaskaram, {{ Auth::user()->name ?? 'Priest/Staff' }}.
                Here's today's temple activity summary.
            </p>
        </div>
    </div>

    <div class="page-header-actions">
        <a href="#" class="btn btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <path d="M12 3v12m0 0-4-4m4 4 4-4"/>
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
            </svg>
            Export Report
        </a>

        <a href="#" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            New Vazhipad
        </a>
    </div>
</div>


<!-- First Statistics Row -->
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                    <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
                </svg>
            </div>
            <span class="stat-delta">▲ +8%</span>
        </div>

        <div class="stat-value">
            {{ $todaysVazhipad ?? 62 }}
        </div>

        <div class="stat-label">
            Today's Vazhipad
        </div>
    </div>


    <div class="stat-card stat-card--gold">
        <div class="stat-top">
            <div class="stat-icon stat-icon--gold">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="14" r="6"/>
                    <circle cx="15" cy="9" r="6" opacity="0.5"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            ₹{{ number_format($todaysHundi ?? 24850) }}
        </div>

        <div class="stat-label">
            Today's Hundi Collection
        </div>
    </div>


    <div class="stat-card stat-card--orange">
        <div class="stat-top">
            <div class="stat-icon stat-icon--orange">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span class="stat-delta">▲ +3.4%</span>
        </div>

        <div class="stat-value">
            {{ number_format($devoteeFootfall ?? 418) }}
        </div>

        <div class="stat-label">
            Devotee Footfall Today
        </div>
    </div>


    <div class="stat-card stat-card--green">
        <div class="stat-top">
            <div class="stat-icon stat-icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3c-2 3-5 5-5 9a5 5 0 0 0 10 0c0-1.5-.6-2.5-1.3-3.5.1 1.4-.6 2-1.2 2 0-2-1-3-1.5-4.5-.3.9-.7 1.4-1 2z"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            {{ $poojasScheduled ?? 9 }}
        </div>

        <div class="stat-label">
            Poojas Scheduled Today
        </div>
    </div>

</div>


<!-- Second Statistics Row -->
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            {{ $staffOnDuty ?? 6 }}
        </div>

        <div class="stat-label">
            Staff / Priests On Duty
        </div>
    </div>


    <div class="stat-card stat-card--gold">
        <div class="stat-top">
            <div class="stat-icon stat-icon--gold">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="8" width="18" height="13" rx="1"/>
                    <path d="M3 12h18M12 8v13M7.5 8a2.5 2.5 0 0 1 0-5C10 3 12 8 12 8s2-5 4.5-5a2.5 2.5 0 0 1 0 5"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            {{ number_format($prasadamOrders ?? 134) }}
        </div>

        <div class="stat-label">
            Prasadam Orders Today
        </div>
    </div>


    <div class="stat-card stat-card--orange">
        <div class="stat-top">
            <div class="stat-icon stat-icon--orange">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="6" y="4" width="12" height="17" rx="2"/>
                    <path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            {{ $pendingApprovals ?? 4 }}
        </div>

        <div class="stat-label">
            Pending Approvals
        </div>
    </div>


    <div class="stat-card stat-card--green">
        <div class="stat-top">
            <div class="stat-icon stat-icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 3 2.5 5.5L20 9l-4 4 1 6-5-3-5 3 1-6-4-4 5.5-.5z"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            {{ $upcomingFestivals ?? 2 }}
        </div>

        <div class="stat-label">
            Upcoming Festivals (30d)
        </div>
    </div>

</div>


<!-- Hundi Chart -->
<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 7 13.5 15.5 8.5 10.5 2 17"/>
                <path d="M16 7h6v6"/>
            </svg>
            Hundi Collection Trend – Last 7 Days
        </h2>

        <span class="legend-dot">
            Hundi
        </span>
    </div>

    <div class="chart-wrap">
        <canvas id="hundiTrendChart"></canvas>
    </div>
</div>


@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

<script>
    const ctx = document.getElementById('hundiTrendChart');

    if (ctx) {
        // Colours pulled from the same oxide/brass palette used across
        // the sidebar and stat cards, so the chart doesn't feel bolted on.
        new Chart(ctx, {
            type: 'line',

            data: {
                labels: chartLabels,

                datasets: [{
                    label: 'Hundi Collection',
                    data: chartValues,

                    borderColor: '#63151f',
                    backgroundColor: 'rgba(99, 21, 31, 0.08)',

                    fill: true,
                    tension: 0.35,

                    pointBackgroundColor: '#63151f',
                    pointRadius: window.innerWidth < 640 ? 2 : 3,
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        ticks: {
                            callback: function (v) {
                                return '₹' + (v / 1000) + 'k';
                            }
                        },

                        grid: {
                            color: '#ecdfc4'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            autoSkip: true
                        }
                    }
                }
            }
        });
    }
</script>

@endpush