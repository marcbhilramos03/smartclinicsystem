@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-dark fw-bold">My Students</h1>

    @if($students->count() > 0)
        <div class="row g-3">
            @foreach($students as $student)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                            <h5 class="card-title fw-semibold">{{ $student->personalInformation->full_name ?? 'N/A' }}</h5>
                            <p class="text-muted small mb-2">{{ $student->personalInformation->course ?? '' }}</p>

                            @php
                                $firstCheckupPatient = $student->checkupPatients()->first();
                            @endphp

                            @if($firstCheckupPatient)
                                <a href="{{ route('staff.checkups.show', $firstCheckupPatient->checkup->id) }}" class="btn btn-sm btn-success">
                                    View Checkups
                                </a>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>No Checkups</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No students assigned to your checkups.</p>
    @endif
</div>
@endsection
