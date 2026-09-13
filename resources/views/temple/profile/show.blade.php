@extends('temple.layouts.app')

@section('title', 'Temple Profile')

@section('content')
<div class="profile-page">

    {{-- Page Header --}}
    <div class="page-header">
        <h1>Temple Profile</h1>
        <p>View and manage your temple's registration details</p>
    </div>

    {{-- Temple Images Card (moved to top) --}}
    <div class="card profile-card">
        <div class="card-header card-header-flex">
            <div>
                <h2>Temple Images</h2>
                <p>Upload up to 3 images of your temple. Recommended size: 800×600px.</p>
            </div>
            <button type="button" class="btn btn-primary btn-sm" id="toggleUploadBtn">
                <i class="fas fa-upload"></i> Upload Images
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Image Upload Form (hidden by default) --}}
        <div class="upload-section" id="uploadSection" style="display: none;">
            <form action="{{ route('temple.images.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="image-upload-grid">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="image-upload-item">
                            <label>Image {{ $i }}</label>

                            <div class="image-preview-wrapper">
                                @if($templeImages && $templeImages->{'image' . $i})
                                    <img src="{{ asset('storage/' . $templeImages->{'image' . $i}) }}"
                                         alt="Temple Image {{ $i }}">
                                @else
                                    <div class="image-placeholder">
                                        <i class="fas fa-image"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>

                            <div class="file-input-wrapper">
                                <input type="file" name="image{{ $i }}" id="image{{ $i }}" accept="image/*">
                                <label for="image{{ $i }}" class="file-input-label">
                                    <i class="fas fa-upload"></i> Choose File
                                </label>
                                <span class="file-name" id="file-name-{{ $i }}">No file chosen</span>
                            </div>

                            @error('image' . $i)
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endfor
                </div>

                <div class="profile-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Images
                    </button>
                    <button type="button" class="btn btn-secondary" id="cancelUploadBtn">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Profile Details Card --}}
    <div class="card profile-card">
        <div class="profile-header">
            <div class="profile-logo">
                @if($temple->logo)
                    <img src="{{ asset('storage/' . $temple->logo) }}" alt="{{ $temple->temple_name }}">
                @else
                    <div class="profile-logo-placeholder">
                        {{ \Illuminate\Support\Str::substr($temple->temple_name ?? 'T', 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="profile-title">
                <h2>{{ $temple->temple_name }}</h2>
                <span class="status-badge status-{{ $temple->status }}">
                    {{ ucfirst($temple->status) }}
                </span>
            </div>
        </div>

        <div class="profile-grid">
            <div class="profile-field">
                <label>Registration Number</label>
                <p>{{ $temple->registration_number ?? '—' }}</p>
            </div>

            <div class="profile-field">
                <label>Contact Number</label>
                <p>{{ $temple->contact_number ?? '—' }}</p>
            </div>

            <div class="profile-field">
                <label>Email</label>
                <p>{{ $temple->email ?? '—' }}</p>
            </div>

            <div class="profile-field">
                <label>District</label>
                <p>{{ $temple->district ?? '—' }}</p>
            </div>

            <div class="profile-field">
                <label>Location</label>
                <p>{{ $temple->location ?? '—' }}</p>
            </div>

            <div class="profile-field profile-field-full">
                <label>Address</label>
                <p>{{ $temple->address ?? '—' }}</p>
            </div>

            <div class="profile-field profile-field-full">
                <label>Description</label>
                <p>{{ $temple->description ?? '—' }}</p>
            </div>
        </div>

        <div class="profile-actions">
            <a href="{{ route('temple.profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
            <a href="{{ route('temple.password.edit') }}" class="btn btn-secondary">
                <i class="fas fa-key"></i> Change Password
            </a>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    /* ===== Profile Page ===== */
    .profile-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.25rem;
    }

    .page-header p {
        color: #718096;
        font-size: 0.95rem;
    }

    /* ===== Card ===== */
    .profile-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.06);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }

    .profile-card .card-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #edf2f7;
    }

    .profile-card .card-header h2 {
        font-size: 1.35rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 0.25rem;
    }

    .profile-card .card-header p {
        color: #718096;
        font-size: 0.9rem;
    }

    /* Header with button on the right */
    .card-header-flex {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    /* ===== Profile Header ===== */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #edf2f7;
    }

    .profile-logo {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        background: #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-logo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #a0aec0;
        background: #edf2f7;
        border-radius: 50%;
    }

    .profile-title h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.5rem;
    }

    /* ===== Status Badge ===== */
    .status-badge {
        display: inline-block;
        padding: 0.3rem 0.85rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .status-active,
    .status-approved {
        background: #c6f6d5;
        color: #22543d;
    }

    .status-pending {
        background: #fefcbf;
        color: #744210;
    }

    .status-inactive,
    .status-rejected {
        background: #fed7d7;
        color: #822727;
    }

    /* ===== Profile Grid ===== */
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem 2rem;
    }

    .profile-field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.35rem;
    }

    .profile-field p {
        font-size: 1rem;
        color: #2d3748;
        margin: 0;
        line-height: 1.5;
        word-break: break-word;
    }

    .profile-field-full {
        grid-column: 1 / -1;
    }

    /* ===== Actions ===== */
    .profile-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1.75rem;
        padding-top: 1.5rem;
        border-top: 1px solid #edf2f7;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.4rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #4f46e5;
        color: #fff;
    }

    .btn-primary:hover {
        background: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
    }

    .btn-secondary {
        background: #edf2f7;
        color: #4a5568;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    /* ===== Upload Section ===== */
    .upload-section {
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Image Upload Grid ===== */
    .image-upload-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .image-upload-item label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.6rem;
    }

    .image-preview-wrapper {
        width: 100%;
        height: 160px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px dashed #e2e8f0;
        background: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        transition: border-color 0.2s ease;
    }

    .image-preview-wrapper:hover {
        border-color: #a0aec0;
    }

    .image-preview-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #a0aec0;
        font-size: 0.85rem;
    }

    .image-placeholder i {
        font-size: 1.75rem;
    }

    /* ===== Custom File Input ===== */
    .file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .file-input-label {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.9rem;
        background: #edf2f7;
        color: #4a5568;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .file-input-label:hover {
        background: #e2e8f0;
    }

    .file-name {
        font-size: 0.78rem;
        color: #a0aec0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    /* ===== Alert ===== */
    .alert {
        padding: 0.85rem 1.1rem;
        border-radius: 8px;
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-success {
        background: #f0fff4;
        color: #22543d;
        border: 1px solid #c6f6d5;
    }

    .text-danger {
        color: #e53e3e;
        font-size: 0.82rem;
        margin-top: 0.35rem;
        display: block;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .profile-page {
            padding: 1rem;
        }

        .profile-card {
            padding: 1.25rem;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .image-upload-grid {
            grid-template-columns: 1fr;
        }

        .profile-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
            width: 100%;
        }

        .card-header-flex {
            flex-direction: column;
        }

        .card-header-flex .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle upload section
        const toggleBtn = document.getElementById('toggleUploadBtn');
        const cancelBtn = document.getElementById('cancelUploadBtn');
        const uploadSection = document.getElementById('uploadSection');

        if (toggleBtn && uploadSection) {
            toggleBtn.addEventListener('click', function () {
                const isHidden = uploadSection.style.display === 'none';
                uploadSection.style.display = isHidden ? 'block' : 'none';

                // Change button text/icon
                if (isHidden) {
                    toggleBtn.innerHTML = '<i class="fas fa-times"></i> Close Upload';
                } else {
                    toggleBtn.innerHTML = '<i class="fas fa-upload"></i> Upload Images';
                }
            });
        }

        if (cancelBtn && uploadSection) {
            cancelBtn.addEventListener('click', function () {
                uploadSection.style.display = 'none';
                if (toggleBtn) {
                    toggleBtn.innerHTML = '<i class="fas fa-upload"></i> Upload Images';
                }
            });
        }

        // Update file name display when a file is selected
        for (let i = 1; i <= 3; i++) {
            const input = document.getElementById('image' + i);
            const nameSpan = document.getElementById('file-name-' + i);

            if (input && nameSpan) {
                input.addEventListener('change', function () {
                    if (this.files && this.files.length > 0) {
                        nameSpan.textContent = this.files[0].name;
                        nameSpan.style.color = '#4a5568';
                    } else {
                        nameSpan.textContent = 'No file chosen';
                        nameSpan.style.color = '#a0aec0';
                    }
                });
            }
        }
    });
</script>
@endpush