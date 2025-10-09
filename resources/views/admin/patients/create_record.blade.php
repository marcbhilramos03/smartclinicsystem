@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Record for {{ $user->name }}</h1>

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

        <div class="mb-3">
            <label>Record Type</label>
            <select name="record_type" class="form-control" required>
                <option value="">Select</option>
                <option value="clinic_session">Clinic Session</option>
                <option value="medical_history">Medical History</option>
            </select>
        </div>

        <!-- Clinic Session Fields -->
        <div id="clinic-session-fields" style="display:none;">
            <div class="mb-3"><label>Session Date</label><input type="date" name="session_date" class="form-control"></div>
            <div class="mb-3"><label>Reason</label><textarea name="reason" class="form-control"></textarea></div>
            <div class="mb-3"><label>Notes</label><textarea name="remedy" class="form-control"></textarea></div>
        </div>

        <!-- Medical History Fields -->
        <div id="medical-history-fields" style="display:none;">
            <div class="mb-3">
                <label>History Type</label>
                <select name="history_type" class="form-control">
                    <option value="allergy">Allergy</option>
                    <option value="illness">Illness</option>
                    <option value="vaccination">Vaccination</option>
                </select>
            </div>
            <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
            <div class="mb-3"><label>Date Recorded</label><input type="date" name="date_recorded" class="form-control"></div>
        </div>

        <button type="submit" class="btn btn-success">Save Record</button>
    </form>
</div>

<script>
const recordType = document.querySelector('select[name="record_type"]');
const clinicFields = document.getElementById('clinic-session-fields');
const historyFields = document.getElementById('medical-history-fields');

recordType.addEventListener('change', function() {
    clinicFields.style.display = this.value === 'clinic_session' ? 'block' : 'none';
    historyFields.style.display = this.value === 'medical_history' ? 'block' : 'none';
});
</script>
@endsection
