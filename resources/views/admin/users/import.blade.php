@extends('layouts.app')

@section('page-title', 'Import Patients')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Import Patients</h2>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Import Form --}}
    <form action="{{ route('admin.patients.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Choose Excel/CSV file</label>
            <input type="file" class="form-control" name="file" id="file" accept=".xlsx,.csv" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-upload"></i> Import Patients
        </button>
    </form>

    <hr class="my-4">

    {{-- Instructions --}}
    <div class="alert alert-info">
        <h5>Instructions:</h5>
        <ul class="mb-0">
            <li>The file must be in Excel (.xlsx) or CSV (.csv) format.</li>
            <li>The first row should contain headers exactly like: 
                <code>school_id, first_name, middle_name, last_name, gender, birthdate, contact_number, address, course, grade_level, school_year, emergency_name, emergency_relationship, emergency_phone, emergency_address</code>
            </li>
            <li>All existing patients will be updated automatically if the school_id matches.</li>
            <li>Invalid rows will be skipped and counted in the summary after import.</li>
        </ul>
    </div>
</div>
@endsection
