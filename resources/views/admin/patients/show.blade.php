@extends('layouts.app')

@section('content')

<style>
    /* Scrollable content height for viewport */
    .scrollable-content {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
        padding-right: 15px;
    }

    /* Cards width */
    .card {
        width: 100%;
    }

    /* Modals responsive */
    .modal-xl {
        max-width: 95%;
    }

    /* Responsive adjustments for small screens */
    @media (max-width: 768px) {
        .scrollable-content {
            max-height: calc(100vh - 150px);
        }
        .btn-group {
            flex-direction: column;
        }
        .btn-group .btn {
            margin-bottom: 5px;
        }
    }
</style>

<div class="container-fluid mt-4">
    {{-- HEADER & ACTIONS --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 border-bottom pb-2">
        <h2 class="mb-2 mb-md-0">Patient Medical Record: <span class="text-primary">{{ $patient->first_name }} {{ $patient->last_name }}</span></h2>
        <div class="btn-group" role="group" aria-label="Record Actions">
            <a href="{{ route('admin.patients.clinic_sessions.create', $patient->user_id) }}" class="btn btn-outline-primary shadow-sm">
                <i class="fas fa-file-medical"></i> Regular Visit
            </a>
            <a href="{{ route('admin.patients.medical_histories.create', $patient->user_id) }}" class="btn btn-outline-success shadow-sm">
                <i class="fas fa-history"></i> Add Medical History
            </a>
        </div>
    </div>

    <div class="row">
        {{-- LEFT COLUMN: PERSONAL INFORMATION --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-circle"></i> Personal Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Gender:</strong> {{ $patient->gender ?? '-' }}</p>
                    <p><strong>Birth Date:</strong> {{ $patient->date_of_birth ? $patient->date_of_birth->format('F d, Y') : '-' }}</p>
                    <p><strong>Course:</strong> {{ $patient->personalInformation->course ?? '-' }}</p>
                    <p><strong>Grade Level:</strong> {{ $patient->personalInformation->grade_level ?? '-' }}</p>
                    <p><strong>Phone:</strong> {{ $patient->phone_number ?? '-' }}</p>
                    <p><strong>Address:</strong> {{ $patient->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: RECORDS --}}
        <div class="col-lg-8">
            <div class="scrollable-content">

                {{-- CLINIC VISITS --}}
                @php
                    $recentClinics = $patient->clinicSessions->sortByDesc('created_at')->take(5);
                @endphp
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-stethoscope"></i> Clinic Visits</h4>
                        @if($patient->clinicSessions->isNotEmpty())
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#clinicModalAll">
                                View All Details
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if($recentClinics->isEmpty())
                            <p class="text-muted mb-0 p-3">No clinic visits found.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($recentClinics as $clinic)
                                    <li class="list-group-item small">
                                        {{ $clinic->session_date ? \Carbon\Carbon::parse($clinic->session_date)->format('F d, Y') : '-' }} - {{ $clinic->reason ?? '-' }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- CLINIC MODAL --}}
                <div class="modal fade" id="clinicModalAll" tabindex="-1" aria-labelledby="clinicModalAllLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="clinicModalAllLabel">All Clinic Visits</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @foreach($patient->clinicSessions->sortByDesc('created_at') as $clinic)
                                    <div class="p-3 mb-3 border rounded bg-light">
                                        <p><strong>Date:</strong> {{ $clinic->session_date ? \Carbon\Carbon::parse($clinic->session_date)->format('F d, Y') : '-' }}</p>
                                        <p><strong>Reason:</strong> {{ $clinic->reason ?? '-' }}</p>
                                        <p><strong>Remedy:</strong> {{ $clinic->remedy ?? '-' }}</p>
                                        <p><strong>Incharge:</strong> {{ $clinic->admin->first_name ?? '-' }} {{ $clinic->admin->last_name ?? '' }}</p>
                                        <p><strong>License Type:</strong> {{ $clinic->admin->credential->license_type ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MEDICAL HISTORIES --}}
                @php
                    $recentHistories = $patient->medicalHistories->sortByDesc('created_at')->take(5);
                @endphp
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-book-medical"></i> Medical Histories</h4>
                        @if($patient->medicalHistories->isNotEmpty())
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#historyModalAll">
                                View All Details
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if($recentHistories->isEmpty())
                            <p class="text-muted mb-0 p-3">No medical histories found.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($recentHistories as $history)
                                    <li class="list-group-item small">
                                        {{ $history->date_recorded ? \Carbon\Carbon::parse($history->date_recorded)->format('F d, Y') : '-' }} - {{ $history->history_type ?? '-' }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- MEDICAL HISTORY MODAL --}}
                <div class="modal fade" id="historyModalAll" tabindex="-1" aria-labelledby="historyModalAllLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="historyModalAllLabel">All Medical Histories</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @foreach($patient->medicalHistories->sortByDesc('created_at') as $history)
                                    <div class="p-3 mb-3 border rounded bg-light">
                                        <p><strong>Date:</strong> {{ $history->date_recorded ? \Carbon\Carbon::parse($history->date_recorded)->format('F d, Y') : '-' }}</p>
                                        <p><strong>Type:</strong> {{ $history->history_type ?? '-' }}</p>
                                        <p><strong>Description:</strong> {{ $history->description ?? '-' }}</p>
                                        <p><strong>Doctor's Notes:</strong> {{ $history->notes ?? '-' }}</p>
                                        <p><strong>Incharge:</strong> {{ $history->admin->first_name ?? '-' }} {{ $history->admin->last_name ?? '' }}</p>
                                        <p><strong>License Type:</strong> {{ $history->admin->credential->license_type ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHECKUPS --}}
                @php
                    $recentCheckups = $patient->checkups->sortByDesc('date')->take(5);
                @endphp
                <div class="card mb-5 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-heartbeat"></i> Checkups</h4>
                        @if($patient->checkups->isNotEmpty())
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#checkupModalAll">
                                View All Details
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if($recentCheckups->isEmpty())
                            <p class="text-muted mb-0 p-3">No checkups found.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($recentCheckups as $checkup)
                                    <li class="list-group-item small">
                                        {{ $checkup->date ? \Carbon\Carbon::parse($checkup->date)->format('F d, Y') : '-' }} - {{ $checkup->checkup_type ?? '-' }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- CHECKUP MODAL --}}
                <div class="modal fade" id="checkupModalAll" tabindex="-1" aria-labelledby="checkupModalAllLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="checkupModalAllLabel">All Checkups</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @foreach($patient->checkups->sortByDesc('date') as $checkup)
                                    <div class="p-3 mb-3 border rounded bg-light">
                                        <p><strong>Date:</strong> {{ $checkup->date ? \Carbon\Carbon::parse($checkup->date)->format('F d, Y') : '-' }}</p>
                                        <p><strong>Type:</strong> {{ $checkup->checkup_type ?? '-' }}</p>
                                        <p><strong>Notes:</strong> {{ $checkup->notes ?? '-' }}</p>
                                        <p><strong>Incharge:</strong> {{ $checkup->staff->first_name ?? '-' }} {{ $checkup->staff->last_name ?? '' }}</p>
                                        <p><strong>License Type:</strong> {{ $checkup->staff->credential->license_type ?? '-' }}</p>
                                        @php $checkupPatients = $checkup->checkupPatients ?? collect(); @endphp
                                        @foreach($checkupPatients as $cp)
                                            @if($cp->vitals->isNotEmpty())
                                                @php $vital = $cp->vitals->first(); @endphp
                                                <hr>
                                                <strong>Vitals:</strong>
                                                <p>H/W: {{ $vital->height ?? '-' }}cm / {{ $vital->weight ?? '-' }}kg</p>
                                                <p>BP: {{ $vital->blood_pressure ?? '-' }}</p>
                                                <p>Pulse: {{ $vital->pulse_rate ?? '-' }}</p>
                                                <p>Temp: {{ $vital->temperature ?? '-' }}°C</p>
                                                <p>BMI: {{ $vital->bmi ?? '-' }}</p>
                                            @endif
                                            @if($cp->dentals->isNotEmpty())
                                                @php $dental = $cp->dentals->first(); @endphp
                                                <hr>
                                                <strong>Dental:</strong>
                                                <p>Status: {{ $dental->dental_status ?? '-' }}</p>
                                                <p>Treatment: {{ $dental->treatment_type ?? '-' }} (Needs: {{ $dental->needs_treatment ?? '-' }})</p>
                                                <p>Notes: {{ $dental->note ?? '-' }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 
        </div> 
    </div> 
</div>

@endsection
