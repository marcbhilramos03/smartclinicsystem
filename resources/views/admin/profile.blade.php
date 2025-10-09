@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin Profile</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dashboard
        </a>
    </div>

    <div class="row">

        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle mb-3" src="{{ asset('img/user.png') }}" width="120" height="120">
                    <h4 class="font-weight-bold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                    <p class="text-muted">{{ auth()->user()->role }}</p>
                    <p class="text-gray-600 small">Email: {{ auth()->user()->email }}</p>
                    <p class="text-gray-600 small">Profession: {{ auth()->user()->profession ?? '-' }}</p>
                    <p class="text-gray-600 small">License: {{ auth()->user()->license_type ?? '-' }}</p>

                    <!-- Edit Profile Button -->
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.profile.update') }}">
          @csrf
          @method('PUT')

          <div class="modal-header">
              <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label for="first_name">First Name</label>
                      <input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label for="middle_name">Middle Name</label>
                      <input type="text" name="middle_name" class="form-control" value="{{ auth()->user()->middle_name }}">
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label for="last_name">Last Name</label>
                      <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label for="email">Email</label>
                      <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label for="profession">Profession</label>
                      <input type="text" name="profession" class="form-control" value="{{ auth()->user()->profession }}">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label for="license_type">License Type</label>
                      <input type="text" name="license_type" class="form-control" value="{{ auth()->user()->license_type }}">
                  </div>
              </div>
          </div>

          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Profile</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
