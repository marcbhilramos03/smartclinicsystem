@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800 mb-2 mb-md-0">Patient Profile</h1>
      
    </div>

    <!-- Landscape Profile Card -->
    <div class="d-flex justify-content-center">
        <div class="card shadow-sm mb-4 w-100" style="max-width: 900px;">
            <div class="row g-0 align-items-center">
                <!-- Profile Image -->
                <div class="col-12 col-md-4 text-center p-4 border-end">
                    <img class="img-profile rounded-circle border border-secondary mb-3" src="{{ asset('images/profile.png') }}" width="140" height="140">
                    <h4 class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h4>
                    <button type="button" class="btn btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </button>
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
                        <div class="border-top pt-3 mt-3">
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
