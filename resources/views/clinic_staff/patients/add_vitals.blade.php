@extends('layouts.app')
@section('title', 'Add Vitals')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Step 1: Search Patient --}}
    <div class="card mb-3">
        <div class="card-header">Step 1: Search Patient</div>
        <div class="card-body">
            <form method="GET" action="{{ route('clinic_staff.patients.add_vitals') }}">
                <div class="input-group mb-2">
                    <input type="text" name="search" id="searchInput" class="form-control" 
                           placeholder="Enter School ID (C00-0000)" 
                           value="{{ request('search') }}"
                           style="text-transform:uppercase;"
                           pattern="[A-Z]{1}[0-9]{2}-[0-9]{4}"
                           title="Format: C00-0000">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            {{-- Display search results --}}
            @if(isset($patients) && $patients->count())
                <ul class="list-group mt-2">
                    @foreach($patients as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $p->personalInformation->first_name ?? $p->username }} {{ $p->personalInformation->last_name ?? '' }}
                            <button type="button" class="btn btn-sm btn-success select-patient" 
                                    data-id="{{ $p->id }}" 
                                    data-name="{{ $p->personalInformation->first_name ?? $p->username }}">
                                Select
                            </button>
                        </li>
                    @endforeach
                </ul>
            @elseif(request('search'))
                <p class="text-muted">No patients found.</p>
            @endif
        </div>
    </div>

    {{-- Modal for Step 2 & 3 --}}
    <div class="modal fade" id="vitalsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Vitals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('clinic_staff.patients.vitals.store') }}">
                        @csrf
                        <input type="hidden" name="patient_id" id="modalPatientId">

                        <div class="mb-3">
                            <label for="checkup_type_id" class="form-label">Checkup Type</label>
                            <select name="checkup_type_id" id="checkup_type_id" class="form-select" required>
                                <option value="">Select Checkup Type</option>
                                @foreach($checkupTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason (Optional)</label>
                            <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for vitals check">
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" id="weight" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" step="0.1" name="height" id="height" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="blood_pressure" class="form-label">Blood Pressure</label>
                            <input type="text" name="blood_pressure" id="blood_pressure" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="heart_rate" class="form-label">Heart Rate (bpm)</label>
                            <input type="number" name="heart_rate" id="heart_rate" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="respiratory_rate" class="form-label">Respiratory Rate (breaths/min)</label>
                            <input type="number" name="respiratory_rate" id="respiratory_rate" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="temperature" class="form-label">Temperature (°C)</label>
                            <input type="number" step="0.1" name="temperature" id="temperature" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Save Vitals</button>
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
    // Force uppercase for School ID input
    const searchInput = document.querySelector('#searchInput');
    searchInput.addEventListener('input', () => {
        searchInput.value = searchInput.value.toUpperCase();
    });

    // Open modal when a patient is selected
    const selectButtons = document.querySelectorAll('.select-patient');
    selectButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const patientId = btn.dataset.id;
            const patientName = btn.dataset.name;
            document.querySelector('#modalPatientId').value = patientId;

            const modalTitle = document.querySelector('#vitalsModal .modal-title');
            modalTitle.textContent = `Add Vitals for ${patientName}`;

            const modal = new bootstrap.Modal(document.getElementById('vitalsModal'));
            modal.show();
        });
    });
});
</script>
@endpush
@endsection
