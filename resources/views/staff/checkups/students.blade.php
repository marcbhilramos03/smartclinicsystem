@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h3 mb-0 text-gray-800">Students in Checkup: {{ $checkup->checkup_type }} - {{ $checkup->date }}</h2>
        <a href="{{ route('staff.checkups.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Checkups
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Students Table -->
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkup->patients as $student)
                        <tr>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->personalInformation->course ?? 'N/A' }}</td>
                            <td>{{ $student->personalInformation->grade_level ?? 'N/A' }}</td>
                            <td>{{ ucfirst($student->pivot->status ?? 'pending') }}</td> <!-- Status from pivot -->

                            <td>
                                <a href="{{ route('staff.checkup_records.create', [$checkup->id, $student->user_id]) }}" class="btn btn-primary btn-sm">
                                    Add/Edit Record
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @if($checkup->patients->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No students assigned to this checkup.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
