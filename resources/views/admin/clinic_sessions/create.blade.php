@extends('layouts.app')

@section('page-title', 'Add Clinic Session')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Clinic Session for {{ $patient->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('admin.patients.clinic_sessions.store', $patient) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="session_date" class="form-label">Session Date</label>
            <input type="date" name="session_date" id="session_date" class="form-control"
                   value="{{ old('session_date', now()->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Reason for Visit</label>
            <input type="text" name="reason" id="reason" class="form-control"
                   value="{{ old('reason') }}" required>
        </div>

        <div class="mb-3">
            <label for="remedy" class="form-label">Remedy / Notes</label>
            <textarea name="remedy" id="remedy" class="form-control" rows="3">{{ old('remedy') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
