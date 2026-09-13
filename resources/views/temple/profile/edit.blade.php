@extends('temple.layouts.app')

@section('title', 'Edit Temple Profile')

@section('content')
<div class="profile-page">

    <div class="page-header">
        <h1>Edit Temple Profile</h1>
        <p>Update your temple's registration details</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card profile-card">
        <form action="{{ route('temple.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                    <label class="form-label">Change Logo</label>
                    <input type="file" name="logo" accept="image/*" class="form-control">
                </div>
            </div>

            <div class="profile-grid">
                <div class="profile-field">
                    <label>Temple Name</label>
                    <input type="text" name="temple_name" class="form-control"
                           value="{{ old('temple_name', $temple->temple_name) }}" required>
                </div>

                <div class="profile-field">
                    <label>Registration Number</label>
                    <input type="text" name="registration_number" class="form-control"
                           value="{{ old('registration_number', $temple->registration_number) }}">
                </div>

                <div class="profile-field">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="form-control"
                           value="{{ old('contact_number', $temple->contact_number) }}">
                </div>

                <div class="profile-field">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $temple->email) }}">
                </div>

                <div class="profile-field">
                    <label>District</label>
                    <input type="text" name="district" class="form-control"
                           value="{{ old('district', $temple->district) }}">
                </div>

                <div class="profile-field">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control"
                           value="{{ old('location', $temple->location) }}">
                </div>

                <div class="profile-field profile-field-full">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $temple->address) }}</textarea>
                </div>

                <div class="profile-field profile-field-full">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $temple->description) }}</textarea>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('temple.profile') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection