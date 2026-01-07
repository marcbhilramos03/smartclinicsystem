@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #e9f3ff, #d4e4ff);
        font-family: 'Segoe UI', sans-serif;
    }

    .container-fluid {
        max-width: 1400px;
        background: #fff;
        border-radius: 16px;
        padding:;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        margin-top: 40px;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        color: #000000;
        font-weight: 7x00;
        margin-bottom: 25px;
    }

    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.15);
    }

    .card-header {
        font-weight: 600;
        font-size: 1rem;
    }

    .card-body {
        background-color: #f8fbff;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 6px rgba(13, 110, 253, 0.3);
    }

    .btn {
        border-radius: 10px;
        padding: 12px 25px;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #0d6efd;
        border: none;
    }

    .btn-success:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5c636a;
    }

    .alert {
        border-radius: 10px;
    }

    .alert-dark {
        background-color: #e9f0ff;
        border-left: 5px solid #0d6efd;
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 25px 20px;
        }

        h2 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="container-fluid">
    <h2>Edit User</h2>

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

                @if($user->role !== 'patient')
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                            value="{{ old('email', $user->email) }}" required>
                    </div>
                @endif

                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="date_of_birth" class="form-control" 
                        value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}">
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

        @if($user->role === 'admin')
            <div class="alert alert-dark">
                This user is an <strong>Administrator</strong> and has full system privileges.
            </div>
        @endif

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                ✖ Cancel
            </a>
            <button type="submit" class="btn btn-success">
                💾 Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
