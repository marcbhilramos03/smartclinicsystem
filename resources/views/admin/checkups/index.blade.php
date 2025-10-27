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
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Date</th>
                        <th>Checkup Type</th>
                        <th>Course</th>
                        <th>Total Students</th>
                        <th>Performed By</th>
                        <th>Scheduled By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($checkups as $checkup)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($checkup->date)->format('F d, Y') }}</td>
                            <td>{{ ucfirst($checkup->checkup_type) }}</td>

                            {{-- Display assigned courses/patients --}}
                            <td>
                                @if($checkup->patients->isNotEmpty())
                                    @foreach($checkup->patients as $patient)
                                        {{ $patient->personalInformation?->course ?? 'N/A' }}<br>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>

                            {{-- ✅ Show total patient count --}}
                            <td>
                                <span class="badge bg-primary">
                                    {{ $checkup->patients->count() }}
                                </span>
                            </td>

                            {{-- Performed by --}}
                            <td>
                                {{ $checkup->staff?->first_name ?? '-' }}
                                {{ $checkup->staff?->last_name ?? '-' }}
                                <small class="text-muted">
                                    {{ $checkup->staff?->credential->license_type ?? '' }}
                                </small>
                            </td>

                            {{-- Scheduled by --}}
                            <td>
                                {{ $checkup->admin?->first_name ?? '-' }}
                                {{ $checkup->admin?->last_name ?? '-' }}
                                <small class="text-muted">
                                    {{ $checkup->admin?->credential->license_type ?? '' }}
                                </small>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('admin.checkups.show', $checkup->id) }}" class="btn btn-info btn-sm">View</a>

                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $checkup->id }}">
                                    Delete
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $checkup->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $checkup->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-danger">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $checkup->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this checkup on
                                                <strong>{{ \Carbon\Carbon::parse($checkup->date)->format('F d, Y') }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.checkups.destroy', $checkup->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $checkups->links() }}
        </div>
    @else
        <p>No checkups found.</p>
    @endif
</div>
@endsection
