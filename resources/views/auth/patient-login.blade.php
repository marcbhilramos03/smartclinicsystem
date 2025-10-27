@extends('layouts.guest')

@section('content')
<style>
    /* Center Wrapper */
    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        padding: 2rem;
        background-size: 200% 200%;
        animation: bgShift 6s ease-in-out infinite alternate;
    }

    @keyframes bgShift {
        0% { background-position: left top; }
        100% { background-position: right bottom; }
    }

    /* Glowing border container */
    .login-border {
        position: relative;
        padding: 5px;
        border-radius: 24px;
        background: linear-gradient(135deg, #131a23, #062025, #192c2f, #6227f7);
        background-size: 300% 300%;
        animation: borderMove 6s ease-in-out infinite alternate;
        box-shadow: 0 0 30px rgba(0, 123, 255, 0.35);
        width: 100%;
        max-width: 650px;
    }

    @keyframes borderMove {
        0% { background-position: left top; }
        100% { background-position: right bottom; }
    }

    /* Login Card - glass style */
    .login-card {
        background: rgba(255, 255, 255, 0.92);
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
        padding: 4rem 3rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(12px);
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: -100px;
        left: -100px;
        width: 250px;
        height: 250px;
        background: rgba(0, 119, 182, 0.12);
        border-radius: 50%;
        filter: blur(70px);
        z-index: 0;
    }

    .login-card h1 {
        font-weight: 800;
        font-size: 2.4rem;
        color: #003366;
        margin-bottom: 1rem;
        z-index: 1;
        position: relative;
    }

    .login-card p {
        font-size: 1.1rem;
        color: #444;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 1;
    }

    /* Inputs */
    .form-control {
        border-radius: 14px;
        padding: 1rem 1.2rem;
        border: 1px solid #cdd8e4;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.3);
    }

    /* Button */
    .btn-primary {
        background: linear-gradient(135deg, #007bff, #00b4d8);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 1rem;
        font-weight: 600;
        font-size: 1.2rem;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0062cc, #0096c7);
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 119, 182, 0.45);
    }

    /* Links */
    .small a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
    }

    .small a:hover {
        color: #0096c7;
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-card {
            padding: 3rem 1.8rem;
            max-width: 95%;
        }
        .login-card h1 { font-size: 2rem; }
        .login-card p { font-size: 1rem; }
    }
</style>

<div class="login-wrapper">
    <div class="login-border">
        <div class="login-card">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="SMARTCLINIC Logo" width="90" class="mb-4"> --}}
            <h1>Welcome Student!</h1>
            <p>Enter your School ID to access your account</p>

            <form method="POST" action="{{ route('patient.login') }}">
                @csrf

                @if ($errors->has('login_error'))
                    <div class="alert alert-danger py-2">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif

                <div class="mb-4 text-start">
                    <label class="form-label fw-semibold fs-5">School ID</label>
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

                <button type="submit" class="btn btn-primary mt-3">Login</button>
            </form>

            <div class="text-center small mt-4">
                <a href="{{ route('homepage') }}">←Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
