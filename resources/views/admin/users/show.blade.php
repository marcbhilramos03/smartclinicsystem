@extends('layouts.app')

@section('page-title', 'User Details')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">User Details</h2>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">← Back to Users</a>

    {{-- BASIC INFORMATION --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        Basic Information
    </div>

    <div class="card-body">
        <p><strong>Full Name:</strong> {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</p>

        @if ($user->role === 'staff')
            <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ $user->gender ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
            <p><strong>Contact Number:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
        @else
            <p><strong>Gender:</strong> {{ $user->gender ?? 'N/A' }}</p>
            <p><strong>Birthdate:</strong>
                {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F j, Y') : 'N/A' }}
            </p>
            <p><strong>Contact Number:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
        @endif
    </div>
</div>


    {{-- PATIENT DETAILS --}}
    @if($user->role === 'patient')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                School & Emergency Contact
            </div>
            <div class="card-body">
                <p><strong>School ID:</strong> {{ optional($user->personalInformation)->school_id ?? 'N/A' }}</p>
                <p><strong>Course:</strong> {{ optional($user->personalInformation)->course ?? 'N/A' }}</p>
                <p><strong>Grade Level:</strong> {{ optional($user->personalInformation)->grade_level ?? 'N/A' }}</p>

                <hr>
                <h5>Emergency Contact</h5>
                <p><strong>Name:</strong> {{ optional($user->personalInformation)->emer_con_name ?? 'N/A' }}</p>
                <p><strong>Relationship:</strong> {{ optional($user->personalInformation)->emer_con_rel ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ optional($user->personalInformation)->emer_con_phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ optional($user->personalInformation)->emer_con_address ?? 'N/A' }}</p>
            </div>
        </div>
    @endif

    {{-- STAFF DETAILS --}}
    @if($user->role === 'staff')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                Staff Credentials
            </div>
            <div class="card-body">
                <p><strong>Profession:</strong> {{ optional($user->credential)->profession ?? 'N/A' }}</p>
                <p><strong>License Type:</strong> {{ optional($user->credential)->license_type ?? 'N/A' }}</p>
                <p><strong>Specialization:</strong> {{ optional($user->credential)->specialization ?? 'N/A' }}</p>
            </div>
        </div>
    @endif

    {{-- ADMIN DETAILS --}}
    @if($user->role === 'admin')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white">
                Administrator Information
            </div>
            <div class="card-body">
                <p>This user has administrative privileges and can manage users, records, and other system data.</p>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-primary">Edit User</a>
    </div>
</div>
@endsection
