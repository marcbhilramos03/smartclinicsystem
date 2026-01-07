@extends('layouts.app')

@section('page-title', 'Create User')

@section('content')
<style>

.create-user-container {
    max-width: 1400px;
    margin: 30px auto;
    font-family: 'Segoe UI', sans-serif;
}


.create-user-container h2 {
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 25px;
    text-align: center;
}


.card {
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}
.card-header {
    font-weight: 600;
}
.card-body .form-label {
    font-weight: 500;
}


.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px 12px;
    transition: 0.3s;
}
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
}


.btn {
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: 600;
    transition: 0.3s;
}
.btn-success:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
}
.btn-secondary:hover {
    background-color: #495057;
}


.alert-danger {
    border-radius: 10px;
    font-size: 0.95rem;
}


@media (max-width: 768px) {
    .create-user-container {
        padding: 15px;
    }
}
</style>

<div class="create-user-container">
    <h2>Add New User</h2>

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

       
        <div class="card">
            <div class="card-header bg-primary text-white">Role</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="role" class="form-label">Select User Role</label>
                    <select name="role" id="role" class="form-select" required onchange="toggleUserFields(this.value)">
                        <option value="">Select Role</option>
                        <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Student</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Doctor/Nurse</option>
                    </select>
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header bg-info text-white">Basic Information</div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                </div>

                <div class="col-md-4">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                </div>

                <div class="col-md-4">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                </div>
            </div>
        </div>

       
        <div id="patientFields" style="display:none;">
            <div class="card">
                <div class="card-header bg-success text-white">School Information</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">School ID</label>
                        <input type="text" name="school_id" class="form-control" value="{{ old('school_id') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Grade Level</label>
                        <input type="text" name="grade_level" class="form-control" value="{{ old('grade_level') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Course</label>
                        <select name="course" class="form-select">
                            <option value="">Choose Grade/Course</option>
                            <optgroup label="College Courses">
                                <option value="BSIT" {{ old('course')=='BSIT'?'selected':'' }}>BSIT</option>
                                <option value="BSEd" {{ old('course')=='BSEd'?'selected':'' }}>BSED</option>
                                <option value="BEED" {{ old('course')=='BEED'?'selected':'' }}>BEED</option>
                                <option value="BSSW" {{ old('course')=='BSSW'?'selected':'' }}>BSSW</option>
                                <option value="BSCRIM" {{ old('course')=='BSCRIM'?'selected':'' }}>BSCRIM</option>
                                <option value="BSN" {{ old('course')=='BSN'?'selected':'' }}>BSN</option>
                                <option value="BSBA" {{ old('course')=='BSBA'?'selected':'' }}>BSBA</option>
                                <option value="BSHM" {{ old('course')=='BSHM'?'selected':'' }}>BSHM</option>
                                <option value="BSA" {{ old('course')=='BSA'?'selected':'' }}>BSA</option>
                            </optgroup>
                            <optgroup label="Senior High Tracks">
                                <option value="HUMSS" {{ old('course')=='HUMSS'?'selected':'' }}>HUMSS</option>
                                <option value="STEM" {{ old('course')=='STEM'?'selected':'' }}>STEM</option>
                                <option value="ABM" {{ old('course')=='ABM'?'selected':'' }}>ABM</option>
                                <option value="GAS" {{ old('course')=='GAS'?'selected':'' }}>GAS</option>
                            </optgroup>
                            <optgroup label="High School">
                                <option value="Grade 7" {{ old('course')=='Grade 7'?'selected':'' }}>Grade 7</option>
                                <option value="Grade 8" {{ old('course')=='Grade 8'?'selected':'' }}>Grade 8</option>
                                <option value="Grade 9" {{ old('course')=='Grade 9'?'selected':'' }}>Grade 9</option>
                                <option value="Grade 10" {{ old('course')=='Grade 10'?'selected':'' }}>Grade 10</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
                            <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Birthdate</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>
                </div>
            </div>

       
            <div class="card">
                <div class="card-header bg-warning text-dark">Emergency Contact</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="emer_con_name" class="form-control" value="{{ old('emer_con_name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Relationship</label>
                        <input type="text" name="emer_con_rel" class="form-control" value="{{ old('emer_con_rel') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="emer_con_phone" class="form-control" value="{{ old('emer_con_phone') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input type="text" name="emer_con_address" class="form-control" value="{{ old('emer_con_address') }}">
                    </div>
                </div>
            </div>
        </div>

     
        <div id="staffFields" style="display:none;">
            <div class="card">
                <div class="card-header bg-info text-white">Staff / Admin Credentials</div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Profession</label>
                        <input type="text" name="profession" class="form-control" value="{{ old('profession') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">License Type</label>
                        <input type="text" name="license_type" class="form-control" value="{{ old('license_type') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Create User</button>
        </div>
    </form>
</div>

<script>
function toggleUserFields(role) {
    document.getElementById('patientFields').style.display = (role === 'patient') ? 'block' : 'none';
    document.getElementById('staffFields').style.display = (role === 'staff' || role === 'admin') ? 'block' : 'none';
}


window.onload = function() {
    const role = '{{ old('role') }}';
    if(role) toggleUserFields(role);
}
</script>
@endsection
