@extends('temple.layouts.app')

@section('title', 'Collections Report')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="8" cy="14" r="6"/><circle cx="15" cy="9" r="6" opacity=".5"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">Collections Report</h1>
            <p class="page-subtitle">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} <span class="em-dash">—</span> {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('temple.reports.index') }}" class="btn btn-outline">← Reports</a>
        <a href="{{ route('temple.reports.collections.excel', request()->only(['from_date','to_date','source'])) }}" class="btn btn-outline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Excel
        </a>
        <a href="{{ route('temple.reports.collections.pdf', request()->only(['from_date','to_date','source'])) }}" target="_blank" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            PDF / Print
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="report-filter-panel">
    <form method="GET" action="{{ route('temple.reports.collections') }}" class="report-filter-form">
        <div class="report-filter-field report-filter-field--date">
            <label>📅 From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-input">
        </div>
        <div class="report-filter-field report-filter-field--date">
            <label>📅 To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-input">
        </div>
        <div class="report-filter-field">
            <label>Source</label>
            <input type="text" name="source" value="{{ request('source') }}" placeholder="e.g. Hundi" class="form-input" style="width:160px;">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<div class="report-collections-layout">

    {{-- Main Table --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="14" r="6"/><circle cx="15" cy="9" r="6" opacity=".5"/></svg>
                {{ $collections->total() }} entries
            </h2>
            <span class="panel-amount-badge">₹{{ number_format($totalAmount, 2) }}</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Source</th>
                        <th>Collected By</th>
                        <th>Remarks</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collections as $collection)
                        <tr>
                            <td>{{ optional($collection->collection_date)->format('d-m-Y') ?? '—' }}</td>
                            <td>{{ $collection->source }}</td>
                            <td>{{ $collection->collected_by ?? '—' }}</td>
                            <td>{{ $collection->remarks ?? '—' }}</td>
                            <td class="text-right">₹{{ number_format($collection->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-row">No collections found for the selected filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pagination-wrap">{{ $collections->links() }}</div>
    </div>

    {{-- Source Breakdown --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">By Source</h2>
        </div>
        <div style="padding:4px 0;">
            @forelse($bySource as $row)
                <div class="report-source-list-item">
                    <span class="report-source-list-item__label">{{ $row->source }}</span>
                    <span class="report-source-list-item__amount">₹{{ number_format($row->total, 2) }}</span>
                </div>
            @empty
                <p style="padding:16px 20px; color:var(--ink-400); font-size:13px;">No data</p>
            @endforelse
        </div>
    </div>
</div>

@endsection