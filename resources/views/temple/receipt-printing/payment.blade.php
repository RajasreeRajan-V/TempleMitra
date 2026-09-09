@extends('temple.layouts.app')

@section('title', 'Mark Payment — ' . ($receipt->receipt_number ?: $receipt->id))

@section('content')
<div class="receipt-create-container">

    {{-- Header --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                    <path d="M12 18V6"></path>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <h1 class="vazhipad-page-title">Counter Payment Update</h1>
                <p class="vazhipad-page-subtitle">Update payment status and collection method for Receipt #{{ $receipt->receipt_number ?: $receipt->id }}</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.receipt-printing.show', $receipt) }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Receipt</span>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="temple-alert temple-alert--danger" id="paymentErrorAlert">
            <div class="temple-alert-content" style="align-items: flex-start;">
                <div class="temple-alert-icon" style="margin-top: 2px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div>
                    <strong style="display: block; margin-bottom: 4px;">Please review the following:</strong>
                    <ul style="margin: 0; padding-left: 18px; font-size: 13.5px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('paymentErrorAlert').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Devotee & Receipt Summary Card --}}
    <div class="receipt-card-section" style="margin-bottom: 24px;">
        <div class="vazhipad-card-accent"></div>
        <div class="receipt-card-header">
            <h3 class="receipt-card-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--gold-600);">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                <span>Receipt Summary</span>
            </h3>

            <span class="receipt-id-badge">
                {{ $receipt->receipt_number ?: '#RC-' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
            </span>
        </div>

        <div class="receipt-card-body">
            <div class="receipt-meta-grid" style="margin-bottom: 20px;">
                <div>
                    <div class="meta-field-label">Devotee Name</div>
                    <div class="meta-field-value" style="font-family: 'Noto Serif', Georgia, serif; color: var(--maroon-900);">
                        {{ $receipt->devotee_name }}
                    </div>
                </div>
                <div>
                    <div class="meta-field-label">Nakshatram</div>
                    <div class="meta-field-value">
                        <span class="nakshatram-tag"> {{ $receipt->nakshatram }}</span>
                    </div>
                </div>
                <div>
                    <div class="meta-field-label">Receipt Date</div>
                    <div class="meta-field-value">
                        {{ optional($receipt->receipt_date ?: $receipt->receipts_date)->format('d M Y') ?: 'N/A' }}
                    </div>
                </div>
                <div>
                    <div class="meta-field-label">Total Amount</div>
                    <div class="meta-field-value" style="font-size: 16px; color: var(--maroon-900);">
                        ₹{{ number_format($receipt->total_amount, 2) }}
                    </div>
                </div>
            </div>

            <table class="receipt-slip-table">
                <thead>
                    <tr>
                        <th>Vazhipad Offering</th>
                        <th style="width: 20%; text-align: center;">Quantity</th>
                        <th style="width: 25%; text-align: right;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipt->items as $item)
                        <tr>
                            <td><strong>{{ $item->vazhipad->name ?? 'Offering' }}</strong></td>
                            <td style="text-align: center;">{{ $item->quantity ?? 1 }}</td>
                            <td style="text-align: right; font-weight: 600;">₹{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="receipt-total-row">
                        <td style="font-family: 'Noto Serif', Georgia, serif; font-weight: 700; color: var(--maroon-900);">Grand Total</td>
                        <td style="text-align: center; font-weight: 700;">{{ $receipt->items->sum('quantity') }} items</td>
                        <td style="text-align: right; font-weight: 700; font-size: 17px; color: var(--maroon-900);">
                            ₹{{ number_format($receipt->total_amount, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Payment Form Card --}}
    <div class="receipt-card-section" style="max-width: 620px;">
        <div class="vazhipad-card-accent"></div>
        <div class="receipt-card-header">
            <h3 class="receipt-card-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--green-600);">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 14 14"></polyline>
                </svg>
                <span>Update Counter Payment</span>
            </h3>
        </div>

        <div class="receipt-card-body">
            <form method="POST" action="{{ route('temple.receipt-printing.payment', $receipt) }}" id="payment-form">
                @csrf
                @method('PATCH')

                <div class="form-group-item" style="margin-bottom: 18px;">
                    <label class="form-label" for="payment_status">
                        <span>Payment Status</span>
                        <span style="color: var(--red-600); font-weight: 700;">*</span>
                    </label>
                    <select name="payment_status" id="payment_status" class="form-select" required>
                        @php
                            $statuses = [
                                'pending' => 'Pending (Unpaid)',
                                'paid' => 'Paid (Full Amount)',
                                'partially_paid' => 'Partially Paid',
                                'cancelled' => 'Cancelled / Refunded',
                            ];
                        @endphp
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(old('payment_status', $receipt->payment_status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-item" style="margin-bottom: 18px;">
                    <label class="form-label" for="payment_method">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">— Select Payment Method —</option>
                        @php
                            $methods = [
                                'cash' => 'Cash at Counter',
                                'upi' => 'UPI (Google Pay / PhonePe / Paytm)',
                                'card' => 'Debit / Credit Card POS',
                                'bank_transfer' => 'Direct Bank Transfer / NEFT',
                            ];
                        @endphp
                        @foreach ($methods as $value => $label)
                            <option value="{{ $value }}" @selected(old('payment_method', $receipt->payment_method) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-item" style="margin-bottom: 18px;">
                    <label class="form-label">Total Bill Amount</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--gold-600);">₹</span>
                        <input type="text"
                               class="form-control"
                               style="padding-left: 32px; background: var(--cream-50); font-weight: 700; color: var(--maroon-900);"
                               value="{{ number_format($receipt->total_amount, 2) }}"
                               disabled>
                    </div>
                </div>

                <div class="form-group-item" style="margin-bottom: 24px;">
                    <label class="form-label" for="paid_amount">
                        <span>Paid Amount (₹)</span>
                        <span style="color: var(--red-600); font-weight: 700;">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--gold-600);">₹</span>
                        <input type="number"
                               step="0.01"
                               min="0"
                               max="{{ $receipt->total_amount }}"
                               name="paid_amount"
                               id="paid_amount"
                               class="form-control"
                               style="padding-left: 32px; font-weight: 700;"
                               value="{{ old('paid_amount', $receipt->paid_amount ?: $receipt->total_amount) }}"
                               required>
                    </div>
                    <span style="font-size: 12px; color: var(--ink-400); margin-top: 4px;">
                        Cannot exceed the total amount of ₹{{ number_format($receipt->total_amount, 2) }}.
                    </span>
                </div>

                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px;">
                    <a href="{{ route('temple.receipt-printing.show', $receipt) }}" class="btn-temple btn-temple-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn-temple btn-temple-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Update Payment Status</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    (function () {
        const totalAmount = {{ (float) $receipt->total_amount }};
        const statusSelect = document.getElementById('payment_status');
        const paidAmountInput = document.getElementById('paid_amount');

        statusSelect?.addEventListener('change', function () {
            if (this.value === 'paid') {
                paidAmountInput.value = totalAmount.toFixed(2);
            } else if (this.value === 'cancelled' || this.value === 'pending') {
                paidAmountInput.value = '0.00';
            }
        });

        paidAmountInput?.addEventListener('input', function () {
            if (parseFloat(this.value) > totalAmount) {
                this.value = totalAmount.toFixed(2);
            }
        });
    })();
</script>
@endpush
@endsection