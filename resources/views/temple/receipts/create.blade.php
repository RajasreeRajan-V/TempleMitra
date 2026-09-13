@extends('temple.layouts.app')

@section('title', 'New Vazhipad Receipt')

@section('content')
<div class="receipt-create-container">

    {{-- Header Bar --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <h1 class="vazhipad-page-title">Issue Vazhipad Receipt</h1>
                <p class="vazhipad-page-subtitle">Register devotee sankalpam, pooja offerings, and dakshina payment</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.receipts.index') }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Receipts</span>
            </a>
        </div>
    </div>

    {{-- Validation Errors Summary --}}
    @if ($errors->any())
        <div class="temple-alert temple-alert--danger" id="formErrorAlert">
            <div class="temple-alert-content" style="align-items: flex-start;">
                <div class="temple-alert-icon" style="margin-top: 2px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div>
                    <strong style="display: block; margin-bottom: 4px;">Please correct the errors below:</strong>
                    <ul style="margin: 0; padding-left: 18px; font-size: 13.5px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('formErrorAlert').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('temple.receipts.store') }}" id="receiptForm">
        @csrf

        {{-- Devotee & Sankalpam Details Card --}}
        <div class="receipt-card-section">
            <div class="vazhipad-card-accent"></div>
            <div class="receipt-card-header">
                <h3 class="receipt-card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--gold-600);">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Devotee &amp; Sankalpam Details</span>
                </h3>
                <span style="font-size: 12px; color: var(--ink-400);">Fields marked with <span style="color: var(--red-600); font-weight: 700;">*</span> are mandatory</span>
            </div>

            <div class="receipt-card-body">
                <div class="form-grid-3">
                    {{-- Devotee Name --}}
                    <div class="form-group-item">
                        <label for="devotee_name" class="form-label">
                            <span>Devotee Name</span>
                            <span style="color: var(--red-600); font-weight: 700;">*</span>
                        </label>
                        <div class="input-icon-wrap">
                            <span class="input-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input type="text"
                                   name="devotee_name"
                                   id="devotee_name"
                                   class="form-control input-with-icon @error('devotee_name') is-invalid @enderror"
                                   value="{{ old('devotee_name') }}"
                                   placeholder="e.g., Ananthakrishnan R / Smt. Lakshmi"
                                   required
                                   autofocus>
                        </div>
                        @error('devotee_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nakshatram (Birth Star) --}}
<div class="form-group-item">
    <label for="nakshatram" class="form-label">
        <span>Nakshatram (Birth Star)</span>
        <span style="color: var(--red-600); font-weight: 700;">*</span>
    </label>

    <div class="input-icon-wrap">
        <span class="input-icon">
            <svg width="16" height="16"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 style="color: var(--gold-600);">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14
                    18.18 21.02 12 17.77 5.82 21.02 7 14.14
                    2 9.27 8.91 8.26 12 2">
                </polygon>
            </svg>
        </span>

        <select
            name="nakshatram"
            id="nakshatram"
            class="form-select @error('nakshatram') is-invalid @enderror"
            required
        >
            <option value="">-- Search Nakshatram --</option>

            @include('temple.partials.nakshatram-options', [
                'selected' => old('nakshatram')
            ])
        </select>
    </div>

    @error('nakshatram')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                    {{-- Receipt Date --}}
                    <div class="form-group-item">
                        <label for="receipts_date" class="form-label">
                            <span>Receipt Date</span>
                            <span style="color: var(--red-600); font-weight: 700;">*</span>
                        </label>
                        <div class="input-icon-wrap">
                            <span class="input-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                            <input type="date"
                                   name="receipts_date"
                                   id="receipts_date"
                                   class="form-control input-with-icon @error('receipts_date') is-invalid @enderror"
                                   value="{{ old('receipts_date', date('Y-m-d')) }}"
                                   required>
                        </div>
                        @error('receipts_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Repeatable Vazhipad Line Items Card --}}
        <div class="receipt-card-section">
            <div class="vazhipad-card-accent"></div>
            <div class="receipt-card-header">
                <h3 class="receipt-card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--maroon-700);">
                        <path d="M12 2c1.5 2.5 3 4.5 3 7a3 3 0 0 1-6 0c0-2.5 1.5-4.5 3-7Z"/>
                        <path d="M5 14h14l-1.5 5.5a2 2 0 0 1-1.9 1.5H8.4a2 2 0 0 1-1.9-1.5L5 14Z"/>
                        <path d="M10 21v1h4v-1"/>
                    </svg>
                    <span>Vazhipad Offerings &amp; Items</span>
                </h3>

                <button type="button" class="btn-temple btn-temple-gold btn-temple-sm" id="add-row-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add Another Offering</span>
                </button>
            </div>

            <div class="temple-table-responsive">
                <table class="receipt-items-table" id="vazhipad-table">
                    <thead>
                        <tr>
                            <th style="width: 48%;">Offering Name</th>
                            <th style="width: 18%; text-align: center;">Quantity</th>
                            <th style="width: 24%; text-align: right;">Amount (₹)</th>
                            <th style="width: 10%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="vazhipad-rows">
                        {{-- Rows injected by JavaScript --}}
                    </tbody>
                </table>
            </div>

            {{-- Grand Total Section --}}
            <div class="grand-total-banner">
                <span class="grand-total-label">Grand Total Dakshina:</span>
                <div class="grand-total-val">
                    <span style="color: var(--gold-600); font-size: 20px;">₹</span>
                    <span id="grand-total-amount">0.00</span>
                </div>
            </div>
        </div>

        {{-- Form Actions Footer --}}
        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="{{ route('temple.receipts.index') }}" class="btn-temple btn-temple-secondary">
                Cancel
            </a>

            <button type="submit" class="btn-temple btn-temple-primary" id="saveReceiptBtn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>Save &amp; Generate Receipt</span>
            </button>
        </div>
    </form>
</div>

{{-- Hidden HTML Template for a Repeatable Offering Row --}}
<template id="row-template">
    <tr class="vazhipad-row">
        <td>
            <select name="vazhipad_id[]" class="form-select vazhipad-select" required>
                <option value="" data-price="0">-- Select Offering --</option>
                @foreach ($vazhipads as $vazhipad)
                    <option value="{{ $vazhipad->id }}" data-price="{{ $vazhipad->price }}">
                        {{ $vazhipad->name }} — ₹{{ number_format($vazhipad->price, 2) }}
                    </option>
                @endforeach
            </select>
        </td>

        <td style="text-align: center;">
            <input type="number"
                   name="quantity[]"
                   class="form-control qty-input"
                   value="1"
                   min="1"
                   max="999"
                   style="text-align: center; max-width: 110px; margin: 0 auto;"
                   required>
        </td>

        <td style="text-align: right;">
            <div style="position: relative; max-width: 160px; margin-left: auto;">
                <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--gold-600); font-size: 14px;">₹</span>
                <input type="number"
                       step="0.01"
                       min="0"
                       name="amount[]"
                       class="form-control amount-input"
                       value="0.00"
                       style="padding-left: 28px; text-align: right; font-weight: 600;"
                       required>
            </div>
        </td>

        <td style="text-align: center;">
            <button type="button" class="btn-icon-danger remove-row-btn" title="Remove offering row">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rowsBody       = document.getElementById('vazhipad-rows');
    const template       = document.getElementById('row-template');
    const addBtn         = document.getElementById('add-row-btn');
    const grandTotalSpan = document.getElementById('grand-total-amount');

    function updateDeleteButtonsState() {
        const rows = rowsBody.querySelectorAll('.vazhipad-row');
        const deleteButtons = rowsBody.querySelectorAll('.remove-row-btn');
        if (rows.length <= 1) {
            deleteButtons.forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.35';
                btn.style.cursor = 'not-allowed';
            });
        } else {
            deleteButtons.forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            });
        }
    }

    function addRow() {
        const clone = template.content.cloneNode(true);
        rowsBody.appendChild(clone);
        bindRowEvents(rowsBody.lastElementChild);
        recalcTotal();
        updateDeleteButtonsState();
    }

    function removeRow(row) {
        if (rowsBody.querySelectorAll('.vazhipad-row').length > 1) {
            row.remove();
            recalcTotal();
            updateDeleteButtonsState();
        }
    }

    function bindRowEvents(row) {
        const select    = row.querySelector('.vazhipad-select');
        const qtyInput  = row.querySelector('.qty-input');
        const amtInput  = row.querySelector('.amount-input');
        const removeBtn = row.querySelector('.remove-row-btn');

        function autoFillAmount() {
            const opt = select.options[select.selectedIndex];
            const price = parseFloat(opt?.dataset?.price || 0);
            const qty = parseInt(qtyInput.value || 1, 10);
            amtInput.value = (price * (qty > 0 ? qty : 1)).toFixed(2);
            recalcTotal();
        }

        select.addEventListener('change', autoFillAmount);
        qtyInput.addEventListener('input', autoFillAmount);
        amtInput.addEventListener('input', recalcTotal);
        removeBtn.addEventListener('click', () => removeRow(row));
    }

    function recalcTotal() {
        let total = 0;
        rowsBody.querySelectorAll('.amount-input').forEach(input => {
            total += parseFloat(input.value || 0);
        });
        grandTotalSpan.textContent = total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    addBtn.addEventListener('click', addRow);

    // Initialize with 1 empty offering row
    addRow();
});
</script>
@endpush
@endsection