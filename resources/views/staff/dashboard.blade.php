@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Heading --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Doctor's Dashboard</h1>
        <span class="text-muted">Welcome, {{ auth()->user()->first_name }}</span>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Dashboard Cards --}}
    <div class="row mb-4">

        {{-- Total Patients --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body text-center">
                    <h5>Total Patients</h5>
                    <h2 class="fw-bold">{{ $totalPatients ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Total Courses --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body text-center">
                    <h5>Total Courses</h5>
                    <h2 class="fw-bold">{{ $totalCourses ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Pending Checkups --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body text-center">
                    <h5>Pending Checkups</h5>
                    <h2 class="fw-bold">{{ $pendingCheckups ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Completed Checkups --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body text-center">
                    <h5>Completed Checkups</h5>
                    <h2 class="fw-bold">{{ $completedCheckups ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- Optional: Checkups by Course Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Checkups by Course</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Course</th>
                            <th>Pending Checkups</th>
                            <th>Completed Checkups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coursesWithCheckups ?? [] as $course)
                            <tr>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->pending_checkups }}</td>
                                <td>{{ $course->completed_checkups }}</td>
                            </tr>
                        @endforeach
                        @if(empty($coursesWithCheckups))
                            <tr>
                                <td colspan="3">No data available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
