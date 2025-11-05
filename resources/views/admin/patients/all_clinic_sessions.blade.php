@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-dark mb-2 mb-md-0">
            <i class="fas fa-briefcase-medical me-2 text-secondary"></i> 
            All Clinic Visits of {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
        <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Card Wrapper --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-notes-medical me-2"></i> Clinic Session Records
            </h5>
        </div>

        <div class="card-body">
            @if($clinicSessions->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark text-white">
                            <tr>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Remedy</th>
                                <th>Recorded By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clinicSessions as $clinic)
                                <tr>
                                    <td>
                                        {{ $clinic->session_date 
                                            ? \Carbon\Carbon::parse($clinic->session_date)->format('F d, Y') 
                                            : '-' }}
                                    </td>
                                    <td>{{ $clinic->reason ?? '-' }}</td>
                                    <td>{{ $clinic->remedy ?? '-' }}</td>
                                    <td>
                                        {{ $clinic->admin->first_name ?? '-' }} {{ $clinic->admin->last_name ?? '' }}
                                        <small class="text-muted d-block">
                                            {{ $clinic->admin->credential->license_type ?? '-' }}
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
                    No clinic visits found for this patient.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- INTERNAL STYLES --}}
<style>
body {
    background-color: #f4f4f4;
    font-family: 'Poppins', sans-serif;
}

.card {
    border-radius: 12px;
    transition: 0.3s ease;
}
.card-header {
    background: linear-gradient(90deg, #212529, #343a40);
    border-bottom: none;
    font-weight: 600;
}

/* Table styling */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(90deg, #343a40, #212529);
    color: #f8f9fa;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.table tbody tr:hover {
    background-color: #e9ecef;
    transition: 0.2s;
}

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
    background-color: #212529;
    color: #fff;
}

/* Responsive */
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
