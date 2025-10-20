@extends('layouts.app')

@section('page-title', 'Add Checkup Record')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            Add {{ ucfirst($checkup->checkup_type) }} Record — 
            {{ $student->first_name }} {{ $student->last_name }}
        </h2>
        <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('staff.checkup_records.store', [$checkup->id, $student->user_id]) }}" method="POST" class="card shadow-sm p-4">
        @csrf

        {{-- VITALS CHECKUP --}}
        @if($checkup->checkup_type === 'vitals')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Height (cm)</label>
                    <input type="number" step="0.1" name="height" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Blood Pressure</label>
                    <input type="text" name="blood_pressure" class="form-control" placeholder="e.g. 120/80">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pulse Rate (bpm)</label>
                    <input type="number" name="pulse_rate" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Respiratory Rate (per min)</label>
                    <input type="number" step="0.1" name="respiratory_rate" class="form-control">
                </div>
            </div>
        @endif

        {{-- DENTAL CHECKUP --}}
        @if($checkup->checkup_type === 'dental')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dental Status</label>
                    <input type="text" name="dental_status" class="form-control" placeholder="e.g. Good, Fair, Poor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Cavities</label>
                    <input type="number" name="cavities" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Missing Teeth</label>
                    <input type="number" name="missing_teeth" class="form-control">
                </div>

                <div class="col-md-6 mb-3 form-check mt-4">
                    <input type="checkbox" name="gum_disease" class="form-check-input" id="gum_disease">
                    <label for="gum_disease" class="form-check-label">Gum Disease</label>
                </div>

                <div class="col-md-6 mb-3 form-check mt-4">
                    <input type="checkbox" name="oral_hygiene" class="form-check-input" id="oral_hygiene" checked>
                    <label for="oral_hygiene" class="form-check-label">Good Oral Hygiene</label>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
            </div>
        @endif

        {{-- Submit --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                Save Record
            </button>
        </div>
    </form>
</div>
@endsection
