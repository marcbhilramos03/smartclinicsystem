@extends('layouts.app')

@section('page-title', 'Checkup Details')

@section('content')
<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h3 class="fw-bold text-primary">{{ ucfirst($checkup->checkup_type) }} Checkup</h3>
        <p><strong>Course:</strong> {{ $checkup->courseInformation->course }} ({{ $checkup->courseInformation->year_level }})</p>
        <p><strong>Staff:</strong> {{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($checkup->date)->format('F d, Y') }}</p>
        <p><strong>Notes:</strong> {{ $checkup->notes ?? 'None' }}</p>
    </div>

    <a href="{{ route('admin.checkups.index') }}" class="btn btn-secondary mt-3">← Back to list</a>
</div>
@endsection
