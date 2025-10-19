@extends('layouts.app')

@section('page-title', 'Create Checkup')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-primary mb-3">Create Checkup Schedule</h2>

    <form action="{{ route('admin.checkups.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Select Course/Grade</label>
            <select name="course_information_id" class="form-select" required>
                <option value="">-- Select Course/Grade --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course }} - {{ $course->year_level }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Staff</label>
            <select name="staff_id" class="form-select" required>
                <option value="">-- Select Staff --</option>
                @foreach($staff as $member)
                    <option value="{{ $member->user_id }}">{{ $member->first_name }} {{ $member->last_name }} {{ $member->license_type }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Checkup Type</label>
            <select name="checkup_type" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="vital">Vital Checkup</option>
                <option value="dental">Dental Checkup</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Checkup Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create Schedule</button>
        <a href="{{ route('admin.checkups.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
