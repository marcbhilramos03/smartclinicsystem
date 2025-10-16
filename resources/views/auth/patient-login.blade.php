@extends('layouts.guest')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden; /* no scroll */
        font-family: 'Poppins', sans-serif;
        background: #f8f9fc; /* light background */
    }

    /* Center wrapper */
    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
        padding: 1rem;
    }

    /* Login card */
    .login-card {
        background: #ffffff;
        color: #343a40;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 3.5rem 2.5rem;
        width: 100%;
        max-width: 480px;
        text-align: center;
        position: relative;
    }

    .login-card img {
        filter: drop-shadow(0 3px 5px rgba(0,0,0,0.1));
        margin-bottom: 1rem;
    }

    .login-title {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.25rem;
    }

    .login-subtitle {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 2rem;
    }

    /* Inputs */
    .form-control {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        outline: none;
        font-size: 1rem;
        width: 100%;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.15rem rgba(78,115,223,0.25);
    }

    /* Button */
    .btn-primary {
        background-color: #4e73df;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3458c0;
    }

    /* Links */
    .small a {
        color: #4e73df;
        text-decoration: none;
    }
    .small a:hover {
        color: #2e59d9;
    }

    @media (max-width: 768px) {
        .login-card {
            padding: 2rem 1.5rem;
            max-width: 95%;
        }
        .login-title { font-size: 1.6rem; }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <img src="{{ asset('images/logo.png') }}" alt="SMARTCLINIC Logo" width="85">
        <h1 class="login-title">Welcome Back!</h1>
        <p class="login-subtitle">Enter your School ID to access your account</p>

        <form method="POST" action="{{ route('patient.login') }}">
            @csrf

            @if ($errors->has('login_error'))
                <div class="alert alert-danger py-2">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <div class="mb-4 text-start">
                <label class="form-label fw-semibold">School ID</label>
                <input type="text" 
                       name="school_id" 
                       placeholder="Enter your School ID"
                       value="{{ old('school_id') }}"
                       class="form-control @error('school_id') is-invalid @enderror"
                       required autofocus>
                @error('school_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2">Login</button>
        </form>

        <div class="mt-4 text-center small">
            <a href="{{ route('login-admin') }}">← Back to Staff/Admin Login</a>
        </div>
    </div>
</div>
@endsection
