@extends('layouts.app')

@section('content')
<div class="bg-light min-vh-100 p-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('patient.dashboard') }}" class="btn btn-lg btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white"></i> Dashboard
        </a>
    </div>

    <div class="row">
        <!-- Left Column: Patient Info -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-dark">
                <div class="card-header py-3 bg-dark text-white">
                    <h5 class="m-0 font-weight-bold">Your Details</h5>
                </div>
                <div class="card-body text-center text-dark">
                    <img class="img-profile rounded-circle mb-4 border border-dark p-2 shadow-sm" 
                         src="{{ asset('images/profile.png') }}" 
                         width="150" height="150" alt="Profile Image">

                    <h3 class="font-weight-bold mb-1 text-black">
                        {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }} {{ auth()->user()->last_name }}
                    </h3>
                    <p class="text-primary font-weight-bold lead mb-4">Patient</p>

                    <ul class="list-group list-group-flush text-left mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark">
                            <strong class="text-secondary">Gender:</strong>
                            <span class="text-black">{{ ucfirst(auth()->user()->gender ?? 'N/A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark">
                            <strong class="text-secondary">Date of Birth:</strong>
                            <span class="text-black">
                                {{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('M d, Y') : 'N/A' }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark">
                            <strong class="text-secondary">Address:</strong>
                            <span class="text-black">{{ auth()->user()->address ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark">
                            <strong class="text-secondary">Contact:</strong>
                            <span class="text-black">{{ auth()->user()->phone_number ?? 'N/A' }}</span>
                        </li>
                    </ul>

                    <button type="button" class="btn btn-dark btn-lg mt-3 w-100 shadow" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-user-edit fa-lg me-2"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Security / Logout -->
        <div class="col-lg-8 col-md-6 mb-4">
            <div class="card shadow border-dark">
                <div class="card-header py-3 bg-dark text-white">
                    <h5 class="m-0 font-weight-bold">School and Emergency Details</h5>
                </div>
                <div class="card-body text-dark">
                    <p class="lead text-dark">
                        Manage your personal information and ensure your account stays secure. You can log out safely or update your details anytime.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
