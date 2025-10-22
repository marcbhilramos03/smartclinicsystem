@extends('layouts.app')

@section('page-title', 'Create User')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Add New User</h2>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">Back</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required onchange="toggleUserFields(this.value)">
                <option value="">Select Role</option>
                <option value="patient">Patient</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        {{-- Common Fields --}}
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
        </div>

        {{-- Patient Fields --}}
        <div id="patientFields" style="display:none;">
            <div class="mb-3">
                <label for="school_id" class="form-label">School ID</label>
                <input type="text" name="school_id" class="form-control" value="{{ old('school_id') }}">
            </div>
            <div class="mb-3">
                <label for="grade_level" class="form-label">Year Level</label>
                <input type="text" name="grade_level" class="form-control" value="{{ old('grade_level') }}">
            </div>
<div class="mb-3">
    <label for="course" class="form-label">Course</label>
    <select name="course" class="form-select">
        <option value="">Grade Level --</option>

        <!-- College Courses -->
        <optgroup label="College Courses">
            <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>BSIT</option>
            <option value="BSCS" {{ old('course') == 'BSCS' ? 'selected' : '' }}>BSCS</option>
            <option value="BSEd" {{ old('course') == 'BSEd' ? 'selected' : '' }}>BSEd</option>
            <option value="BSBA" {{ old('course') == 'BSBA' ? 'selected' : '' }}>BSBA</option>
        </optgroup>

        <!-- Senior High Tracks -->
        <optgroup label="Senior High Tracks">
            <option value="HUMSS" {{ old('course') == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
            <option value="STEM" {{ old('course') == 'STEM' ? 'selected' : '' }}>STEM</option>
            <option value="ABM" {{ old('course') == 'ABM' ? 'selected' : '' }}>ABM</option>
            <option value="GAS" {{ old('course') == 'GAS' ? 'selected' : '' }}>GAS</option>
        </optgroup>

        <!-- Grade School / Junior High -->
        <optgroup label="Basic Education">
            <option value="Grade 1" {{ old('course') == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
            <option value="Grade 2" {{ old('course') == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
            <option value="Grade 3" {{ old('course') == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
            <!-- Continue up to Grade 12 if needed -->
        </optgroup>
    </select>
</div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" name="gender" class="form-control" value="{{ old('gender') }}">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Birthdate</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Contact Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            </div>
            {{-- Emergency Contact --}}
            <h5>Emergency Contact</h5>
            <div class="mb-3">
                <label for="emer_con_name" class="form-label">Name</label>
                <input type="text" name="emer_con_name" class="form-control" value="{{ old('emer_con_name') }}">
            </div>
            <div class="mb-3">
                <label for="emer_con_rel" class="form-label">Relationship</label>
                <input type="text" name="emer_con_rel" class="form-control" value="{{ old('emer_con_rel') }}">
            </div>
            <div class="mb-3">
                <label for="emer_con_phone" class="form-label">Phone</label>
                <input type="text" name="emer_con_phone" class="form-control" value="{{ old('emer_con_phone') }}">
            </div>
            <div class="mb-3">
                <label for="emer_con_address" class="form-label">Address</label>
                <input type="text" name="emer_con_address" class="form-control" value="{{ old('emer_con_address') }}">
            </div>
        </div>

        {{-- Staff/Admin Fields --}}
        <div id="staffFields" style="display:none;">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="mb-3">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" name="profession" class="form-control" value="{{ old('profession') }}">
            </div>
            <div class="mb-3">
                <label for="license_type" class="form-label">License Type</label>
                <input type="text" name="license_type" class="form-control" value="{{ old('license_type') }}">
            </div>
            <div class="mb-3">
                <label for="specialization" class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Create User</button>
    </form>
</div>

<script>
function toggleUserFields(role) {
    document.getElementById('patientFields').style.display = (role === 'patient') ? 'block' : 'none';
    document.getElementById('staffFields').style.display = (role === 'staff' || role === 'admin') ? 'block' : 'none';
}
</script>
@endsection
