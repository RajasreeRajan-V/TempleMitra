@extends('temple.layouts.app')

@section('title', $vazhipad->name . ' — Details')

@section('content')
<div class="vazhipad-page-container" style="max-width: 960px;">

    @php
        $isActive = in_array($vazhipad->status, ['active', 1, '1', true], true);
    @endphp

    {{-- Page Header --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-avatar-badge" style="width: 52px; height: 52px; font-size: 24px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                    <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2px;">
                    <span class="vazhipad-code-badge">#VP-{{ sprintf('%03d', $vazhipad->id) }}</span>
                    <span class="temple-badge {{ $isActive ? 'temple-badge--active' : 'temple-badge--inactive' }}">
                        <span class="temple-badge-dot"></span>
                        {{ $isActive ? 'Active Offering' : 'Inactive' }}
                    </span>
                </div>
                <h1 class="vazhipad-page-title">{{ $vazhipad->name }}</h1>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.vazhipad.edit', $vazhipad->id) }}" class="btn-temple btn-temple-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                <span>Edit Offering</span>
            </a>

            <button type="button"
                    class="btn-temple btn-temple-secondary"
                    onclick="openDeleteModal('{{ $vazhipad->id }}', '{{ addslashes($vazhipad->name) }}')"
                    style="color: var(--red-600);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                <span>Delete</span>
            </button>

            <a href="{{ route('temple.vazhipad.index') }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    {{-- Detail Overview Card --}}
    <div class="vazhipad-card" style="box-shadow: var(--shadow-md); margin-bottom: 24px;">
        <div class="vazhipad-card-accent"></div>

        <div style="padding: 28px 32px;">
            {{-- Price Highlight Hero Banner --}}
            <div class="vazhipad-price-banner" style="padding: 18px 24px; margin-bottom: 28px; border-radius: var(--radius-xl);">
                <div>
                    <span class="vazhipad-price-label" style="font-size: 13px;">Dakshina Rate per receipts</span>
                    <p style="margin: 4px 0 0 0; font-size: 13.5px; color: var(--ink-600);">Standard offering contribution amount for this pooja</p>
                </div>
                <div class="vazhipad-price-amount" style="font-size: 32px;">
                    <span class="vazhipad-price-symbol" style="font-size: 24px;">₹</span>{{ number_format($vazhipad->price, 2) }}
                </div>
            </div>

            {{-- Metadata Grid --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px;">
                <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 16px 18px;">
                    <div style="font-size: 12px; color: var(--ink-400); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; font-weight: 600;">Catalogue Code</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--maroon-900);">#VP-{{ sprintf('%03d', $vazhipad->id) }}</div>
                </div>

                <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 16px 18px;">
                    <div style="font-size: 12px; color: var(--ink-400); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; font-weight: 600;">Availability Status</div>
                    <div style="font-size: 16px; font-weight: 700; color: {{ $isActive ? 'var(--green-700)' : 'var(--ink-600)' }};">
                        {{ $isActive ? '● Available for Devotees' : '○ Currently Disabled' }}
                    </div>
                </div>

                <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 16px 18px;">
                    <div style="font-size: 12px; color: var(--ink-400); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; font-weight: 600;">Offering Type</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--ink-900);">Daily Temple Pooja</div>
                </div>

                <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 16px 18px;">
                    <div style="font-size: 12px; color: var(--ink-400); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; font-weight: 600;">Created On</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--ink-900);">
                        {{ $vazhipad->created_at ? $vazhipad->created_at->format('d M Y, h:i A') : 'N/A' }}
                    </div>
                </div>
            </div>

            {{-- Description Section --}}
            <div style="margin-bottom: 8px;">
                <h3 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: 20px; font-weight: 700; color: var(--maroon-900); margin: 0 0 10px 0;">
                    Offering Description & Ritual Details
                </h3>
                <div style="background: var(--cream-50); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 20px; font-size: 14.5px; line-height: 1.6; color: var(--ink-800);">
                    @if(!empty($vazhipad->description))
                        {{ $vazhipad->description }}
                    @else
                        <span style="color: var(--ink-400); font-style: italic;">No specific description or pooja instructions provided for this offering.</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="vazhipad-card-footer" style="padding: 18px 32px; justify-content: space-between;">
            <a href="{{ route('temple.vazhipad.index') }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Offerings</span>
            </a>

            <div style="display: flex; align-items: center; gap: 10px;">
                <button type="button"
                        class="btn-temple btn-temple-secondary"
                        onclick="openDeleteModal('{{ $vazhipad->id }}', '{{ addslashes($vazhipad->name) }}')"
                        style="color: var(--red-600);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    <span>Delete</span>
                </button>

                <a href="{{ route('temple.vazhipad.edit', $vazhipad->id) }}" class="btn-temple btn-temple-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Edit Offering</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Standalone Modal for Delete Confirmation --}}
<div class="temple-modal-backdrop" id="templeDeleteModal">
    <div class="temple-modal-card">
        <div class="temple-modal-header">
            <div class="temple-modal-icon-wrap">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>
            <div>
                <h4 class="temple-modal-title">Delete Vazhipad</h4>
            </div>
        </div>

        <div class="temple-modal-body">
            Are you sure you want to permanently delete <strong id="deleteOfferingName" class="temple-modal-item-name">this offering</strong>? This action cannot be undone.
        </div>

        <div class="temple-modal-footer">
            <button type="button" class="btn-temple btn-temple-secondary btn-temple-sm" onclick="closeDeleteModal()">
                Cancel
            </button>

            <form id="templeDeleteForm" method="POST" action="" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-temple btn-temple-danger btn-temple-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    <span>Confirm Delete</span>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(id, name) {
        const form = document.getElementById('templeDeleteForm');
        form.action = "{{ url('temple/vazhipad') }}/" + id;
        document.getElementById('deleteOfferingName').textContent = '"' + name + '"';
        document.getElementById('templeDeleteModal').classList.add('is-active');
    }

    function closeDeleteModal() {
        document.getElementById('templeDeleteModal').classList.remove('is-active');
    }

    document.getElementById('templeDeleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush
@endsection