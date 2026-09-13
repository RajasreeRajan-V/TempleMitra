@extends('temple.layouts.app')

@section('title', 'Premium Dashboard')

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
                {{ $temple->temple_name ?? 'Sree Temple' }} — Premium Dashboard
            </h1>

            <p class="page-subtitle">
                Namaskaram, {{ Auth::user()->name ?? 'Priest/Staff' }}.
                Here's the overall temple activity summary.
            </p>
        </div>
    </div>

    <div class="page-header-actions">
      

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
            {{ $totalVazhipad ?? 62 }}
        </div>

        <div class="stat-label">
            Total Vazhipad
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
            ₹{{ number_format($totalHundi ?? 24850) }}
        </div>

        <div class="stat-label">
            Total Hundi Collection
        </div>
    </div>

</div>


<!-- Second Statistics Row -->
<div class="stat-grid">

    <div class="stat-card stat-card--gold">
        <div class="stat-top">
            <div class="stat-icon stat-icon--gold">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21s-7-4.35-9.5-9.1C1 8.5 2.7 5 6.2 5c1.9 0 3.3 1 4.3 2.4C11.5 6 12.9 5 14.8 5 18.3 5 20 8.5 18.5 11.9 16 16.65 12 21 12 21Z"/>
                </svg>
            </div>
        </div>

        <div class="stat-value">
            ₹{{ number_format($totalDonations ?? 158400) }}
        </div>

        <div class="stat-label">
            Total Donations
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
            {{ number_format($totalPrasadamOrders ?? 134) }}
        </div>

        <div class="stat-label">
            Total Prasadam Orders
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
        const chartLabels = {!! json_encode($chartLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!};
        const chartValues = {!! json_encode($chartValues ?? [18500, 22400, 19800, 26700, 31200, 42500, 24850]) !!};

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