@extends('layouts.guest')

@section('content')
<style>
    /* Background and Center Wrapper */
    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Subtle animated overlay for effect */
    .login-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        backdrop-filter: blur(4px);
        z-index: 0;
    }

    /* Card Container */
    .login-card {
        position: relative;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 24px;
        padding: 4rem 3rem;
        width: 100%;
        max-width: 650px;
        text-align: center;
        box-shadow: 0 10px 35px rgba(78, 115, 223, 0.35);
        backdrop-filter: blur(12px);
        z-index: 1;
        overflow: hidden;
    }

    /* Animated Glowing Border */
    .login-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 24px;
        padding: 3px;
        background: linear-gradient(135deg, #131a23, #062025, #192c2f, #6227f7);
        background-size: 300% 300%;
        animation: borderFlow 6s ease-in-out infinite alternate;
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    @keyframes borderFlow {
        0% { background-position: left top; }
        100% { background-position: right bottom; }
    }

    /* Title and Subtitle */
    .login-title {
        font-weight: 800;
        font-size: 2.3rem;
        margin-bottom: 1rem;
        color: #003366;
        letter-spacing: 0.5px;
    }

    .login-subtitle {
        font-size: 1.1rem;
        color: #444;
        margin-bottom: 2.5rem;
    }

    /* Input Fields */
    .form-control {
        border-radius: 14px;
        padding: 1rem 1.2rem;
        border: 1px solid #94a3b8;
        background: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
        color: #333;
        width: 100%;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: #6c757d;
    }

    .form-control:focus {
        border-color: #00b4d8;
        box-shadow: 0 0 0 0.25rem rgba(0,180,216,0.3);
        background: rgba(255, 255, 255, 0.95);
    }

    /* Button */
    .btn-primary {
        background: linear-gradient(135deg, #4e73df, #00b4d8);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 1rem;
        font-weight: 600;
        font-size: 1.2rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2e59d9, #0096c7);
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(78,115,223,0.45);
    }

    /* Small Link */
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
        .login-title { font-size: 2rem; }
        .login-subtitle { font-size: 1rem; }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        {{-- <img src="{{ asset('images/logo.png') }}" alt="SMARTCLINIC Logo" width="90" class="mb-4"> --}}
        <h1 class="login-title">Doctor or Nurse</h1>
        <p class="login-subtitle">Enter your email and password to access the dashboard</p>

        <form method="POST" action="{{ route('login-admin') }}">
            @csrf

            @if ($errors->has('login_error'))
                <div class="alert alert-danger py-2">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <div class="mb-4 text-start">
                <input type="email"
                       name="email"
                       placeholder="Enter Email Address..."
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autofocus>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
<br>
            <div class="mb-4 text-start">
                <input type="password"
                       name="password"
                       placeholder="Enter Password"
                       class="form-control @error('password') is-invalid @enderror"
                       required>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>

        <div class="text-center small mt-4">
            <a href="{{ route('homepage') }}">←Back</a>
        </div>
    </div>
</div>
@endsection
