@extends('temple.layouts.app')

@section('title', 'Confirm Vazhipad Booking')

@section('content')
<div class="receipt-narrow-container">

    {{-- Header --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 11l3 3L22 4"></path>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <h1 class="vazhipad-page-title">Review &amp; Confirm Booking</h1>
                <p class="vazhipad-page-subtitle">Verify devotee sankalpam details before generating official receipt</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.receipts.create') }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Edit Details</span>
            </a>
        </div>
    </div>

    {{-- Confirmation Card --}}
    <div class="receipt-card-section">
        <div class="vazhipad-card-accent"></div>

        <div class="receipt-card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--gold-600);">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 14 14"></polyline>
                </svg>
                <strong style="font-family: 'Noto Serif', Georgia, serif; font-size: 17px; color: var(--maroon-900);">
                    {{ $vazhipad->name ?? 'Vazhipad Offering' }}
                </strong>
            </div>

            <span class="temple-badge temple-badge--active">Ready for Confirmation</span>
        </div>

        <div class="receipt-card-body">
            <table class="success-summary-table">
                <tbody>
                    <tr>
                        <th>Devotee Name</th>
                        <td style="font-family: 'Noto Serif', Georgia, serif; font-size: 16px; color: var(--maroon-900);">
                            {{ $devotee_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Birth Star (Nakshatram)</th>
                        <td>
                            <span class="nakshatram-tag">
                                 {{ $nakshatram }}
                            </span>
                        </td>
                    </tr>
                    @if(!empty($phone))
                        <tr>
                            <th>Contact Phone</th>
                            <td>{{ $phone }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Pooja / Receipt Date</th>
                        <td>{{ \Carbon\Carbon::parse($receipts_date)->format('d F Y, l') }}</td>
                    </tr>
                    @if(!empty($notes))
                        <tr>
                            <th>Special Instructions</th>
                            <td style="font-weight: 500; color: var(--ink-800);">{{ $notes }}</td>
                        </tr>
                    @endif
                    <tr style="border-top: 2px solid var(--line); background: var(--cream-50);">
                        <th style="font-size: 16px; font-weight: 700; color: var(--maroon-900);">Total Dakshina</th>
                        <td>
                            <span style="font-family: 'Poppins', system-ui, sans-serif; font-size: 22px; font-weight: 700; color: var(--maroon-900);">
                                <span style="color: var(--gold-600); font-size: 17px;">₹</span>{{ number_format($amount, 2) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="background: var(--gold-50); border: 1px solid var(--gold-300); border-radius: var(--radius-md); padding: 14px 18px; display: flex; align-items: flex-start; gap: 12px; margin-top: 20px; font-size: 13px; color: var(--ink-800); line-height: 1.5;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--gold-600); flex-shrink: 0; margin-top: 1px;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <div>
                    <strong>Sankalpam Verification:</strong>
                    Please ensure the <strong>Devotee Name</strong> and <strong>Nakshatram</strong> are accurately recorded, as they will be chanted during the auspicious temple sankalpam archana.
                </div>
            </div>
        </div>

        <div style="padding: 18px 24px; background: var(--cream-50); border-top: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <a href="{{ route('temple.receipts.create') }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Edit</span>
            </a>

            <form action="{{ route('temple.receipts.store') }}" method="POST" style="margin: 0;">
                @csrf
                @if(isset($vazhipad->id))
                    <input type="hidden" name="vazhipad_id[]" value="{{ $vazhipad->id }}">
                    <input type="hidden" name="quantity[]" value="1">
                    <input type="hidden" name="amount[]" value="{{ $amount }}">
                @endif
                <input type="hidden" name="devotee_name" value="{{ $devotee_name }}">
                <input type="hidden" name="nakshatram" value="{{ $nakshatram }}">
                <input type="hidden" name="receipts_date" value="{{ $receipts_date }}">

                <button type="submit" class="btn-temple btn-temple-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Confirm &amp; Issue Receipt</span>
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
