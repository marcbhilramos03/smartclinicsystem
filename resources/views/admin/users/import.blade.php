@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Upload Section -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📂 Batch Upload Students</h4>
        </div>

        <div class="card-body">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Error:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Upload Form -->
            <form action="{{ route('admin.patients.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Choose Excel or CSV File</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.csv" required>
                        <small class="text-muted">Accepted formats: .xlsx, .csv</small>
                    </div>
                </div>

                <div class="d-flex justify-content-start gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-upload me-1"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Example Format -->
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-info-circle me-2"></i> Example File Format
            </h5>
        </div>

        <div class="card-body">
            <p class="text-muted mb-3">
                The Excel or CSV file should include the following columns in order.  
                Each row represents one student record:
            </p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>School ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Birthdate</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Department</th>
                            <th>Grade Level</th>
                            <th>Emergency Name</th>
                            <th>Relationship</th>
                            <th>Phone</th>
                            <th>Emergency Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025001</td>
                            <td>Juan</td>
                            <td>Dela</td>
                            <td>Cruz</td>
                            <td>Male</td>
                            <td>2005-03-21</td>
                            <td>09123456789</td>
                            <td>123 Main St</td>
                            <td>College</td>
                            <td>BSIT-1</td>
                            <td>Maria Dela Cruz</td>
                            <td>Mother</td>
                            <td>09198765432</td>
                            <td>123 Main St</td>
                        </tr>
                        <tr>
                            <td>HS202501</td>
                            <td>Ana</td>
                            <td>Santos</td>
                            <td>Reyes</td>
                            <td>Female</td>
                            <td>2007-06-15</td>
                            <td>09981234567</td>
                            <td>456 School Rd</td>
                            <td>Senior High School</td>
                            <td>Grade 12</td>
                            <td>Jose Reyes</td>
                            <td>Father</td>
                            <td>09182345678</td>
                            <td>456 School Rd</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="text-muted mt-2">
                💡 <strong>Tip:</strong> Make sure the column headers match exactly as shown above.  
                Supports both <strong>College</strong> (e.g., BSIT-1, BSN-2) and <strong>High School</strong> (e.g., Grade 10, SHS-STEM-12) formats.
            </p>
        </div>
    </div>

</div>
@endsection
