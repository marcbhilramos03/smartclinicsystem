@extends('layouts.app')
@section('title', 'Patients List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Patients</h2>

    {{-- Search --}}
    <form method="GET" action="{{ route('clinic_staff.patients.index') }}" class="mb-4 position-relative">
        <div class="input-group">
            <input type="text" id="searchInput" name="search" 
                   class="form-control" 
                   placeholder="Search by School ID (C00-0000)..." 
                   value="{{ request('search') }}"
                   pattern="[A-Z]{1}[0-9]{2}-[0-9]{4}"
                   title="Format: C00-0000 (Capital letter, 2 digits, dash, 4 digits)">
            <button class="btn btn-primary" type="submit">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Search
            </button>
            @if(request('search'))
                <span class="input-group-text" style="cursor:pointer;" 
                      onclick="document.getElementById('searchInput').value=''; this.closest('form').submit();">
                    &times;
                </span>
            @endif
        </div>
    </form>

    @if($patients->isEmpty())
        <div class="alert alert-info">No patients found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>School ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $index => $patient)
                        @php
                            $pi = $patient->personalInformation;
                            $fullName = $pi ? ($pi->first_name.' '.$pi->last_name) : $patient->username;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fullName }}</td>
                            <td>{{ $pi->school_id ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $patient->id }}">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Modals --}}
        @foreach($patients as $patient)
            @php
                $pi = $patient->personalInformation;
                $fullName = $pi ? ($pi->first_name.' '.$pi->last_name) : $patient->username;
                $sessions = $patient->clinicSessionsAsPatient ?? collect();
                $sessionsByDate = $sessions->groupBy(fn($s) => optional($s->session_date)->format('Y-m-d'));
            @endphp
            <div class="modal fade" id="modal-{{ $patient->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $patient->id }}" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalLabel-{{ $patient->id }}">{{ $fullName }} — Details</h5>
                            <button type="button" class="btn btn-light ms-3" data-bs-dismiss="modal">
                                <i class="fa-solid fa-arrow-left"></i> Back
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- Tabs --}}
                            <ul class="nav nav-tabs mb-3" id="tab-{{ $patient->id }}" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="vitals-tab-{{ $patient->id }}" data-bs-toggle="tab" data-bs-target="#vitals-{{ $patient->id }}" type="button" role="tab" aria-controls="vitals-{{ $patient->id }}" aria-selected="true">Vitals</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="medical-tab-{{ $patient->id }}" data-bs-toggle="tab" data-bs-target="#medical-{{ $patient->id }}" type="button" role="tab" aria-controls="medical-{{ $patient->id }}" aria-selected="false">Medical Records</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="prescription-tab-{{ $patient->id }}" data-bs-toggle="tab" data-bs-target="#prescription-{{ $patient->id }}" type="button" role="tab" aria-controls="prescription-{{ $patient->id }}" aria-selected="false">Prescription</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="tabContent-{{ $patient->id }}">
                                {{-- Vitals Tab --}}
                                <div class="tab-pane fade show active" id="vitals-{{ $patient->id }}" role="tabpanel" aria-labelledby="vitals-tab-{{ $patient->id }}">
                                    @forelse($sessionsByDate as $date => $dailySessions)
                                        <h6 class="text-secondary mt-3">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Checkup Type</th>
                                                        <th>Weight (kg)</th>
                                                        <th>Height (cm)</th>
                                                        <th>BP</th>
                                                        <th>Heart Rate</th>
                                                        <th>Resp Rate</th>
                                                        <th>Temp (°C)</th>
                                                        <th>BMI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($dailySessions as $session)
                                                        @php $v = $session->vitals; @endphp
                                                        <tr>
                                                            <td>{{ optional($session->session_date)->format('h:i A') }}</td>
                                                            <td>{{ $session->checkupType->name ?? 'General Visit' }}</td>
                                                            <td>{{ $v->weight ?? 'N/A' }}</td>
                                                            <td>{{ $v->height ?? 'N/A' }}</td>
                                                            <td>{{ $v->blood_pressure ?? 'N/A' }}</td>
                                                            <td>{{ $v->heart_rate ?? 'N/A' }}</td>
                                                            <td>{{ $v->respiratory_rate ?? 'N/A' }}</td>
                                                            <td>{{ $v->temperature ?? 'N/A' }}</td>
                                                            <td>{{ $v->bmi ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @empty
                                        <p class="text-muted">No vitals recorded.</p>
                                    @endforelse
                                </div>

                                {{-- Medical Records Tab --}}
                                <div class="tab-pane fade" id="medical-{{ $patient->id }}" role="tabpanel" aria-labelledby="medical-tab-{{ $patient->id }}">
                                    @forelse($sessionsByDate as $date => $dailySessions)
                                        <h6 class="text-secondary mt-3">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Checkup Type</th>
                                                        <th>Staff</th>
                                                        <th>Diagnosis</th>
                                                        <th>Treatment</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($dailySessions as $session)
                                                        <tr>
                                                            <td>{{ optional($session->session_date)->format('h:i A') }}</td>
                                                            <td>{{ $session->checkupType->name ?? 'General Visit' }}</td>
                                                            <td>{{ optional($session->clinicStaff->personalInformation)->first_name ?? $session->clinicStaff->username ?? 'N/A' }}</td>
                                                            <td>{{ $session->medicalRecord->diagnosis ?? 'N/A' }}</td>
                                                            <td>{{ $session->medicalRecord->treatment ?? 'N/A' }}</td>
                                                            <td>{{ $session->medicalRecord->notes ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @empty
                                        <p class="text-muted">No medical records available.</p>
                                    @endforelse
                                </div>

                                {{-- Prescription Tab --}}
                                <div class="tab-pane fade" id="prescription-{{ $patient->id }}" role="tabpanel" aria-labelledby="prescription-tab-{{ $patient->id }}">
                                    @forelse($sessionsByDate as $date => $dailySessions)
                                        <h6 class="text-secondary mt-3">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Checkup Type</th>
                                                        <th>Medicine</th>
                                                        <th>Dosage</th>
                                                        <th>Frequency</th>
                                                        <th>Duration</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($dailySessions as $session)
                                                        @forelse($session->prescriptions as $prescription)
                                                            <tr>
                                                                <td>{{ optional($session->session_date)->format('h:i A') }}</td>
                                                                <td>{{ $session->checkupType->name ?? 'General Visit' }}</td>
                                                                <td>{{ $prescription->inventory->name ?? 'N/A' }}</td>
                                                                <td>{{ $prescription->dosage ?? 'N/A' }}</td>
                                                                <td>{{ $prescription->frequency ?? 'N/A' }}</td>
                                                                <td>{{ $prescription->duration ?? 'N/A' }}</td>
                                                                <td>{{ $prescription->quantity ?? 'N/A' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-muted">No prescriptions available.</td>
                                                            </tr>
                                                        @endforelse
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @empty
                                        <p class="text-muted">No prescriptions available.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('#searchInput');
    searchInput.addEventListener('input', () => {
        searchInput.value = searchInput.value.toUpperCase().replace(/[^A-Z0-9\-]/g, '');
    });
});
</script>
@endpush
@endsection
