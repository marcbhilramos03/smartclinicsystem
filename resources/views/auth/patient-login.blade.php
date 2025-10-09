@extends('layouts.guest')

@section('content')
<div class="container-fluid min-vh-100 p-0">
    <div class="row g-0 min-vh-100">
        <!-- Left: Login Form -->
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center bg-white p-5">
            <div class="w-100" style="max-width: 400px;">
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold text-dark mb-2">Welcome back!</h1>
                    <p class="text-muted">Enter your School ID to access your account</p>
                </div>

                <form method="POST" action="{{ route('patient.login') }}">
                    @csrf

                    @if ($errors->has('login_error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('login_error') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <input type="text" name="school_id" placeholder="School ID"
                               value="{{ old('school_id') }}"
                               class="form-control @error('school_id') is-invalid @enderror"
                               required autofocus>
                        @error('school_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold">
                        Login
                    </button>
                </form>

                <div class="mt-3 text-center">
                    <a href="{{ route('login-admin') }}" class="text-muted small text-decoration-none">
                        Back to Staff/Admin Login
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Illustration -->
        <div class="col-12 col-md-6 d-none d-md-flex bg-light justify-content-center align-items-center">
            <img src="{{ asset('images/patient-login-illustration.png') }}" 
                 alt="Login Illustration" 
                 class="img-fluid" 
                 style="max-width: 500px;">
        </div>
    </div>
</div>
@endsection
