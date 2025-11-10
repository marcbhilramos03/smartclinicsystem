@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-dark fw-bold">Doctors Dashboard</h1>

    <div class="row g-4">
        <!-- My Checkups -->
        <div class="col-md-4">
            <a href="{{ route('staff.checkups.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 hover-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-notes-medical fa-3x text-primary mb-3"></i>
                        <h5 class="card-title text-dark fw-semibold">My Checkups</h5>
                        <p class="text-muted small mb-0">View and manage your assigned checkups</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- View Records -->
        <div class="col-md-4">
            <a href="" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 hover-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-medical fa-3x text-success mb-3"></i>
                        <h5 class="card-title text-dark fw-semibold">View Records</h5>
                        <p class="text-muted small mb-0">Access medical records and diagnosis</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- View Patients -->
        <div class="col-md-4">
            <a href="" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 hover-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-user-injured fa-3x text-danger mb-3"></i>
                        <h5 class="card-title text-dark fw-semibold">View Students</h5>
                        <p class="text-muted small mb-0">Browse the list of registered students</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
    }
</style>
@endsection
