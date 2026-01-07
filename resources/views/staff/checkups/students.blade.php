@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <h2 class="h4 mb-3 mb-md-0 text-gray-800">
            Students in Checkup
        </h2>

        <a href="{{ route('staff.checkups.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Students Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Grade Level</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($checkup->patients as $student)
                        <tr>
                            <td class="fw-semibold">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </td>

                            <td>
                                {{ $student->personalInformation->course ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $student->personalInformation->grade_level ?? 'N/A' }}
                            </td>

                            <td>
                                @php
                                    $status = $student->pivot->status ?? 'pending';
                                @endphp

                                <span class="badge 
                                    {{ $status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('staff.checkup_records.create', [$checkup->id, $student->user_id]) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-notes-medical me-1"></i>
                                    Add / Edit
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No students assigned to this checkup.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
@endsection
