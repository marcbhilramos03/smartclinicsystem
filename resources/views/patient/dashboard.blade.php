<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Dashboard</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background-color: #f0f4ff;
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* Topbar */
    .topbar {
        background-color: #1e3a8a;
        color: white;
        padding: 0.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 0.3rem 0.6rem rgba(0,0,0,0.15);
        flex-shrink: 0;
    }
    .topbar .profile {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .topbar .profile img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid white;
    }
    .topbar .profile .name {
        font-weight: 600;
        font-size: 1rem;
    }
    .topbar .profile .logout-btn {
        margin-left: 1rem;
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
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <div class="logo">
        <h3 class="text-white m-0">Patient Dashboard</h3>
    </div>
    <div class="profile">
                <a href="{{ asset('patient.profile') }}" >
                    <div class="profile">
    <a href="{{ route('patient.profile') }}" class="btn btn-light btn-sm logout-btn">
        <img class="img-profile rounded-circle" src="{{ asset('images/profile.png') }}" alt="Profile">
    </a>
</div>

        <span class="name">John Doe</span></a>
        </div>
</div>

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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
