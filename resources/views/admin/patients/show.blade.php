@extends('layouts.app')

@section('content')

<style>
    body {
    background-color: #f8f9fc;
    font-family: 'Poppins', sans-serif;
}

/* Section spacing */
.container, .row {
    margin-top: 10px;
}

/* ===== CARD STYLING ===== */
.card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}


.card-header {
    font-weight: 600;
    padding: 0.75rem 1rem;
}

.card-header.bg-light {
    background: linear-gradient(90deg, #f8f9fa, #f1f1f1);
    border-bottom: 2px solid #e2e6ea;
}

.card-header.bg-primary {
    background: linear-gradient(90deg, #007bff, #0056b3);
    border-bottom: none;
}

.card-header h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

/* ===== PERSONAL INFO SECTION ===== */
.card-body p {
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.card-body strong {
    color: #495057;
}

/* ===== BUTTONS ===== */
.btn {
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-sm {
    font-size: 0.85rem;
    padding: 0.35rem 0.75rem;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.btn-outline-success:hover {
    background-color: #198754;
    color: #fff;
    border-color: #198754;
}

.btn-light {
    background-color: #f8f9fa;
    border: 1px solid #d6d8db;
}

.btn-light:hover {
    background-color: #e2e6ea;
}

.btn-primary,
.btn-success {
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.btn-primary:hover,
.btn-success:hover {
    transform: scale(1.03);
}

/* ===== TABLE STYLING ===== */
.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    background-color: #e9ecef;
    color: #343a40;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
    text-transform: uppercase;
    font-size: 0.9rem;
}

.table tbody tr:hover {
    background-color: #f1f3f5;
}

.table td, .table th {
    padding: 0.75rem 1rem;
}

/* ===== MODAL STYLING ===== */
.modal-content {
    border-radius: 12px;
}

.modal-header {
    background: linear-gradient(90deg, #007bff, #0056b3);
    border-bottom: none;
}

.modal-title {
    font-weight: 600;
}

.modal-body p {
    margin-bottom: 6px;
    font-size: 0.95rem;
}

.modal-footer {
    border-top: none;
}

/* ===== SCROLLABLE CONTENT ===== */
.scrollable-content {
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    padding-right: 15px;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 991px) {
    .scrollable-content {
        max-height: none;
        overflow: visible;
        padding-right: 0;
    }
}

@media (max-width: 768px) {
    .card-header h4 {
        font-size: 1rem;
    }

    .btn-group,
    .d-flex.flex-wrap {
        flex-direction: column;
    }

    .btn-group .btn,
    .d-flex.flex-wrap .btn {
        width: 100%;
        text-align: center;
    }

    .table {
        font-size: 0.85rem;
    }

    .btn-sm {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
    }
}
</style>

<div class="row g-3">
    {{-- LEFT COLUMN: PERSONAL INFORMATION --}}
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i> Personal Information</h4>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <p style="font-size:20px;m, font-weight:10px;"><strong>Name:</strong> {{ $patient->first_name ?? '-' }} {{ $patient->middle_name ?? '' }} {{ $patient->last_name ?? '-' }}</p>
                    <p><strong>School ID:</strong> {{ $patient->school_id ?? '-' }}</p>
                    <p><strong>Gender:</strong> {{ $patient->gender ?? '-' }}</p>
                    <p><strong>Course:</strong> {{ $patient->personalInformation->course ?? '-' }}</p>
                    <p><strong>Grade Level:</strong> {{ $patient->personalInformation->grade_level ?? '-' }}</p>
                    <p><strong>Phone:</strong> {{ $patient->phone_number ?? '-' }}</p>
                </div>

                {{-- View Details Button --}}
                <div class="text-center mb-3">
                    <button 
                        class="btn btn-light d-inline-flex align-items-center btn-sm shadow-sm rounded-3 px-3" 
                        data-bs-toggle="modal" 
                        data-bs-target="#patientInfoModal"
                    >
                        <i class="fas fa-eye me-2 text-primary"></i>
                        <span>View Details</span>
                    </button>
                </div>

                <hr class="my-3">

                {{-- Record Actions --}}
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.patients.clinic_sessions.create', $patient->user_id) }}" 
                       class="btn btn-outline-primary shadow-sm flex-fill text-nowrap">
                        <i class="fas fa-file-medical me-1"></i> Regular Visit
                    </a>

                    <a href="{{ route('admin.patients.medical_histories.create', $patient->user_id) }}" 
                       class="btn btn-outline-success shadow-sm flex-fill text-nowrap">
                        <i class="fas fa-history me-1"></i> Add Medical History
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: RECORDS --}}
    <div class="col-lg-8">
        <div class="scrollable-content">
            {{-- CLINIC SESSIONS --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-stethoscope"></i> Clinic Visits</h4>
                    @if($clinicSessions->count())
                        <a href="{{ route('admin.patients.all_clinic_sessions', $patient->user_id) }}" class="btn btn-sm btn-info">
                            View All
                        </a>
                    @endif
                </div>

                <div class="card-body p-0">
                    @if($clinicSessions->count())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
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
                                            <td>{{ $clinic->session_date ? \Carbon\Carbon::parse($clinic->session_date)->format('F d, Y') : '-' }}</td>
                                            <td>{{ $clinic->reason ?? '-' }}</td>
                                            <td>{{ $clinic->remedy ?? '-' }}</td>
                                            <td>{{ $clinic->admin->first_name ?? '-' }} {{ $clinic->admin->last_name ?? '' }} {{ $clinic->admin->credential->license_type ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 px-3">{{ $clinicSessions->links('pagination::bootstrap-5') }}</div>
                    @else
                        <p class="text-muted p-3 mb-0">No clinic visits found.</p>
                    @endif
                </div>
            </div>

            {{-- MEDICAL HISTORIES --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-book-medical"></i> Medical Histories</h4>
                    @if($medicalHistories->count())
                        <a href="{{ route('admin.patients.all_medical_histories', $patient->user_id) }}" class="btn btn-sm btn-info">
                            View All
                        </a>
                    @endif
                </div>

                <div class="card-body p-0">
                    @if($medicalHistories->count())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
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
                                            <td>{{ $history->date_recorded ? \Carbon\Carbon::parse($history->date_recorded)->format('F d, Y') : '(𝘯𝘰 𝘥𝘢𝘵𝘦)' }}</td>
                                            <td>{{ $history->history_type ?? '-' }}</td>
                                            <td>{{ $history->description ?? '-' }}</td>
                                            <td>{{ $history->admin->first_name ?? '-' }} {{ $history->admin->last_name ?? '' }} {{ $history->admin->credential->license_type ?? '-' }}</td>
                                         
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 px-3">{{ $medicalHistories->links('pagination::bootstrap-5') }}</div>
                    @else
                        <p class="text-muted p-3 mb-0">No medical histories found.</p>
                    @endif
                </div>
            </div>

            {{-- CHECKUPS --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-heartbeat"></i> Checkups</h4>
                    @if($checkups->count())
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('admin.patients.all_vitals', $patient->user_id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-heartbeat"></i> View All Vitals
                            </a>
                            <a href="{{ route('admin.patients.all_dentals', $patient->user_id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-tooth"></i> View All Dentals
                            </a>
                        </div>
                    @endif
                </div>

                <div class="card-body p-0">
                    @if($checkups->count())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Notes</th>
                                        <th>Perfomed By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($checkups as $checkup)
                                        <tr>
                                            <td>{{ $checkup->date ? \Carbon\Carbon::parse($checkup->date)->format('F d, Y') : '-' }}</td>
                                            <td>{{ $checkup->checkup_type ?? '-' }}</td>
                                            <td>{{ $checkup->notes ?? '-' }}</td>
                                            <td>{{ $checkup->staff->first_name ?? '-' }} {{ $checkup->staff->last_name ?? '' }} {{ $checkup->staff->credential->license_type ?? '-' }}
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 px-3">{{ $checkups->links('pagination::bootstrap-5') }}</div>
                    @else
                        <p class="text-muted p-3 mb-0">No checkups found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PATIENT INFO MODAL --}}
<div class="modal fade" id="patientInfoModal" tabindex="-1" aria-labelledby="patientInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user"></i> Full Patient Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}</p>
                        <p><strong>School ID:</strong> {{ $patient->school_id ?? '-' }}</p>
                        <p><strong>Gender:</strong> {{ $patient->gender ?? '-' }}</p>
                        <p><strong>Birth Date:</strong> {{ $patient->date_of_birth ? $patient->date_of_birth->format('F d, Y') : '-' }}</p>
                        <p><strong>Address:</strong> {{ $patient->address ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Course:</strong> {{ $patient->personalInformation->course ?? '-' }}</p>
                        <p><strong>Grade Level:</strong> {{ $patient->personalInformation->grade_level ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $patient->phone_number ?? '-' }}</p>
                    </div>
                </div>
                <hr>
                <h6><i class="fas fa-phone-alt"></i> Emergency Contact</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $patient->personalInformation->emer_con_name ?? '-' }}</p>
                        <p><strong>Relationship:</strong> {{ $patient->personalInformation->emer_con_rel ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Phone:</strong> {{ $patient->personalInformation->emer_con_phone ?? '-' }}</p>
                        <p><strong>Address:</strong> {{ $patient->personalInformation->emer_con_address ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
