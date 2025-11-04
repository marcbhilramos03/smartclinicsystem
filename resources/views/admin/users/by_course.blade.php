@extends('layouts.app')

@section('page-title', 'Students in ' . $course)

@section('content')
<div class="container-fluid">
    {{-- Back Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">List of Students</h5>
        </div>
        <div class="card-body table-responsive">
            @if($patients->isEmpty())
                <p class="text-center text-muted">No students found for this course.</p>
            @else
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>School ID</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $index => $patient)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $patient->last_name }}, {{ $patient->first_name }}</td>
                                <td>{{ $patient->personalInformation->school_id ?? 'N/A' }}</td>
                                <td>{{ $patient->personalInformation->course ?? 'N/A' }}</td>
                                <td>{{ $patient->personalInformation->grade_level ?? 'N/A' }}</td>
                                <td>
                                            <a href="{{ route('admin.users.show', $patient->user_id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('admin.users.edit', $patient->user_id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $patient->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
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
