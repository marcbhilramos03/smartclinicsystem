@extends('layouts.app')

@section('content')

<style>
/* ===== Body & Container ===== */
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #e6f4ea, #c8f0d2);
    margin: 0;
    padding: 0;
}

.container-fluid {
    padding: 20px 15px;
}

/* ===== Heading ===== */
h1.h3 {
    color: #198754;
    font-weight: 700;
}

/* ===== Profile Card ===== */
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

.card-profile:hover {
    transform: translateY(-3px);
}

/* ===== Profile Image ===== */
.img-profile {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #198754;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

/* ===== Name & Typography ===== */
h4.fw-bold {
    color: #198754;
    margin-top: 10px;
    margin-bottom: 0;
}

.list-group-item {
    border: none;
    padding-left: 0;
    padding-right: 0;
    padding-top: 6px;
    padding-bottom: 6px;
    font-size: 0.95rem;
}

.list-group-item strong {
    color: #333;
}

/* ===== Credential Section ===== */
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

/* ===== Responsive ===== */
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

    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <h1 class="h3 mb-2 mb-md-0">Patient Profile</h1>
    </div>

    <!-- Profile Card -->
    <div class="d-flex justify-content-center">
        <div class="card-profile shadow-sm mb-4">
            <div class="row g-0 align-items-center">
                
                <!-- Profile Image -->
                <div class="col-12 col-md-4 text-center p-4 border-end border-light">
                    <img class="img-profile mb-3" src="{{ asset('images/profile.png') }}" alt="Profile Image">
                    <h4 class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h4>
                </div>

                <!-- Personal Info -->
                <div class="col-12 col-md-8 p-4">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong>Gender:</strong> {{ $user->gender ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Date of Birth:</strong> {{ $user->date_of_birth ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone_number ?? 'N/A' }}</li>
                    </ul>

                    @if($user->credential)
                    <div class="credential-section">
                        <h5>Credential</h5>
                        <p><strong>Profession:</strong> {{ $user->credential->profession }}</p>
                        <p><strong>License:</strong> {{ $user->credential->license_type }}</p>
                        <p><strong>Specialization:</strong> {{ $user->credential->specialization }}</p>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
