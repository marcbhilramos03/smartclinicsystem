@extends('layouts.app')

@section('content')
{{-- Removed 'container-fluid' and added a padding utility (p-4) to simulate full-width content 
     while retaining some margin from the screen edges --}}
<div class="bg-light min-vh-100"> 

    <div class="d-sm-flex align-items-center justify-content-between mb-1">

        <a href="{{ route('admin.dashboard') }}" class="btn btn-lg btn-primary shadow-sm"> {{-- Bigger button --}}
            <i class="fas fa-arrow-left fa-sm text-white "></i>Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-dark"> {{-- Darker border for the card --}}
                <div class="card-header py-3 bg-dark text-white"> {{-- Dark header --}}
                    <h5 class="m-0 font-weight-bold">Your Details</h5> {{-- Slightly bigger font in card header --}}
                </div>
                <div class="card-body text-center text-dark">
                    <img class="img-profile rounded-circle mb-4 border border-dark p-2 shadow-sm" 
                         src="{{ asset('images/profile.png') }}" width="150" height="150" alt="Profile Image"> {{-- Bigger image --}}
                    
                    <h3 class="font-weight-bold mb-1 text-black">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h3> {{-- Bigger name --}}
                    <p class="text-primary font-weight-bold lead mb-4">{{ auth()->user()->role }}</p> {{-- Bigger role text --}}

                    <ul class="list-group list-group-flush text-left mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark"> {{-- Bigger list item font --}}
                            <strong class="text-secondary">Email:</strong>
                            <span class="text-black">{{ auth()->user()->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark">
                            <strong class="text-secondary">Profession:</strong>
                            <span class="text-black">{{ auth()->user()->profession ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center h5 text-dark">
                            <strong class="text-secondary">License:</strong>
                            <span class="text-black">{{ auth()->user()->license_type ?? 'N/A' }}</span>
                        </li>
                    </ul>

                    <button type="button" class="btn btn-dark btn-lg mt-3 w-100 shadow" data-bs-toggle="modal" data-bs-target="#editProfileModal"> {{-- Bigger and darker button --}}
                        <i class="fas fa-user-edit fa-lg me-2"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-6 mb-4">
            <div class="card shadow border-dark">
                <div class="card-header py-3 bg-dark text-white">
                    <h5 class="m-0 font-weight-bold">Security & Activity</h5>
                </div>
                <div class="card-body text-dark">
                    <p class="lead text-dark">This area is reserved for security settings like password change forms, two-factor authentication, or a detailed log of recent account activity. Keep your account secure!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-l"> {{-- Larger modal dialog --}}
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="modal-header bg-dark text-white"> {{-- Dark header --}}
                    <h4 class="modal-title" id="editProfileModalLabel">Update Profile Details</h4> {{-- Bigger modal title --}}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-dark">
                    <div class="row">
                        <div class="col-md-6 mb-4"> {{-- Increased margin --}}
                            <label for="first_name" class="form-label h6 text-black">First Name</label> {{-- Bigger label --}}
                            <input type="text" name="first_name" id="first_name" class="form-control form-control-lg" value="{{ auth()->user()->first_name }}"> {{-- Bigger input --}}
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="middle_name" class="form-label h6 text-black">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" class="form-control form-control-lg" value="{{ auth()->user()->middle_name }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="last_name" class="form-label h6 text-black">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control form-control-lg" value="{{ auth()->user()->last_name }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label h6 text-black">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ auth()->user()->email }}">
                        </div>
                    </div>
                    
                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="profession" class="form-label h6 text-black">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control form-control-lg" value="{{ auth()->user()->profession }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="license_type" class="form-label h6 text-black">License Type</label>
                            <input type="text" name="license_type" id="license_type" class="form-control form-control-lg" value="{{ auth()->user()->license_type }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark btn-lg">Update Profile</button> {{-- Dark submit button --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection