@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('staff.checkups.students', $checkupPatient->checkup->id) }}" class="btn btn-secondary mb-3">
        Back to Students
    </a>

    <h2>Add/Edit Record: {{ $checkupPatient->patient->first_name }} {{ $checkupPatient->patient->last_name }}</h2>
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

    <form action="{{ route('staff.checkup_records.store', [$checkupPatient->checkup->id, $checkupPatient->patient->user_id]) }}" method="POST">
        @csrf

        @if($checkupPatient->checkup->checkup_type === 'vitals')
            <div class="mb-3">
                <label for="height">Height (cm)</label>
                <input type="number" step="0.01" name="height" class="form-control" value="{{ old('height', optional($checkupPatient->vitals->first())->height) }}">
            </div>
            <div class="mb-3">
                <label for="weight">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', optional($checkupPatient->vitals->first())->weight) }}">
            </div>
            <div class="mb-3">
                <label for="blood_pressure">Blood Pressure</label>
                <input type="text" name="blood_pressure" class="form-control" value="{{ old('blood_pressure', optional($checkupPatient->vitals->first())->blood_pressure) }}">
            </div>
            <div class="mb-3">
                <label for="pulse_rate">Pulse Rate</label>
                <input type="number" name="pulse_rate" class="form-control" value="{{ old('pulse_rate', optional($checkupPatient->vitals->first())->pulse_rate) }}">
            </div>
            <div class="mb-3">
                <label for="temperature">Temperature (°C)</label>
                <input type="number" step="0.1" name="temperature" class="form-control" value="{{ old('temperature', optional($checkupPatient->vitals->first())->temperature) }}">
            </div>
            <div class="mb-3">
                <label for="respiratory_rate">Respiratory Rate</label>
                <input type="number" step="0.1" name="respiratory_rate" class="form-control" value="{{ old('respiratory_rate', optional($checkupPatient->vitals->first())->respiratory_rate) }}">
            </div>
            <div class="mb-3">
                <label for="bmi">BMI</label>
                <input type="number" step="0.01" name="bmi" class="form-control" value="{{ old('bmi', optional($checkupPatient->vitals->first())->bmi) }}">
            </div>
        @endif

        @if($checkupPatient->checkup->checkup_type === 'dental')
            <div class="mb-3">
                <label for="dental_status">Dental Status</label>
                <input type="text" name="dental_status" class="form-control" value="{{ old('dental_status', optional($checkupPatient->dentals->first())->dental_status) }}">
            </div>
            <div class="mb-3">
                <label for="needs_treatment">Needs Treatment</label>
                <select name="needs_treatment" class="form-control">
                    <option value="no" {{ optional($checkupPatient->dentals->first())->needs_treatment === 'no' ? 'selected' : '' }}>No</option>
                    <option value="yes" {{ optional($checkupPatient->dentals->first())->needs_treatment === 'yes' ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="treatment_type">Treatment Type</label>
                <input type="text" name="treatment_type" class="form-control" value="{{ old('treatment_type', optional($checkupPatient->dentals->first())->treatment_type) }}">
            </div>
            <div class="mb-3">
                <label for="note">Notes</label>
                <textarea name="note" class="form-control">{{ old('note', optional($checkupPatient->dentals->first())->note) }}</textarea>
            </div>
        @endif

        <button type="submit" class="btn btn-success">Save Record</button>
    </form>
</div>
@endsection
