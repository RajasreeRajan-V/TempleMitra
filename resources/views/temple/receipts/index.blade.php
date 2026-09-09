@extends('temple.layouts.app')

@section('title', 'Vazhipad Receipts')

@section('content')

<div class="receipt-page-container">

```
{{-- ================================================================
     FLASH NOTIFICATIONS
================================================================= --}}
@if(session('success'))
    <div class="temple-alert temple-alert--success" id="receiptSuccessAlert">
        <div class="temple-alert-content">
            <div class="temple-alert-icon">
                <svg width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <span>{{ session('success') }}</span>
        </div>

        <button type="button"
                class="temple-alert-close"
                onclick="document.getElementById('receiptSuccessAlert').remove()"
                aria-label="Close">
            <svg width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif


@if(session('error'))
    <div class="temple-alert temple-alert--danger" id="receiptErrorAlert">
        <div class="temple-alert-content">
            <div class="temple-alert-icon">
                <svg width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>

            <span>{{ session('error') }}</span>
        </div>

        <button type="button"
                class="temple-alert-close"
                onclick="document.getElementById('receiptErrorAlert').remove()"
                aria-label="Close">
            <svg width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif


{{-- ================================================================
     PAGE HEADER
================================================================= --}}
<div class="vazhipad-header">

    <div class="vazhipad-header-left">

        <div class="vazhipad-header-icon">
            <svg width="26" height="26" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">

                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>

                <polyline points="14 2 14 8 20 8"></polyline>

                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>

                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
        </div>


        <div class="vazhipad-header-titles">
            <h1 class="vazhipad-page-title">
                Vazhipad Receipts
            </h1>

            <p class="vazhipad-page-subtitle">
                Manage devotee booking receipts, sankalpam details, and dakshina accounts
            </p>
        </div>

    </div>


    <div class="vazhipad-header-actions">

        <a href="{{ route('temple.receipts.create') }}"
           class="btn-temple btn-temple-primary">

            <svg width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.2"
                 stroke-linecap="round" stroke-linejoin="round">

                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>

            </svg>

            <span>New Receipt</span>

        </a>

    </div>

</div>


{{-- ================================================================
     SUMMARY CALCULATIONS
================================================================= --}}
@php

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $totalReceiptsCount = ($receiptss instanceof \Illuminate\Pagination\AbstractPaginator)
        ? $receiptss->total()
        : $receiptss->count();


    /*
    |--------------------------------------------------------------------------
    | Current page amount
    |--------------------------------------------------------------------------
    */

    $totalAmountSum = $receiptss->sum(function ($receipt) {
        return (float) ($receipt->amount ?? 0);
    });


    /*
    |--------------------------------------------------------------------------
    | Status counts
    |--------------------------------------------------------------------------
    */

    $confirmedCount = $receiptss->filter(function ($receipt) {

        $status = strtolower(
            $receipt->status ?? 'confirmed'
        );

        return in_array(
            $status,
            ['confirmed', 'completed']
        );

    })->count();


    $pendingCount = $receiptss->filter(function ($receipt) {

        return strtolower(
            $receipt->status ?? ''
        ) === 'pending';

    })->count();

@endphp


{{-- ================================================================
     SUMMARY STATS
================================================================= --}}
<div class="receipts-stats-grid">

    {{-- Total Receipts --}}
    <div class="vazhipad-stat-box">

        <div class="vazhipad-stat-icon vazhipad-stat-icon--maroon">

            <svg width="22" height="22" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8">

                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>

                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>

            </svg>

        </div>

        <div class="vazhipad-stat-info">

            <span class="vazhipad-stat-number">
                {{ $totalReceiptsCount }}
            </span>

            <span class="vazhipad-stat-label">
                Total Receipts
            </span>

        </div>

    </div>


    {{-- Total Amount --}}
    <div class="vazhipad-stat-box">

        <div class="vazhipad-stat-icon vazhipad-stat-icon--gold">

            <svg width="22" height="22" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8">

                <circle cx="12" cy="12" r="10"></circle>

                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>

                <path d="M12 18V6"></path>

            </svg>

        </div>

        <div class="vazhipad-stat-info">

            <span class="vazhipad-stat-number">
                ₹{{ number_format($totalAmountSum, 2) }}
            </span>

            <span class="vazhipad-stat-label">  

            
                Dakshina Recorded
            </span>

        </div>

    </div>


    {{-- Confirmed --}}
    <div class="vazhipad-stat-box">

        <div class="vazhipad-stat-icon vazhipad-stat-icon--green">

            <svg width="22" height="22" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8">

                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>

                <polyline points="22 4 12 14.01 9 11.01"></polyline>

            </svg>

        </div>

        <div class="vazhipad-stat-info">

            <span class="vazhipad-stat-number">
                {{ $confirmedCount }}
            </span>

            <span class="vazhipad-stat-label">
                Confirmed / Completed
            </span>

        </div>

    </div>


    {{-- Pending --}}
    <div class="vazhipad-stat-box">

        <div class="vazhipad-stat-icon vazhipad-stat-icon--orange">

            <svg width="22" height="22" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8">

                <circle cx="12" cy="12" r="10"></circle>

                <polyline points="12 6 12 12 14 14"></polyline>

            </svg>

        </div>

        <div class="vazhipad-stat-info">

            <span class="vazhipad-stat-number">
                {{ $pendingCount }}
            </span>

            <span class="vazhipad-stat-label">
                Pending Approval
            </span>

        </div>

    </div>

</div>


{{-- ================================================================
     SEARCH & FILTER
================================================================= --}}
<div class="vazhipad-toolbar">

    <div class="vazhipad-search-wrap">

        <span class="vazhipad-search-icon">

            <svg width="17" height="17" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2">

                <circle cx="11" cy="11" r="8"></circle>

                <line x1="21" y1="21"
                      x2="16.65" y2="16.65"></line>

            </svg>

        </span>


        <input type="text"
               id="receiptSearch"
               class="vazhipad-search-input"
               placeholder="Search by receipt #, devotee, star, or offering..."
               autocomplete="off">

    </div>


    <div class="vazhipad-filter-pills">

        <button type="button"
                class="filter-pill active"
                data-filter="all">

            <span>All Receipts</span>

            <span class="filter-count">
                {{ $totalReceiptsCount }}
            </span>

        </button>


        <button type="button"
                class="filter-pill"
                data-filter="confirmed">

            <span>Confirmed</span>

        </button>


        <button type="button"
                class="filter-pill"
                data-filter="pending">

            <span>Pending</span>

        </button>

    </div>

</div>


{{-- ================================================================
     RECEIPTS TABLE
================================================================= --}}
<div class="receipt-card-section">

    <div class="vazhipad-card-accent"></div>

    <div class="temple-table-responsive">

        <table class="temple-data-table" id="receiptsTable">

            <thead>

                <tr>

                    <th style="width: 130px;">
                        Receipt No
                    </th>

                    <th>
                        Devotee &amp; Nakshatram
                    </th>

                    <th>
                        Vazhipad Offering
                    </th>

                    <th style="width: 160px;">
                        Receipt Date
                    </th>

                    <th style="width: 130px; text-align: right;">
                        Total Dakshina
                    </th>

                    <th style="width: 110px; text-align: right;">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody id="receiptsTableBody">

               @forelse($receiptss as $receipts)

    @php

        $status = strtolower(
            $receipts->status ?? 'confirmed'
        );

        $devoteeName = $receipts->devotee_name
            ?? 'Walk-in Devotee';

        $nakshatram = $receipts->nakshatram ?? null;


        /*
        |--------------------------------------------------------------------------
        | Get all Vazhipad names from receipt_items
        |--------------------------------------------------------------------------
        */
        $vazhipadNames = $receipts->items
            ->filter(function ($item) {
                return $item->vazhipad !== null;
            })
            ->map(function ($item) {
                return $item->vazhipad->name;
            })
            ->implode(' ');


        /*
        |--------------------------------------------------------------------------
        | Search data
        |--------------------------------------------------------------------------
        */
        $searchHaystack = strtolower(
            ($receipts->id ?? '') . ' ' .
            ($receipts->receipt_no ?? '') . ' ' .
            ($devoteeName ?? '') . ' ' .
            ($nakshatram ?? '') . ' ' .
            ($vazhipadNames ?? '') . ' ' .
            ($receipts->payment_mode ?? '') . ' ' .
            ($receipts->type ?? '')
        );

    @endphp


    <tr class="receipt-row"
        data-status="{{ $status }}"
        data-search="{{ $searchHaystack }}">


        {{-- =================================================
             RECEIPT NUMBER
        ================================================== --}}
        <td>

            <span class="receipt-id-badge">

                <svg width="13"
                     height="13"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                    </path>

                    <polyline points="14 2 14 8 20 8">
                    </polyline>

                </svg>

                #RC-{{ str_pad(
                    $receipts->receipt_no ?? $receipts->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ) }}

            </span>

        </td>


        {{-- =================================================
             DEVOTEE & NAKSHATRAM
        ================================================== --}}
        <td>

            <div class="devotee-profile-cell">

                <span class="devotee-name-text">
                    {{ $devoteeName }}
                </span>


                @if(!empty($nakshatram))

                    <span class="nakshatram-tag"
                          title="Devotee Birth Star">

                        <svg width="11"
                             height="11"
                             viewBox="0 0 24 24"
                             fill="currentColor">

                            <polygon points="
                                12 2
                                15.09 8.26
                                22 9.27
                                17 14.14
                                18.18 21.02
                                12 17.77
                                5.82 21.02
                                7 14.14
                                2 9.27
                                8.91 8.26
                                12 2
                            ">
                            </polygon>

                        </svg>

                        {{ $nakshatram }}

                    </span>

                @endif

            </div>

        </td>


        {{-- =================================================
             VAZHIPAD OFFERING
        ================================================== --}}
        <td>

            <div class="vazhipad-chips-wrap">

                @forelse($receipts->items as $item)

                    @if($item->vazhipad)

                        <span class="vazhipad-item-chip">

                            <svg width="12"
                                 height="12"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 style="
                                    color: var(--gold-600);
                                    flex-shrink: 0;
                                 ">

                                <circle cx="12"
                                        cy="12"
                                        r="10">
                                </circle>

                                <path d="m9 12 2 2 4-4">
                                </path>

                            </svg>


                            <span>
                                {{ $item->vazhipad->name }}
                            </span>


                            @if((int) $item->quantity > 1)

                                <span style="
                                    font-size: 11px;
                                    margin-left: 4px;
                                    color: var(--ink-500);
                                    font-weight: 600;
                                    white-space: nowrap;
                                ">
                                    × {{ $item->quantity }}
                                </span>

                            @endif

                        </span>

                    @endif

                @empty

                    <span style="
                        color: var(--ink-400);
                        font-style: italic;
                        font-size: 13px;
                    ">
                        No Vazhipad
                    </span>

                @endforelse

            </div>

        </td>


        {{-- =================================================
             RECEIPT DATE
        ================================================== --}}
        <td>

            <div style="
                display: flex;
                align-items: center;
                gap: 6px;
                color: var(--ink-600);
                font-size: 13.5px;
            ">

                <svg width="14"
                     height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     style="color: var(--ink-400);">

                    <rect x="3"
                          y="4"
                          width="18"
                          height="18"
                          rx="2"
                          ry="2">
                    </rect>

                    <line x1="16"
                          y1="2"
                          x2="16"
                          y2="6">
                    </line>

                    <line x1="8"
                          y1="2"
                          x2="8"
                          y2="6">
                    </line>

                    <line x1="3"
                          y1="10"
                          x2="21"
                          y2="10">
                    </line>

                </svg>


                <span>

                    @if($receipts->receipts_date)

                        {{ $receipts->receipts_date->format('d M Y') }}

                    @else

                        <span style="color: #999;">
                            No Date
                        </span>

                    @endif

                </span>

            </div>

        </td>


        {{-- =================================================
             TOTAL AMOUNT
        ================================================== --}}
        <td style="text-align: right;">

            <span class="amount-highlight">

                <span style="
                    color: var(--gold-600);
                    font-size: 13px;
                    font-weight: 600;
                ">
                    ₹
                </span>

                {{ number_format(
                    (float) ($receipts->total_amount ?? 0),
                    2
                ) }}

            </span>

        </td>


        {{-- =================================================
             ACTION
        ================================================== --}}
        <td style="text-align: right;">

            <a href="{{ route(
                'temple.receipts.show',
                $receipts->id
            ) }}"
               class="btn-temple btn-temple-secondary btn-temple-sm"
               title="View receipt voucher">

                <svg width="14"
                     height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="
                        M1 12s4-8 11-8
                        11 8 11 8
                        -4 8-11 8
                        -11-8-11-8z
                    ">
                    </path>

                    <circle cx="12"
                            cy="12"
                            r="3">
                    </circle>

                </svg>

                <span>
                    View
                </span>

            </a>

        </td>

    </tr>

@empty

    {{-- Your existing empty state stays here --}}

@endforelse

            </tbody>

        </table>

    </div>


    {{-- ================================================================
         PAGINATION
    ================================================================= --}}
    @if($receiptss instanceof \Illuminate\Contracts\Pagination\Paginator)

        <div style="
            padding: 18px 20px;
            display: flex;
            justify-content: flex-end;
        ">
            {{ $receiptss->links() }}
        </div>

    @endif

</div>


{{-- ================================================================
     NO SEARCH RESULTS
================================================================= --}}
<div id="noReceiptFilterResults"
     class="vazhipad-empty-box"
     style="
        display: none;
        margin-top: 20px;
     ">

    <div class="vazhipad-empty-icon">

        <svg width="32"
             height="32"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="1.8">

            <circle cx="11"
                    cy="11"
                    r="8"></circle>

            <line x1="21"
                  y1="21"
                  x2="16.65"
                  y2="16.65"></line>

        </svg>

    </div>


    <h3 class="vazhipad-empty-title">
        No Matching Receipts
    </h3>


    <p class="vazhipad-empty-desc">
        No receipt records match your current search query
        or filter selection.
    </p>


    <button type="button"
            class="btn-temple btn-temple-secondary"
            onclick="resetReceiptFilters()">

        <span>
            Reset Search &amp; Filters
        </span>

    </button>

</div>
```

</div>

{{-- ================================================================
JAVASCRIPT
================================================================= --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('receiptSearch');

    const filterPills =
        document.querySelectorAll('.filter-pill');

    const rows =
        document.querySelectorAll('.receipt-row');

    const noResults =
        document.getElementById('noReceiptFilterResults');


    let currentFilter = 'all';


    /*
    |--------------------------------------------------------------------------
    | Filter receipt rows
    |--------------------------------------------------------------------------
    */

    function filterReceiptRows() {

        const query =
            searchInput
                ? searchInput.value.trim().toLowerCase()
                : '';


        let visibleCount = 0;


        rows.forEach(function (row) {

            const searchData =
                row.getAttribute('data-search') || '';


            const status =
                row.getAttribute('data-status') || '';


            const matchesQuery =
                !query ||
                searchData.includes(query);


            /*
            |--------------------------------------------------------------------------
            | Confirmed filter
            |--------------------------------------------------------------------------
            */

            let matchesFilter = true;


            if (currentFilter === 'confirmed') {

                matchesFilter =
                    status === 'confirmed' ||
                    status === 'completed';

            }


            /*
            |--------------------------------------------------------------------------
            | Pending filter
            |--------------------------------------------------------------------------
            */

            if (currentFilter === 'pending') {

                matchesFilter =
                    status === 'pending';

            }


            /*
            |--------------------------------------------------------------------------
            | Show / hide
            |--------------------------------------------------------------------------
            */

            if (matchesQuery && matchesFilter) {

                row.style.display = '';

                visibleCount++;

            } else {

                row.style.display = 'none';

            }

        });


        /*
        |--------------------------------------------------------------------------
        | No results message
        |--------------------------------------------------------------------------
        */

        if (noResults) {

            if (
                visibleCount === 0 &&
                rows.length > 0
            ) {

                noResults.style.display = 'flex';

            } else {

                noResults.style.display = 'none';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterReceiptRows
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Filter buttons
    |--------------------------------------------------------------------------
    */

    filterPills.forEach(function (pill) {

        pill.addEventListener(
            'click',
            function () {

                filterPills.forEach(function (item) {

                    item.classList.remove('active');

                });


                this.classList.add('active');


                currentFilter =
                    this.getAttribute('data-filter') ||
                    'all';


                filterReceiptRows();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Reset filters
    |--------------------------------------------------------------------------
    */

    window.resetReceiptFilters = function () {

        if (searchInput) {

            searchInput.value = '';

        }


        currentFilter = 'all';


        filterPills.forEach(function (pill) {

            if (
                pill.getAttribute('data-filter') === 'all'
            ) {

                pill.classList.add('active');

            } else {

                pill.classList.remove('active');

            }

        });


        filterReceiptRows();

    };


    /*
    |--------------------------------------------------------------------------
    | Initial filter
    |--------------------------------------------------------------------------
    */

    filterReceiptRows();

});

</script>

@endpush

@endsection
