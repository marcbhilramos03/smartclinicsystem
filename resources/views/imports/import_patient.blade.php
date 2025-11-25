@extends('layouts.app')

@section('content')
<style>
/* === Container === */
.import-container {
    width: 100%;
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
    box-sizing: border-box;
}

/* === Headings === */
.import-container h3 {
    font-weight: 700;
    color: #333;
}

/* === Card Styling === */
.card {
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}
.card-header {
    font-weight: 600;
}
.card-body {
    padding: 20px;
}

/* === Form Inputs === */
.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px 12px;
    transition: 0.3s;
}
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
}

/* === Buttons === */
.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    transition: 0.3s;
}
.btn-success:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
}
.btn-info:hover {
    background-color: #0c7cd5;
}
.btn-dashboard {
    margin-bottom: 20px;
}

/* === Alerts === */
.alert {
    border-radius: 10px;
}

/* === Responsive === */
@media (max-width: 768px) {
    .row > .col-lg-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

<div class="import-container">
    <h3 class="mb-4 text-dark"><i class="fas fa-file-import me-2"></i> Import Students</h3>
    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Upload Form --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i> Upload File</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.imports.patients.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Select Excel/CSV File</label>
                            <input type="file" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-import me-1"></i> Import Students
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Downloadable Template --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-file-download me-2"></i> Download Template</h5>
                </div>
                <div class="card-body">
                    <p>To ensure proper import, please download our template file and fill in your data. Make sure to follow the column format.</p>
                    <ul>
                        <li><strong>School ID:</strong> Unique student identifier</li>
                        <li><strong>First Name</strong>, <strong>Middle Name</strong>, <strong>Last Name</strong></li>
                        <li><strong>Gender</strong></li>
                        <li><strong>Date of Birth:</strong> MM-DD-YYYY</li>
                        <li><strong>Phone Number</strong> & <strong>Address</strong></li>
                        <li><strong>Course</strong>, <strong>Grade Level</strong>, <strong>School Year</strong></li>
                        <li><strong>Emergency Contact Name, Relationship, Phone, Address</strong></li>
                    </ul>
                    <a href="{{ route('admin.import.patient.template') }}" class="btn btn-info">
                        <i class="fas fa-download me-1"></i> Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
