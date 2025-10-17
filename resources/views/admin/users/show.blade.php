@extends('layouts.app')

@section('page-title', 'User Details')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2 class="h4 text-gray-800">User Details</h2>

    @php
        // Determine back button route dynamically
        $backRoute = 'admin.dashboard';
        $backParams = [];

        if (request()->routeIs('admin.patients.*')) {
            $backRoute = 'admin.patients.index';
        } elseif (request()->routeIs('admin.users.*')) {
            $backRoute = 'admin.users.index';
        }
    @endphp

    <a href="{{ route($backRoute, $backParams) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">

        {{-- PATIENT DETAILS --}}
        @if($user->role === 'patient')
            @php
                $info = $user->personalInformation;
                $course = $info?->courseInformation;
                $emergency = $info?->emergencyContacts?->first();
            @endphp

            <h5 class="mb-3 text-primary fw-bold">Personal Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>First Name:</strong><br> {{ $user->first_name }}
                </div>
                <div class="col-md-4">
                    <strong>Middle Name:</strong><br> {{ $user->middle_name ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Last Name:</strong><br> {{ $user->last_name }}
                </div>
                @if($user->email)
                    <div class="col-md-6">
                        <strong>Email:</strong><br> {{ $user->email }}
                    </div>
                @endif
                <div class="col-md-6">
                    <strong>School ID:</strong><br> {{ $info->school_id ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Gender:</strong><br> {{ $info->gender ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Birthdate:</strong><br> {{ $info->birthdate ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Contact Number:</strong><br> {{ $info->contact_number ?? '-' }}
                </div>
                <div class="col-md-12">
                    <strong>Address:</strong><br> {{ $info->address ?? '-' }}
                </div>
            </div>

            @if($course)
                <hr>
                <h5 class="mb-3 text-primary fw-bold">Course Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <strong>Course:</strong><br> {{ $course->course ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Year / Grade Level:</strong><br> 
                        @if($course->education_level === 'College')
                            {{ strtoupper($course->course) }}-{{ $course->year_level }}
                        @elseif(in_array($course->education_level, ['High School', 'Senior High School', 'Grade School']))
                            {{ $course->education_level }} - Grade {{ $course->grade_level }}
                        @else
                            {{ $course->grade_level ?? '-' }}
                        @endif
                    </div>
                </div>
            @endif

            @if($emergency)
                <hr>
                <h5 class="mb-3 text-primary fw-bold">Emergency Contact</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <strong>Name:</strong><br> {{ $emergency->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Relationship:</strong><br> {{ $emergency->relationship }}
                    </div>
                    <div class="col-md-6">
                        <strong>Phone:</strong><br> {{ $emergency->phone_number ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Address:</strong><br> {{ $emergency->address ?? '-' }}
                    </div>
                </div>
            @endif

        {{-- STAFF / ADMIN DETAILS --}}
        @else
            <h5 class="mb-3 text-primary fw-bold">Basic Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>First Name:</strong><br> {{ $user->first_name }}
                </div>
                <div class="col-md-4">
                    <strong>Middle Name:</strong><br> {{ $user->middle_name ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Last Name:</strong><br> {{ $user->last_name }}
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong><br> {{ $user->email }}
                </div>
                <div class="col-md-6">
                    <strong>Role:</strong><br> {{ ucfirst($user->role) }}
                </div>
            </div>

            <hr>
            <h5 class="mb-3 text-primary fw-bold">Professional Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <strong>Profession:</strong><br> {{ $user->profession ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>License Type:</strong><br> {{ $user->license_type ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Specialization:</strong><br> {{ $user->specialization ?? '-' }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
