@extends('layouts.app')

@section('content')
{{-- Main wrapper with sidebar offset --}}
<div class="main-content" style="margin-left: 250px; min-height: 100vh; padding: 2rem;">

    {{-- SUCCESS & ERROR MESSAGES --}}
    <div class="container-fluid mb-4">
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
    <div class="row g-4">
        {{-- LEFT SIDE: Profile Info --}}
        <div class="col-lg-8 col-md-12 d-flex">
            <div class="card shadow-sm border-0 w-100 hover-scale">
                <div class="card-header py-3 bg-dark text-white">
                    <h4 class="m-0 fw-bold">Your Profile</h4>
                </div>

                <div class="card-body text-center text-dark d-flex flex-column justify-content-between">
                    <div>
                        <img class="img-profile rounded-circle mb-4 border border-3 border-dark shadow-sm"
                             src="{{ asset('images/profile.png') }}" width="180" height="180" alt="Profile Image">

                        <h3 class="fw-bold mb-3 text-dark">
                            {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }} {{ auth()->user()->last_name }}
                        </h3>

                        <ul class="list-group list-group-flush text-start mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center fs-5">
                                <span class="text-muted">Email:</span>
                                <span class="fw-semibold">{{ auth()->user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fs-5">
                                <span class="text-muted">Profession:</span>
                                <span class="fw-semibold">{{ auth()->user()->credential->profession ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fs-5">
                                <span class="text-muted">License:</span>
                                <span class="fw-semibold">{{ auth()->user()->credential->license_type ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-gradient btn-lg mt-3 w-100 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-user-edit me-2"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE: Security --}}
        <div class="col-lg-4 col-md-12 d-flex">
            <div class="card shadow-sm border-0 w-100 hover-scale">
                <div class="card-header py-3 bg-dark text-white">
                    <h5 class="m-0 fw-bold">Security & Activity</h5>
                </div>

                <div class="card-body text-dark">
                    <p class="lead text-dark">Manage your account security and update your password.</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                   class="form-control form-control-lg" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">New Password</label>
                            <input type="password" name="new_password" id="new_password"
                                   class="form-control form-control-lg" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                   class="form-control form-control-lg" required>
                        </div>

                        <button type="submit" class="btn btn-gradient btn-lg w-100">
                            <i class="fas fa-key me-2"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Profile Modal --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-sm">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h4 class="modal-title" id="editProfileModalLabel">Update Profile</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="first_name" class="form-label fw-semibold">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control form-control-lg"
                                   value="{{ old('first_name', auth()->user()->first_name) }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="middle_name" class="form-label fw-semibold">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" class="form-control form-control-lg"
                                   value="{{ old('middle_name', auth()->user()->middle_name) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="last_name" class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control form-control-lg"
                                   value="{{ old('last_name', auth()->user()->last_name) }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg"
                                   value="{{ old('email', auth()->user()->email) }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="profession" class="form-label fw-semibold">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control form-control-lg"
                                   value="{{ old('profession', auth()->user()->credential->profession ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="license_type" class="form-label fw-semibold">License Type</label>
                            <input type="text" name="license_type" id="license_type" class="form-control form-control-lg"
                                   value="{{ old('license_type', auth()->user()->credential->license_type ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-gradient btn-lg">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Extra CSS --}}
<style>
    .btn-gradient {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: #fff;
        border: none;
        transition: 0.3s;
    }
    .btn-gradient:hover {
        background: linear-gradient(to right, #2575fc, #6a11cb);
        color: #fff;
    }

</style>
@endsection
