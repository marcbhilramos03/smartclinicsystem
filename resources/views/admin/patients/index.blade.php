@extends('layouts.app')

@section('content')
<div class="container-fluid px-2">
    <h2 class="mb-4" style="font-size: 2.5rem; font-weight: 700; color: #222;">Latest Visits</h2>

    @if($patients->count())
        <div class="row g-3">
            @foreach($patients as $patient)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card patient-card shadow-sm border-0">

                    
                        <div class="card-body d-flex flex-column flex-md-row justify-content-start align-items-start">

                           
                            <div class="patient-info me-md-3">
                                <h5 class="card-title mb-2">
                                    {{ $patient->full_name ?? $patient->first_name . ' ' . $patient->last_name }}
                                </h5>

                       
                                <p class="mb-2">
                                    <i class="fas fa-id-card"></i>
                                    @if($patient->school_id)
                                        <span class="badge school-id">{{ $patient->school_id }}</span>
                                    @else
                                        <span class="badge school-id-missing">No School ID</span>
                                    @endif
                                </p>

                              
                                @if($patient->latestClinicSession)
                                    <span class="badge last-visit mb-0">
                                        Last Visit: {{ \Carbon\Carbon::parse($patient->latestClinicSession->session_date)->format('M d, Y') }}
                                    </span>
                                @else
                                    <p class="text-muted mb-0">No clinic sessions recorded.</p>
                                @endif
                            </div>

                          
                            <div class="patient-action mt-4 ms-auto">
                                <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-info btn-sm shadow-sm patient-btn">
                                    <i class="fas fa-eye me-2"></i> Details
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

      
        <div class="mt-4 d-flex justify-content-start">
            {{ $patients->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center">No patients found.</div>
    @endif
</div>

<style>
.patient-card {
    background: linear-gradient(145deg, #ffffff, #e8f0fe);
    border-radius: 16px;
    padding: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.patient-info h5 {
    color: #1a1a1a;
    font-size: 1.15rem;
    font-weight: 700;
}

.patient-info p {
    color: #555;
    margin-bottom: 0.4rem;
}

.patient-info .badge {
    padding: 0.3em 0.7em;
    border-radius: 12px;
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 600;
    margin-right: 0.3rem;
    
}

.badge.school-id {
    color: #000;
    text-shadow: 0 0 1px rgba(0,0,0,0.3);
}

.badge.school-id-missing {
    background-color: #6c757d;
    color: #fff;
    font-style: italic;
}

.badge.last-visit {
    color: #0b0b0b;
    background-color: #ffc107;
}

.patient-action .patient-btn {
    font-size: 1.2rem; 
    padding: 0.6rem 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: #000;
}

.patient-action .patient-btn i {
    font-size: 1.3rem;
}

.patient-action .patient-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .patient-card {
        text-align: center;
        flex-direction: column !important;
    }
    .patient-action {
        width: 100%;
        margin-top: 12px;
        text-align: center;
    }
}
</style>
@endsection
