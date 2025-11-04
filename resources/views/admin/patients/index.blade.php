@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center" style="font-size: 2.5rem;">Latest Visits</h2>

    @if($patients->count())
        <div class="row g-4">
            @foreach($patients as $patient)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card patient-card shadow-sm border-0">

                        {{-- Card body --}}
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">

                            {{-- Patient Info --}}
                            <div class="patient-info me-md-3">
                                <h5 class="card-title mb-2" style="font-size: 1.1rem; font-weight: 700;">
                                    {{ $patient->full_name ?? $patient->first_name . ' ' . $patient->last_name }}
                                </h5>

                                {{-- School ID Badge --}}
                                <p class="mb-2" style="font-size: 0.95rem;">
                                    <i class="fas fa-id-card me-1"></i>
                                    @if($patient->school_id)
                                        <span class="badge school-id" style="font-size: 1rem;">{{ $patient->school_id }}</span>
                                    @else
                                        <span class="badge school-id-missing" style="font-size: 1rem;">No School ID</span>
                                    @endif
                                </p>

                                {{-- Latest Clinic Session --}}
                                @if($patient->latestClinicSession)
                                    <span class="badge last-visit mb-0" style="font-size: 1rem;">
                                        Last Visit: {{ \Carbon\Carbon::parse($patient->latestClinicSession->session_date)->format('M d, Y') }}
                                    </span>
                                @else
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">No clinic sessions recorded.</p>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            <div class="patient-action mt-3 mt-md-0">
                                <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-info btn-sm shadow-sm" style="font-size: 0.9rem;">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $patients->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center" style="font-size: 1rem;">No patients found.</div>
    @endif
</div>

{{-- Internal CSS --}}
<style>
.patient-card {
    background: linear-gradient(145deg, #ffffff, #f3f6f9);
    border-radius: 16px;
    padding: 1.2rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.patient-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.patient-info h5 {
    color: #1a1a1a;
}

.patient-info p {
    color: #555;
}

.patient-info .badge {
    padding: 0.25em 0.5em;
    border-radius: 12px;
    display: inline-block;
    margin-bottom: 0.3rem;
}

.badge.school-id {
    color: #000000;
}

.badge.school-id-missing {
    background-color: #6c757d;
    color: #fff;
    font-style: italic;
}

.badge.last-visit {
    color: #010100;
}

.patient-action a {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: inline-block;
}

.patient-action a:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .patient-card {
        text-align: center;
        flex-direction: column !important;
    }
    .patient-action {
        width: 100%;
        margin-top: 10px;
    }
}
</style>
@endsection
