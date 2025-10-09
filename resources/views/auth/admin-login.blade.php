@extends('layouts.guest')

@section('content')
<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4">Admin / Staff Login</h1>
    <p class="small text-gray-700 mb-4">Enter your email and password to access the dashboard</p>
</div>

<form method="POST" action="{{ route('login-admin') }}" class="user">
    @csrf
        @if ($errors->has('login_error'))
        <div class="alert alert-danger">
            {{ $errors->first('login_error') }}
        </div>
        @endif
    
    {{-- Email --}}
    <div class="form-group mb-3">
        <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
               placeholder="Enter Email Address..." value="{{ old('email') }}" required autofocus>
    </div>

    {{-- Password --}}
    <div class="form-group mb-3">
        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
               placeholder="Password" required>
        @error('password')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    {{-- Submit Button --}}
    <button type="submit" class="btn btn-primary btn-user btn-block">
        Login
    </button>
</form>

<hr>
<div class="text-center">
    <a class="small" href="#">Forgot Password?</a>
</div>
<div class="text-center mt-2">
    <a class="small" href="{{ route('patient.login.form') }}">Patient Login</a>
</div>
@endsection
