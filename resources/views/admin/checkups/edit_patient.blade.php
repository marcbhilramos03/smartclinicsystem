@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.checkups.show', $checkupPatient->checkup->id) }}" class="btn btn-secondary mb-3">Back to Checkup</a>

    <h2>Edit Patient Record: {{ $checkupPatient->patient->first_name }} {{ $checkupPatient->patient->last_name }}</h2>
    <p><strong>Checkup Type:</strong> {{ ucfirst($checkupPatient->checkup->checkup_type) }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.checkups.update_patient', $checkupPatient->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Vitals form --}}
        @if($checkupPatient->checkup->checkup_type === 'vitals')
            <div class="card mb-3 p-3">
                <h4>Vitals</h4>
                <div class="mb-3">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" step="0.01" name="height" id="height" class="form-control" 
                           value="{{ old('height', optional($checkupPatient->vitals->first())->height) }}">
                </div>

                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" step="0.01" name="weight" id="weight" class="form-control" 
                           value="{{ old('weight', optional($checkupPatient->vitals->first())->weight) }}">
                </div>

                <div class="mb-3">
                    <label for="blood_pressure" class="form-label">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure" class="form-control"
                           value="{{ old('blood_pressure', optional($checkupPatient->vitals->first())->blood_pressure) }}">
                </div>

                <div class="mb-3">
                    <label for="pulse_rate" class="form-label">Pulse Rate</label>
                    <input type="number" name="pulse_rate" id="pulse_rate" class="form-control"
                           value="{{ old('pulse_rate', optional($checkupPatient->vitals->first())->pulse_rate) }}">
                </div>

                <div class="mb-3">
                    <label for="temperature" class="form-label">Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" id="temperature" class="form-control"
                           value="{{ old('temperature', optional($checkupPatient->vitals->first())->temperature) }}">
                </div>

                <div class="mb-3">
                    <label for="respiratory_rate" class="form-label">Respiratory Rate</label>
                    <input type="number" step="0.1" name="respiratory_rate" id="respiratory_rate" class="form-control"
                           value="{{ old('respiratory_rate', optional($checkupPatient->vitals->first())->respiratory_rate) }}">
                </div>

                <div class="mb-3">
                    <label for="bmi" class="form-label">BMI</label>
                    <input type="number" step="0.01" name="bmi" id="bmi" class="form-control"
                           value="{{ old('bmi', optional($checkupPatient->vitals->first())->bmi) }}">
                </div>
            </div>
        @endif

        {{-- Dental form --}}
        @if($checkupPatient->checkup->checkup_type === 'dental')
            <div class="card mb-3 p-3">
                <h4>Dental</h4>
                <div class="mb-3">
                    <label for="dental_status" class="form-label">Dental Status</label>
                    <input type="text" name="dental_status" id="dental_status" class="form-control"
                           value="{{ old('dental_status', optional($checkupPatient->dentals->first())->dental_status) }}">
                </div>

                <div class="mb-3">
                    <label for="needs_treatment" class="form-label">Needs Treatment</label>
                    <select name="needs_treatment" id="needs_treatment" class="form-select">
                        <option value="yes" {{ old('needs_treatment', optional($checkupPatient->dentals->first())->needs_treatment) === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('needs_treatment', optional($checkupPatient->dentals->first())->needs_treatment) === 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="treatment_type" class="form-label">Treatment Type</label>
                    <input type="text" name="treatment_type" id="treatment_type" class="form-control"
                           value="{{ old('treatment_type', optional($checkupPatient->dentals->first())->treatment_type) }}">
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" id="note" class="form-control">{{ old('note', optional($checkupPatient->dentals->first())->note) }}</textarea>
                </div>
            </div>
        @endif
<form action="{{ route('admin.checkups.update_patient', $checkupPatient->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Vitals/Dental form fields here --}}

    <button type="submit" class="btn btn-success btn-sm">
        Save Record
    </button>
</form>


    </form>
</div>
@endsection
