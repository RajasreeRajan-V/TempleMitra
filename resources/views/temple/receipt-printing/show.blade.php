@extends('temple.layouts.app')

@section('title', 'Receipt #' . ($receipt->receipt_number ?: str_pad($receipt->id, 6, '0', STR_PAD_LEFT)))

@section('content')
<div class="receipt-view-container">

    {{-- Top Action Toolbar --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;" class="no-print">
        <a href="{{ route('temple.receipt-printing.index') }}" class="btn-temple btn-temple-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Printing List</span>
        </a>

        <div style="display: flex; align-items: center; gap: 10px;">

        
       
      
            

        
            <a href="{{ route('temple.receipt-printing.print', $receipt) }}"
               class="btn-temple btn-temple-gold"
               target="_blank">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Print Voucher</span>
            </a>
        
            

            <a href="{{ route('temple.receipt-printing.payment.form', $receipt) }}"
               class="btn-temple btn-temple-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                    <path d="M12 18V6"></path>
                </svg>
                <span>Update Payment</span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="temple-alert temple-alert--success" id="receiptShowSuccessAlert">
            <div class="temple-alert-content">
                <div class="temple-alert-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('receiptShowSuccessAlert').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Main Receipt Details Card --}}
    <div class="receipt-card-section">
        <div class="vazhipad-card-accent"></div>

        <div class="receipt-card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--gold-600);">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                <h3 class="receipt-card-title">
                    {{ config('app.temple_name', 'TempleMitra Devasthanam') }} — Receipt Details
                </h3>
            </div>

            <span class="receipt-id-badge">
                {{ $receipt->receipt_number ?: '#RC-' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
            </span>
        </div>

        <div class="receipt-card-body">
            {{-- Devotee & Meta Overview Grid --}}
            <div class="receipt-meta-grid">
                <div>
                    <div class="meta-field-label">Devotee Name</div>
                    <div class="meta-field-value" style="font-family: 'Noto Serif', Georgia, serif; font-size: 17px; color: var(--maroon-900);">
                        {{ $receipt->devotee_name }}
                    </div>
                </div>

                <div>
                    <div class="meta-field-label">Birth Star (Nakshatram)</div>
                    <div class="meta-field-value">
                        <span class="nakshatram-tag">
                             {{ $receipt->nakshatram }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="meta-field-label">Receipt Date</div>
                    <div class="meta-field-value">
                        {{ optional($receipt->receipt_date ?: $receipt->receipts_date)->format('d F Y') ?: 'N/A' }}
                    </div>
                </div>

                <div>
                    <div class="meta-field-label">Payment Status</div>
                    <div class="meta-field-value">
                        @php $pStatus = strtolower($receipt->payment_status ?? 'pending'); @endphp
                        <span class="status-badge-custom status--{{ $pStatus }}">
                            <span class="badge-dot"></span>
                            {{ $receipt->payment_status_label ?: ucfirst($pStatus) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Vazhipad Offerings Table --}}
            <div style="margin-bottom: 28px;">
                <h4 style="font-family: 'Noto Serif', Georgia, serif; font-size: 16px; font-weight: 700; color: var(--maroon-900); margin: 0 0 12px 0;">
                    Pooja &amp; Vazhipad Line Items
                </h4>

                <table class="receipt-slip-table">
                    <thead>
                        <tr>
                            <th style="width: 8%; text-align: center;">#</th>
                            <th style="width: 52%;">Vazhipad Offering</th>
                            <th style="width: 15%; text-align: center;">Quantity</th>
                            <th style="width: 25%; text-align: right;">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receipt->items as $index => $item)
                            <tr>
                                <td style="text-align: center; color: var(--ink-400); font-weight: 600;">{{ $index + 1 }}</td>
                                <td>
                                    <strong style="color: var(--maroon-900);">{{ $item->vazhipad->name ?? 'Offering' }}</strong>
                                </td>
                                <td style="text-align: center; font-weight: 600;">{{ $item->quantity ?? 1 }}</td>
                                <td style="text-align: right; font-weight: 700;">₹{{ number_format($item->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--ink-400); font-style: italic;">No offering items attached to this receipt.</td>
                            </tr>
                        @endforelse

                        <tr class="receipt-total-row">
                            <td colspan="2" style="font-family: 'Noto Serif', Georgia, serif; font-size: 15px; font-weight: 700; color: var(--maroon-900);">
                                Total Contribution Amount
                            </td>
                            <td style="text-align: center; font-weight: 700; color: var(--ink-600);">
                                {{ $receipt->items->sum('quantity') }} items
                            </td>
                            <td style="text-align: right;">
                                <span class="total-amount-display">
                                    <span style="font-size: 18px; color: var(--gold-600);">₹</span>{{ number_format($receipt->total_amount, 2) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Payment Information Section --}}
            <div>
                <h4 style="font-family: 'Noto Serif', Georgia, serif; font-size: 16px; font-weight: 700; color: var(--maroon-900); margin: 0 0 12px 0;">
                    Counter Payment Information
                </h4>

                <div class="form-grid-4">
                    <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-md); padding: 14px 16px;">
                        <div class="meta-field-label">Payment Status</div>
                        <div style="margin-top: 4px;">
                            <span class="status-badge-custom status--{{ $pStatus }}">
                                <span class="badge-dot"></span>
                                {{ $receipt->payment_status_label ?: ucfirst($pStatus) }}
                            </span>
                        </div>
                    </div>

                    <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-md); padding: 14px 16px;">
                        <div class="meta-field-label">Payment Method</div>
                        <div style="font-weight: 700; font-size: 14px; color: var(--ink-900); margin-top: 4px;">
                            {{ $receipt->payment_method ? strtoupper($receipt->payment_method) : '—' }}
                        </div>
                    </div>

                    <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-md); padding: 14px 16px;">
                        <div class="meta-field-label">Paid Amount</div>
                        <div style="font-weight: 700; font-size: 15px; color: var(--green-700); margin-top: 4px;">
                            ₹{{ number_format($receipt->paid_amount ?: $receipt->total_amount, 2) }}
                        </div>
                    </div>

                    <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-md); padding: 14px 16px;">
                        <div class="meta-field-label">Paid Timestamp</div>
                        <div style="font-weight: 600; font-size: 13.5px; color: var(--ink-800); margin-top: 4px;">
                            {{ $receipt->paid_at ? $receipt->paid_at->format('d M Y, h:i A') : '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection