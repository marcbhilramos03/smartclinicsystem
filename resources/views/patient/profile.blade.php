{{-- resources/views/patient/profile.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background-color: #f0f4ff;
        min-height: 100vh;
    }
    .profile-card {
        max-width: 500px;
        margin: 3rem auto;
        background: #1e3a8a;
        color: white;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.25);
    }
    .profile-card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid white;
        margin-bottom: 1rem;
    }
    .profile-card h1 {
        font-size: 2rem;
        margin-bottom: 0.3rem;
    }
    .profile-card p {
        font-size: 5rem;
        margin-bottom: 0.8rem;
        opacity: 0.9;
    }
    .profile-info {
        text-align: left;
        margin-top: 1rem;
        background: rgba(255,255,255,0.1);
        padding: 1rem;
        border-radius: 10px;
    }
    .profile-info dt {
        font-weight: 600;
    }
    .profile-info dd {
        margin-bottom: 0.5rem;
    }
</style>
</head>
<body>

<div class="profile-card">
        <img class="img-profile rounded-circle" src="{{ asset('images/profile.png') }}" alt="Profile">
    <h1>{{ auth()->user()->first_name }}  {{ auth()->user()->middle_name }} {{ auth()->user()->last_name }}</h1>

    <dl class="profile-info">
    
        <dd>{{ auth()->user()->phone_number ?? '-' }}</dd>

        <dt>Gender:</dt>
        <dd>{{ ucfirst(auth()->user()->gender ?? '-') }}</dd>

        <dt>Date of Birth:</dt>
        <dd>{{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('M d, Y') : '-' }}</dd>

        <dt>Address:</dt>
        <dd>{{ auth()->user()->address ?? '-' }}</dd>
    </dl>
    
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-light btn-xl logout-btn">
        Logout
    </button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
