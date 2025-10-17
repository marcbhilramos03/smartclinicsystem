@extends('layouts.app')

@section('content')
<style>
    /* Full width content */
    .full-width-content {
        width: 100%;
        max-width: 100%;
        margin-left: 0; /* align with sidebar */
        padding-left: 1rem;
        padding-right: 1rem;
    }

    /* Make table full width */
    .full-width-content table {
        width: 100%;
    }
</style>

<div class="full-width-content mb-4">
    <h1>Scheduled Checkups</h1>
    <a href="{{ route('admin.checkups.create') }}" class="btn btn-primary mb-3">Schedule Checkup</a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Staff</th>
                        <th>Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkups as $checkup)
                    <tr>
                        <td>{{ $checkup->patient->first_name }} {{ $checkup->patient->last_name }}</td>
                        <td>{{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}</td>
                        <td>{{ $checkup->date }}</td>
                        <td>{{ $checkup->notes }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No scheduled checkups found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $checkups->links() }}
        </div>
    </div>
</div>
@endsection
