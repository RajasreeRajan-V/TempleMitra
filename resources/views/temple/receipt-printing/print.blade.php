<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Voucher — {{ $receipt->receipt_number ?: $receipt->id }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Noto+Serif:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/temple.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #2d2118;
            margin: 0;
            padding: 24px 12px;
            background: #ede4d3;
        }

       
    </style>
</head>
<body>

    <div class="print-toolbar no-print">
        <a href="{{ route('temple.receipt-printing.show', $receipt) }}" class="btn-temple btn-temple-secondary btn-temple-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to Details</span>
        </a>

        <button onclick="window.print()" class="btn-temple btn-temple-primary btn-temple-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            <span>Print Voucher Slip</span>
        </button>
    </div>

    <div class="print-voucher-wrapper">

        {{-- Header --}}
        <div class="voucher-header">
            <div class="voucher-invocation">|| ഓം നമഃ ശിവായ || ശുഭം ഭവതു ||</div>
            <h1 class="voucher-temple-name">{{ config('app.temple_name', 'TempleMitra Devasthanam') }}</h1>
            <div class="voucher-type-subtitle">Vazhipad &amp; Pooja Dakshina Receipt</div>
        </div>

        {{-- Receipt Meta --}}
        <div class="voucher-meta-row">
            <span><strong>Receipt No:</strong></span>
            <span style="font-family: monospace; font-weight: 700; color: var(--maroon-900);">
                {{ $receipt->receipt_number ?: '#RC-' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
            </span>
        </div>
        <div class="voucher-meta-row">
            <span><strong>Date:</strong></span>
            <span>{{ optional($receipt->receipt_date ?: $receipt->receipts_date)->format('d-m-Y') }}</span>
        </div>

        <div class="voucher-divider"></div>

        {{-- Devotee Details --}}
        <div class="voucher-meta-row">
            <span><strong>Devotee:</strong></span>
            <span style="font-family: 'Noto Serif', Georgia, serif; font-weight: 700; color: var(--maroon-900);">
                {{ $receipt->devotee_name }}
            </span>
        </div>
        <div class="voucher-meta-row">
            <span><strong>Nakshatram:</strong></span>
            <span style="font-weight: 600; color: var(--gold-600);">
                {{ $receipt->nakshatram }}
            </span>
        </div>

        <div class="voucher-divider"></div>

        {{-- Offerings Table --}}
        <table class="voucher-table">
            <thead>
                <tr>
                    <th style="width: 55%;">Vazhipad</th>
                    <th style="width: 15%;">Qty</th>
                    <th style="width: 30%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receipt->items as $item)
                    <tr>
                        <td><strong>{{ $item->vazhipad->name ?? 'Offering' }}</strong></td>
                        <td>{{ $item->quantity ?? 1 }}</td>
                        <td>₹{{ number_format($item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total --}}
        <div class="voucher-total-banner">
            <span>TOTAL</span>
            <span>₹{{ number_format($receipt->total_amount, 2) }}</span>
        </div>

        {{-- Payment Status Info Box --}}
        <div class="voucher-payment-box">
            <div>
                <span><strong>Status:</strong></span>
                <span style="text-transform: uppercase; font-weight: 700; color: var(--green-700);">
                    {{ $receipt->payment_status_label ?: ($receipt->payment_status ?: 'Confirmed') }}
                </span>
            </div>
            @if($receipt->payment_method)
                <div>
                    <span><strong>Method:</strong></span>
                    <span>{{ strtoupper($receipt->payment_method) }}</span>
                </div>
            @endif
            @if($receipt->transaction_id)
                <div>
                    <span><strong>Txn ID:</strong></span>
                    <span style="font-family: monospace; font-weight: 600;">{{ $receipt->transaction_id }}</span>
                </div>
            @endif
            @if($receipt->paid_amount)
                <div>
                    <span><strong>Paid:</strong></span>
                    <span>₹{{ number_format($receipt->paid_amount, 2) }}</span>
                </div>
            @endif
        </div>

        <div class="voucher-blessing">
            "May the divine grace and blessings be upon you and your family."
        </div>

        <div class="voucher-sign-row">
            <div>
                <small>{{ date('d/m/Y h:i A') }}</small>
            </div>
            <div>
                <div class="sign-line"></div>
                <span>Counter Seal</span>
            </div>
        </div>

    </div>

</body>
</html>