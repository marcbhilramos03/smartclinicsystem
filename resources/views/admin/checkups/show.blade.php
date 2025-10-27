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
                <div class="col-md-3"><strong>Perfomed By:</strong> {{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}  {{ $checkup->staff->credential->license_type }}</div>
                <div class="col-md-3"><strong>Type:</strong> {{ ucfirst($checkup->checkup_type) }}</div>
                <div class="col-md-3"><strong>Notes:</strong> {{ $checkup->notes ?? '𝘯𝘰 𝘯𝘰𝘵𝘦𝘴' }}</div>
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
                    @php
                        // Fetch the matching checkup_patient record for this student
                        $checkupPatient = \App\Models\CheckupPatient::where('checkup_id', $checkup->id)
                            ->where('patient_id', $student->user_id)
                            ->first();

                        $status = $checkupPatient->status ?? 'pending';
                    @endphp

                    <tr class="text-center">
                        <td class="text-start">{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->personalInformation->course ?? 'N/A' }}</td>
                        <td>{{ $student->personalInformation->grade_level ?? 'N/A' }}</td>
                        <td>
                            <span class="badge 
                                @if($status == 'completed') bg-success
                                @elseif($status == 'incomplete') bg-warning text-dark
                                @else bg-secondary @endif">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td>
                            @if($checkupPatient)
                                <a href="{{ route('admin.checkups.edit_patient', $checkupPatient->id) }}" 
                                   class="btn btn-primary btn-sm">
                                   Fill Record
                                </a>
                            @else
                                <span class="text-muted">No record</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
