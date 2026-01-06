@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #eaf3ff, #d6e5ff);
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1300px;
        margin-top: 40px;
        background: #fff;
        border-radius: 16px;
        padding: 40px 50px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        color: #0d6efd;
        font-weight: 700;
        margin-bottom: 10px;
    }

    h4 {
        color: #0d6efd;
        font-weight: 600;
    }

    p {
        font-size: 1rem;
        color: #555;
    }

    .card {
        border: 2px solid #0d6efd !important;
        border-radius: 12px;
        background-color: #f8fbff;
    }

    label.form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.4);
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 25px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
        background: white;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }

    .alert-success, .alert-danger {
        border-radius: 10px;
        padding: 15px 20px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 25px 20px;
        }

        h2 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="container">

    {{-- Alerts --}}
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

    {{-- ✅ Form --}}
    <form action="{{ route('admin.checkups.update_patient', $checkupPatient->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ---------------- VITALS ---------------- --}}
        @if($checkupPatient->checkup->checkup_type === 'vitals')
            <div class="card mb-3 p-3">
                <h4>Vitals</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="height" class="form-label">Height (cm)</label>
                        <input type="number" step="0.01" name="height" id="height" class="form-control"
                            value="{{ old('height', optional($checkupPatient->vitals)->height) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" id="weight" class="form-control"
                            value="{{ old('weight', optional($checkupPatient->vitals)->weight) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bmi" class="form-label">BMI (auto-calculated)</label>
                    <input type="number" step="0.01" name="bmi" id="bmi" class="form-control"
                        value="{{ old('bmi', optional($checkupPatient->vitals)->bmi) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="blood_pressure" class="form-label">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure" class="form-control"
                        value="{{ old('blood_pressure', optional($checkupPatient->vitals)->blood_pressure) }}">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="pulse_rate" class="form-label">Pulse Rate</label>
                        <input type="number" name="pulse_rate" id="pulse_rate" class="form-control"
                            value="{{ old('pulse_rate', optional($checkupPatient->vitals)->pulse_rate) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="temperature" class="form-label">Temperature (°C)</label>
                        <input type="number" step="0.1" name="temperature" id="temperature" class="form-control"
                            value="{{ old('temperature', optional($checkupPatient->vitals)->temperature) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="respiratory_rate" class="form-label">Respiratory Rate</label>
                        <input type="number" step="0.1" name="respiratory_rate" id="respiratory_rate" class="form-control"
                            value="{{ old('respiratory_rate', optional($checkupPatient->vitals)->respiratory_rate) }}">
                    </div>
                </div>
            </div>
        @endif

        {{-- ---------------- DENTAL ---------------- --}}
        @if($checkupPatient->checkup->checkup_type === 'dental')
            <div class="card mb-3 p-3">
                <h4>Dental</h4>
                <div class="mb-3">
                    <label for="dental_status" class="form-label">Dental Status</label>
                    <input type="text" name="dental_status" id="dental_status" class="form-control"
                        value="{{ old('dental_status', optional($checkupPatient->dentals)->dental_status) }}">
                </div>

                <div class="mb-3">
                    <label for="needs_treatment" class="form-label">Needs Treatment</label>
                    <select name="needs_treatment" id="needs_treatment" class="form-select">
                        <option value="yes" {{ old('needs_treatment', optional($checkupPatient->dentals)->needs_treatment) === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('needs_treatment', optional($checkupPatient->dentals)->needs_treatment) === 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="treatment_type" class="form-label">Treatment Type</label>
                    <input type="text" name="treatment_type" id="treatment_type" class="form-control"
                        value="{{ old('treatment_type', optional($checkupPatient->dentals)->treatment_type) }}">
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" id="note" class="form-control">{{ old('note', optional($checkupPatient->dentals)->note) }}</textarea>
                </div>
            </div>
        @endif

        {{-- ✅ Buttons --}}
        <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
            <button type="submit" class="btn btn-primary w-100">
                💾 Save Record
            </button>
            <a href="{{ route('admin.checkups.show', $checkupPatient->checkup->id) }}" class="btn btn-outline-secondary w-100">
                ✖ Cancel
            </a>
        </div>
    </form>
</div>

{{-- ✅ Auto-calculate BMI --}}
@if($checkupPatient->checkup->checkup_type === 'vitals')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heightInput = document.getElementById('height');
    const weightInput = document.getElementById('weight');
    const bmiInput = document.getElementById('bmi');

    function calculateBMI() {
        const height = parseFloat(heightInput.value);
        const weight = parseFloat(weightInput.value);

        if (height > 0 && weight > 0) {
            const heightInMeters = height / 100;
            const bmi = weight / (heightInMeters * heightInMeters);
            bmiInput.value = bmi.toFixed(2);
        } else {
            bmiInput.value = '';
        }
    }

    heightInput.addEventListener('input', calculateBMI);
    weightInput.addEventListener('input', calculateBMI);
});
</script>
@endif

@endsection
