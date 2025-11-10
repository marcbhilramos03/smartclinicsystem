@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold text-dark mb-2 mb-md-0">
            <i class="fas fa-notes-medical me-2 text-dark"></i>
            All Medical Records of {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
        <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-outline-dark shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Card Wrapper --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-file-medical-alt me-2"></i> Patient Medical History
            </h5>
        </div>

        <div class="card-body bg-light">
            @if($medicalHistories->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Date Recorded</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Recorded By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicalHistories as $history)
                                <tr>
                                    <td>
                                        {{ $history->date_recorded 
                                            ? \Carbon\Carbon::parse($history->date_recorded)->format('F d, Y') 
                                            : '(no date)' }}
                                    </td>
                                    <td class="fw-semibold text-dark">{{ $history->history_type ?? '-' }}</td>
                                    <td>{{ $history->description ?? '-' }}</td>
                                    <td>
                                        {{ $history->admin->first_name ?? '-' }} {{ $history->admin->last_name ?? '' }}
                                        <small class="text-muted d-block">
                                            {{ $history->admin->credential->license_type ?? '-' }}
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
                    No medical histories found for this student.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- INTERNAL STYLES --}}
<style>
/* General styling */
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
}

/* Card styling */
.card {
    border-radius: 12px;
    transition: 0.3s ease;
}


/* Card header */
.card-header {
    background: linear-gradient(90deg, #000, #333);
    font-weight: 600;
    border-bottom: none;
}

/* Table styling */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(90deg, #000, #343a40);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.table tbody tr:hover {
    background-color: #e9ecef;
    transition: 0.2s;
}

/* Table cells */
.table td {
    padding: 0.8rem;
    vertical-align: middle;
    color: #212529;
}

/* Buttons */
.btn {
    border-radius: 8px;
    transition: all 0.2s ease-in-out;
}

.btn-outline-dark:hover {
    background-color: #000;
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
