@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #e8f5e9, #c8f0d2);
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        min-height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .form-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 40px 45px;
        max-width: 1300px;
        width: 100%;
        border-top: 8px solid #198754;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        text-align: center;
        color: #198754;
        font-weight: 700;
        margin-bottom: 35px;
        font-size: 1.8rem;
    }

    .form-floating label {
        color: #555;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid #ccc;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 5px rgba(25, 135, 84, 0.3);
    }

    .form-control[readonly] {
        background-color: #e9f7ee;
        cursor: not-allowed;
        color: #333;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 25px;
        transition: 0.3s;
    }

    .btn-success {
        background-color: #198754;
        border: none;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
    }

    .alert-danger {
        border-radius: 10px;
        background-color: #f8d7da;
        color: #842029;
        border: none;
        padding: 15px 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-card {
            padding: 25px 20px;
            box-shadow: none;
            border-radius: 12px;
        }
        h2 {
            font-size: 1.4rem;
        }
        .btn {
            font-size: 0.95rem;
            padding: 10px 18px;
        }
    }

    @media (max-width: 576px) {
        .form-control, .form-floating label {
            font-size: 0.9rem;
        }
        .d-flex.flex-column.flex-sm-row {
            flex-direction: column !important;
        }
    }
</style>

<div class="container">
    <div class="form-card">
        <h2><i class="fas fa-notes-medical me-2"></i>Add Medical History</h2>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.patients.medical_histories.store', ['patient' => $patient->user_id]) }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $patient->user_id }}">

            {{-- History Type --}}
            <div class="form-floating mb-3">
                <select name="history_type" id="history_type" class="form-control" required>
                    <option value="allergy">Allergy</option>
                    <option value="illness">Illness</option>
                    <option value="vaccination">Immunization</option>
                </select>
                <label for="history_type">History Type</label>
            </div>

            {{-- Description --}}
            <div class="form-floating mb-3">
                <textarea name="description" id="description" class="form-control" placeholder="Write details..." required>{{ old('description') }}</textarea>
                <label for="description">Description</label>
            </div>

            {{-- Notes --}}
            <div class="form-floating mb-3">
                <textarea name="notes" id="notes" class="form-control" placeholder="Optional">{{ old('notes') }}</textarea>
                <label for="notes">Notes (Optional)</label>
            </div>

            {{-- Date Recorded --}}
            <div class="form-floating mb-3">
                <input type="text" id="date_recorded" name="date_recorded" class="form-control" value="{{ now()->format('F j, Y') }}" readonly>
                <label for="date_recorded">Date Recorded</label>
            </div>

            {{-- Buttons --}}
            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                <button type="submit" class="btn btn-success w-100">
                    💾 Save Medical History
                </button>
                <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-secondary w-100">
                    ✖ Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
