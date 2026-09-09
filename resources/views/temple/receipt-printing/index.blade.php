@extends('temple.layouts.app')

@section('title', 'Receipt Printing & Payments')

@section('content')
<div class="receipt-page-container">

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="temple-alert temple-alert--success" id="receiptPrintSuccessAlert">
            <div class="temple-alert-content">
                <div class="temple-alert-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="
                    " stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('receiptPrintSuccessAlert').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <h1 class="vazhipad-page-title">Receipt Printing &amp; Counter Payments</h1>
                <p class="vazhipad-page-subtitle">Print devotee pooja vouchers, update payment statuses, and manage counters</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.receipts.create') }}" class="btn-temple btn-temple-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>New Receipt</span>
            </a>
        </div>
    </div>

    @php
        $totalCount = ($receipts instanceof \Illuminate\Pagination\AbstractPaginator) ? $receipts->total() : $receipts->count();
        $paidCount = $receipts->filter(fn($r) => ($r->payment_status ?? '') === 'paid')->count();
        $pendingCount = $receipts->filter(fn($r) => in_array($r->payment_status ?? '', ['pending', 'partially_paid', '']))->count();
        $totalCollected = $receipts->where('payment_status', 'paid')->sum('paid_amount') ?: $receipts->where('payment_status', 'paid')->sum('total_amount');
    @endphp

    {{-- Stats Summary Row --}}
    <div class="receipts-stats-grid">
        <div class="vazhipad-stat-box">
            <div class="vazhipad-stat-icon vazhipad-stat-icon--maroon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div class="vazhipad-stat-info">
                <span class="vazhipad-stat-number">{{ $totalCount }}</span>
                <span class="vazhipad-stat-label">Total Receipts</span>
            </div>
        </div>

        <div class="vazhipad-stat-box">
            <div class="vazhipad-stat-icon vazhipad-stat-icon--green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="vazhipad-stat-info">
                <span class="vazhipad-stat-number">{{ $paidCount }}</span>
                <span class="vazhipad-stat-label">Fully Paid</span>
            </div>
        </div>

        <div class="vazhipad-stat-box">
            <div class="vazhipad-stat-icon vazhipad-stat-icon--orange">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="vazhipad-stat-info">
                <span class="vazhipad-stat-number">{{ $pendingCount }}</span>
                <span class="vazhipad-stat-label">Pending / Partial</span>
            </div>
        </div>

        <div class="vazhipad-stat-box">
            <div class="vazhipad-stat-icon vazhipad-stat-icon--gold">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                    <path d="M12 18V6"></path>
                </svg>
            </div>
            <div class="vazhipad-stat-info">
                <span class="vazhipad-stat-number">₹{{ number_format($totalCollected, 2) }}</span>
                <span class="vazhipad-stat-label">Collected Amount</span>
            </div>
        </div>
    </div>

    {{-- Filter Card / Search Form --}}
    <div class="receipt-card-section" style="margin-bottom: 24px;">
        <div class="receipt-card-body" style="padding: 18px 22px;">
            <form method="GET" action="{{ route('temple.receipt-printing.index') }}" style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 260px;">
                    <div class="input-icon-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control input-with-icon"
                               placeholder="Search receipt no., devotee name, or nakshatram...">
                    </div>
                </div>

                <div style="min-width: 200px;">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment Statuses</option>
                        <option value="pending" @selected(request('payment_status') === 'pending')>Pending</option>
                        <option value="paid" @selected(request('payment_status') === 'paid')>Paid</option>
                        <option value="partially_paid" @selected(request('payment_status') === 'partially_paid')>Partially Paid</option>
                        <option value="cancelled" @selected(request('payment_status') === 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <button type="submit" class="btn-temple btn-temple-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Filter</span>
                    </button>

                    <a href="{{ route('temple.receipt-printing.index') }}" class="btn-temple btn-temple-secondary">
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Receipts Printing & Payment Table Card --}}
    <div class="receipt-card-section">
        <div class="vazhipad-card-accent"></div>

        <div class="temple-table-responsive">
            <table class="temple-data-table">
                <thead>
                    <tr>
                        <th style="width: 130px;">Receipt No</th>
                        <th>Devotee &amp; Star</th>
                        <th style="width: 130px;">Receipt Date</th>
                        <th style="width: 130px; text-align: right;">Total Amount</th>
                        <th style="width: 140px; text-align: center;">Payment Status</th>
                        <th style="width: 130px;">Method</th>
                        <th style="width: 220px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($receipts as $receipt)
                        @php
                            $pStatus = strtolower($receipt->payment_status ?? 'pending');
                        @endphp
                        <tr>
                            <td>
                                <span class="receipt-id-badge">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                    {{ $receipt->receipt_number ?: '#RC-' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <td>
                                <div class="devotee-profile-cell">
                                    <span class="devotee-name-text">{{ $receipt->devotee_name }}</span>
                                    @if(!empty($receipt->nakshatram))
                                        <span class="nakshatram-tag">
                                            {{ $receipt->nakshatram }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div style="display: flex; align-items: center; gap: 6px; color: var(--ink-600); font-size: 13.5px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--ink-400);">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span>{{ optional($receipt->receipt_date ?: $receipt->receipts_date)->format('d M Y') ?: 'N/A' }}</span>
                                </div>
                            </td>

                            <td style="text-align: right;">
                                <span class="amount-highlight">
                                    <span style="color: var(--gold-600); font-size: 13px;">₹</span>{{ number_format($receipt->total_amount, 2) }}
                                </span>
                            </td>

                            <td style="text-align: center;">
                                <span class="status-badge-custom status--{{ $pStatus }}">
                                    <span class="badge-dot"></span>
                                    {{ $receipt->payment_status_label ?: ucfirst(str_replace('_', ' ', $pStatus)) }}
                                </span>
                            </td>

                            <td>
                                @if(!empty($receipt->payment_method))
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-weight: 600; font-size: 12.5px; text-transform: uppercase; color: var(--ink-800); background: var(--cream-50); border: 1px solid var(--line); padding: 3px 8px; border-radius: 4px;">
                                        💳 {{ strtoupper($receipt->payment_method) }}
                                    </span>
                                @else
                                    <span style="color: var(--ink-400); font-size: 13px;">—</span>
                                @endif
                            </td>

                            <td style="text-align: center;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <a href="{{ route('temple.receipt-printing.show', $receipt) }}"
                                       class="btn-temple btn-temple-secondary btn-temple-sm"
                                       title="View details">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span>View</span>
                                    </a>

                                    <a href="{{ route('temple.receipt-printing.print', $receipt) }}"
                                       class="btn-temple btn-temple-gold btn-temple-sm"
                                       target="_blank"
                                       title="Print voucher slip">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                        <span>Print</span>
                                    </a>

                                    <a href="{{ route('temple.receipt-printing.payment.form', $receipt) }}"
                                       class="btn-temple btn-temple-primary btn-temple-sm"
                                       title="Update counter payment">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                                            <path d="M12 18V6"></path>
                                        </svg>
                                        <span>Payment</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 0;">
                                <div class="vazhipad-empty-box" style="border: none; box-shadow: none;">
                                    <div class="vazhipad-empty-icon">
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                    </div>
                                    <h3 class="vazhipad-empty-title">No Receipts Found</h3>
                                    <p class="vazhipad-empty-desc">No receipt records matched your filter or search query. Try adjusting your search keywords.</p>
                                    <a href="{{ route('temple.receipt-printing.index') }}" class="btn-temple btn-temple-secondary">
                                        <span>Clear Search Filters</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if ($receipts instanceof \Illuminate\Pagination\AbstractPaginator && $receipts->hasPages())
            <div style="padding: 16px 20px; background: var(--cream-50); border-top: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div style="font-size: 13px; color: var(--ink-600);">
                    Showing <strong>{{ $receipts->firstItem() }}</strong> to <strong>{{ $receipts->lastItem() }}</strong> of <strong>{{ $receipts->total() }}</strong> records
                </div>
                <div>
                    {{ $receipts->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection