@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2 class="h4 text-gray-800">Edit User</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- The role field is disabled on edit for simplicity -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" value="{{ ucfirst(str_replace('_',' ', $user->role)) }}" disabled>
            </div>

            @if($user->role === 'patient')
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                </div>
                <div class="mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $user->middle_name) }}">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                </div>
                @php
                    $info = $user->personalInformation;
                    $emergency = $info?->emergencyContacts?->first();
                @endphp
                <div class="mb-3">
                    <label for="school_id" class="form-label">School ID</label>
                    <input type="text" name="school_id" class="form-control" value="{{ old('school_id', $info->school_id ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $info->contact_number ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control">{{ old('address', $info->address ?? '') }}</textarea>
                </div>

                <hr>
                <h5>Emergency Contact</h5>
                <div class="mb-3">
                    <label for="emergency_name" class="form-label">Name</label>
                    <input type="text" name="emergency_name" class="form-control" value="{{ old('emergency_name', $emergency->name ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="emergency_relation" class="form-label">Relationship</label>
                    <input type="text" name="emergency_relation" class="form-control" value="{{ old('emergency_relation', $emergency->relationship ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="emergency_phone" class="form-label">Phone</label>
                    <input type="text" name="emergency_phone" class="form-control" value="{{ old('emergency_phone', $emergency->phone_number ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="emergency_address" class="form-label">Address</label>
                    <textarea name="emergency_address" class="form-control">{{ old('emergency_address', $emergency->address ?? '') }}</textarea>
                </div>
            @else
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>
                <div class="mb-3">
                    <label for="profession" class="form-label">Profession</label>
                    <input type="text" name="profession" class="form-control" value="{{ old('profession', $user->profession) }}">
                </div>
                <div class="mb-3">
                    <label for="license_type" class="form-label">License Type</label>
                    <input type="text" name="license_type" class="form-control" value="{{ old('license_type', $user->license_type) }}">
                </div>
                <div class="mb-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $user->specialization) }}">
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-3">Update User</button>
        </form>
    </div>
</div>
@endsection
