@extends('layouts.app')

@section('page-title', 'Assigned Checkups')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-primary mb-4">Assigned Checkups</h2>

    @if($checkups->isEmpty())
        <div class="alert alert-info">No checkups assigned yet.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkups as $checkup)
                    <tr>
                        <td>{{ $checkup->course->course_name ?? 'N/A' }}</td>
                        <td class="text-capitalize">{{ $checkup->checkup_type }}</td>
                        <td>{{ $checkup->date->format('F d, Y') }}</td>
                        <td>{{ $checkup->notes ?? '—' }}</td>
                        <td>
                            <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn btn-sm btn-primary">
                                View Students
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
