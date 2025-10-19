@extends('layouts.app')

@section('page-title', 'Patient Record')

@section('content')
<style>
    /* Make layout full-width */
    .container-fluid {
        max-width: 100%;
    }

    /* Card styling */
    .custom-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    /* Section headers */
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
    }

    /* Table styling */
    table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
    }

    table td {
        vertical-align: middle;
    }

    /* Soft card background */
    .bg-soft {
        background-color: #f9fafc;
    }
</style>

<div class="container-fluid mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="bi bi-person-vcard"></i> Patient Record: {{ $user->first_name }} {{ $user->last_name }}
        </h1>
        <a href="{{ route('admin.patients.records.create', $user) }}" class="btn btn-success px-4 py-2 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Record
        </a>
    </div>

    {{-- Personal Information --}}
    <div class="custom-card mb-4 bg-soft">
        <div class="card-header bg-primary text-white">
            Personal Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4"><strong>Name:</strong> {{ $user->first_name }} {{ $user->middle_name ?? '' }} {{ $user->last_name }}</div>
                <div class="col-md-4"><strong>School ID:</strong> {{ $user->personalInformation->school_id ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Course/Grade:</strong> {{ $user->personalInformation->courseInformation->course ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Age:</strong>
                    @if($user->personalInformation && $user->personalInformation->birthdate)
                        {{ \Carbon\Carbon::parse($user->personalInformation->birthdate)->age }} years
                    @else
                        N/A
                    @endif
                </div>
                <div class="col-md-4"><strong>Birthdate:</strong> {{ $user->personalInformation->birthdate ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Gender:</strong> {{ ucfirst($user->personalInformation->gender) ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Address:</strong> {{ $user->personalInformation->address ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Contact Number:</strong> {{ $user->personalInformation->contact_number ?? 'N/A' }}</div>
            </div>

            <h5 class="mt-3">Emergency Contacts</h5>
@if($user->personalInformation->emergencyContacts && $user->personalInformation->emergencyContacts->isNotEmpty())
    <div class="row g-3 mt-2">
        @foreach($user->personalInformation->emergencyContacts as $contact)
                    <p class="col mb-4"><strong>Name:</strong> {{ $contact->name }}</p>
                    <p class="col mb-4"><strong>Relationship:</strong> {{ $contact->relationship }}</p>
                    <p class="colmb-4"><strong>Contact No:</strong> {{ $contact->phone_number }}</p>
                
        @endforeach
    </div>
@else
    <p class="text-muted">No emergency contacts available.</p>
@endif

    </div>

    {{-- Clinic Sessions --}}
    <div class="custom-card mb-4">
        <div class="card-header bg-info text-white">Clinic Sessions</div>
        <div class="card-body">
            @if($clinicSessions->isEmpty())
                <p class="text-muted">No clinic sessions recorded.</p>
            @else
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Handled By</th>
                            <th>Reason</th>
                            <th>Remedy / Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clinicSessions as $session)
                            <tr>
                                <td>{{ $session->session_date }}</td>
                                <td>{{ $session->admin->first_name ?? '' }} {{ $session->admin->last_name ?? '' }}</td>
                                <td>{{ $session->reason }}</td>
                                <td>{{ $session->remedy ?? '-' }}</td>
                            </tr>
                            @if($session->medications && $session->medications->isNotEmpty())
                                <tr>
                                    <td colspan="4">
                                        <div class="bg-light p-2 rounded">
                                            <strong>Medications Prescribed:</strong>
                                            <table class="table table-sm table-bordered mt-2">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Medicine</th>
                                                        <th>Dosage</th>
                                                        <th>Duration</th>
                                                        <th>Qty Used</th>
                                                        <th>Current Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($session->medications as $med)
                                                        <tr>
                                                            <td>{{ $med->inventory->item_name ?? 'N/A' }}</td>
                                                            <td>{{ $med->dosage ?? '-' }}</td>
                                                            <td>{{ $med->duration ?? '-' }}</td>
                                                            <td>{{ $med->quantity }}</td>
                                                            <td>{{ $med->inventory->quantity ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Checkups --}}
    <div class="custom-card mb-4">
        <div class="card-header bg-success text-white">Checkup Records</div>
        <div class="card-body">
            @if($checkups->isEmpty())
                <p class="text-muted">No checkup records found.</p>
            @else
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Findings</th>
                            <th>Recommendations</th>
                            <th>Checked By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkups as $checkup)
                            <tr>
                                <td>{{ $checkup->date }}</td>
                                <td>{{ ucfirst($checkup->type ?? '-') }}</td>
                                <td>{{ $checkup->findings ?? '-' }}</td>
                                <td>{{ $checkup->recommendations ?? '-' }}</td>
                                <td>{{ $checkup->admin->first_name ?? '' }} {{ $checkup->admin->last_name ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Medical Histories --}}
    <div class="custom-card mb-4">
        <div class="card-header bg-warning text-dark">Medical Histories</div>
        <div class="card-body">
            @if($medicalHistories->isEmpty())
                <p class="text-muted">No medical histories recorded.</p>
            @else
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Date Recorded</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicalHistories as $history)
                            <tr>
                                <td>{{ ucfirst($history->history_type) }}</td>
                                <td>{{ $history->description }}</td>
                                <td>{{ $history->date_recorded }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
