@extends('layouts.app')

@section('content')
<style>
    /* Make content full width */
    .full-width-content {
        width: 100%;
        max-width: 100%;
        margin-left: 0; /* align with sidebar */
        padding-left: 1rem;
        padding-right: 1rem;
    }

    /* Make tables stretch full width */
    .full-width-content table {
        width: 100%;
    }
</style>

<div class="full-width-content mb-4">
    <h1 class="mb-4">Manage Patients</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Patients</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>School ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration + ($patients->currentPage()-1)*$patients->perPage() }}</td>
                            <td>{{ $patient->first_name }} {{ $patient->middle_name ?? '' }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->personalInformation->school_id ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-info text-white">View</a>
                                <a href="{{ route('admin.patients.records.create', $patient) }}" class="btn btn-sm btn-secondary">Add Record</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection
