@extends('temple.layouts.app')

@section('title', 'Vazhipad Offerings')

@section('content')
<div class="vazhipad-page-container">

    {{-- Success / Error Flash Notifications --}}
    @if(session('success'))
        <div class="temple-alert temple-alert--success" id="flashSuccessAlert">
            <div class="temple-alert-content">
                <div class="temple-alert-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('flashSuccessAlert').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="temple-alert temple-alert--danger" id="flashErrorAlert">
            <div class="temple-alert-content">
                <div class="temple-alert-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="temple-alert-close" onclick="document.getElementById('flashErrorAlert').remove()" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                    <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <h1 class="vazhipad-page-title">Vazhipad Offerings</h1>
                <p class="vazhipad-page-subtitle">Manage temple pooja offerings, rates, and service availability</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.vazhipad.create') }}" class="btn-temple btn-temple-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Add Vazhipad</span>
            </a>
        </div>
    </div>

    @php
        $totalCount = $vazhipads->count();
        $activeCount = $vazhipads->filter(fn($item) => in_array($item->status, ['active', 1, '1', true], true))->count();
        $inactiveCount = $totalCount - $activeCount;
        $avgPrice = $totalCount > 0 ? $vazhipads->avg('price') : 0;
    @endphp

    {{-- Stats Summary Row --}}
    <div class="vazhipad-stats-grid">
        <div class="vazhipad-stat-box">
            <div class="vazhipad-stat-icon vazhipad-stat-icon--maroon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                </svg>
            </div>
            <div class="vazhipad-stat-info">
                <span class="vazhipad-stat-number">{{ $totalCount }}</span>
                <span class="vazhipad-stat-label">Total Offerings</span>
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
                <span class="vazhipad-stat-number">{{ $activeCount }}</span>
                <span class="vazhipad-stat-label">Active Offerings</span>
            </div>
        </div>

        <div class="vazhipad-stat-box">
            <div class="vazhipad-stat-icon vazhipad-stat-icon--orange">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="10" y1="15" x2="10" y2="9"></line>
                    <line x1="14" y1="15" x2="14" y2="9"></line>
                </svg>
            </div>
            <div class="vazhipad-stat-info">
                <span class="vazhipad-stat-number">{{ $inactiveCount }}</span>
                <span class="vazhipad-stat-label">Inactive</span>
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
                <span class="vazhipad-stat-number">₹{{ number_format($avgPrice, 2) }}</span>
                <span class="vazhipad-stat-label">Average Rate</span>
            </div>
        </div>
    </div>

    {{-- Search & Filter Toolbar --}}
    <div class="vazhipad-toolbar">
        <div class="vazhipad-search-wrap">
            <span class="vazhipad-search-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="text"
                   id="vazhipadSearch"
                   class="vazhipad-search-input"
                   placeholder="Search offering by name, code or keyword..."
                   autocomplete="off">
        </div>

        <div class="vazhipad-filter-pills">
            <button type="button" class="filter-pill active" data-filter="all">
                <span>All Offerings</span>
                <span class="filter-count">{{ $totalCount }}</span>
            </button>
            <button type="button" class="filter-pill" data-filter="active">
                <span>Active</span>
                <span class="filter-count">{{ $activeCount }}</span>
            </button>
            <button type="button" class="filter-pill" data-filter="inactive">
                <span>Inactive</span>
                <span class="filter-count">{{ $inactiveCount }}</span>
            </button>
        </div>
    </div>

    {{-- Box-Type Cards Grid --}}
    <div class="vazhipad-grid" id="vazhipadGrid">
        @forelse($vazhipads as $vazhipad)
            @php
                $isActive = in_array($vazhipad->status, ['active', 1, '1', true], true);
                $statusSlug = $isActive ? 'active' : 'inactive';
            @endphp

            <div class="vazhipad-card {{ $isActive ? '' : 'vazhipad-card--inactive' }}"
                 data-status="{{ $statusSlug }}"
                 data-name="{{ strtolower($vazhipad->name) }}"
                 data-desc="{{ strtolower($vazhipad->description ?? '') }}"
                 data-code="vp-{{ sprintf('%03d', $vazhipad->id) }}">

                {{-- Ornate Card Top Accent --}}
                <div class="vazhipad-card-accent"></div>

                {{-- Card Header --}}
                <div class="vazhipad-card-header">
                    <div class="vazhipad-card-identity">
                        <div class="vazhipad-avatar-badge" title="Temple Offering">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2c1.5 2.5 3 4.5 3 7a3 3 0 0 1-6 0c0-2.5 1.5-4.5 3-7Z"/>
                                <path d="M5 14h14l-1.5 5.5a2 2 0 0 1-1.9 1.5H8.4a2 2 0 0 1-1.9-1.5L5 14Z"/>
                                <path d="M10 21v1h4v-1"/>
                            </svg>
                        </div>
                        <div class="vazhipad-title-group">
                            <span class="vazhipad-code-badge">#VP-{{ sprintf('%03d', $vazhipad->id) }}</span>
                            <h3 class="vazhipad-title" title="{{ $vazhipad->name }}">
                                <a href="{{ route('temple.vazhipad.show', $vazhipad->id) }}">
                                    {{ $vazhipad->name }}
                                </a>
                            </h3>
                        </div>
                    </div>

                    <span class="temple-badge {{ $isActive ? 'temple-badge--active' : 'temple-badge--inactive' }}">
                        <span class="temple-badge-dot"></span>
                        {{ $isActive ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                {{-- Card Body --}}
                <div class="vazhipad-card-body">
                    {{-- Description --}}
                    @if(!empty($vazhipad->description))
                        <div class="vazhipad-description-box" title="{{ $vazhipad->description }}">
                            {{ $vazhipad->description }}
                        </div>
                    @else
                        <div class="vazhipad-description-box empty">
                            No special description specified for this offering.
                        </div>
                    @endif

                    {{-- Price Display Box --}}
                    <div class="vazhipad-price-banner">
                        <span class="vazhipad-price-label">Offering Dakshina</span>
                        <span class="vazhipad-price-amount">
                            <span class="vazhipad-price-symbol">₹</span>{{ number_format($vazhipad->price, 2) }}
                        </span>
                    </div>

                    {{-- Metadata Row --}}
                    <div class="vazhipad-card-meta">
                        <span class="vazhipad-meta-item">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>{{ $vazhipad->created_at ? $vazhipad->created_at->format('d M Y') : 'Regular Offering' }}</span>
                        </span>
                        <span class="vazhipad-meta-item">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Daily Pooja</span>
                        </span>
                    </div>
                </div>

                {{-- Card Footer / Action Buttons --}}
                <div class="vazhipad-card-footer">
                    <div class="vazhipad-action-group">
                        <a href="{{ route('temple.vazhipad.show', $vazhipad->id) }}"
                           class="btn-card-action"
                           title="View full offering details">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <span>View</span>
                        </a>

                        <a href="{{ route('temple.vazhipad.edit', $vazhipad->id) }}"
                           class="btn-card-action btn-card-action--edit"
                           title="Edit offering details">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span>Edit</span>
                        </a>

                        <button type="button"
                                class="btn-card-action btn-card-action--delete"
                                onclick="openDeleteModal('{{ $vazhipad->id }}', '{{ addslashes($vazhipad->name) }}')"
                                title="Delete offering">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="vazhipad-empty-box">
                <div class="vazhipad-empty-icon">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                        <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
                    </svg>
                </div>
                <h3 class="vazhipad-empty-title">No Vazhipad Offerings Found</h3>
                <p class="vazhipad-empty-desc">You have not registered any pooja or vazhipad offerings yet. Get started by creating your first offering.</p>
                <a href="{{ route('temple.vazhipad.create') }}" class="btn-temple btn-temple-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Create First Vazhipad</span>
                </a>
            </div>
        @endforelse
    </div>

    {{-- Filter No Results Notice (hidden by default) --}}
    <div id="noFilterResults" class="vazhipad-empty-box" style="display: none; margin-top: 20px;">
        <div class="vazhipad-empty-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>
        <h3 class="vazhipad-empty-title">No Matching Offerings</h3>
        <p class="vazhipad-empty-desc">No Vazhipad matches your current search criteria. Try a different query or reset filters.</p>
        <button type="button" class="btn-temple btn-temple-secondary" onclick="resetFilters()">
            <span>Reset Search & Filters</span>
        </button>
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
            Are you sure you want to permanently delete <strong id="deleteOfferingName" class="temple-modal-item-name">this offering</strong>? This action cannot be undone and will remove it from the offering catalogue.
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
    // Delete Modal Control
    function openDeleteModal(id, name) {
        const form = document.getElementById('templeDeleteForm');
        form.action = "{{ url('temple/vazhipad') }}/" + id;
        document.getElementById('deleteOfferingName').textContent = '"' + name + '"';
        document.getElementById('templeDeleteModal').classList.add('is-active');
    }

    function closeDeleteModal() {
        document.getElementById('templeDeleteModal').classList.remove('is-active');
    }

    // Close modal when clicking backdrop
    document.getElementById('templeDeleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Live Search and Filter Logic
    const searchInput = document.getElementById('vazhipadSearch');
    const filterPills = document.querySelectorAll('.filter-pill');
    const cards = document.querySelectorAll('.vazhipad-card');
    const noResults = document.getElementById('noFilterResults');

    let currentFilter = 'all';

    function filterCards() {
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const desc = card.getAttribute('data-desc') || '';
            const code = card.getAttribute('data-code') || '';
            const status = card.getAttribute('data-status') || '';

            const matchesQuery = !query || name.includes(query) || desc.includes(query) || code.includes(query);
            const matchesFilter = currentFilter === 'all' || status === currentFilter;

            if (matchesQuery && matchesFilter) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResults) {
            if (visibleCount === 0 && cards.length > 0) {
                noResults.style.display = 'flex';
            } else {
                noResults.style.display = 'none';
            }
        }
    }

    searchInput?.addEventListener('input', filterCards);

    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter') || 'all';
            filterCards();
        });
    });

    function resetFilters() {
        if (searchInput) searchInput.value = '';
        currentFilter = 'all';
        filterPills.forEach(p => {
            if (p.getAttribute('data-filter') === 'all') {
                p.classList.add('active');
            } else {
                p.classList.remove('active');
            }
        });
        filterCards();
    }
</script>
@endpush
@endsection
