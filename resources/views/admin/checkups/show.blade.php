@extends('layouts.app')

@section('page-title', 'Checkup Details')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary">
            Checkup Details
        </h1>

        <a href="{{ route('admin.checkups.index') }}" class="btn btn-secondary btn-sm">
            ← Back to Checkups
        </a>
    </div>

    {{-- Checkup Info Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Checkup Information</h5>
            <hr>
            <p><strong>Staff Assigned:</strong> {{ $checkup->staff->first_name ?? '' }} {{ $checkup->staff->last_name ?? '' }}</p>
            <p><strong>Course:</strong> {{ $checkup->course->course ?? 'N/A' }}</p>
            <p><strong>Type:</strong> {{ ucfirst($checkup->checkup_type) }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($checkup->date)->format('F d, Y') }}</p>
            <p><strong>Notes:</strong> {{ $checkup->notes ?? 'No notes provided.' }}</p>
        </div>
    </div>

    {{-- Students List --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Students for this Checkup</h5>
            <hr>

            @if($checkup->students->isEmpty())
                <p class="text-muted">No students assigned to this checkup yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Course & Year</th>
                                <th>Patient Record</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkup->students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->course->course?? 'N/A' }}</td>
                                    <td>
                                        @if($student->patient)
                                            ✅ Record Exists
                                        @else
                                            ❌ No Record
                                        @endif
                                    </td>
                                    <td>
        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
