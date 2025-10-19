@extends('layouts.app')

@section('page-title', 'Checkup Details')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Checkup Details</h1>

    {{-- Checkup Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Checkup Type: {{ $checkup->checkup_type }}</h5>
            <p><strong>Date:</strong> {{ $checkup->date->format('F d, Y') }}</p>
            <p><strong>Admin:</strong> {{ $checkup->admin->first_name ?? '-' }} {{ $checkup->admin->last_name ?? '' }}</p>
            <p><strong>Staff:</strong> {{ $checkup->staff->first_name ?? '-' }} {{ $checkup->staff->last_name ?? '' }}</p>
            <p><strong>Course:</strong> {{ $checkup->course->course ?? '-' }} - {{ $checkup->course->grade_level ?? '-' }}</p>
            <p><strong>Notes:</strong> {{ $checkup->notes ?? '-' }}</p>
        </div>
    </div>

    {{-- Students --}}
    <h3>Students in this Checkup</h3>
    @if($students->count() > 0)
   <table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>School ID</th>
            <th>Course</th>
            <th>Year Level</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->personalInformation->school_id ?? '-' }}</td>
                <td>{{ $student->personalInformation->course->course ?? '-' }}</td>
                <td>{{ $student->personalInformation->course->grade_level ?? '-' }}</td>
                <td>
            <a href="{{ route('staff.checkup_records.create', ['checkupId' => $checkup->id, 'studentId' => $student->user_id]) }}" class="btn btn-primary btn-sm">Add Record
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No students found</td>
            </tr>
        @endforelse
    </tbody>
</table>

    @else
    <p>No students found for this checkup.</p>
    @endif

</div>
@endsection
