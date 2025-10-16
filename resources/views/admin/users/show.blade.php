@extends('layouts.app')

@section('page-title', 'User Details')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2 class="h4 text-gray-800">User Details</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <h5 class="mb-3">Basic Info</h5>
        <div class="row mb-4">
            <div class="col-md-6">
                <strong>First Name:</strong> {{ $user->first_name }}
            </div>
            <div class="col-md-6">
                <strong>Middle Name:</strong> {{ $user->middle_name ?? '-' }}
            </div>
            <div class="col-md-6 mt-2">
                <strong>Last Name:</strong> {{ $user->last_name }}
            </div>
            <div class="col-md-6 mt-2">
                <strong>Role:</strong> {{ ucfirst(str_replace('_',' ', $user->role)) }}
            </div>
            @if($user->email)
            <div class="col-md-6 mt-2">
                <strong>Email:</strong> {{ $user->email }}
            </div>
            @endif
        </div>

        @if($user->role === 'patient')
            @php
                $info = $user->personalInformation;
                $emergency = $info?->emergencyContacts?->first();
            @endphp

            <hr>
            <h5 class="mb-3">Personal Information</h5>
            <div class="row mb-4">
                <div class="col-md-6"><strong>School ID:</strong> {{ $info->school_id ?? '-' }}</div>
                <div class="col-md-6"><strong>Gender:</strong> {{ $info->gender ?? '-' }}</div>
                <div class="col-md-6 mt-2"><strong>Birthdate:</strong> {{ $info->birthdate ?? '-' }}</div>
                <div class="col-md-6 mt-2"><strong>Contact Number:</strong> {{ $info->contact_number ?? '-' }}</div>
                <div class="col-md-12 mt-2"><strong>Address:</strong> {{ $info->address ?? '-' }}</div>
            </div>

            @if($emergency)
                <hr>
                <h5 class="mb-3">Emergency Contact</h5>
                <div class="row mb-4">
                    <div class="col-md-6"><strong>Name:</strong> {{ $emergency->name }}</div>
                    <div class="col-md-6"><strong>Relationship:</strong> {{ $emergency->relationship }}</div>
                    <div class="col-md-6 mt-2"><strong>Phone:</strong> {{ $emergency->phone_number ?? '-' }}</div>
                    <div class="col-md-6 mt-2"><strong>Address:</strong> {{ $emergency->address ?? '-' }}</div>
                </div>
            @endif

        @else
            <hr>
            <h5 class="mb-3">Professional Info</h5>
            <div class="row mb-4">
                <div class="col-md-6"><strong>Profession:</strong> {{ $user->profession ?? '-' }}</div>
                <div class="col-md-6"><strong>License Type:</strong> {{ $user->license_type ?? '-' }}</div>
                <div class="col-md-6 mt-2"><strong>Specialization:</strong> {{ $user->specialization ?? '-' }}</div>
            </div>
        @endif
    </div>
</div>
@endsection
