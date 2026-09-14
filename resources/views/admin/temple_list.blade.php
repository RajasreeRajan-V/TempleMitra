@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-left">
        <h1 class="page-title">Temple Registrations</h1>
        <p class="page-subtitle">Manage all registered temples and their details</p>
    </div>
    <div class="page-header-actions">
        <button type="button" class="btn btn--primary" data-toggle="modal" data-target="#createTempleModal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Register New Temple
        </button>
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert--success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <path d="m9 11 3 3L22 4"/>
        </svg>
        {{ session('success') }}
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert--error">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 8v4M12 16h.01"/>
        </svg>
        {{ session('error') }}
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

{{-- Statistics Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon--primary">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-label">Total Temples</span>
            <span class="stat-value">{{ number_format($totalTemples) }}</span>
            <span class="stat-trend stat-trend--up">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m18 15-6-6-6 6"/>
                </svg>
                {{ $growthPercentage }}% growth
            </span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon--success">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <path d="m9 11 3 3L22 4"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-label">Active Temples</span>
            <span class="stat-value">{{ number_format($activeTemples) }}</span>
            <span class="stat-trend stat-trend--up">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m18 15-6-6-6 6"/>
                </svg>
                {{ $totalTemples > 0 ? round(($activeTemples / $totalTemples) * 100) : 0 }}% of total
            </span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon--warning">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 8v4M12 16h.01"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-label">Inactive Temples</span>
            <span class="stat-value">{{ number_format($inactiveTemples) }}</span>
            <span class="stat-trend stat-trend--down">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
                {{ $inactivePercentage }}% of total
            </span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon--info">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-label">Districts Covered</span>
            <span class="stat-value">{{ number_format($districtsCount) }}</span>
            <span class="stat-trend">
                Across the state
            </span>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.temples-registration.index') }}" class="filter-form">
            <div class="filter-row">
                <div class="filter-group filter-group--search">
                    <label class="filter-label">Search</label>
                    <div class="search-input">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by temple name, location, district, or registration number...">
                    </div>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">District</label>
                    <select name="district" class="filter-select">
                        <option value="">All Districts</option>
                        @foreach($districts as $district)
                            <option value="{{ $district }}" {{ request('district') === $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn--primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'district']))
                        <a href="{{ route('admin.temples-registration.index') }}" class="btn btn--outline">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Temples Table --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            All Temples
            <span class="badge">{{ $temples->total() }}</span>
        </h2>
    </div>

    <div class="card-body card-body--no-padding">
        @if($temples->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Temple</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Reg. Number</th>
                            <th>Status</th>
                            <th>Registered</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($temples as $index => $temple)
                            <tr>
                                <td>{{ $temples->firstItem() + $index }}</td>
                                <td>
                                    <div class="temple-info">
                                        @if($temple->logo)
                                            <img src="{{ Storage::url($temple->logo) }}" 
                                                 alt="{{ $temple->temple_name }}" 
                                                 class="temple-logo">
                                        @else
                                            <div class="temple-logo temple-logo--placeholder">
                                                {{ Str::substr($temple->temple_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="temple-details">
                                            <span class="temple-name">{{ $temple->temple_name }}</span>
                                            @if($temple->email)
                                                <span class="temple-email">{{ $temple->email }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="location-info">
                                        <span class="location-district">{{ $temple->district }}</span>
                                        @if($temple->location)
                                            <span class="location-place">{{ $temple->location }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($temple->contact_number)
                                        <a href="tel:{{ $temple->contact_number }}" class="contact-link">
                                            {{ $temple->contact_number }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($temple->registration_number)
                                        <span class="reg-number">{{ $temple->registration_number }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-badge--{{ $temple->status }}">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($temple->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="date-text">{{ $temple->created_at->format('d M, Y') }}</span>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $temples->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M8 3c0 2.5-1.5 4-1.5 6.5A2.5 2.5 0 0 0 9 12M16 3c0 2.5 1.5 4 1.5 6.5a2.5 2.5 0 0 1-2.5 2.5M12 2c0 3-2 4.5-2 8a2 2 0 0 0 4 0c0-3.5-2-5-2-8Z"/>
                        <path d="M6 21v-3a6 6 0 0 1 12 0v3"/>
                    </svg>
                </div>
                <h3 class="empty-state-title">No temples found</h3>
                <p class="empty-state-text">
                    @if(request()->hasAny(['search', 'status', 'district']))
                        No temples match your current filters. Try adjusting your search criteria.
                    @else
                        Get started by registering your first temple.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'district']))
                    <a href="{{ route('admin.temples-registration.index') }}" class="btn btn--outline">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- Create Temple Modal --}}
<div class="modal" id="createTempleModal">
    <div class="modal-overlay" data-dismiss="modal"></div>
    <div class="modal-content modal-content--lg">
        <div class="modal-header">
            <h2 class="modal-title">Register New Temple</h2>
            <button type="button" class="modal-close" data-dismiss="modal">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" 
              action="{{ route('admin.temples-registration.store') }}" 
              enctype="multipart/form-data"
              class="modal-form">
            @csrf

            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label class="form-label form-label--required">Temple Name</label>
                        <input type="text" 
                               name="temple_name" 
                               value="{{ old('temple_name') }}" 
                               class="form-input @error('temple_name') form-input--error @enderror"
                               placeholder="Enter temple name"
                               required>
                        @error('temple_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label class="form-label form-label--required">Address</label>
                        <textarea name="address" 
                                  class="form-textarea @error('address') form-input--error @enderror"
                                  placeholder="Enter full address"
                                  rows="3"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label form-label--required">District</label>
                        <input type="text" 
                               name="district" 
                               value="{{ old('district') }}" 
                               class="form-input @error('district') form-input--error @enderror"
                               placeholder="Enter district"
                               required>
                        @error('district')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location') }}" 
                               class="form-input @error('location') form-input--error @enderror"
                               placeholder="Enter location">
                        @error('location')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" 
                               name="contact_number" 
                               value="{{ old('contact_number') }}" 
                               class="form-input @error('contact_number') form-input--error @enderror"
                               placeholder="Enter contact number">
                        @error('contact_number')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="form-input @error('email') form-input--error @enderror"
                               placeholder="Enter email address">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Registration Number</label>
                        <input type="text" 
                               name="registration_number" 
                               value="{{ old('registration_number') }}" 
                               class="form-input @error('registration_number') form-input--error @enderror"
                               placeholder="Enter registration number">
                        @error('registration_number')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') form-input--error @enderror">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-textarea @error('description') form-input--error @enderror"
                                  placeholder="Enter temple description"
                                  rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label class="form-label">Temple Logo</label>
                        <div class="file-upload" id="logoUpload">
                            <input type="file" 
                                   name="logo" 
                                   id="logoInput"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="file-input">
                            <div class="file-upload-content">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <path d="m17 8-5-5-5 5M12 3v12"/>
                                </svg>
                                <span class="file-upload-text">Click to upload or drag and drop</span>
                                <span class="file-upload-hint">JPG, PNG, WEBP (Max 2MB)</span>
                            </div>
                            <div class="file-preview" id="logoPreview" style="display: none;">
                                <img src="" alt="Preview" id="logoPreviewImg">
                                <button type="button" class="file-remove" id="removeLogo">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 6 6 18M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('logo')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4M12 8h.01"/>
                    </svg>
                    A random password will be generated and sent to the temple's email address.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn--outline" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Register Temple
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Page Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 4px 0 0;
    }

    /* Alerts */
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert--success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert--error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        opacity: 0.6;
        color: inherit;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon--primary {
        background: #eef2ff;
        color: #4f46e5;
    }

    .stat-icon--success {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-icon--warning {
        background: #fffbeb;
        color: #d97706;
    }

    .stat-icon--info {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-content {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.2;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
    }

    .stat-trend--up {
        color: #059669;
    }

    .stat-trend--down {
        color: #dc2626;
    }

    /* Cards */
    .card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 10px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
    }

    .card-body {
        padding: 24px;
    }

    .card-body--no-padding {
        padding: 0;
    }

    /* Filter Form */
    .filter-form {
        width: 100%;
    }

    .filter-row {
        display: flex;
        gap: 16px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 160px;
    }

    .filter-group--search {
        flex: 1;
        min-width: 280px;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-input {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input svg {
        position: absolute;
        left: 12px;
        color: #9ca3af;
        pointer-events: none;
    }

    .search-input input {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        color: #1a1a2e;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .filter-select {
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        color: #1a1a2e;
        background: #fff;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
    }

    .filter-select:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn--primary {
        background: #4A1420;
        color: #fff;
    }

    .btn--primary:hover {
        background: #3a0f19;
        box-shadow:  0 4px 12px rgba(74, 20, 32, 0.3);
    }

    .btn--outline {
        background: #fff;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .btn--outline:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    /* Data Table */
    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .data-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Temple Info */
    .temple-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .temple-logo {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .temple-logo--placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        font-size: 18px;
        font-weight: 700;
    }

    .temple-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .temple-name {
        font-weight: 600;
        color: #1a1a2e;
    }

    .temple-email {
        font-size: 12px;
        color: #6b7280;
    }

    /* Location Info */
    .location-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .location-district {
        font-weight: 500;
        color: #1a1a2e;
    }

    .location-place {
        font-size: 12px;
        color: #6b7280;
    }

    /* Contact */
    .contact-link {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 500;
    }

    .contact-link:hover {
        text-decoration: underline;
    }

    .text-muted {
        color: #9ca3af;
    }

    /* Registration Number */
    .reg-number {
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', monospace;
        font-size: 13px;
        padding: 3px 8px;
        background: #f3f4f6;
        border-radius: 4px;
        color: #374151;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-badge--active {
        background: #ecfdf5;
        color: #059669;
    }

    .status-badge--inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Date */
    .date-text {
        color: #6b7280;
        font-size: 13px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .inline-form {
        display: inline;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        background: transparent;
        color: #6b7280;
    }

    .action-btn:hover {
        background: #f3f4f6;
    }

    .action-btn--view:hover {
        background: #eef2ff;
        color: #4f46e5;
    }

    .action-btn--edit:hover {
        background: #fffbeb;
        color: #d97706;
    }

    .action-btn--warning:hover {
        background: #fef3c7;
        color: #d97706;
    }

    .action-btn--success:hover {
        background: #ecfdf5;
        color: #059669;
    }

    .action-btn--danger:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 24px;
        text-align: center;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        margin-bottom: 20px;
    }

    .empty-state-title {
        font-size: 18px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0 0 8px;
    }

    .empty-state-text {
        font-size: 14px;
        color: #6b7280;
        margin: 0 0 20px;
        max-width: 400px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal.active {
        display: flex;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(2px);
    }

    .modal-content {
        position: relative;
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        animation: modalIn 0.2s ease;
    }

    .modal-content--lg {
        max-width: 720px;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .modal-close {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: background 0.2s;
    }

    .modal-close:hover {
        background: #f3f4f6;
    }

    .modal-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }

    .modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0 0 16px 16px;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group--full {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .form-label--required::after {
        content: '*';
        color: #dc2626;
        margin-left: 3px;
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        color: #1a1a2e;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-input--error {
        border-color: #dc2626;
    }

    .form-input--error:focus {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 80px;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
        cursor: pointer;
    }

    .form-error {
        font-size: 12px;
        color: #dc2626;
    }

    /* File Upload */
    .file-upload {
        position: relative;
        border: 2px dashed #e5e7eb;
        border-radius: 10px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .file-upload:hover {
        border-color: #4f46e5;
        background: #f9fafb;
    }

    .file-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        color: #6b7280;
    }

    .file-upload-text {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .file-upload-hint {
        font-size: 12px;
        color: #9ca3af;
    }

    .file-preview {
        position: relative;
        display: inline-block;
    }

    .file-preview img {
        max-width: 120px;
        max-height: 120px;
        border-radius: 8px;
        object-fit: cover;
    }

    .file-remove {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #dc2626;
        color: #fff;
        border: 2px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Form Note */
    .form-note {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 16px;
        background: #eff6ff;
        border-radius: 8px;
        font-size: 13px;
        color: #1e40af;
        margin-top: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-row {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .filter-group--search {
            min-width: auto;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .data-table {
            font-size: 13px;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 10px 12px;
        }

        .action-buttons {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal functionality
        var modals = document.querySelectorAll('.modal');
        var openButtons = document.querySelectorAll('[data-target]');
        var closeButtons = document.querySelectorAll('[data-dismiss="modal"]');

        openButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = document.querySelector(this.dataset.target);
                if (target) {
                    target.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        closeButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var modal = this.closest('.modal');
                if (modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        modals.forEach(function (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Escape key to close modal
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                modals.forEach(function (modal) {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });

        // File upload preview
        var logoInput = document.getElementById('logoInput');
        var logoPreview = document.getElementById('logoPreview');
        var logoPreviewImg = document.getElementById('logoPreviewImg');
        var removeLogo = document.getElementById('removeLogo');
        var fileUploadContent = document.querySelector('.file-upload-content');

        if (logoInput) {
            logoInput.addEventListener('change', function () {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        logoPreviewImg.src = e.target.result;
                        logoPreview.style.display = 'block';
                        fileUploadContent.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removeLogo) {
            removeLogo.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                logoInput.value = '';
                logoPreview.style.display = 'none';
                fileUploadContent.style.display = 'flex';
            });
        }
    });
</script>
@endpush