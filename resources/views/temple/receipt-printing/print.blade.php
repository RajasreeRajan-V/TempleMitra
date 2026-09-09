<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Voucher — {{ $receipt->receipt_number ?: $receipt->id }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700&family=Noto+Serif:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/temple.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #2d2118;
            margin: 0;
            padding: 32px 16px;
            background: #f8f3e7;
        }

        .print-toolbar {
            max-width: 520px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .print-voucher-wrapper {
            max-width: 520px;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid var(--gold-500);
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 10px 25px rgba(74, 20, 32, 0.12);
            position: relative;
        }

        .voucher-header {
            text-align: center;
            border-bottom: 2px double var(--line);
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        .voucher-invocation {
            font-family: 'Noto Serif', Georgia, serif;
            font-size: 12px;
            letter-spacing: 0.15em;
            color: var(--gold-600);
            margin-bottom: 4px;
            font-weight: 700;
        }

        .voucher-temple-name {
            font-family: 'Noto Serif', Georgia, serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--maroon-900);
            margin: 0 0 2px 0;
            line-height: 1.2;
        }

        .voucher-type-subtitle {
            font-size: 11px;
            font-weight: 600;
            color: var(--ink-600);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .voucher-meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px;
            color: var(--ink-800);
        }

        .voucher-divider {
            border-top: 1px dashed var(--line);
            margin: 12px 0;
        }

        table.voucher-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 8px;
        }

        table.voucher-table th {
            text-align: left;
            border-bottom: 1.5px solid var(--maroon-900);
            padding: 6px 0;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--maroon-900);
        }

        table.voucher-table td {
            padding: 8px 0;
            border-bottom: 1px dashed var(--line-light);
            vertical-align: middle;
        }

        .voucher-total-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            font-size: 16px;
            margin-top: 10px;
            border-top: 2px solid var(--maroon-900);
            padding-top: 10px;
            color: var(--maroon-900);
        }

        .voucher-payment-box {
            background: var(--cream-50);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 10px 14px;
            margin-top: 14px;
            font-size: 12px;
        }

        .voucher-blessing {
            margin-top: 18px;
            text-align: center;
            font-family: 'Noto Serif', Georgia, serif;
            font-size: 11.5px;
            font-style: italic;
            color: var(--ink-600);
            line-height: 1.4;
        }

        .voucher-sign-row {
            margin-top: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 11px;
            color: var(--ink-600);
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .print-toolbar, .no-print {
                display: none !important;
            }

            .print-voucher-wrapper {
                border: 1px solid #000000 !important;
                box-shadow: none !important;
                max-width: 100% !important;
                padding: 16px !important;
                border-radius: 0 !important;
            }

            table.voucher-table th {
                border-bottom: 1.5px solid #000000 !important;
                color: #000000 !important;
            }

            .voucher-total-banner {
                border-top: 2px solid #000000 !important;
                color: #000000 !important;
            }

            @page {
                size: auto;
                margin: 10mm;
            }
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
            <div class="voucher-type-subtitle">Official Vazhipad &amp; Pooja Dakshina Receipt</div>
        </div>

        {{-- Receipt Meta --}}
        <div class="voucher-meta-row">
            <span><strong>Receipt No:</strong></span>
            <span style="font-family: monospace; font-weight: 700; color: var(--maroon-900);">
                {{ $receipt->receipt_number ?: '#RC-' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
            </span>
        </div>
        <div class="voucher-meta-row">
            <span><strong>Date of Pooja:</strong></span>
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
                    <th style="width: 55%;">Vazhipad Offering</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 30%; text-align: right;">Amount</th>
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
            </tbody>
        </table>

        {{-- Total --}}
        <div class="voucher-total-banner">
            <span>TOTAL DAKSHINA</span>
            <span>₹{{ number_format($receipt->total_amount, 2) }}</span>
        </div>

        {{-- Payment Status Info Box --}}
        <div class="voucher-payment-box">
            <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                <span><strong>Payment Status:</strong></span>
                <span style="text-transform: uppercase; font-weight: 700; color: var(--green-700);">
                    {{ $receipt->payment_status_label ?: ($receipt->payment_status ?: 'Confirmed') }}
                </span>
            </div>
            @if($receipt->payment_method)
                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                    <span><strong>Payment Method:</strong></span>
                    <span>{{ strtoupper($receipt->payment_method) }}</span>
                </div>
            @endif
            @if($receipt->paid_amount)
                <div style="display: flex; justify-content: space-between;">
                    <span><strong>Paid Amount:</strong></span>
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
            <div style="text-align: right;">
                <div style="border-top: 1px solid var(--ink-600); width: 130px; margin-bottom: 2px;"></div>
                <span>Authorized Counter Seal</span>
            </div>
        </div>

    </div>

</body>
</html>