@extends('temple.layouts.app')

@section('title', 'Receipt #' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="receipt-view-container">

    {{-- Success Flash Alert --}}
    @if(session('success'))
        <div class="temple-alert temple-alert--success" id="receiptSuccessNotice">
            <div class="temple-alert-content">
                <div class="temple-alert-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('receiptSuccessNotice').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Top Action Toolbar --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;" class="no-print">
        <a href="{{ route('temple.receipts.index') }}" class="btn-temple btn-temple-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Receipts</span>
        </a>

        <a href="{{ route('temple.receipt-printing.payment.form', $receipt) }}" class="btn-temple btn-temple-secondary">
                        <span>Print Receipt</span>
                    </a>

        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('temple.receipts.create') }}" class="btn-temple btn-temple-gold">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>New Receipt</span>
            </a>

           
        </div>
    </div>

    {{-- Ornate Temple Receipt Slip --}}
    <div class="temple-receipt-slip">
        <div class="vazhipad-card-accent"></div>

        <div class="receipt-slip-inner">
            {{-- Temple Header --}}
            <div class="receipt-temple-header">
                <div class="receipt-emblem-icon">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 2c1.5 2.5 3 4.5 3 7a3 3 0 0 1-6 0c0-2.5 1.5-4.5 3-7Z"/>
                        <path d="M5 14h14l-1.5 5.5a2 2 0 0 1-1.9 1.5H8.4a2 2 0 0 1-1.9-1.5L5 14Z"/>
                        <path d="M10 21v1h4v-1"/>
                    </svg>
                </div>
                <div class="receipt-invocation">|| ഓം നമഃ ശിവായ || ശുഭം ഭവതു ||
</div>
                <h1 class="receipt-temple-name">TempleMitra Devasthanam</h1>
                <div class="receipt-type-title">Official Vazhipad &amp; Pooja Dakshina Voucher</div>
            </div>

            {{-- Metadata Summary Grid --}}
            <div class="receipt-meta-grid">
                <div>
                    <div class="meta-field-label">Receipt Number</div>
                    <div class="meta-field-value" style="color: var(--maroon-900); font-family: monospace; font-size: 15px;">
                        #RC-{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <div>
                    <div class="meta-field-label">Receipt Date</div>
                    <div class="meta-field-value">
                        {{ $receipt->receipts_date ? \Carbon\Carbon::parse($receipt->receipts_date)->format('d M Y') : 'N/A' }}
                    </div>
                </div>

                <div>
                    <div class="meta-field-label">Booking Status</div>
                    <div class="meta-field-value">
                        <span class="temple-badge temple-badge--active" style="padding: 2px 8px; font-size: 11.5px;">
                            <span class="temple-badge-dot"></span>
                            {{ ucfirst($receipt->status ?? 'Confirmed') }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="meta-field-label">Generated On</div>
                    <div class="meta-field-value" style="font-size: 13.5px; color: var(--ink-600);">
                        {{ $receipt->created_at ? $receipt->created_at->format('d/m/Y h:i A') : date('d/m/Y') }}
                    </div>
                </div>
            </div>

            {{-- Devotee & Sankalpam Spotlight Box --}}
            <div class="devotee-spotlight-box">
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--gold-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px;">
                        Devotee Sankalpam Name
                    </div>
                    <h2 class="devotee-main-title">{{ $receipt->devotee_name }}</h2>
                    <div style="font-size: 13px; color: var(--ink-600);">Offering dedicated in accordance with temple rituals</div>
                </div>

                @if(!empty($receipt->nakshatram))
                    <div style="background: #ffffff; border: 1px solid var(--gold-400); border-radius: var(--radius-md); padding: 10px 18px; text-align: center; box-shadow: var(--shadow-sm);">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--ink-400); letter-spacing: 0.05em;">Birth Star (Nakshatram)</div>
                        <div style="font-family: 'Noto Serif', Georgia, serif; font-size: 18px; font-weight: 700; color: var(--maroon-900); margin-top: 2px;">
                             {{ $receipt->nakshatram }}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Offering Items Table --}}
            <table class="receipt-slip-table">
                <thead>
                    <tr>
                        <th style="width: 8%; text-align: center;">#</th>
                        <th style="width: 52%;">Vazhipad / Offering Name</th>
                        <th style="width: 15%; text-align: center;">Qty</th>
                        <th style="width: 25%; text-align: right;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receipt->items as $index => $item)
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: var(--ink-400);">{{ $index + 1 }}</td>
                            <td>
                                <strong style="color: var(--maroon-900);">{{ $item->vazhipad->name ?? 'Vazhipad Offering' }}</strong>
                                @if(!empty($item->vazhipad->description))
                                    <div style="font-size: 12px; color: var(--ink-400); margin-top: 2px;">{{ Str::limit($item->vazhipad->description, 60) }}</div>
                                @endif
                            </td>
                            <td style="text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                            <td style="text-align: right; font-weight: 700;">₹{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--ink-400); font-style: italic;">No line items found for this receipt.</td>
                        </tr>
                    @endforelse

                    {{-- Total Row --}}
                    <tr class="receipt-total-row">
                        <td colspan="2" style="font-family: 'Noto Serif', Georgia, serif; font-size: 16px; font-weight: 700; color: var(--maroon-900);">
                            Total Dakshina Contribution
                        </td>
                        <td style="text-align: center; font-weight: 700; color: var(--ink-600);">
                            {{ $receipt->items->sum('quantity') }} items



                        </td>
                        <td style="text-align: right;">
                            <span class="total-amount-display">
                                <span style="font-size: 18px; color: var(--gold-600);">₹</span>{{ number_format($item->amount, 2) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Footer Blessing & Authority Signature --}}
            <div class="receipt-blessing-footer">
                <div class="blessing-text">
                    "May the divine grace and blessings of the presiding deity bring peace, prosperity, health, and spiritual fulfillment to you and your loved ones."
                </div>

                <div class="signature-block">
                    <div style="height: 38px; display: flex; align-items: flex-end; justify-content: center; margin-bottom: 4px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="color: var(--gold-500); opacity: 0.6;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="signature-line"></div>
                    <div class="signature-label">Authorized Signature</div>
                    <div style="font-size: 11px; color: var(--ink-400); margin-top: 2px;">Temple Counter Desk</div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection