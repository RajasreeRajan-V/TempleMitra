@extends('temple.layouts.app')

@section('title', 'Devotees Report')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">Devotees Report</h1>
            <p class="page-subtitle">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} <span class="em-dash">—</span> {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('temple.reports.index') }}" class="btn btn-outline">← Reports</a>
        <a href="{{ route('temple.reports.devotees.excel', request()->only(['from_date','to_date','search'])) }}" class="btn btn-outline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Excel
        </a>
        <a href="{{ route('temple.reports.devotees.pdf', request()->only(['from_date','to_date','search'])) }}" target="_blank" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            PDF / Print
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="report-filter-panel">
    <form method="GET" action="{{ route('temple.reports.devotees') }}" class="report-filter-form">
        <div class="report-filter-field report-filter-field--date">
            <label>📅 From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-input">
        </div>
        <div class="report-filter-field report-filter-field--date">
            <label>📅 To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-input">
        </div>
        <div class="report-filter-field">
            <label>Search</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Name, phone or email" class="form-input" style="width:200px;">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
            {{ $devotees->total() }} devotees
        </h2>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th class="text-right">Receipts</th>
                    <th class="text-right">Total Contribution</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devotees as $i => $devotee)
                    <tr>
                        <td>{{ ($devotees->currentPage() - 1) * $devotees->perPage() + $loop->iteration }}</td>
                        <td>{{ $devotee->name }}</td>
                        <td>{{ $devotee->phone ?? '—' }}</td>
                        <td>{{ $devotee->email ?? '—' }}</td>
                        <td class="text-right">{{ $devotee->receipts_count }}</td>
                        <td class="text-right">₹{{ number_format($devotee->total_amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-row">No devotees found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="report-pagination-wrap">{{ $devotees->links() }}</div>
</div>

@endsection