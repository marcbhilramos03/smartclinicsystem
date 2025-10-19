@extends('layouts.app')

@section('page-title', 'Checkup Schedules')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Checkup Schedules</h2>
        <a href="{{ route('admin.checkups.create') }}" class="btn btn-primary">+ New Checkup</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Course/Grade</th>
                <th>Type</th>
                <th>Staff</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($checkups as $checkup)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $checkup->courseInformation->course ?? 'N/A' }}</td>
                    <td class="text-capitalize">{{ $checkup->checkup_type }}</td>
                    <td>{{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($checkup->date)->format('F d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.checkups.show', $checkup->id) }}" class="btn btn-sm btn-info">View</a>
                        <form action="{{ route('admin.checkups.destroy', $checkup->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this checkup?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No checkups found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
