@extends('temple.layouts.app')

@section('title', 'Add New Vazhipad')

@section('content')
<div class="vazhipad-page-container" style="max-width: 860px;">

    {{-- Breadcrumb / Header Bar --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <h1 class="vazhipad-page-title">Add New Vazhipad</h1>
                <p class="vazhipad-page-subtitle">Register a new pooja or offering in the temple catalogue</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.vazhipad.index') }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Offerings</span>
            </a>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="vazhipad-card" style="box-shadow: var(--shadow-md);">
        <div class="vazhipad-card-accent"></div>

        <div style="padding: 28px 32px;">
            <form action="{{ route('temple.vazhipad.store') }}" method="POST" id="vazhipadForm">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 22px;">
                    {{-- Offering Name --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="name" class="form-label" style="font-weight: 600; color: var(--ink-900); display: flex; align-items: center; gap: 6px;">
                            <span>Offering Name</span>
                            <span style="color: var(--red-600); font-weight: 700;">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g., Pushpanjali, Neyyappam Nivedyam, Ganapathi Homam"
                               required
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Rate / Dakshina (Price) --}}
                    <div>
                        <label for="price" class="form-label" style="font-weight: 600; color: var(--ink-900); display: flex; align-items: center; gap: 6px;">
                            <span>Dakshina / Rate (₹)</span>
                            <span style="color: var(--red-600); font-weight: 700;">*</span>
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--gold-600); font-size: 15px;">₹</span>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="price"
                                   id="price"
                                   value="{{ old('price') }}"
                                   class="form-control @error('price') is-invalid @enderror"
                                   placeholder="0.00"
                                   style="padding-left: 32px;"
                                   required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Offering Status --}}
                    <div>
                        <label for="status" class="form-label" style="font-weight: 600; color: var(--ink-900); display: flex; align-items: center; gap: 6px;">
                            <span>Status</span>
                            <span style="color: var(--red-600); font-weight: 700;">*</span>
                        </label>
                        <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (Available for devotees)</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (Temporarily unavailable)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="description" class="form-label" style="font-weight: 600; color: var(--ink-900);">
                            <span>Offering Description & Ritual Details</span>
                            <span style="font-size: 12px; color: var(--ink-400); font-weight: 400; margin-left: 6px;">(Optional)</span>
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Describe the pooja procedure, benefits, timing, items required, or any devotee instructions...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Form Actions Footer --}}
                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid var(--line);">
                    <a href="{{ route('temple.vazhipad.index') }}" class="btn-temple btn-temple-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn-temple btn-temple-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Save Vazhipad</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection