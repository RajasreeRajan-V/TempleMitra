@extends('layouts.app')

@section('title', 'Temple Reports')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Temple Reports</h1>
    </div>

    <form method="GET" action="{{ route('temple.reports.index') }}" class="row g-2 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label small mb-0">From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </div>
    </form>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm h-100 position-relative">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Total Receipts</div>
                    <div class="h4 mb-1">₹{{ number_format($totals['receipts'], 2) }}</div>
                    <div class="text-muted small">{{ $totals['receipts_count'] }} receipts</div>
                    <a href="{{ route('temple.reports.receipts', ['from_date' => $from, 'to_date' => $to]) }}" class="stretched-link small">View report &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100 position-relative">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Collections</div>
                    <div class="h4 mb-1">₹{{ number_format($totals['collections'], 2) }}</div>
                    <div class="text-muted small">Hundi / donation box</div>
                    <a href="{{ route('temple.reports.collections', ['from_date' => $from, 'to_date' => $to]) }}" class="stretched-link small">View report &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100 position-relative">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Vazhipad Revenue</div>
                    <div class="h4 mb-1">₹{{ number_format($totals['vazhipad_receipts'], 2) }}</div>
                    <div class="text-muted small">Ritual offerings</div>
                    <a href="{{ route('temple.reports.vazhipads', ['from_date' => $from, 'to_date' => $to]) }}" class="stretched-link small">View report &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100 position-relative">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Devotees</div>
                    <div class="h4 mb-1">{{ $totals['devotees_count'] }}</div>
                    <div class="text-muted small">Registered devotees</div>
                    <a href="{{ route('temple.reports.devotees') }}" class="stretched-link small">View report &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection