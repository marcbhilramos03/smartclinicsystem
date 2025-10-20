@extends('layouts.app')

@section('page-title', 'Edit Checkup')

@section('content')
<div class="container mt-4">
    <h2>Edit Checkup</h2>

    <form action="{{ route('admin.checkups.update', $checkup->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Staff --}}
        <div class="mb-3">
            <label for="staff_id" class="form-label">Assign Staff</label>
            <select name="staff_id" id="staff_id" class="form-select" required>
                <option value="">-- Select Staff --</option>
                @foreach($staff as $s)
                    <option value="{{ $s->user_id }}" {{ $checkup->staff_id == $s->user_id ? 'selected' : '' }}>
                        {{ $s->first_name }} {{ $s->last_name }}
                    </option>
                @endforeach
            </select>
            @error('staff_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Course --}}
        <div class="mb-3">
            <label for="course_information_id" class="form-label">Assign Course</label>
            <select name="course_information_id" id="course_information_id" class="form-select" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $checkup->course_information_id == $course->id ? 'selected' : '' }}>
                        {{ $course->course }}
                    </option>
                @endforeach
            </select>
            @error('course_information_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Checkup Type --}}
        <div class="mb-3">
            <label for="checkup_type" class="form-label">Checkup Type</label>
            <select name="checkup_type" id="checkup_type" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="vital" {{ $checkup->checkup_type == 'vital' ? 'selected' : '' }}>Vital</option>
                <option value="dental" {{ $checkup->checkup_type == 'dental' ? 'selected' : '' }}>Dental</option>
            </select>
            @error('checkup_type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $checkup->date->format('Y-m-d') }}" required>
            @error('date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Notes --}}
        <div class="mb-3">
            <label for="notes" class="form-label">Notes / Recommendations</label>
            <textarea name="notes" id="notes" class="form-control" rows="3">{{ $checkup->notes }}</textarea>
            @error('notes')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.checkups.show', $checkup->id) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Update Checkup</button>
        </div>
    </form>
</div>
@endsection
