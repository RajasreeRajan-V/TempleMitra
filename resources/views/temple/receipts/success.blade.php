@extends('temple.layouts.app')

@section('title', 'Receipt Issued Successfully')

@section('content')
<div class="receipt-page-container">
    <div class="success-page-wrap">

        {{-- Glowing Success Icon --}}
        <div class="success-celebration-badge">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1 class="success-title">Receipt Issued Successfully!</h1>
        <p class="success-subtitle">The devotee vazhipad offering has been recorded in the devaswom register with an official voucher.</p>

        {{-- Voucher Summary Box --}}
        <div class="success-summary-card">
            <div class="vazhipad-card-accent"></div>

            <div class="success-card-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--gold-600);">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <strong style="font-family: 'Noto Serif', Georgia, serif; font-size: 16px; color: var(--maroon-900);">
                        Vazhipad Booking Summary
                    </strong>
                </div>

                <span class="temple-badge temple-badge--active">
                    <span class="temple-badge-dot"></span>
                    Confirmed
                </span>
            </div>

            <table class="success-summary-table">
                <tbody>
                    <tr>
                        <th>Receipt ID</th>
                        <td>
                            <span class="receipt-id-badge">
                                #RC-{{ str_pad($receipts->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Devotee Name</th>
                        <td style="font-family: 'Noto Serif', Georgia, serif; font-size: 16px; color: var(--maroon-900);">
                            {{ $receipts->devotee_name }}
                        </td>
                    </tr>
                    @if(!empty($receipts->nakshatram))
                        <tr>
                            <th>Birth Star (Nakshatram)</th>
                            <td>
                                <span class="nakshatram-tag">
                                    {{ $receipts->nakshatram }}
                                </span>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Receipt Date</th>
                        <td>{{ $receipts->receipts_date ? \Carbon\Carbon::parse($receipts->receipts_date)->format('d F Y, l') : 'N/A' }}</td>
                    </tr>
                    @if($receipts->items && $receipts->items->count() > 0)
                        <tr>
                            <th>Offering(s) Booked</th>
                            <td>
                                {{ $receipts->items->map(fn($i) => ($i->vazhipad->name ?? 'Offering') . ' (x' . $i->quantity . ')')->implode(', ') }}
                            </td>
                        </tr>
                    @elseif($receipts->vazhipad)
                        <tr>
                            <th>Offering Booked</th>
                            <td>{{ $receipts->vazhipad->name }}</td>
                        </tr>
                    @endif
                    <tr style="border-top: 2px solid var(--line); background: var(--cream-50);">
                        <th style="font-size: 15px; color: var(--maroon-900); font-weight: 700;">Total Dakshina Paid</th>
                        <td>
                            <span style="font-family: 'Poppins', system-ui, sans-serif; font-size: 20px; font-weight: 700; color: var(--maroon-900);">
                                <span style="color: var(--gold-600); font-size: 16px;">₹</span>{{ number_format($receipts->total_amount ?? $receipts->amount ?? 0, 2) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="success-actions-bar">
                <a href="{{ route('temple.receipts.index') }}" class="btn-temple btn-temple-secondary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                    <span>All Receipts</span>
                </a>

                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('temple.receipts.show', $receipts->id) }}" class="btn-temple btn-temple-secondary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span>View / Print Slip</span>
                    </a>

                    <a href="{{ route('temple.receipts.create') }}" class="btn-temple btn-temple-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Book Another Vazhipad</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
