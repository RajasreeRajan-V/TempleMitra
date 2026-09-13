@extends('temple.layouts.app')

@section('title', 'Daily Report')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">Daily Report</h1>
            <p class="page-subtitle">Temple transactions for {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('temple.reports.daily.excel', ['date' => $date]) }}" class="btn btn-outline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Excel
        </a>
        <a href="{{ route('temple.reports.daily.pdf', ['date' => $date]) }}" target="_blank" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            PDF / Print
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="report-filter-panel">
    <form method="GET" action="{{ route('temple.reports.daily') }}" class="report-filter-form">
        <div class="report-filter-field report-filter-field--date">
            <label>📅 Report Date</label>
            <input type="date" name="date" value="{{ $date }}" class="form-input">
        </div>
        <button type="submit" class="btn btn-primary">Generate</button>
    </form>
</div>

{{-- Summary Cards --}}
<div class="stat-grid" style="margin-bottom:20px;">
    <div class="stat-card">
        <div class="stat-top"><div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/></svg></div></div>
        <div class="stat-value">{{ $totalReceipts }}</div>
        <div class="stat-label">Total Receipts</div>
    </div>
    <div class="stat-card stat-card--gold">
        <div class="stat-top"><div class="stat-icon stat-icon--gold"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="8" cy="14" r="6"/><circle cx="15" cy="9" r="6" opacity=".5"/></svg></div></div>
        <div class="stat-value">₹{{ number_format($totalAmount, 2) }}</div>
        <div class="stat-label">Total Amount</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="8" width="18" height="13" rx="1"/><path d="M3 12h18"/></svg></div></div>
        <div class="stat-value">₹{{ number_format($collectionAmount, 2) }}</div>
        <div class="stat-label">Hundi / Collections</div>
    </div>
    <div class="stat-card stat-card--orange">
        <div class="stat-top"><div class="stat-icon stat-icon--orange"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg></div></div>
        <div class="stat-value">{{ $collectionCount }}</div>
        <div class="stat-label">Collection Entries</div>
    </div>
</div>

{{-- Transactions Table --}}
<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            Daily Transactions
        </h2>
        <span class="panel-amount-badge">₹{{ number_format($receipts->sum('total_amount'), 2) }}</span>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Receipt No</th>
                    <th>Devotee</th>
                    <th>Vazhipad(s)</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $i => $receipt)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $receipt->id }}</td>
                        <td>{{ $receipt->devotee_name ?? '—' }}</td>
                        <td>{{ $receipt->items->pluck('vazhipad.name')->filter()->implode(', ') ?: '—' }}</td>
                        <td>{{ ucfirst($receipt->payment_method ?? '—') }}</td>
                        <td>
                            <span class="badge {{ $receipt->payment_status === 'paid' ? 'badge--green' : 'badge--orange' }}">
                                {{ ucfirst($receipt->payment_status ?? '—') }}
                            </span>
                        </td>
                        <td class="text-right">₹{{ number_format($receipt->total_amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">No transactions found for this date.</td>
                    </tr>
                @endforelse
            </tbody>
            @if($receipts->isNotEmpty())
            <tfoot>
                <tr class="report-table-total-row">
                    <td colspan="6" style="text-align:right;">Grand Total</td>
                    <td class="text-right">₹{{ number_format($receipts->sum('total_amount'), 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection