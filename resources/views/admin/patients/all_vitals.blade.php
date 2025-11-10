@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-primary mb-2 mb-md-0">
            <i class="fas fa-heartbeat me-2"></i> 
            All Vitals of {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
        <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Card Wrapper --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i> Patient Vital Records</h5>
        </div>

        <div class="card-body">
            @if($vitals->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th>Date</th>
                                <th>Height (cm)</th>
                                <th>Weight (kg)</th>
                                <th>BP</th>
                                <th>Pulse</th>
                                <th>Temp (°C)</th>
                                <th>Resp. Rate</th>
                                <th>BMI</th>
                                <th>Recorded by</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vitals as $v)
                                <tr>
                                    <td>
                                        {{ optional($v->checkupPatient->checkup)->date 
                                            ? \Carbon\Carbon::parse($v->checkupPatient->checkup->date)->format('F d, Y') 
                                            : '-' }}
                                    </td>
                                    <td>{{ $v->height ?? '-' }}</td>
                                    <td>{{ $v->weight ?? '-' }}</td>
                                    <td>{{ $v->blood_pressure ?? '-' }}</td>
                                    <td>{{ $v->pulse_rate ?? '-' }}</td>
                                    <td>{{ $v->temperature ?? '-' }}</td>
                                    <td>{{ $v->respiratory_rate ?? '-' }}</td>
                                    <td class="fw-semibold text-primary">{{ $v->bmi ?? '-' }}</td>
                                    <td>
                                        {{ optional($v->checkupPatient->checkup->staff)->first_name ?? '-' }}
                                        {{ optional($v->checkupPatient->checkup->staff)->last_name ?? '' }}
                                        <small class="text-muted d-block">
                                            {{ optional($v->checkupPatient->checkup->staff)->credential->license_type ?? '' }}
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle me-1"></i> 
                    No vitals found for this student.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- INTERNAL STYLES --}}
<style>
/* Overall look */
body {
    background-color: #f8f9fc;
    font-family: 'Poppins', sans-serif;
}

/* Card styling */
.card {
    border-radius: 12px;
    transition: 0.3s ease;
}


/* Card header */
.card-header {
    background: linear-gradient(90deg, #007bff, #0056b3);
    font-weight: 600;
    border-bottom: none;
}

/* Table styling */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(90deg, #e3f2fd, #bbdefb);
    color: #212529;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.table tbody tr:hover {
    background-color: #f1f3f5;
    transition: 0.2s;
}

/* Table cells */
.table td {
    padding: 0.8rem;
    vertical-align: middle;
}

/* Buttons */
.btn {
    border-radius: 8px;
    transition: all 0.2s ease-in-out;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #fff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header h5 {
        font-size: 1rem;
    }

    h2 {
        font-size: 1.3rem;
    }

    .table {
        font-size: 0.85rem;
    }

    .btn {
        width: 100%;
        margin-top: 10px;
    }
}
</style>
@endsection
