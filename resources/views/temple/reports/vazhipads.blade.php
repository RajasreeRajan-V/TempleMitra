@extends('layouts.app')

@section('title', 'Vazhipad Report')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Vazhipad Report</h1>
        <a href="{{ route('temple.reports.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to reports</a>
    </div>

    <form method="GET" action="{{ route('temple.reports.vazhipads') }}" class="row g-2 align-items-end mb-4">
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

    <div class="mb-2 fw-semibold">Total vazhipad revenue: ₹{{ number_format($totalAmount, 2) }}</div>

    <div class="table-responsive mb-4">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Vazhipad</th>
                    <th class="text-end">Bookings</th>
                    <th class="text-end">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($summary as $vazhipad)
                    <tr>
                        <td>{{ $vazhipad->name }}</td>
                        <td class="text-end">{{ $vazhipad->bookings_count }}</td>
                        <td class="text-end">₹{{ number_format($vazhipad->total_amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">No vazhipad types found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="h5 mb-3">Bookings</h2>
    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Devotee</th>
                    <th>Vazhipad</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($receipts as $receipt)
                    <tr>
                        <td>{{ $receipt->receipt_no }}</td>
                        <td>{{ $receipt->receipt_date->format('d-M-Y') }}</td>
                        <td>{{ $receipt->devotee->name ?? '—' }}</td>
                        <td>{{ $receipt->vazhipad->name ?? '—' }}</td>
                        <td class="text-end">₹{{ number_format($receipt->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No bookings found for the selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $receipts->links() }}
</div>
@endsection