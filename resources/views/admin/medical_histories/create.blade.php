@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Medical History for {{ $patient->first_name }} {{ $patient->last_name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('admin.patients.medical_histories.store', ['patient' => $patient->user_id]) }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $patient->user_id }}">
    
    <!-- History Type -->
    <div class="mb-3">
        <label for="history_type" class="form-label">History Type</label>
        <select name="history_type" id="history_type" class="form-control" required>
            <option value="">Select Type</option>
            <option value="allergy">Allergy</option>
            <option value="illness">Illness</option>
            <option value="vaccination">Vaccination</option>
        </select>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
    </div>

    <!-- Notes -->
    <div class="mb-3">
        <label for="notes" class="form-label">Notes (Optional)</label>
        <textarea name="notes" id="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
    </div>

    <!-- Date Recorded -->
    <div class="mb-3">
        <label for="date_recorded" class="form-label">Date Recorded</label>
        <input type="date" name="date_recorded" id="date_recorded" class="form-control" value="{{ old('date_recorded') }}">
    </div>

    <button type="submit" class="btn btn-primary">Add Medical History</button>
    <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection
