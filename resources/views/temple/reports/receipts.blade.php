
@extends('temple.layouts.app')

@section('title', 'Receipts Report')

@section('content')

<div class="page-header">

    <div class="page-header-left">

        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.7"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="14" height="20" rx="2"/>
                <line x1="9" y1="7" x2="15" y2="7"/>
                <line x1="9" y1="11" x2="15" y2="11"/>
                <line x1="9" y1="15" x2="13" y2="15"/>
            </svg>
        </div>

        <div>
            <h1 class="page-title">Receipts Report</h1>

            <p class="page-subtitle">
                {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
                <span class="em-dash">—</span>
                {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
            </p>
        </div>

    </div>

    <div class="page-header-actions">

        <a href="{{ route('temple.reports.index') }}" class="btn btn-outline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Reports
        </a>

        <a href="{{ route('temple.reports.receipts.excel', request()->only(['from_date','to_date','payment_status','payment_method'])) }}"
           class="btn btn-outline">

            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>

            Excel
        </a>

        <a href="{{ route('temple.reports.receipts.pdf', request()->only(['from_date','to_date','payment_status','payment_method'])) }}"
           target="_blank"
           class="btn btn-primary">

            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>

            PDF / Print
        </a>

    </div>

</div>

{{-- Filters --}}

<div class="report-filter-panel">

    <form method="GET"
          action="{{ route('temple.reports.receipts') }}"
          class="report-filter-form">

        <div class="report-filter-field report-filter-field--date">

            <label>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     style="vertical-align: middle; margin-right: 4px;">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                From
            </label>

            <input type="date"
                   name="from_date"
                   value="{{ $from }}"
                   class="form-input">

        </div>

        <div class="report-filter-field report-filter-field--date">

            <label>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     style="vertical-align: middle; margin-right: 4px;">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                To
            </label>

            <input type="date"
                   name="to_date"
                   value="{{ $to }}"
                   class="form-input">

        </div>

        <div class="report-filter-field">

            <label>Status</label>

            <select name="payment_status" class="form-input">

                <option value="">All</option>

                @foreach(['paid','pending','partially_paid','cancelled'] as $s)

                    <option value="{{ $s }}"
                        @selected(request('payment_status') === $s)>
                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="report-filter-field">

            <label>Method</label>

            <select name="payment_method" class="form-input">

                <option value="">All</option>

                @foreach(['cash','upi','card','bank_transfer'] as $m)

                    <option value="{{ $m }}"
                        @selected(request('payment_method') === $m)>
                        {{ strtoupper(str_replace('_', ' ', $m)) }}
                    </option>

                @endforeach

            </select>

        </div>

        <button type="submit" class="btn btn-primary">

            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>

            Filter

        </button>

    </form>

</div>


<div class="panel">

    <div class="panel-header">

        <h2 class="panel-title">

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="14" height="20" rx="2"/>
                <line x1="9" y1="7" x2="15" y2="7"/>
            </svg>

            {{ $receipts->total() }} receipts

        </h2>

        <span class="panel-amount-badge">
            ₹{{ number_format($totalAmount, 2) }}
        </span>

    </div>


    <div class="table-wrap">

        <table class="data-table">

            <thead>

                <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Devotee</th>
                    <th>Vazhipad(s)</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th class="text-right">Amount</th>
                </tr>

            </thead>

            <tbody>

                @forelse($receipts as $receipt)

                    <tr>

                        <td>
                            {{ $receipt->id }}
                        </td>

                        <td>
                            {{ optional($receipt->receipt_date)->format('d-m-Y')
                                ?? optional($receipt->created_at)->format('d-m-Y')
                                ?? '—' }}
                        </td>

                        <td>
                            {{ $receipt->devotee_name ?? '—' }}
                        </td>

                        <td>
                            {{ $receipt->items->pluck('vazhipad.name')->filter()->implode(', ') ?: '—' }}
                        </td>

                        <td>
                            {{ ucfirst($receipt->payment_method ?? '—') }}
                        </td>

                        <td>

                            <span class="badge
                                {{ $receipt->payment_status === 'paid'
                                    ? 'badge--green'
                                    : 'badge--orange' }}">

                                {{ ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $receipt->payment_status ?? '—'
                                    )
                                ) }}

                            </span>

                        </td>

                        <td class="text-right">
                            ₹{{ number_format($receipt->total_amount ?? 0, 2) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty-row">
                            No receipts found for the selected filters.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="report-pagination-wrap">
        {{ $receipts->links() }}
    </div>

</div>

@endsection
