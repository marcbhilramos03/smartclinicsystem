@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f4ff;
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }
    /* Content container */
    .content-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    /* Dashboard cards */
    .content {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        align-items: center;
    }
    .dashboard-card {
        width: 320px;
        height: 200px;
        cursor: pointer;
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.25);
    }
    .card-icon {
        font-size: 4rem;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }
    .card-text {
        font-size: 1.1rem;
        font-weight: 500;
        color: #555;
    }
</style>

<div class="bg-light min-vh-100 p-4">
    <!-- Dashboard Cards -->
    <div class="content-wrapper">
        <div class="content">
            <a href="{{ route('patient.checkups.index') }}" class="text-decoration-none">
                <div class="card dashboard-card border-primary shadow-sm bg-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center h-100">
                        <i class="bi bi-heart-pulse-fill text-primary card-icon mb-3"></i>
                        <div class="card-title text-primary">Checkups</div>
                        <div class="card-text">View My Checkups</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('patient.medical_records.index') }}" class="text-decoration-none">
                <div class="card dashboard-card border-success shadow-sm bg-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center h-100">
                        <i class="bi bi-file-medical-fill text-success card-icon mb-3"></i>
                        <div class="card-title text-success">Medical Records</div>
                        <div class="card-text">View My Records</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
