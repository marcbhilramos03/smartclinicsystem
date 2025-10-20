@extends('layouts.app')

@section('page-title', 'Students List')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary">
            Students under {{ $checkup->checkup_type }} Checkup
        </h1>
        <a href="{{ route('staff.checkups.index') }}" class="btn btn-secondary">← Back to Checkups</a>
    </div>

    {{-- Student Table --}}
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            @if ($students->isEmpty())
                <p class="text-muted text-center mb-0">No students found for this course.</p>
            @else
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $student->first_name ?? 'N/A' }} {{ $student->last_name ?? '' }}
                                </td>
                                <td>
                                    {{-- Safely access nested relations using optional() --}}
                                    {{ optional(optional($student->personalInformation)->course)->course ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ optional(optional($student->personalInformation)->course)->grade_level ?? 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ route('staff.checkup_records.create', ['checkupId' => $checkup->id, 'studentId' => $student->user_id]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Add Record
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
