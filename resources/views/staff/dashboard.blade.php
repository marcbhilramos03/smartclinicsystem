@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0">Doctor's Dashboard</h1>
            <small class="text-muted">Checkup's overview and statistics</small>
        </div>

        <span class="badge bg-light text-dark px-3 py-2 shadow-sm">
            👋 Welcome, {{ auth()->user()->first_name }}
        </span>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">

        {{-- Patients --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-start border-success border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase">Patients</h6>
                            <h2 class="fw-bold mb-0">{{ $totalPatients }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Courses --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-start border-info border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase">Courses</h6>
                            <h2 class="fw-bold mb-0">{{ $totalCourses }}</h2>
                        </div>
                        <i class="fas fa-book fa-2x text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-start border-warning border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase">Pending</h6>
                            <h2 class="fw-bold mb-0">{{ $pendingCheckups }}</h2>
                        </div>
                        <i class="fas fa-hourglass-half fa-2x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-start border-primary border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase">Completed</h6>
                            <h2 class="fw-bold mb-0">{{ $completedCheckups }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Checkups by Course --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h6 class="fw-bold text-primary mb-0">
                <i class="fas fa-chart-bar me-1"></i> Checkups by Course
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Course</th>
                            <th>Pending</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coursesWithCheckups as $course)
                            <tr>
                                <td class="fw-semibold">{{ $course->name }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $course->pending_checkups }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $course->completed_checkups }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted py-4">
                                    No data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
