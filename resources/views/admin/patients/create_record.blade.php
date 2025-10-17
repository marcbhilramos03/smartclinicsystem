@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Record for {{ $user->name }}</h1>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.patients.records.store', $user) }}" method="POST">
        @csrf

        {{-- Record Type --}}
        <div class="mb-3">
            <label class="form-label">Record Type</label>
            <select name="record_type" class="form-control" required>
                <option value="">Select</option>
                <option value="clinic_session">Clinic Session</option>
                <option value="medical_history">Medical History</option>
            </select>
        </div>

        {{-- CLINIC SESSION FIELDS --}}
        <div id="clinic-session-fields" style="display:none;">
            <h5 class="mt-4">Clinic Session Details</h5>
            <hr>

            <div class="mb-3">
                <label class="form-label">Session Date</label>
                <input type="date" name="session_date" class="form-control" value="{{ old('session_date') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Reason</label>
                <textarea name="reason" class="form-control" rows="3" placeholder="Enter reason for visit">{{ old('reason') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Notes / Remedy</label>
                <textarea name="remedy" class="form-control" rows="3" placeholder="Enter notes or remedy">{{ old('remedy') }}</textarea>
            </div>

            {{-- Optional Medications --}}
            <div class="mb-3">
                <h5>Medications <small class="text-muted">(Optional)</small></h5>
                <button type="button" class="btn btn-sm btn-primary mb-2" id="addMedication">+ Add Medication</button>

                <div id="medication-list">
                    {{-- Medications will be appended here --}}
                </div>
            </div>
        </div>

        {{-- MEDICAL HISTORY FIELDS --}}
        <div id="medical-history-fields" style="display:none;">
            <h5 class="mt-4">Medical History Details</h5>
            <hr>

            <div class="mb-3">
                <label class="form-label">History Type</label>
                <select name="history_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="allergy" {{ old('history_type') == 'allergy' ? 'selected' : '' }}>Allergy</option>
                    <option value="illness" {{ old('history_type') == 'illness' ? 'selected' : '' }}>Illness</option>
                    <option value="vaccination" {{ old('history_type') == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Enter details">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Date Recorded</label>
                <input type="date" name="date_recorded" class="form-control" value="{{ old('date_recorded') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Record</button>
        <a href="{{ route('admin.patients.index', $user) }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>

{{-- Dynamic Fields Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recordType = document.querySelector('select[name="record_type"]');
    const clinicFields = document.getElementById('clinic-session-fields');
    const historyFields = document.getElementById('medical-history-fields');
    const medicationList = document.getElementById('medication-list');
    const addMedicationBtn = document.getElementById('addMedication');

    // Toggle between Clinic Session and Medical History
    function toggleFields() {
        clinicFields.style.display = recordType.value === 'clinic_session' ? 'block' : 'none';
        historyFields.style.display = recordType.value === 'medical_history' ? 'block' : 'none';
    }
    recordType.addEventListener('change', toggleFields);
    toggleFields(); // Initialize state

    // Add medication row dynamically
    let medIndex = 0;
    addMedicationBtn.addEventListener('click', function() {
        const medRow = document.createElement('div');
        medRow.classList.add('border', 'rounded', 'p-3', 'mb-2', 'bg-light');
        medRow.innerHTML = `
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Medicine</label>
                    <select name="medications[${medIndex}][inventory_id]" class="form-control">
                        <option value="">Select Medicine</option>
                        @foreach(\App\Models\Inventory::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dosage</label>
                    <input type="text" name="medications[${medIndex}][dosage]" class="form-control" placeholder="e.g. 1 tablet">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Duration</label>
                    <input type="text" name="medications[${medIndex}][duration]" class="form-control" placeholder="e.g. 3 days">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="medications[${medIndex}][quantity]" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-12 mt-2 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-medication">Remove</button>
                </div>
            </div>
        `;
        medicationList.appendChild(medRow);
        medIndex++;
    });

    // Remove medication row
    medicationList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-medication')) {
            e.target.closest('.border').remove();
        }
    });
});
</script>
@endsection
