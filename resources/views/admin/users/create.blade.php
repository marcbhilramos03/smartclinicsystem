@extends('layouts.app')

@section('page-title', 'Create User')

@section('content')
<style>
/* Scoped CSS for create-user form only */
.create-user-form-container {
    width: 100%;
    padding: 30px 50px;
    box-sizing: border-box;
}

.create-user-form-container h2 {
    font-weight: 700;
    color: #333;
    margin-bottom: 30px;
}

/* Card style for form */
.create-user-form {
    background: #ffffff;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.create-user-form:hover {
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.15);
}

/* Labels */
.create-user-form .form-label {
    font-weight: 500;
    color: #555;
}

/* Inputs */
.create-user-form .form-control,
.create-user-form .form-select {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px 12px;
    transition: 0.3s;
}

.create-user-form .form-control:focus,
.create-user-form .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
}

/* Buttons */
.create-user-form .btn-success {
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: 600;
    transition: 0.3s;
}

.create-user-form .btn-success:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
}

.create-user-form .btn-secondary {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
}

/* Section titles */
.create-user-form h5 {
    margin-top: 25px;
    font-weight: 600;
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    display: inline-block;

}

/* Error messages */
.create-user-form .alert-danger {
    border-radius: 10px;
    font-size: 0.95rem;
}

/* Spacing between fields */
.create-user-form .mb-3 {
    margin-bottom: 18px !important;
}

/* Optgroup styling */
.create-user-form select optgroup {
    font-weight: 600;
    color: #333;
}
</style>

<div class="create-user-form-container">
    <h2>Add New User</h2>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-4">Back</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="create-user-form">
        @csrf

        {{-- Role --}}
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required onchange="toggleUserFields(this.value)">
                <option value="">Select User</option>
                <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Student</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Doctor/Nurse</option>
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
                    <option value="">Choose Grade/Course</option>

                    <!-- College Courses -->
                    <optgroup label="College Courses">
                        <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>BSIT</option>
                        <option value="BSEd" {{ old('course') == 'BSEd' ? 'selected' : '' }}>BSED</option>
                        <option value="BEED" {{ old('course') == 'BEED' ? 'selected' : '' }}>BEED</option>
                        <option value="BSSW" {{ old('course') == 'BSSW' ? 'selected' : '' }}>BSSW</option>
                        <option value="BSCRIM" {{ old('course') == 'BSCRIM' ? 'selected' : '' }}>BSCRIM</option>
                        <option value="BSN" {{ old('course') == 'BSN' ? 'selected' : '' }}>BSN</option>
                        <option value="BSBA" {{ old('course') == 'BSBA' ? 'selected' : '' }}>BSBA</option>
                        <option value="BSHM" {{ old('course') == 'BSHM' ? 'selected' : '' }}>BSHM</option>
                        <option value="BSA" {{ old('course') == 'BSA' ? 'selected' : '' }}>BSA</option>
                    </optgroup>

                    <!-- Senior High Tracks -->
                    <optgroup label="Senior High Tracks">
                        <option value="HUMSS" {{ old('course') == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                        <option value="STEM" {{ old('course') == 'STEM' ? 'selected' : '' }}>STEM</option>
                        <option value="ABM" {{ old('course') == 'ABM' ? 'selected' : '' }}>ABM</option>
                        <option value="GAS" {{ old('course') == 'GAS' ? 'selected' : '' }}>GAS</option>
                    </optgroup>

                    <!-- High School -->
                    <optgroup label="High School">
                        <option value="Grade 7" {{ old('course') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                        <option value="Grade 8" {{ old('course') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                        <option value="Grade 9" {{ old('course') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                        <option value="Grade 10" {{ old('course') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                    </optgroup>

                    <!-- Basic Education -->
                    <optgroup label="Basic Education">
                        <option value="Grade 1" {{ old('course') == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
                        <option value="Grade 2" {{ old('course') == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
                        <option value="Grade 3" {{ old('course') == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
                        <option value="Grade 4" {{ old('course') == 'Grade 4' ? 'selected' : '' }}>Grade 4</option>
                        <option value="Grade 5" {{ old('course') == 'Grade 5' ? 'selected' : '' }}>Grade 5</option>
                        <option value="Grade 6" {{ old('course') == 'Grade 6' ? 'selected' : '' }}>Grade 6</option>
                    </optgroup>
                </select>
            </div>

           <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

          <div class="mb-3">
            <label for="date_of_birth" class="form-label">Birthdate</label>
            <input type="date" name="date_of_birth" class="form-control" id="dob" value="{{ old('date_of_birth') }}"placeholder="MM/DD/YYYY">
        </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Contact Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            </div>

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

        <button type="submit" class="btn btn-success mt-3">Create User</button>
    </form>
</div>

<script>
function toggleUserFields(role) {
    document.getElementById('patientFields').style.display = (role === 'patient') ? 'block' : 'none';
    document.getElementById('staffFields').style.display = (role === 'staff' || role === 'admin') ? 'block' : 'none';
}

// Keep old role selected on page reload
window.onload = function() {
    const role = '{{ old('role') }}';
    if(role) toggleUserFields(role);
}

</script>
@endsection
