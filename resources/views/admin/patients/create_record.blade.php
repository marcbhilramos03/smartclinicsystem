@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Record for {{ $user->first_name }} {{ $user->last_name }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

        {{-- Clinic Session --}}
        <div id="clinic-session-fields" style="display:none;">
            <h5>Clinic Session Details</h5>
            <hr>

            <div class="mb-3">
                <label class="form-label">Session Date</label>
                <input type="date" name="session_date" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Reason</label>
                <textarea name="reason" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Notes / Remedy</label>
                <textarea name="remedy" class="form-control"></textarea>
            </div>

            {{-- Medications --}}
            <div class="mb-3">
                <h5>Medications <small>(Optional)</small></h5>
                <button type="button" class="btn btn-sm btn-primary mb-2" id="addMedication">+ Add Medication</button>
                <div id="medication-list"></div>
            </div>
        </div>

        {{-- Medical History --}}
        <div id="medical-history-fields" style="display:none;">
            <h5>Medical History</h5>
            <hr>
            <div class="mb-3">
                <label class="form-label">History Type</label>
                <select name="history_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="allergy">Allergy</option>
                    <option value="illness">Illness</option>
                    <option value="vaccination">Vaccination</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Date Recorded</label>
                <input type="date" name="date_recorded" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Record</button>
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recordType = document.querySelector('select[name="record_type"]');
    const clinicFields = document.getElementById('clinic-session-fields');
    const historyFields = document.getElementById('medical-history-fields');
    const medicationList = document.getElementById('medication-list');
    const addMedicationBtn = document.getElementById('addMedication');
    let medIndex = 0;

    function toggleFields() {
        clinicFields.style.display = recordType.value === 'clinic_session' ? 'block' : 'none';
        historyFields.style.display = recordType.value === 'medical_history' ? 'block' : 'none';
    }
    recordType.addEventListener('change', toggleFields);
    toggleFields();

    // Add medication
    addMedicationBtn.addEventListener('click', function() {
        const medRow = document.createElement('div');
        medRow.classList.add('border', 'p-2', 'mb-2', 'rounded', 'bg-light');
        medRow.innerHTML = `
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label>Medicine</label>
                    <select name="medications[${medIndex}][inventory_id]" class="form-control">
                        <option value="">Select Medicine</option>
                        @foreach(\App\Models\Inventory::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->item_name }} (Stock: {{ $item->quantity }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Dosage</label>
                    <input type="text" name="medications[${medIndex}][dosage]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Duration</label>
                    <input type="text" name="medications[${medIndex}][duration]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Quantity</label>
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

    // Remove medication
    medicationList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-medication')) {
            e.target.closest('.border').remove();
        }
    });
});
</script>
@endsection
