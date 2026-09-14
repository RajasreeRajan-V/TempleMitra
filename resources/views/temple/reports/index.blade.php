@extends('temple.layouts.app')

@section('title', 'Temple Reports')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">Temple Reports</h1>
            <p class="page-subtitle">Overview of collections, receipts, vazhipads and devotees</p>
        </div>
    </div>
</div>

{{-- Date Filter --}}
<div class="report-filter-panel">
    <form method="GET" action="{{ route('temple.reports.index') }}" class="report-filter-form">

        <div class="report-filter-field report-filter-field--date">
            <label>
                <i class="fas fa-calendar-alt"></i> From
            </label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-input">
        </div>

        <div class="report-filter-field report-filter-field--date">
            <label>
                <i class="fas fa-calendar-alt"></i> To
            </label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-input">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i> Filter
        </button>

    </form>
</div>

{{-- Summary Cards --}}
<div class="report-index-stat-grid">

    {{--
        "Total Receipts Amount" now reflects PAID amounts only.
        Expects the controller to pass $totals['paid_amount'] and $totals['paid_count'],
        e.g.:
            Receipt::whereBetween('created_at', [$from, $to])
                ->where('payment_status', 'paid') // or ->whereNotNull('paid_amount')
                ->selectRaw('SUM(paid_amount) as paid_amount, COUNT(*) as paid_count')
                ->first();
        Falls back to the old $totals['receipts'] / $totals['receipts_count'] keys
        if paid-specific keys aren't present yet, so this doesn't break before the
        controller is updated.
    --}}
    <a href="{{ route('temple.reports.receipts', ['from_date' => $from, 'to_date' => $to]) }}" class="report-index-stat-card">
        <div class="stat-card" style="border:none;box-shadow:none;">
            <div class="stat-top">
                <div class="stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><line x1="9" y1="15" x2="13" y2="15"/></svg>
                </div>
                <span class="stat-delta">{{ $totals['paid_count'] ?? $totals['receipts_count'] }} paid</span>
            </div>
            <div class="stat-value">₹{{ number_format($totals['paid_amount'] ?? $totals['receipts'], 2) }}</div>
            <div class="stat-label">Total Paid Amount</div>
        </div>
    </a>

    

    <a href="{{ route('temple.reports.vazhipads', ['from_date' => $from, 'to_date' => $to]) }}" class="report-index-stat-card">
        <div class="stat-card stat-card--orange">
            <div class="stat-top">
                <div class="stat-icon stat-icon--orange">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/><path d="M6 21v-3a6 6 0 0 1 12 0v3"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totals['vazhipad_count'] ?? 0) }}</div>
            <div class="stat-label">TotalS Vazhipads</div>
        </div>
    </a>

<div class="report-index-stat-card">
    <div class="stat-card stat-card--red">
        <div class="stat-top">
            <div class="stat-icon stat-icon--red">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <span class="stat-delta">
                {{ $pendingCount ?? 0 }} pending
            </span>
        </div>

        <div class="stat-value">
            ₹{{ number_format($totalPending ?? 0, 2) }}
        </div>

        <div class="stat-label">
            Pending Payments
        </div>
    </div>
</div>

</div>

{{-- Charts Section --}}
<div class="report-charts-grid" style="display:grid;grid-template-columns:1.4fr 1fr;gap:20px;margin-top:24px;">

    {{-- Trend Chart: Collections over the selected date range --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-4 4"/></svg>
                Collection Trend
            </h2>
        </div>
        <div style="padding:16px;">
            <canvas id="collectionTrendChart" height="120"></canvas>
        </div>
    </div>

    {{-- Distribution Chart: Received vs Pending share of receipt amount --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 0 1 10 10h-10Z"/></svg>
                Received vs Pending
            </h2>
        </div>
        <div style="padding:16px;">
            <canvas id="revenueDistributionChart" height="200"></canvas>
        </div>
    </div>

</div>

{{-- Quick Links to Sub-Reports --}}
<div class="panel" style="margin-top:24px;">
    <div class="panel-header">
        <h2 class="panel-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
            Quick Access
        </h2>
    </div>
   
<a href="{{ route('temple.reports.daily') }}" class="btn btn-outline">
    <i class="fas fa-calendar-day"></i> Daily Report
</a>

<a href="{{ route('temple.reports.receipts', ['from_date'=>$from,'to_date'=>$to]) }}" class="btn btn-outline">
    <i class="fas fa-receipt"></i> Receipts
</a>

<a href="{{ route('temple.reports.vazhipads', ['from_date'=>$from,'to_date'=>$to]) }}" class="btn btn-outline">
    <i class="fas fa-hands-praying"></i> Vazhipads
</a>

@if(Route::has('temple.reports.pending'))
<a href="{{ route('temple.reports.pending', ['from_date'=>$from,'to_date'=>$to]) }}" class="btn btn-outline">
    <i class="fas fa-hourglass-half"></i> Pending Payments
</a>
@endif

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---- Data passed from the controller ----
    // $trend is expected as an associative array/collection built from the temple receipts table,
    // e.g. Receipt::whereBetween('created_at', [$from, $to])
    //          ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
    //          ->groupBy('date')->orderBy('date')->pluck('total', 'date');
    // ['2026-09-01' => 1200.50, '2026-09-02' => 980, ...]
    const trendLabels = @json(collect($trend ?? [])->keys());
    const trendValues = @json(collect($trend ?? [])->values());

    // "Received" side of the donut now mirrors the same paid-amount figure
    // shown on the "Total Paid Amount" stat card above.
    const totalReceipts = {{ (float) ($totals['paid_amount'] ?? $totals['receipts'] ?? 0) }};
    const totalPending  = {{ (float) ($totals['pending_amount'] ?? 0) }};

    // ---- Collection Trend (Line Chart) — driven by temple receipt amount ----
    new Chart(document.getElementById('collectionTrendChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Receipt Amount (₹)',
                data: trendValues,
                borderColor: '#f97316',
                backgroundColor: 'rgba(249,115,22,0.12)',
                borderWidth: 2,
                fill: true,
                tension: 0.35,
                pointRadius: 3,
                pointBackgroundColor: '#f97316'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => '₹' + Number(ctx.parsed.y).toLocaleString('en-IN')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => '₹' + Number(value).toLocaleString('en-IN')
                    }
                }
            }
        }
    });

    // ---- Received vs Pending (Doughnut Chart) ----
    new Chart(document.getElementById('revenueDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Received', 'Pending'],
            datasets: [{
                data: [totalReceipts, totalPending],
                backgroundColor: ['#3b82f6', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ctx.label + ': ₹' + Number(ctx.parsed).toLocaleString('en-IN')
                    }
                }
            },
            cutout: '65%'
        }
    });

});
</script>
@endpush