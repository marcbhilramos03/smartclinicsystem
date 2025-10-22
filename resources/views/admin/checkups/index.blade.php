@extends('layouts.app')

@section('page-title', 'Checkups')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Checkups</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.checkups.create') }}" class="btn btn-primary mb-3">Create New Checkup</a>

    @if($checkups->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Checkup Type</th>
                        <th>Patients (Course)</th>
                        <th>Staff</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkups as $checkup)
                        <tr>
                            <td>{{ $checkup->date }}</td>
                            <td>{{ ucfirst($checkup->checkup_type) }}</td>
                            <td>
                                @if($checkup->patients->isNotEmpty())
                                    @foreach($checkup->patients as $patient)
                                        {{ $patient->personalInformation?->first_name ?? '-' }}
                                        {{ $patient->personalInformation?->last_name ?? '' }}
                                        ({{ $patient->personalInformation?->course ?? '-' }})<br>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $checkup->staff?->first_name ?? '-' }}</td>
                            <td>{{ $checkup->admin?->first_name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.checkups.show', $checkup->id) }}" class="btn btn-info btn-sm">View</a>
                                <form action="{{ route('admin.checkups.destroy', $checkup->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this checkup?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination links -->
        <div class="mt-3">
            {{ $checkups->links() }}
        </div>
    @else
        <p>No checkups found.</p>
    @endif
</div>
@endsection
