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
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 40px 45px;
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
        color: #000000;
        font-weight: 700;
        margin-bottom: 35px;
        font-size: 1.8rem;
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

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 25px;
        transition: 0.3s;
    }

    .btn-success {
        background-color: #198754;
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
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
            font-size: 1.4rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="container">
    <div class="form-card">
        <h2><i class="fas fa-calendar-check me-2"></i>Schedule Checkup</h2>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.checkups.store') }}" method="POST">
            @csrf

            {{-- Assign Staff --}}
            <div class="mb-3">
                <label for="staff_id" class="form-label">Assign Staff</label>
                <select name="staff_id" id="staff_id" class="form-control" required>
                    <option value="">Select Doctor</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->user_id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Course --}}
            <div class="mb-3">
                <label for="course" class="form-label">Grade/Course</label>
                <select name="course" id="course" class="form-control" required>
                    <option value="">Select Grade/Course</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->course }}">{{ $c->course }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Checkup Type --}}
            <div class="mb-3">
                <label for="checkup_type" class="form-label">Checkup Type</label>
                <select name="checkup_type" id="checkup_type" class="form-control" required>
                    <option value="vitals">Vitals</option>
                    <option value="dental">Dental</option>
                </select>
            </div>

            {{-- Date --}}
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>

            {{-- Notes --}}
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
            </div>
               <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
            <button type="submit" class="btn btn-success w-100">
                💾 Schedule Checkup
            </button>
            <a href="{{ route('admin.checkups.index') }}" class="btn btn-secondary w-100">
                ✖ Cancel
            </a>
        </div>
        </form>
    </div>
</div>

@endsection
