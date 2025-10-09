@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add New User</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <!-- Role Toggle Buttons -->
          <div class="btn-group mb-4 w-100" role="group" aria-label="User Role Selection">
    <button type="button" class="btn btn-outline-primary active" id="toggle-patient">Patient</button>
    <button type="button" class="btn btn-outline-primary" id="toggle-staff">Staff</button>
</div>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <!-- Common for Admin and Staff -->
                <div id="admin-staff-form" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Profession</label>
                            <input type="text" name="profession" class="form-control" value="{{ old('profession') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>License Type</label>
                            <input type="text" name="license_type" class="form-control" value="{{ old('license_type') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Specialization</label>
                            <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}">
                        </div>
                    </div>

                    <input type="hidden" name="role" id="role" value="staff">
                    <div class="mt-4">
    <button type="submit" class="btn btn-success">Save User</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</div>
                </div>

<!-- Patient Form -->
<div id="patient-form" style="display: block;"> <!-- default to patient -->
    <!-- Personal Info Fields -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label>Middle Name</label>
            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label>School ID</label>
            <input type="text" name="school_id" class="form-control" required value="{{ old('school_id') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <label>Gender</label>
            <select name="gender" class="form-select">
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label>Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
    </div>

    <!-- Emergency Contact Form -->
    <div class="card mt-4">
        <div class="card-header">
            <strong>Emergency Contact</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Contact Name</label>
                    <input type="text" name="emergency_name" class="form-control" value="{{ old('emergency_name') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Relation</label>
                    <input type="text" name="emergency_relation" class="form-control" value="{{ old('emergency_relation') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="emergency_phone" class="form-control" value="{{ old('emergency_phone') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Address</label>
                    <input type="text" name="emergency_address" class="form-control" value="{{ old('emergency_address') }}">
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="role" value="patient">

    <!-- Submit Button -->
    <div class="mt-4">
        <button type="submit" class="btn btn-success">Save User</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<!-- JavaScript for Toggling -->

<!-- JavaScript Toggle -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const staffBtn = document.getElementById('toggle-staff');
    const patientBtn = document.getElementById('toggle-patient');
    const adminStaffForm = document.getElementById('admin-staff-form');
    const patientForm = document.getElementById('patient-form');
    const roleInput = document.getElementById('role');

    function setActive(btn) {
        [staffBtn, patientBtn].forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    staffBtn.addEventListener('click', function() {
        setActive(staffBtn);
        adminStaffForm.style.display = 'block';
        patientForm.style.display = 'none';
        roleInput.value = 'clinic_staff';
    });

    patientBtn.addEventListener('click', function() {
        setActive(patientBtn);
        adminStaffForm.style.display = 'none';
        patientForm.style.display = 'block';
        roleInput.value = 'patient';
    });
});
</script>
@endsection
