@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 text-center fw-bold">My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        {{-- Left Sidebar --}}
        <div class="col-lg-4 text-center">
            <div class="bg-light rounded-4 p-4 shadow-sm">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-8x text-primary"></i>
                </div>
                <h4 class="fw-bold">{{ $info?->first_name }} {{ $info?->middle_name }} {{ $info?->last_name }}</h4>
                <p class="text-muted">{{ $info?->school_id }}</p>
                <p class="text-muted">{{ ucfirst($info?->gender) }}</p>
                <p class="text-muted">Birthdate: {{ $info?->birthdate }}</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('clinic_staff.profile.edit') }}" class="btn btn-primary w-100">Edit Profile</a>
            </div>
        </div>

        {{-- Right Content --}}
        <div class="col-lg-8">
            {{-- Contact Info --}}
            <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                <h5 class="fw-bold text-info mb-3"><i class="fas fa-address-book me-2"></i>Contact Information</h5>
                <hr>
                <p><strong>Address:</strong> {{ $info?->address }}</p>
                <p><strong>Phone:</strong> {{ $info?->contact_no }}</p>
                <p><strong>Emergency Contact:</strong> {{ $info?->emergency_contact_name }} ({{ $info?->emergency_contact_relationship }}) - {{ $info?->emergency_contact_no }}</p>
            </div>

            {{-- Professional Credentials --}}
            <div class="bg-white rounded-4 p-4 shadow-sm">
                <h5 class="fw-bold text-success mb-3"><i class="fas fa-certificate me-2"></i>Professional Credentials</h5>
                <hr>
                <p><strong>Credential Type:</strong> {{ optional($credential)->credential_type }}</p>
                @if(optional($credential)->credential_type === 'license')
                    <p><strong>License:</strong> {{ $credential->license_type }}</p>
                @elseif(optional($credential)->credential_type === 'degree')
                    <p><strong>Degree:</strong> {{ $credential->degree }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
