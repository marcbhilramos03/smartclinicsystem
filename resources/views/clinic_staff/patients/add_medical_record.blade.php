@extends('layouts.app')
@section('title', 'Add Medical Record')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Step 1: Search Patient --}}
    <div class="card mb-4">
        <div class="card-header">Step 1: Search Patient</div>
        <div class="card-body">
            <form method="GET" action="{{ route('clinic_staff.patients.add_medical_record') }}">
                <div class="input-group mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Enter School ID (C00-0000)" 
                           value="{{ request('search') }}"
                           style="text-transform:uppercase;"
                           pattern="[A-Z]{1}[0-9]{2}-[0-9]{4}"
                           title="Format: C00-0000">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            {{-- Display search results --}}
            @if(isset($patients) && $patients->count())
                <ul class="list-group">
                    @foreach($patients as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $p->personalInformation->first_name ?? $p->username }} {{ $p->personalInformation->last_name ?? '' }}
                            <button type="button" class="btn btn-sm btn-success" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#medicalRecordModal" 
                                    data-id="{{ $p->id }}">
                                Add Record
                            </button>
                        </li>
                    @endforeach
                </ul>
            @elseif(request('search'))
                <p class="text-muted">No patients found.</p>
            @endif
        </div>
    </div>

    {{-- Modal for Step 2-4 --}}
    <div class="modal fade" id="medicalRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Medical Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="medicalRecordForm" method="POST" action="{{ route('clinic_staff.patients.medical_record.store') }}">
                        @csrf
                        <input type="hidden" name="patient_id" id="selectedPatientId" value="">

                        {{-- Step 2: Checkup Info --}}
                        <div class="step step-2">
                            <h5>Step 2: Checkup Information</h5>
                            <div class="mb-3">
                                <label for="checkup_type_id" class="form-label">Checkup Type</label>
                                <select name="checkup_type_id" id="checkup_type_id" class="form-control" required>
                                    <option value="">Select Checkup Type</option>
                                    @foreach($checkupTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Visit</label>
                                <input type="text" name="reason" id="reason" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-step" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>
                        </div>

                        {{-- Step 3: Diagnosis & Treatment --}}
                        <div class="step step-3 d-none">
                            <h5>Step 3: Diagnosis & Treatment</h5>
                            <div class="mb-3">
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <textarea name="diagnosis" id="diagnosis" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="treatment" class="form-label">Treatment</label>
                                <textarea name="treatment" id="treatment" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes (Optional)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>
                        </div>

                        {{-- Step 4: Prescription --}}
                        <div class="step step-4 d-none">
                            <h5>Step 4: Optional Prescription</h5>
                            <div class="mb-3">
                                <label for="medicine_id" class="form-label">Medicine</label>
                                <select name="medicine_id" id="medicine_id" class="form-control">
                                    <option value="">Select Medicine</option>
                                    @foreach(\App\Models\Inventories::all() as $med)
                                        <option value="{{ $med->id }}">{{ $med->name }} ({{ $med->quantity }} left)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dosage" class="form-label">Dosage</label>
                                <input type="text" name="dosage" id="dosage" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" name="duration" id="duration" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="frequency" class="form-label">Frequency</label>
                                <input type="text" name="frequency" id="frequency" class="form-control" placeholder="e.g., 3 times a day">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" min="1">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                <button type="submit" class="btn btn-success">Save Medical Record</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 2; // modal starts at step 2

    const showStep = (step) => {
        document.querySelectorAll('.step').forEach((el, idx) => {
            el.classList.add('d-none');
            if(idx + 2 === step) el.classList.remove('d-none');
        });
    }

    // Next & Previous buttons
    document.querySelectorAll('.next-step').forEach(btn => {
        btn.addEventListener('click', () => {
            if(currentStep < 4) { currentStep++; showStep(currentStep); }
        });
    });
    document.querySelectorAll('.prev-step').forEach(btn => {
        btn.addEventListener('click', () => {
            if(currentStep > 2) { currentStep--; showStep(currentStep); }
        });
    });

    // Pass selected patient ID to modal
    const modal = document.getElementById('medicalRecordModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const patientId = button.getAttribute('data-id');
        document.querySelector('#selectedPatientId').value = patientId;
        currentStep = 2;
        showStep(currentStep);
    });
});
</script>
@endpush
@endsection
