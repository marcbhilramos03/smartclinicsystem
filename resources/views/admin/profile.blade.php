@extends('layouts.app')

@section('content')
<div class="bg-light min-vh-100">

    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-lg btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white"></i> Dashboard
        </a>
    </div>

    {{-- ✅ SUCCESS & ERROR MESSAGES --}}
    <div class="container mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>There were some problems with your input:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- MAIN CONTENT --}}
    <div class="row d-flex align-items-stretch">
        {{-- LEFT SIDE: Profile Info (Larger) --}}
        <div class="col-lg-8 col-md-7 mb-4 d-flex">
            <div class="card shadow border-dark w-100 h-100">
                <div class="card-header py-3 bg-dark text-white">
                    <h4 class="m-0 font-weight-bold">Your Details</h4>
                </div>

                <div class="card-body text-center text-dark d-flex flex-column justify-content-between">
                    <div>
                        <img class="img-profile rounded-circle mb-4 border border-dark p-2 shadow-sm"
                             src="{{ asset('images/profile.png') }}" width="180" height="180" alt="Profile Image">

                        <h3 class="fw-bold mb-3 text-black">
                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        </h3>

                        <ul class="list-group list-group-flush text-left mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center fs-5 text-dark">
                                <strong class="text-secondary">Email:</strong>
                                <span class="text-black">{{ auth()->user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fs-5 text-dark">
                                <strong class="text-secondary">Profession:</strong>
                                <span class="text-black">{{ auth()->user()->credential->profession ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fs-5 text-dark">
                                <strong class="text-secondary">License:</strong>
                                <span class="text-black">{{ auth()->user()->credential->license_type ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-dark btn-lg mt-3 w-100 shadow"
                            data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-user-edit fa-lg me-2"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE: Security & Activity (Smaller) --}}
        <div class="col-lg-4 col-md-5 mb-4 d-flex">
            <div class="card shadow border-dark w-100 h-100">
                <div class="card-header py-3 bg-dark text-white">
                    <h5 class="m-0 font-weight-bold">Security & Activity</h5>
                </div>

                <div class="card-body text-dark">
                    <p class="lead text-dark">Manage your account security and change your password below.</p>

                    {{-- CHANGE PASSWORD FORM --}}
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold text-dark">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                   class="form-control form-control-lg" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold text-dark">New Password</label>
                            <input type="password" name="new_password" id="new_password"
                                   class="form-control form-control-lg" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-bold text-dark">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                   class="form-control form-control-lg" required>
                        </div>

                        <button type="submit" class="btn btn-dark btn-lg mt-2 w-100">
                            <i class="fas fa-key me-2"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Edit Profile Modal --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h4 class="modal-title" id="editProfileModalLabel">Update Profile Details</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-dark">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="first_name" class="form-label h6 text-black">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control form-control-lg"
                                   value="{{ old('first_name', auth()->user()->first_name) }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="middle_name" class="form-label h6 text-black">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" class="form-control form-control-lg"
                                   value="{{ old('middle_name', auth()->user()->middle_name) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="last_name" class="form-label h6 text-black">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control form-control-lg"
                                   value="{{ old('last_name', auth()->user()->last_name) }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label h6 text-black">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg"
                                   value="{{ old('email', auth()->user()->email) }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="profession" class="form-label h6 text-black">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control form-control-lg"
                                   value="{{ old('profession', auth()->user()->credential->profession ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="license_type" class="form-label h6 text-black">License Type</label>
                            <input type="text" name="license_type" id="license_type" class="form-control form-control-lg"
                                   value="{{ old('license_type', auth()->user()->credential->license_type ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark btn-lg">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
