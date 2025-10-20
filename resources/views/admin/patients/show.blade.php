@extends('layouts.app')

@section('page-title', 'Patient Record')

@section('content')
<style>
    /* Global Styling for the page */
    body {
        background-color: #f4f7f6; /* Light background for the page */
    }

    /* Container full width */
    .container-fluid {
        max-width: 100%;
    }

    /* Cards - Modern look */
    .custom-card {
        border: none; /* Remove default border */
        border-radius: 16px; /* Slightly more rounded corners */
        box-shadow: 0 6px 15px rgba(0,0,0,0.1); /* Stronger, softer shadow */
        margin-bottom: 2.5rem; /* Increased margin for better separation */
        overflow: hidden; /* Ensures header background covers corners */
    }

    .card-header {
        font-weight: 700; /* Bolder header text */
        font-size: 1.25rem; /* Slightly larger text */
        padding: 1rem 1.5rem;
        border-bottom: none; /* Remove border */
    }

    .section-title {
        font-weight: 700;
        color: #1f3e5b; /* Darker, more professional title color */
        margin-bottom: 1.5rem;
        border-left: 6px solid #0d6efd; /* Accent color */
        padding-left: 15px;
        font-size: 1.35rem;
    }

    /* Table Styling */
    table th {
        background-color: #e9ecef; /* Light gray header */
        font-weight: 600;
        color: #495057;
        border-top: none;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
    }

    /* Detail Boxes in Modal */
    .detail-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 5px solid #0d6efd;
        height: 100%; /* Ensure boxes fill vertical space */
    }
    .detail-box h6 {
        font-weight: 700;
        color: #0d6efd;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .detail-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .detail-list li {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 0.95rem;
        border-bottom: 1px dotted #e9ecef;
    }

    .detail-list li:last-child {
        border-bottom: none;
    }

    .detail-list strong {
        color: #495057;
        font-weight: 600;
    }

    /* Badges */
    .badge-primary-custom { background-color: #0d6efd !important; }
    .badge-info-custom { background-color: #0dcaf0 !important; }
    .badge-success-custom { background-color: #198754 !important; }
    .badge-warning-custom { background-color: #ffc107 !important; color: #212529 !important; }

    /* Info Box for Personal Info */
    .info-box {
        background: white;
        padding: 1.2rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        transition: transform 0.2s;
    }

    .info-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .info-box strong {
        color: #0d6efd;
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .info-box span {
        display: block;
        font-size: 1rem;
        color: #212529;
    }

    /* Medication Table */
    .medication-section {
        background-color: #e9f5ff;
        border-radius: 10px;
        padding: 15px;
        margin-top: 10px;
    }
</style>

<div class="container-fluid mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <h1 class="fw-bolder text-dark mb-0">
            <i class="bi bi-person-vcard text-primary me-2"></i> Patient Record: <span class="text-primary">{{ $user->first_name }} {{ $user->last_name }}</span>
        </h1>
        <a href="{{ route('admin.patients.records.create', $user) }}" class="btn btn-primary shadow-lg px-4 py-2 rounded-pill">
            <i class="bi bi-plus-circle me-1"></i> Add New Record
        </a>
    </div>

    {{-- Personal Information --}}
    <div class="card custom-card">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-person-fill me-2"></i> Personal Information
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Name:</strong>
                        <span>{{ $user->first_name }} {{ $user->middle_name ?? '' }} {{ $user->last_name }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>School ID:</strong>
                        <span>{{ $user->personalInformation->school_id ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Course/Grade:</strong>
                        <span>{{ $user->personalInformation->course->course ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Age:</strong>
                        <span>{{ $user->personalInformation && $user->personalInformation->birthdate ? \Carbon\Carbon::parse($user->personalInformation->birthdate)->age . ' years' : 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Birthdate:</strong>
                        <span>{{ $user->personalInformation->birthdate ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Gender:</strong>
                        <span>{{ ucfirst($user->personalInformation->gender) ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Contact Number:</strong>
                        <span>{{ $user->personalInformation->contact_number ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <strong>Address:</strong>
                        <span>{{ $user->personalInformation->address ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <h5 class="section-title">Emergency Contacts</h5>
            @if($user->personalInformation->emergencyContacts && $user->personalInformation->emergencyContacts->isNotEmpty())
                <div class="row g-4 mt-2">
                    @foreach($user->personalInformation->emergencyContacts as $contact)
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <strong>Contact Name:</strong>
                                <span>{{ $contact->name }}</span>
                                <strong>Relationship:</strong>
                                <span>{{ $contact->relationship }}</span>
                                <strong>Contact No:</strong>
                                <span>{{ $contact->phone_number }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted fst-italic">No emergency contacts available.</p>
            @endif
        </div>
    </div>

    ---

    {{-- Clinic Sessions --}}
    <div class="card custom-card">
        <div class="card-header bg-info text-white">
            <i class="bi bi-clock-history me-2"></i> Clinic Sessions
        </div>
        <div class="card-body">
            @if($clinicSessions->isEmpty())
                <p class="text-muted fst-italic">No clinic sessions recorded for this patient.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 15%;">Handled By</th>
                                <th style="width: 30%;">Reason for Visit</th>
                                <th style="width: 45%;">Remedy / Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clinicSessions as $session)
                                <tr class="table-light">
                                    <td><span class="badge badge-info-custom">{{ $session->session_date }}</span></td>
                                    <td>{{ $session->admin->first_name ?? '' }} {{ $session->admin->last_name ?? '' }}</td>
                                    <td>{{ $session->reason }}</td>
                                    <td>{{ $session->remedy ?? '-' }}</td>
                                </tr>
                                @if($session->medications && $session->medications->isNotEmpty())
                                    <tr>
                                        <td colspan="4" class="p-0 border-0">
                                            <div class="medication-section">
                                                <h6 class="text-primary mb-2 fw-bold">Medications Prescribed:</h6>
                                                <table class="table table-sm table-bordered mb-0">
                                                    <thead class="table-primary">
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
                                                                <td><span class="badge bg-danger">{{ $med->quantity }}</span></td>
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
                </div>
            @endif
        </div>
    </div>

    ---

    {{-- Medical Histories --}}
    <div class="card custom-card">
        <div class="card-header bg-warning text-dark">
            <i class="bi bi-heart-pulse-fill me-2"></i> Medical Histories
        </div>
        <div class="card-body">
            @if($medicalHistories->isEmpty())
                <p class="text-muted fst-italic">No medical histories recorded.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Type</th>
                                <th style="width: 65%;">Description</th>
                                <th style="width: 20%;">Date Recorded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicalHistories as $history)
                                <tr>
                                    <td><span class="badge badge-warning-custom">{{ ucfirst($history->history_type) }}</span></td>
                                    <td>{{ $history->description }}</td>
                                    <td>{{ $history->date_recorded }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    ---

    {{-- Checkups (MODIFIED FOR MODAL) --}}
    <div class="card custom-card">
        <div class="card-header bg-success text-white">
            <i class="bi bi-clipboard-check-fill me-2"></i> Checkup Records
        </div>
        <div class="card-body">
            @if($checkups->isEmpty())
                <p class="text-muted fst-italic">No checkup records found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Handled By</th>
                                <th style="width: 15%;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkups as $cp)
                                <tr>
                                    <td><span class="badge badge-success-custom">{{ $cp->checkup->date ?? '-' }}</span></td>
                                    <td>{{ ucfirst($cp->checkup->checkup_type ?? '-') }}</td>
                                    <td>{{ $cp->checkup->staff->first_name ?? '' }} {{ $cp->checkup->staff->last_name ?? '' }}</td>

                                    {{-- Action Button to Open Modal --}}
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#checkupDetailModal"
                                                data-checkup-date="{{ $cp->checkup->date ?? 'N/A' }}"
                                                data-checkup-type="{{ ucfirst($cp->checkup->checkup_type ?? 'N/A') }}"
                                                data-staff-name="{{ ($cp->checkup->staff->first_name ?? '') . ' ' . ($cp->checkup->staff->last_name ?? '') }}"
                                                data-vitals='@json($cp->vitals)'
                                                data-dental='@json($cp->dental)'>
                                            <i class="bi bi-eye"></i> View Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

<div class="modal fade" id="checkupDetailModal" tabindex="-1" aria-labelledby="checkupDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="checkupDetailModalLabel"><i class="bi bi-clipboard-data me-2"></i> Checkup Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-0"><strong>Date:</strong> <span id="modal-date" class="badge bg-success"></span></p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-0"><strong>Type:</strong> <span id="modal-type" class="badge bg-info"></span></p>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Vital Signs Section --}}
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h6>Vital Signs</h6>
                            <ul class="detail-list" id="modal-vitals">
                                {{-- Vitals will be populated here by JavaScript --}}
                            </ul>
                            <p class="text-muted fst-italic mt-3" id="vitals-not-found" style="display:none;">No vital signs recorded for this checkup.</p>
                        </div>
                    </div>

                    {{-- Dental Records Section --}}
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h6>Dental Records</h6>
                            <ul class="detail-list" id="modal-dental">
                                {{-- Dental records will be populated here by JavaScript --}}
                            </ul>
                            <p class="text-muted fst-italic mt-3" id="dental-not-found" style="display:none;">No dental records found for this checkup.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript to Handle Modal Data Population (Essential for the modal logic) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkupDetailModal = document.getElementById('checkupDetailModal');
        checkupDetailModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            const button = event.relatedTarget;

            // Extract info from data-bs-* attributes
            const date = button.getAttribute('data-checkup-date');
            const type = button.getAttribute('data-checkup-type');

            // Get data-vitals and data-dental as JSON strings and parse them
            const vitalsData = JSON.parse(button.getAttribute('data-vitals'));
            const dentalData = JSON.parse(button.getAttribute('data-dental'));

            // Update modal header info
            document.getElementById('modal-date').textContent = date;
            document.getElementById('modal-type').textContent = type;
            document.getElementById('checkupDetailModalLabel').innerHTML = `<i class="bi bi-clipboard-data me-2"></i> Checkup Details (${type} on ${date})`;

            // Function to render a detail list
            const renderDetails = (data, containerId, notFoundId, mappings) => {
                const container = document.getElementById(containerId);
                const notFound = document.getElementById(notFoundId);
                container.innerHTML = ''; // Clear previous content

                if (data && Object.keys(data).length > 0) {
                    notFound.style.display = 'none';
                    for (const [key, label] of Object.entries(mappings)) {
                        let value = data[key] ?? '-';
                        let valueClass = '';

                        // Special formatting for specific fields
                        if (key === 'blood_pressure') valueClass = 'fw-bold text-danger';
                        if (key === 'bmi') valueClass = 'text-primary fw-bold';
                        if (key === 'gum_disease') value = data[key] ? 'Yes' : 'No';
                        if (key === 'oral_hygiene') value = data[key] ? 'Good' : 'Poor';

                        // Skip fields that are null/empty, except for key indicators like notes/status that might be empty
                        if (value === '-' && key !== 'notes' && key !== 'dental_status') {
                            continue;
                        }
                        
                        // Add units for vitals
                        let unit = '';
                        if (containerId === 'modal-vitals') {
                            if (key === 'height') unit = 'cm';
                            else if (key === 'weight') unit = 'kg';
                            else if (key === 'temperature') unit = '°C';
                        }
                        
                        container.innerHTML += `
                            <li>
                                <strong>${label}:</strong>
                                <span class="${valueClass}">${value} ${unit}</span>
                            </li>
                        `;
                    }
                    if (container.innerHTML === '') {
                        // If all non-essential fields were null/empty, show 'not found'
                        notFound.style.display = 'block';
                    }
                } else {
                    notFound.style.display = 'block';
                }
            };

            // Vitals Mappings
            const vitalsMappings = {
                height: 'Height',
                weight: 'Weight',
                blood_pressure: 'Blood Pressure',
                pulse_rate: 'Pulse Rate',
                temperature: 'Temperature',
                respiratory_rate: 'Respiratory Rate',
                bmi: 'BMI',
            };

            // Dental Mappings
            const dentalMappings = {
                dental_status: 'Status',
                cavities: 'Cavities',
                missing_teeth: 'Missing Teeth',
                gum_disease: 'Gum Disease',
                oral_hygiene: 'Oral Hygiene',
                notes: 'Notes',
            };

            // Render Vitals
            renderDetails(vitalsData, 'modal-vitals', 'vitals-not-found', vitalsMappings);

            // Render Dental
            renderDetails(dentalData, 'modal-dental', 'dental-not-found', dentalMappings);

        })
    });
</script>
@endsection