@extends('layouts.app')

@section('title', 'Collections Report')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Collections</h1>
        <a href="{{ route('temple.reports.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to reports</a>
    </div>

    <form method="GET" action="{{ route('temple.reports.collections') }}" class="row g-2 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label small mb-0">From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">Source</label>
            <input type="text" name="source" value="{{ request('source') }}" placeholder="e.g. Hundi" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </div>
    </form>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="mb-2 fw-semibold">
                Total: ₹{{ number_format($totalAmount, 2) }}
                <span class="text-muted small fw-normal">({{ $collections->total() }} entries)</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Source</th>
                            <th>Collected By</th>
                            <th>Remarks</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($collections as $collection)
                            <tr>
                                <td>{{ $collection->collection_date->format('d-M-Y') }}</td>
                                <td>{{ $collection->source }}</td>
                                <td>{{ $collection->collected_by ?? '—' }}</td>
                                <td>{{ $collection->remarks ?? '—' }}</td>
                                <td class="text-end">₹{{ number_format($collection->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No collections found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $collections->links() }}
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header small text-uppercase text-muted">By source</div>
                <ul class="list-group list-group-flush">
                    @forelse ($bySource as $row)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $row->source }}</span>
                            <span class="fw-semibold">₹{{ number_format($row->total, 2) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection