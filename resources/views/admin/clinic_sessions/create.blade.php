@extends('layouts.app')

@section('page-title', 'Add Clinic Session')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #e6f4ea, #c8f0d2);
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 40px 50px;
        max-width: 1300px;
        width: 100%;
        border-top: 8px solid #198754;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        text-align: center;
        color: #198754;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 5px rgba(25, 135, 84, 0.3);
    }

    .form-control[readonly] {
        background-color: #e9f7ee;
        color: #333;
        cursor: not-allowed;
    }

    .btn {
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #198754;
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: #157347;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .alert-danger {
        border-radius: 10px;
        background-color: #f8d7da;
        color: #842029;
        border: none;
        padding: 15px 20px;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 30px 25px;
        }

        h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container">
    <div class="form-card">
        <h2>Add Clinic Session for {{ $patient->name }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.patients.clinic_sessions.store', $patient) }}" method="POST">
            @csrf

            {{-- Readonly formatted date --}}
            <div class="mb-3">
                <label for="session_date" class="form-label">Date</label>
                <input 
                    type="text" 
                    id="session_date" 
                    name="session_date" 
                    class="form-control" 
                    value="{{ now()->format('F j, Y') }}" 
                    readonly
                >
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">Reason for Visit</label>
                <input type="text" name="reason" id="reason" class="form-control"
                       value="{{ old('reason') }}" required placeholder="Enter reason for visit">
            </div>

            <div class="mb-3">
                <label for="remedy" class="form-label">Remedy / Notes</label>
                <textarea name="remedy" id="remedy" class="form-control" rows="3" placeholder="Enter remedy or treatment details">{{ old('remedy') }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-secondary">✖ Cancel</a>
                <button type="submit" class="btn btn-success">💾 Save</button>

            </div>
        </form>
    </div>
</div>

@endsection
