@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-success mb-2 mb-md-0">
            <i class="fas fa-tooth me-2"></i>
            All Dental Records of {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
        <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Card Wrapper --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-tooth me-2"></i> Patient Dental Records
            </h5>
        </div>

        <div class="card-body">
            @if($dentals->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-success text-dark">
                            <tr>
                                <th>Date</th>
                                <th>Dental Status</th>
                                <th>Need Treatment</th>
                                <th>Treatment Type</th>
                                <th>Note</th>
                                <th>Performed By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dentals as $d)
                                <tr>
                                    <td>
                                        {{ optional($d->checkupPatient->checkup)->date 
                                            ? \Carbon\Carbon::parse($d->checkupPatient->checkup->date)->format('F d, Y') 
                                            : '-' }}
                                    </td>
                                    <td>{{ $d->dental_status ?? '-' }}</td>
                                    <td>{{ $d->needs_treatment ?? '-' }}</td>
                                    <td>{{ $d->treatment_type ?? '(𝘯𝘰 𝘯𝘰𝘵𝘦𝘴)' }}</td>
                                    <td>{{ $d->note ?? '-' }}</td>
                                    <td>
                                        {{ optional($d->checkupPatient->checkup->staff)->first_name ?? '-' }}
                                        {{ optional($d->checkupPatient->checkup->staff)->last_name ?? '' }}
                                        <small class="text-muted d-block">
                                            {{ optional($d->checkupPatient->checkup->staff)->credential->license_type ?? '' }}
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
                    No dental records found for this patient.
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
    background: linear-gradient(90deg, #28a745, #1e7e34);
    font-weight: 600;
    border-bottom: none;
}

/* Table styling */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(90deg, #d4edda, #c3e6cb);
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
