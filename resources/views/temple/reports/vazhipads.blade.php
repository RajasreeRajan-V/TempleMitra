@extends('temple.layouts.app')

@section('title', 'Vazhipad Report')

@section('content')

<div class="page-header">


<div class="page-header-left">

    <div class="page-icon">
        <svg width="24" height="24"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="1.7"
             stroke-linecap="round"
             stroke-linejoin="round">

            <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>

            <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>

        </svg>
    </div>

    <div>

        <h1 class="page-title">
            Vazhipad Report
        </h1>

        <p class="page-subtitle">
            {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
            <span class="em-dash">&mdash;</span>
            {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
        </p>

    </div>

</div>


<div class="page-header-actions">

    <a href="{{ route('temple.reports.index') }}"
       class="btn btn-outline">
        ← Reports
    </a>


    <a href="{{ route('temple.reports.vazhipads.excel', request()->only(['from_date','to_date'])) }}"
       class="btn btn-outline">

        <svg width="15" height="15"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>

            <polyline points="14 2 14 8 20 8"/>

        </svg>

        Excel

    </a>


    <a href="{{ route('temple.reports.vazhipads.pdf', request()->only(['from_date','to_date'])) }}"
       target="_blank"
       class="btn btn-primary">

        <svg width="15" height="15"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

            <polyline points="6 9 6 2 18 2 18 9"/>

            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5h-2"/>

            <rect x="6" y="14" width="12" height="8"/>

        </svg>

        PDF / Print

    </a>

</div>


</div>

{{-- Date Filter --}}

<div class="report-filter-panel">


<form method="GET"
      action="{{ route('temple.reports.vazhipads') }}"
      class="report-filter-form">

    <div class="report-filter-field report-filter-field--date">

        <label>📅 From</label>

        <input type="date"
               name="from_date"
               value="{{ $from }}"
               class="form-input">

    </div>


    <div class="report-filter-field report-filter-field--date">

        <label>📅 To</label>

        <input type="date"
               name="to_date"
               value="{{ $to }}"
               class="form-input">

    </div>


    <button type="submit"
            class="btn btn-primary">

        Filter

    </button>

</form>


</div>

{{-- Summary --}}

<div class="panel">


<div class="panel-header">

    <h2 class="panel-title">
        Active Vazhipad Summary
    </h2>

    <div style="font-weight:600;">
        Total Income:
        ₹{{ number_format($totalAmount ?? 0, 2) }}
    </div>

</div>


<div class="table-wrap">

    <table class="data-table">

        <thead>

            <tr>

                <th>#</th>

                <th>
                    Vazhipad Name
                </th>

                <th class="text-right">
                    Total Count
                </th>

                <th class="text-right">
                    Total Income
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($summary as $i => $vazhipad)

                <tr>

                    <td>
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ $vazhipad->name }}
                    </td>

                    <td class="text-right">
                        {{ $vazhipad->bookings_count ?? 0 }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($vazhipad->total_amount ?? 0, 2) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4"
                        class="empty-row">

                        No active vazhipad found.

                    </td>

                </tr>

            @endforelse

        </tbody>


        @if($summary->isNotEmpty())

            <tfoot>

                <tr class="report-table-total-row">

                    <td colspan="2"
                        style="text-align:right; font-weight:700;">

                        Grand Total

                    </td>


                    <td class="text-right"
                        style="font-weight:700;">

                        {{ $summary->sum('bookings_count') }}

                    </td>


                    <td class="text-right"
                        style="font-weight:700;">

                        ₹{{ number_format($summary->sum('total_amount'), 2) }}

                    </td>

                </tr>

            </tfoot>

        @endif

    </table>

</div>


</div>

@endsection
