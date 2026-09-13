@extends('layouts.app')

@section('title', 'Devotee Report')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Devotees</h1>
        <a href="{{ route('temple.reports.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to reports</a>
    </div>

    <form method="GET" action="{{ route('temple.reports.devotees') }}" class="row g-2 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label small mb-0">From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <label class="form-label small mb-0">Search</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Name, phone or email" class="form-control form-control-sm">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th class="text-end">Receipts</th>
                    <th class="text-end">Total Contribution</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($devotees as $devotee)
                    <tr>
                        <td>{{ $devotee->name }}</td>
                        <td>{{ $devotee->phone ?? '—' }}</td>
                        <td>{{ $devotee->email ?? '—' }}</td>
                        <td class="text-end">{{ $devotee->receipts_count }}</td>
                        <td class="text-end">₹{{ number_format($devotee->total_amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No devotees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $devotees->links() }}
</div>
@endsection