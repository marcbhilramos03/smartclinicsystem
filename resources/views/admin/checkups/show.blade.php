@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Checkup Details</h2>
        <a href="{{ route('admin.checkups.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>Date:</strong> {{ $checkup->date }}</div>
                <div class="col-md-3"><strong>Staff:</strong> {{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}</div>
                <div class="col-md-3"><strong>Type:</strong> {{ ucfirst($checkup->checkup_type) }}</div>
                <div class="col-md-3"><strong>Notes:</strong> {{ $checkup->notes ?? '-' }}</div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Assigned Students</h4>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Grade</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkup->patients as $student)
                <tr class="text-center">
                    <td class="text-start">{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->personalInformation->course ?? 'N/A' }}</td>
                    <td>{{ $student->personalInformation->grade_level ?? 'N/A' }}</td>
                    <td>
                        @php
                            // Example status logic; replace with real status if available
                            $status = $student->pivot->status ?? 'Pending';
                        @endphp
                        <span class="badge 
                            @if($status == 'Completed') bg-success
                            @elseif($status == 'Pending') bg-warning
                            @elseif($status == 'In Progress') bg-info
                            @else bg-secondary @endif">
                            {{ $status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.checkups.edit_patient', $student->pivot->id) }}" class="btn btn-primary btn-sm">
                            Fill Record
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
