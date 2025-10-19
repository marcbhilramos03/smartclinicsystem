@csrf

<input type="hidden" name="patient_id" value="{{ $student->user_id }}">

@if($checkup->checkup_type === 'vital')
<div class="row">
    <div class="col-md-4">
        <label>Height (cm)</label>
        <input type="number" name="height" class="form-control" value="{{ $record->height ?? old('height') }}">
    </div>
    <div class="col-md-4">
        <label>Weight (kg)</label>
        <input type="number" name="weight" class="form-control" value="{{ $record->weight ?? old('weight') }}">
    </div>
    <div class="col-md-4">
        <label>Blood Pressure</label>
        <input type="text" name="blood_pressure" class="form-control" value="{{ $record->blood_pressure ?? old('blood_pressure') }}">
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4">
        <label>Pulse Rate</label>
        <input type="number" name="pulse_rate" class="form-control" value="{{ $record->pulse_rate ?? old('pulse_rate') }}">
    </div>
    <div class="col-md-4">
        <label>Temperature (°C)</label>
        <input type="number" step="0.1" name="temperature" class="form-control" value="{{ $record->temperature ?? old('temperature') }}">
    </div>
    <div class="col-md-4">
        <label>Respiratory Rate</label>
        <input type="number" step="0.1" name="respiratory_rate" class="form-control" value="{{ $record->respiratory_rate ?? old('respiratory_rate') }}">
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4">
        <label>BMI</label>
        <input type="number" name="bmi" class="form-control" value="{{ $record->bmi ?? old('bmi') }}">
    </div>
</div>

@elseif($checkup->checkup_type === 'dental')
<div class="row">
    <div class="col-md-4">
        <label>Dental Status</label>
        <input type="text" name="dental_status" class="form-control" value="{{ $record->dental_status ?? old('dental_status') }}">
    </div>
    <div class="col-md-2">
        <label>Cavities</label>
        <input type="number" name="cavities" class="form-control" value="{{ $record->cavities ?? old('cavities') }}">
    </div>
    <div class="col-md-2">
        <label>Missing Teeth</label>
        <input type="number" name="missing_teeth" class="form-control" value="{{ $record->missing_teeth ?? old('missing_teeth') }}">
    </div>
    <div class="col-md-2">
        <label>Gum Disease</label>
        <select name="gum_disease" class="form-control">
            <option value="1" {{ isset($record) && $record->gum_disease ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ isset($record) && !$record->gum_disease ? 'selected' : '' }}>No</option>
        </select>
    </div>
    <div class="col-md-2">
        <label>Oral Hygiene</label>
        <select name="oral_hygiene" class="form-control">
            <option value="1" {{ isset($record) && $record->oral_hygiene ? 'selected' : '' }}>Good</option>
            <option value="0" {{ isset($record) && !$record->oral_hygiene ? 'selected' : '' }}>Poor</option>
        </select>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <label>Notes</label>
        <textarea name="notes" class="form-control">{{ $record->notes ?? old('notes') }}</textarea>
    </div>
</div>
@endif
