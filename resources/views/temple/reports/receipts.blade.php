@extends('layouts.app')

@section('title', 'Receipts Report')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Receipts</h1>
        <a href="{{ route('temple.reports.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to reports</a>
    </div>

    <form method="GET" action="{{ route('temple.reports.receipts') }}" class="row g-2 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label small mb-0">From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">Type</label>
            <select name="type" class="form-select form-select-sm">
                <option value="">All</option>
                @foreach (['vazhipad', 'donation', 'collection', 'other'] as $type)
                    <option value="{{ $type }}" @selected(request('type') === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">Devotee</label>
            <select name="devotee_id" class="form-select form-select-sm">
                <option value="">All</option>
                @foreach ($devotees as $devotee)
                    <option value="{{ $devotee->id }}" @selected((string) request('devotee_id') === (string) $devotee->id)>{{ $devotee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">Payment mode</label>
            <select name="payment_mode" class="form-select form-select-sm">
                <option value="">All</option>
                @foreach (['cash', 'upi', 'card', 'cheque', 'other'] as $mode)
                    <option value="{{ $mode }}" @selected(request('payment_mode') === $mode)>{{ strtoupper($mode) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </div>
    </form>

    <div class="mb-3">
        <span class="fw-semibold">Total: ₹{{ number_format($totalAmount, 2) }}</span>
        <span class="text-muted small">({{ $receipts->total() }} receipts)</span>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Devotee</th>
                    <th>Details</th>
                    <th>Payment</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($receipts as $receipt)
                    <tr>
                        <td>{{ $receipt->receipt_no }}</td>
                        <td>{{ $receipt->receipt_date->format('d-M-Y') }}</td>
                        <td><span class="badge bg-secondary text-capitalize">{{ $receipt->type }}</span></td>
                        <td>{{ $receipt->devotee->name ?? '—' }}</td>
                        <td>{{ $receipt->vazhipad->name ?? $receipt->collection->source ?? $receipt->remarks ?? '—' }}</td>
                        <td class="text-uppercase small">{{ $receipt->payment_mode }}</td>
                        <td class="text-end">₹{{ number_format($receipt->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No receipts found for the selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $receipts->links() }}
</div>
@endsection