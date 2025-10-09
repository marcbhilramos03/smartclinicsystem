@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Search Students</h1>

    <form action="{{ route('admin.patients.index') }}" method="GET" class="mb-3 d-flex gap-2">
        <input type="text" name="query" value="{{ $query ?? '' }}" placeholder="Search by School ID or Name" class="form-control">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>School ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td>{{ $student->first_name }} {{ $student->middle_name ?? '' }} {{ $student->last_name }}</td>
                <td>{{ $student->personalInformation->school_id ?? '-' }}</td>
                <td class="d-flex gap-1 flex-wrap">
                    <a href="{{ route('admin.patients.show', $student->user_id) }}" class="btn btn-info btn-sm">View Records</a>
                    <a href="{{ route('admin.patients.records.create', $student->user_id) }}" class="btn btn-success btn-sm">Add Record</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No students found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $students->withQueryString()->links() }}
</div>
@endsection
