@extends('layouts.app')

@section('page-title', 'Add New User')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>


<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Role Selection -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Select Role</option>
                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                    <option value="clinic_staff" {{ old('role') == 'clinic_staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Patient Fields -->
            <div id="patient-fields" style="display:none;">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                    @error('middle_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="school_id" class="form-label">School ID</label>
                    <input type="text" name="school_id" class="form-control" value="{{ old('school_id') }}">
                    @error('school_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender')=='Male' ? 'selected':'' }}>Male</option>
                        <option value="Female" {{ old('gender')=='Female' ? 'selected':'' }}>Female</option>
                    </select>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
                    @error('birthdate') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
                    @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <hr>
                <h5>Emergency Contact</h5>
                <div class="mb-3">
                    <label for="emergency_name" class="form-label">Name</label>
                    <input type="text" name="emergency_name" class="form-control" value="{{ old('emergency_name') }}">
                </div>
                <div class="mb-3">
                    <label for="emergency_relation" class="form-label">Relationship</label>
                    <input type="text" name="emergency_relation" class="form-control" value="{{ old('emergency_relation') }}">
                </div>
                <div class="mb-3">
                    <label for="emergency_phone" class="form-label">Phone</label>
                    <input type="text" name="emergency_phone" class="form-control" value="{{ old('emergency_phone') }}">
                </div>
                <div class="mb-3">
                    <label for="emergency_address" class="form-label">Address</label>
                    <textarea name="emergency_address" class="form-control">{{ old('emergency_address') }}</textarea>
                </div>
            </div>

            <!-- Staff/Admin Fields -->
            <div id="staff-fields" style="display:none;">
                <div class="mb-3">
                    <label for="first_name_staff" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                </div>
                <div class="mb-3">
                    <label for="last_name_staff" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                </div>
                <div class="mb-3">
                    <label for="email_staff" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password_staff" class="form-label">Password</label>
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

            <button type="submit" class="btn btn-primary mt-3">Save User</button>
        </form>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const patientFields = document.getElementById('patient-fields');
    const staffFields = document.getElementById('staff-fields');

    function toggleFields() {
        const role = roleSelect.value;
        if(role === 'patient') {
            patientFields.style.display = 'block';
            staffFields.style.display = 'none';
        } else if(role === 'clinic_staff' || role === 'admin') {
            patientFields.style.display = 'none';
            staffFields.style.display = 'block';
        } else {
            patientFields.style.display = 'none';
            staffFields.style.display = 'none';
        }
    }

    roleSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>
@endsection
