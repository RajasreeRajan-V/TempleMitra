@extends('layouts.app')

@section('title', 'Edit Temple - ' . $temple->temple_name)

@php
    $breadcrumb = 'Edit Temple';
@endphp

@section('content')
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                <i class="fa-solid fa-gopuram"></i>
            </div>
            <div>
                <h1 class="page-title">Edit Temple</h1>
                <p class="page-subtitle">Update details for {{ $temple->temple_name }}</p>
            </div>
        </div>

        <div class="page-header-actions">
            <button class="btn btn-outline" onclick="window.location.href='{{ route('admin.temples-registration.show', $temple->id) }}'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Details
            </button>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="edit-container">
        <form method="POST" action="{{ route('admin.temples-registration.update', $temple->id) }}" 
              enctype="multipart/form-data" 
              id="editTempleForm">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-main">
                    <!-- Basic Information -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="2" width="6" height="4" rx="1"/>
                                    <path d="M9 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3"/>
                                </svg>
                                Basic Information
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-group">
                                <label for="temple_name">Temple Name <span class="required">*</span></label>
                                <input type="text" 
                                       id="temple_name" 
                                       name="temple_name" 
                                       class="form-input @error('temple_name') is-invalid @enderror" 
                                       value="{{ old('temple_name', $temple->temple_name) }}" 
                                       required>
                                @error('temple_name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="registration_number">Registration Number</label>
                                <input type="text" 
                                       id="registration_number" 
                                       name="registration_number" 
                                       class="form-input @error('registration_number') is-invalid @enderror" 
                                       value="{{ old('registration_number', $temple->registration_number) }}">
                                @error('registration_number')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Address <span class="required">*</span></label>
                                <textarea id="address" 
                                          name="address" 
                                          class="form-input @error('address') is-invalid @enderror" 
                                          rows="3" 
                                          required>{{ old('address', $temple->address) }}</textarea>
                                @error('address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="district">District <span class="required">*</span></label>
                                    <input type="text" 
                                           id="district" 
                                           name="district" 
                                           class="form-input @error('district') is-invalid @enderror" 
                                           value="{{ old('district', $temple->district) }}" 
                                           required>
                                    @error('district')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" 
                                           id="location" 
                                           name="location" 
                                           class="form-input @error('location') is-invalid @enderror" 
                                           value="{{ old('location', $temple->location) }}">
                                    @error('location')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                Contact Information
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" 
                                           id="contact_number" 
                                           name="contact_number" 
                                           class="form-input @error('contact_number') is-invalid @enderror" 
                                           value="{{ old('contact_number', $temple->contact_number) }}" 
                                           placeholder="e.g. 9876543210">
                                    @error('contact_number')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-input @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $temple->email) }}" 
                                           placeholder="temple@example.com">
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                                Description
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-group">
                                <label for="description">Temple Description</label>
                                <textarea id="description" 
                                          name="description" 
                                          class="form-input @error('description') is-invalid @enderror" 
                                          rows="4">{{ old('description', $temple->description) }}</textarea>
                                @error('description')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="form-sidebar">
                    <!-- Logo Upload -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                Temple Logo
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="logo-upload-container">
                                <div class="current-logo">
                                    @if ($temple->logo)
                                        <img src="{{ asset('storage/' . $temple->logo) }}" 
                                             alt="{{ $temple->temple_name }}" 
                                             class="current-logo-image">
                                    @else
                                        <div class="no-logo-placeholder">
                                            <i class="fa-solid fa-gopuram" style="font-size: 48px; color: var(--ink-300);"></i>
                                            <p>No logo uploaded</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="logo-upload">
                                    <label for="logo" class="upload-label">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        Choose New Logo
                                    </label>
                                    <input type="file" 
                                           id="logo" 
                                           name="logo" 
                                           class="logo-input" 
                                           accept="image/*">
                                    <small class="upload-hint">JPG, JPEG, PNG, WEBP (Max: 2MB)</small>
                                    @error('logo')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div id="logoPreview" class="logo-preview" style="display: none;">
                                    <img id="logoPreviewImage" src="#" alt="Logo preview">
                                    <button type="button" id="removeLogoPreview" class="remove-preview">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="18" y1="6" x2="6" y2="18"/>
                                            <line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Status
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-group">
                                <label for="status">Temple Status</label>
                                <select id="status" name="status" class="form-input">
                                    <option value="active" {{ old('status', $temple->status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ old('status', $temple->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6"/>
                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                            </svg>
                            Update Temple
                        </button>
                        <a href="{{ route('admin.temples-registration.show', $temple->id) }}" class="btn btn-outline">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .edit-container {
            margin-top: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
        }

        .form-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--line);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .form-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            background: var(--cream-50);
        }

        .form-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
            color: var(--ink-900);
            margin: 0;
        }

        .form-card-title svg {
            color: var(--maroon-600);
        }

        .form-card-body {
            padding: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-700);
        }

        .form-group label .required {
            color: #e74c3c;
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 14px;
            background: #fff;
            color: var(--ink-900);
            font-family: inherit;
            width: 100%;
            transition: all 0.15s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--maroon-600);
            box-shadow: 0 0 0 3px rgba(124, 31, 44, 0.1);
        }

        .form-input.is-invalid {
            border-color: #e74c3c !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15) !important;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
        }

        select.form-input {
            appearance: auto;
            cursor: pointer;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .error-message {
            font-size: 12px;
            color: #e74c3c;
            margin-top: 4px;
        }

        /* Logo Upload */
        .logo-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .current-logo {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .current-logo-image {
            width: 150px;
            height: 150px;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid var(--line);
        }

        .no-logo-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 16px;
            border: 2px dashed var(--line);
            background: var(--cream-50);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--ink-400);
            gap: 8px;
        }

        .no-logo-placeholder p {
            margin: 0;
            font-size: 13px;
        }

        .logo-upload {
            width: 100%;
            text-align: center;
        }

        .upload-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--cream-50);
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: var(--ink-700);
            transition: all 0.15s ease;
        }

        .upload-label:hover {
            background: var(--cream-100);
            border-color: var(--maroon-600);
            color: var(--maroon-600);
        }

        .logo-input {
            display: none;
        }

        .upload-hint {
            display: block;
            font-size: 12px;
            color: var(--ink-400);
            margin-top: 6px;
        }

        .logo-preview {
            position: relative;
            display: inline-block;
        }

        .logo-preview img {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--line);
        }

        .remove-preview {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: #e74c3c;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .remove-preview:hover {
            transform: scale(1.1);
            background: #c0392b;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            background: #fff;
            color: var(--ink-700);
            width: 100%;
        }

        .btn-lg {
            padding: 14px 24px;
            font-size: 16px;
        }

        .btn-primary {
            background: var(--maroon-700);
            color: #fff;
            border-color: var(--maroon-700);
        }

        .btn-primary:hover {
            background: var(--maroon-800);
            border-color: var(--maroon-800);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 31, 44, 0.2);
        }

        .btn-outline {
            border-color: var(--line);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--cream-50);
            border-color: var(--ink-400);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-card-body {
                padding: 16px;
            }

            .form-card-header {
                padding: 16px 20px;
            }

            .current-logo-image,
            .no-logo-placeholder {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            .form-grid {
                gap: 16px;
            }

            .form-card {
                margin-bottom: 16px;
            }

            .form-actions .btn {
                font-size: 14px;
                padding: 12px 16px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logo preview
            const logoInput = document.getElementById('logo');
            const logoPreview = document.getElementById('logoPreview');
            const logoPreviewImage = document.getElementById('logoPreviewImage');
            const removePreview = document.getElementById('removeLogoPreview');

            logoInput.addEventListener('change', function(e) {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreviewImage.src = e.target.result;
                        logoPreview.style.display = 'block';
                        // Hide current logo
                        document.querySelector('.current-logo').style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });

            removePreview.addEventListener('click', function() {
                logoInput.value = '';
                logoPreview.style.display = 'none';
                document.querySelector('.current-logo').style.display = 'flex';
            });
        });
    </script>
@endpush