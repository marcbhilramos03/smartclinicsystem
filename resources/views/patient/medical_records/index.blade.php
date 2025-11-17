@extends('layouts.app')

@section('content')

<div class="container my-5">

    <!-- FLEXBOX CARDS -->
    <div class="d-flex flex-wrap gap-3 justify-content-center mb-5">

        <!-- Checkups Card -->
        <div class="card flex-fill shadow-sm text-center p-3 hover-shadow" style="min-width: 250px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#checkupsModal">
            <i class="bi bi-heart-pulse-fill text-primary mb-2 fs-2"></i>
            <h5 class="card-title">Checkups</h5>
            <p class="card-text text-muted">{{ $checkups->count() }} Records</p>
        </div>

        <!-- Clinic Sessions Card -->
        <div class="card flex-fill shadow-sm text-center p-3 hover-shadow" style="min-width: 250px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#clinicModal">
            <i class="bi bi-hospital-fill text-success mb-2 fs-2"></i>
            <h5 class="card-title">Clinic Visit</h5>
            <p class="card-text text-muted">{{ $clinicSessions->count() }} Records</p>
        </div>

        <!-- Medical History Card -->
        <div class="card flex-fill shadow-sm text-center p-3 hover-shadow" style="min-width: 250px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#historyModal">
            <i class="bi bi-file-medical-fill text-warning mb-2 fs-2"></i>
            <h5 class="card-title">Medical History</h5>
            <p class="card-text text-muted">{{ $medicalHistories->count() }} Records</p>
        </div>

    </div>

    <!-- CHECKUPS MODAL -->
    <div class="modal fade" id="checkupsModal" tabindex="-1" aria-labelledby="checkupsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content text-dark">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="checkupsModalLabel">Checkups Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    @if($checkups->count())
                        <!-- Vitals Table -->
                        <h6 class="fw-bold mb-2">Vitals Records</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Height (cm)</th>
                                        <th>Weight (kg)</th>
                                        <th>Blood Pressure</th>
                                        <th>Respiratory Rate</th>
                                        <th>Pulse Rate</th>
                                        <th>Temperature</th>
                                        <th>BMI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($checkups as $cp)
                                        @foreach($cp->vitals as $v)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($cp->checkup->date ?? now())->format('M d, Y') }}</td>
                                            <td>{{ $v->height ?? '-' }}</td>
                                            <td>{{ $v->weight ?? '-' }}</td>
                                            <td>{{ $v->blood_pressure ?? '-' }}</td>
                                            <td>{{ $v->respiratory_rate ?? '-' }}</td>
                                            <td>{{ $v->pulse_rate ?? '-' }}</td>
                                            <td>{{ $v->temperature ?? '-' }}</td>
                                            <td>{{ $v->bmi ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Dental Table -->
                        <h6 class="fw-bold mb-2">Dental Records</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Needs Treatment</th>
                                        <th>Treatment Type</th>
                                        <th>Consultation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($checkups as $cp)
                                        @foreach($cp->dentals as $d)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($cp->checkup->date ?? now())->format('M d, Y') }}</td>
                                            <td>{{ $d->dental_status ?? '-' }}</td>
                                            <td>{{ $d->needs_treatment ?? '-' }}</td>
                                            <td>{{ $d->treatment_type ?? '-' }}</td>
                                            <td>{{ $d->note ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <div class="alert alert-info">No checkups found.</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- CLINIC SESSIONS MODAL -->
    <div class="modal fade" id="clinicModal" tabindex="-1" aria-labelledby="clinicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content text-dark">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="clinicModalLabel">Clinic Visit Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($clinicSessions->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Remedy</th>
                                        <th>In-charge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clinicSessions as $cs)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($cs->session_date)->format('M d, Y') }}</td>
                                            <td>{{ $cs->reason }}</td>
                                            <td>{{ $cs->remedy ?? '-' }}</td>
                                            <td>{{ $cs->admin->first_name ?? 'N/A' }} {{ $cs->admin->last_name ?? 'N/A' }} {{ $cs->admin->credential->license_type ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No clinic sessions found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MEDICAL HISTORY MODAL -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content text-dark">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="historyModalLabel">Medical History Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($medicalHistories->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalHistories as $mh)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($mh->date_recorded ?? now())->format('M d, Y') }}</td>
                                            <td>{{ ucfirst($mh->history_type ?? '-') }}</td>
                                            <td>{{ $mh->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No medical history found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Hover Shadow Effect -->
<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}

/* Make inputs and textareas bigger */
#historyModal .form-control {
    font-size: 1.2rem;
    padding: 1rem;
}

/* Make the submit button bigger */
#historyModal .btn-primary {
    font-size: 1.2rem;
    padding: 0.8rem 2rem;
}

/* Optional: increase spacing between form fields */
#historyModal .mb-3 {
    margin-bottom: 1.5rem;
}
/* Form inside modal */
.modal .form-control {
    font-size: 1.2rem;
    padding: 1rem;
    width: 100%;
    box-sizing: border-box;
}

.modal .btn-lg {
    font-size: 1.2rem;
    padding: 0.8rem 2rem;
}

.modal .mb-3 {
    margin-bottom: 1.5rem;
}

/* Form container styling */
.modal .bg-light {
    background-color: #f8f9fa !important;
}
.big-card {
    min-width: 500px;      /* Make cards wider */
    min-height: 250px;     /* Make cards taller */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.big-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 1rem 2rem rgba(0,0,0,0.25) !important;
}

.card i {
    font-size: 3rem;       /* Bigger icon */
}

.card-title {
    font-size: 1.5rem;     /* Bigger title */
}

.card-text {
    font-size: 1.2rem;     /* Bigger text */
}
</style>

@endsection
