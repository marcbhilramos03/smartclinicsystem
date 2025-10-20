@extends('layouts.app')

@section('page-title', 'Add Dental Record')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Add Dental Record for {{ $student->first_name }} {{ $student->last_name }}</h2>

<form action="{{ route('staff.checkup_records.store', ['checkupId' => $checkup->id, 'studentId' => $student->user_id]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Dental Status</label>
            <input type="text" name="dental_status" class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Cavities</label>
                <input type="number" name="cavities" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Missing Teeth</label>
                <input type="number" name="missing_teeth" class="form-control">
            </div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="gum_disease" value="1" class="form-check-input" id="gum_disease">
            <label for="gum_disease" class="form-check-label">Gum Disease Present</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="oral_hygiene" value="1" class="form-check-input" id="oral_hygiene" checked>
            <label for="oral_hygiene" class="form-check-label">Good Oral Hygiene</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Dental Record</button>
        <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
