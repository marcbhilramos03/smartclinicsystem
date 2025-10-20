@extends('layouts.app')

@section('page-title', 'Add Vital Record')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Add Vital Record for {{ $students->first_name }} {{ $students->last_name }}</h2>

<form action="{{ route('staff.checkup_records.store', ['checkupId' => $checkup->id, 'studentId' => $students->user_id]) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number" step="0.1" name="height" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" step="0.1" name="weight" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="blood_pressure" class="form-label">Blood Pressure</label>
            <input type="text" name="blood_pressure" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pulse_rate" class="form-label">Pulse Rate</label>
                <input type="number" name="pulse_rate" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="temperature" class="form-label">Temperature (°C)</label>
                <input type="number" step="0.1" name="temperature" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="respiratory_rate" class="form-label">Respiratory Rate</label>
                <input type="number" name="respiratory_rate" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="bmi" class="form-label">BMI</label>
            <input type="number" step="0.1" name="bmi" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Vital Record</button>
        <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
