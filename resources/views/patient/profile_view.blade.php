@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold text-center">My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row">
        {{-- Left Sidebar --}}
        <div class="col-lg-4 text-center mb-4">
            <div class="bg-light rounded-4 shadow-sm p-4">
                <i class="fas fa-user-circle fa-7x text-primary mb-3"></i>
                <h4 class="fw-bold">{{ $info?->first_name }} {{ $info?->middle_name }} {{ $info?->last_name }}</h4>
                <p class="text-muted">{{ ucfirst(str_replace('_',' ',$info?->category)) }}</p>
                <p class="text-muted">{{ $info?->school_id }}</p>
                <a href="{{ route('patient.profile.edit') }}" class="btn btn-primary w-100 mt-3">Edit Profile</a>
            </div>
        </div>

        {{-- Right Content --}}
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-id-card me-2"></i>Personal & Contact Info</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <p><strong>Gender:</strong> {{ ucfirst($info?->gender) }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Birthdate:</strong> {{ $info?->birthdate }}</p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <p><strong>Address:</strong> {{ $info?->address }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Phone:</strong> {{ $info?->contact_no }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Emergency Contact:</strong> {{ $info?->emergency_contact_name }} ({{ $info?->emergency_contact_relationship }}) - {{ $info?->emergency_contact_no }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
