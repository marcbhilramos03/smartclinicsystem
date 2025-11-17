@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #e6f4ea, #c8f0d2);
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 40px 50px;
        max-width: 1500px;
        width: 100%;
        border-top: 8px solid #198754;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        text-align: center;
        color: #198754;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #198754;
        margin-bottom: 15px;
        border-left: 4px solid #198754;
        padding-left: 10px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-top: 10px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 1rem;
        transition: all 0.2s ease;
        margin-bottom: 10px;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 5px rgba(25, 135, 84, 0.3);
    }

    .btn {
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #198754;
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: #157347;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .alert-danger {
        border-radius: 10px;
        background-color: #f8d7da;
        color: #842029;
        padding: 15px 20px;
        border: none;
    }

    .alert-success {
        border-radius: 10px;
        padding: 12px 18px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .form-card { padding: 30px 25px; }
        h2 { font-size: 1.4rem; }
    }
</style>

<div class="container">
    <div class="form-card">
        <h2>
            Add/Edit Record: 
            {{ $checkupPatient->patient->first_name }} 
            {{ $checkupPatient->patient->last_name }}
        </h2>

        <div class="section-title">
            Checkup Type: {{ ucfirst($checkupPatient->checkup->checkup_type) }}
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.checkup_records.store', [$checkupPatient->checkup->id, $checkupPatient->patient->user_id]) }}" method="POST">
            @csrf


            {{-- ⭐ VITALS FORM --}}
            @if($checkupPatient->checkup->checkup_type === 'vitals')
                <h4 class="section-title">Vitals Information</h4>

                <label class="form-label">Height (cm)</label>
                <input type="number" step="0.01" name="height" class="form-control"
                    value="{{ old('height', optional($checkupPatient->vitals->first())->height) }}">

                <label class="form-label">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" class="form-control"
                    value="{{ old('weight', optional($checkupPatient->vitals->first())->weight) }}">

                <label class="form-label">Blood Pressure</label>
                <input type="text" name="blood_pressure" class="form-control"
                    value="{{ old('blood_pressure', optional($checkupPatient->vitals->first())->blood_pressure) }}">

                <label class="form-label">Pulse Rate</label>
                <input type="number" name="pulse_rate" class="form-control"
                    value="{{ old('pulse_rate', optional($checkupPatient->vitals->first())->pulse_rate) }}">

                <label class="form-label">Temperature (°C)</label>
                <input type="number" step="0.1" name="temperature" class="form-control"
                    value="{{ old('temperature', optional($checkupPatient->vitals->first())->temperature) }}">

                <label class="form-label">Respiratory Rate</label>
                <input type="number" step="0.1" name="respiratory_rate" class="form-control"
                    value="{{ old('respiratory_rate', optional($checkupPatient->vitals->first())->respiratory_rate) }}">

                <label class="form-label">BMI</label>
                <input type="number" step="0.01" name="bmi" class="form-control"
                    value="{{ old('bmi', optional($checkupPatient->vitals->first())->bmi) }}">
            @endif


            {{-- ⭐ DENTAL FORM --}}
            @if($checkupPatient->checkup->checkup_type === 'dental')
                <h4 class="section-title">Dental Information</h4>

                <label class="form-label">Dental Status</label>
                <input type="text" name="dental_status" class="form-control"
                    value="{{ old('dental_status', optional($checkupPatient->dentals->first())->dental_status) }}">

                <label class="form-label">Needs Treatment</label>
                <select name="needs_treatment" class="form-control">
                    <option value="no" {{ optional($checkupPatient->dentals->first())->needs_treatment === 'no' ? 'selected' : '' }}>No</option>
                    <option value="yes" {{ optional($checkupPatient->dentals->first())->needs_treatment === 'yes' ? 'selected' : '' }}>Yes</option>
                </select>

                <label class="form-label">Treatment Type</label>
                <input type="text" name="treatment_type" class="form-control"
                    value="{{ old('treatment_type', optional($checkupPatient->dentals->first())->treatment_type) }}">

                <label class="form-label">Notes</label>
                <textarea name="note" class="form-control" rows="3">{{ old('note', optional($checkupPatient->dentals->first())->note) }}</textarea>
            @endif


            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('staff.checkups.students', $checkupPatient->checkup->id) }}" class="btn btn-secondary">
                    ✖ Cancel
                </a>

                <button type="submit" class="btn btn-success">
                    💾 Save Record
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
