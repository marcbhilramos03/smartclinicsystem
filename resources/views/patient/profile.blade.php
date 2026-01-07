@extends('layouts.app')

@section('content')

<style>
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #e6f4ea, #c8f0d2);
    margin: 0;
    padding: 0;
    height: 100%;
}

.container-fluid {
    padding: 20px 15px;
}

h1.h3 {
    color: #198754;
    font-weight: 700;
}

.card-profile {
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    background: #fff;
    overflow: hidden;
    border-top: 6px solid #198754;
    transition: transform 0.2s ease;
    width: 100%;
    max-width: 900px;
}


.img-profile {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

h4.fw-bold {
    color: #198754;
    margin-top: 10px;
    margin-bottom: 0;
}

.list-group-item {
    border: none;
    padding: 6px 0;
    font-size: 0.95rem;
}

.list-group-item strong {
    color: #333;
}

.credential-section {
    background-color: #f6fdf7;
    padding: 15px 20px;
    border-radius: 12px;
    margin-top: 20px;
}

.credential-section h5 {
    color: #198754;
    font-weight: 700;
    margin-bottom: 10px;
}

.credential-section p {
    margin-bottom: 5px;
}

@media (max-width: 768px) {
    .row.g-0 {
        flex-direction: column;
        text-align: center;
    }
    .col-md-4, .col-md-8 {
        border: none !important;
    }
    .credential-section {
        text-align: left;
    }
}
</style>

<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <h1 class="h3 mb-2 mb-md-0">Patient Profile</h1>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card-profile shadow-sm mb-4">
            <div class="row g-0 align-items-center">
                
                <div class="col-12 col-md-4 text-center p-4 border-end border-light">
                    <img class="img-profile mb-3" src="{{ asset('images/profile.png') }}" alt="Profile Image">
                    <h4 class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h4>
                    <p class="text-muted">{{ $user->personalInformation->course ?? 'N/A' }} - {{ $user->personalInformation->grade_level ?? 'N/A' }}</p>
                </div>

                <div class="col-12 col-md-8 p-4 text-dark">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong>Gender:</strong> {{ $user->gender ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Date of Birth:</strong> {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') : 'N/A' }}</li>
                        <li class="list-group-item"><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone_number ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>School:</strong> {{ $user->personalInformation->school_id ?? 'N/A' }}</li>
                    </ul>

                    <div class="credential-section">
                        <h5>Emergency Contact</h5>
                        <p><strong>Name:</strong> {{ $user->personalInformation->emer_con_name ?? 'N/A' }}</p>
                        <p><strong>Relationship:</strong> {{ $user->personalInformation->emer_con_rel ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $user->personalInformation->emer_con_phone ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $user->personalInformation->emer_con_address ?? 'N/A' }}</p>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection
