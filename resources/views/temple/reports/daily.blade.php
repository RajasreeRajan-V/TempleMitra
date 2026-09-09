@extends('temple.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Daily Report</h2>
            <p class="text-muted mb-0">
                Daily temple collection and transaction report
            </p>
        </div>
    </div>

    {{-- Date Filter --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Select Date</h5>
        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('temple.reports.daily') }}">

                <div class="row align-items-end">

                    <div class="col-md-4">
                        <label for="date" class="form-label">
                            Report Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            id="date"
                            value="{{ $date }}"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-2">
                        <button type="submit"
                                class="btn btn-primary w-100">
                            Generate Report
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- Report --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-1">Daily Temple Report</h5>

                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                </small>
            </div>

            <button onclick="window.print()"
                    class="btn btn-outline-secondary">
                🖨 Print
            </button>

        </div>

        <div class="card-body">

            <div class="alert alert-info">
                Daily report generated for
                <strong>
                    {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                </strong>
            </div>

            <div class="row">

                <div class="col-md-3 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <small class="text-muted">
                                Total Receipts
                            </small>

                            <h3 class="mt-2">
                                {{ $totalReceipts ?? 0 }}
                            </h3>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <small class="text-muted">
                                Total Collection
                            </small>

                            <h3 class="mt-2">
                                ₹{{ number_format($totalCollection ?? 0, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <small class="text-muted">
                                Cash Collection
                            </small>

                            <h3 class="mt-2">
                                ₹{{ number_format($cashCollection ?? 0, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <small class="text-muted">
                                Online Collection
                            </small>

                            <h3 class="mt-2">
                                ₹{{ number_format($onlineCollection ?? 0, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Daily Transactions</h5>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Receipt No.</th>
                            <th>Devotee</th>
                            <th>Vazhipad</th>
                            <th>Payment</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($receipts ?? [] as $receipt)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $receipt->receipt_number ?? $receipt->id }}
                                </td>

                                <td>
                                    {{ $receipt->devotee_name ?? '-' }}
                                </td>

                                <td>
                                    {{ $receipt->vazhipad->name ?? '-' }}
                                </td>

                                <td>
                                    {{ ucfirst($receipt->payment_method ?? '-') }}
                                </td>

                                <td>
                                    ₹{{ number_format($receipt->total_amount ?? 0, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted py-4">
                                    No transactions found for this date.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection