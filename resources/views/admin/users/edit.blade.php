@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit User</h2>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- BASIC INFORMATION --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                Basic Information
            </div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" 
                        value="{{ old('first_name', $user->first_name) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" 
                        value="{{ old('middle_name', $user->middle_name) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" 
                        value="{{ old('last_name', $user->last_name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                        value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="date_of_birth" class="form-control" 
                        value="{{ old('date_of_birth', $user->date_of_birth) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="phone_number" class="form-control" 
                        value="{{ old('phone_number', $user->phone_number) }}">
                </div>

                <div class="col-md-8">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" 
                        value="{{ old('address', $user->address) }}">
                </div>
            </div>
        </div>

        {{-- PATIENT FIELDS --}}
        @if($user->role === 'patient')
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    School Information
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">School ID</label>
                        <input type="text" name="school_id" class="form-control" 
                            value="{{ old('school_id', optional($user->personalInformation)->school_id) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Course</label>
                        <input type="text" name="course" class="form-control" 
                            value="{{ old('course', optional($user->personalInformation)->course) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Grade Level</label>
                        <input type="text" name="grade_level" class="form-control" 
                            value="{{ old('grade_level', optional($user->personalInformation)->grade_level) }}">
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    Emergency Contact
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="emer_con_name" class="form-control" 
                            value="{{ old('emer_con_name', optional($user->personalInformation)->emer_con_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Relationship</label>
                        <input type="text" name="emer_con_rel" class="form-control" 
                            value="{{ old('emer_con_rel', optional($user->personalInformation)->emer_con_rel) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="emer_con_phone" class="form-control" 
                            value="{{ old('emer_con_phone', optional($user->personalInformation)->emer_con_phone) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Emergency Contact Address</label>
                        <input type="text" name="emer_con_address" class="form-control" 
                            value="{{ old('emer_con_address', optional($user->personalInformation)->emer_con_address) }}">
                    </div>
                </div>
            </div>
        @endif

        {{-- STAFF FIELDS --}}
        @if($user->role === 'staff')
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    Staff Credentials
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Profession</label>
                        <input type="text" name="profession" class="form-control" 
                            value="{{ old('profession', optional($user->credential)->profession) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">License Type</label>
                        <input type="text" name="license_type" class="form-control" 
                            value="{{ old('license_type', optional($user->credential)->license_type) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control" 
                            value="{{ old('specialization', optional($user->credential)->specialization) }}">
                    </div>
                </div>
            </div>
        @endif

        {{-- ADMIN INFO NOTICE --}}
        @if($user->role === 'admin')
            <div class="alert alert-dark">
                This user is an <strong>Administrator</strong> and has full system privileges.
            </div>
        @endif

        {{-- BUTTONS --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
    </form>
</div>
@endsection
