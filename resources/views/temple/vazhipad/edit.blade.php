@extends('temple.layouts.app')

@section('title', 'Edit Vazhipad — ' . $vazhipad->name)

@section('content')
<div class="vazhipad-page-container" style="max-width: 860px;">

    {{-- Header --}}
    <div class="vazhipad-header">
        <div class="vazhipad-header-left">
            <div class="vazhipad-header-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
            <div class="vazhipad-header-titles">
                <span class="vazhipad-code-badge">#VP-{{ sprintf('%03d', $vazhipad->id) }}</span>
                <h1 class="vazhipad-page-title">Edit Vazhipad Offering</h1>
                <p class="vazhipad-page-subtitle">Update rate dakshina, details, and availability status</p>
            </div>
        </div>

        <div class="vazhipad-header-actions">
            <a href="{{ route('temple.vazhipad.show', $vazhipad->id) }}" class="btn-temple btn-temple-secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span>View Details</span>
            </a>

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
            <form action="{{ route('temple.vazhipad.update', $vazhipad->id) }}" method="POST" id="vazhipadEditForm">
                @csrf
                @method('PUT')

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
                               value="{{ old('name', $vazhipad->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g., Pushpanjali, Ganapathi Homam"
                               required>
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
                                   value="{{ old('price', $vazhipad->price) }}"
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
                        @php
                            $currentStatus = old('status', is_numeric($vazhipad->status) ? ($vazhipad->status == 1 ? 'active' : 'inactive') : $vazhipad->status);
                        @endphp
                        <label for="status" class="form-label" style="font-weight: 600; color: var(--ink-900); display: flex; align-items: center; gap: 6px;">
                            <span>Status</span>
                            <span style="color: var(--red-600); font-weight: 700;">*</span>
                        </label>
                        <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>
                            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active (Available for devotees)</option>
                            <option value="inactive" {{ $currentStatus === 'inactive' ? 'selected' : '' }}>Inactive (Temporarily unavailable)</option>
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
                                  placeholder="Describe the pooja procedure, benefits, timing, items required...">{{ old('description', $vazhipad->description) }}</textarea>
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
                        <span>Update Vazhipad</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection