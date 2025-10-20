@extends('layouts.staff')

@section('content')
<div class="container mt-4">
    <h2>Edit {{ ucfirst($checkup->type) }} Record for {{ $student->first_name }} {{ $student->last_name }}</h2>

    <form action="{{ route('staff.checkup_records.update', [$checkup->id, $record->id]) }}" method="POST">
        @csrf
        @method('PUT')

        @if($checkup->type === 'vital')
            <div class="mb-3">
                <label>Height (cm)</label>
                <input type="number" name="height" step="0.1" class="form-control" value="{{ $record->height }}">
            </div>
            <div class="mb-3">
                <label>Weight (kg)</label>
                <input type="number" name="weight" step="0.1" class="form-control" value="{{ $record->weight }}">
            </div>
            <div class="mb-3">
                <label>Blood Pressure</label>
                <input type="text" name="blood_pressure" class="form-control" value="{{ $record->blood_pressure }}">
            </div>
            <div class="mb-3">
                <label>Pulse Rate</label>
                <input type="number" name="pulse_rate" class="form-control" value="{{ $record->pulse_rate }}">
            </div>
            <div class="mb-3">
                <label>Temperature</label>
                <input type="number" name="temperature" step="0.1" class="form-control" value="{{ $record->temperature }}">
            </div>
            <div class="mb-3">
                <label>Respiratory Rate</label>
                <input type="number" name="respiratory_rate" step="0.1" class="form-control" value="{{ $record->respiratory_rate }}">
            </div>
            <div class="mb-3">
                <label>BMI</label>
                <input type="number" name="bmi" class="form-control" value="{{ $record->bmi }}">
            </div>
        @else
            <div class="mb-3">
                <label>Dental Status</label>
                <input type="text" name="dental_status" class="form-control" value="{{ $record->dental_status }}">
            </div>
            <div class="mb-3">
                <label>Cavities</label>
                <input type="number" name="cavities" class="form-control" value="{{ $record->cavities }}">
            </div>
            <div class="mb-3">
                <label>Missing Teeth</label>
                <input type="number" name="missing_teeth" class="form-control" value="{{ $record->missing_teeth }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="gum_disease" class="form-check-input" id="gum_disease" {{ $record->gum_disease ? 'checked' : '' }}>
                <label for="gum_disease" class="form-check-label">Gum Disease</label>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="oral_hygiene" class="form-check-input" id="oral_hygiene" {{ $record->oral_hygiene ? 'checked' : '' }}>
                <label for="oral_hygiene" class="form-check-label">Oral Hygiene Good</label>
            </div>
            <div class="mb-3">
                <label>Notes</label>
                <textarea name="notes" class="form-control">{{ $record->notes }}</textarea>
            </div>
        @endif

        <button class="btn btn-primary">Update Record</button>
        <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
