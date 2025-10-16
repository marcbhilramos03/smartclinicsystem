@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $viewType }} Details</h2>

    @if($type === 'clinic')
        <p><strong>Date:</strong> {{ $record->session_date }}</p>
        <p><strong>Reason:</strong> {{ $record->reason }}</p>
        <p><strong>Remedy:</strong> {{ $record->remedy ?? 'N/A' }}</p>
        <p><strong>Handled By:</strong> {{ $record->admin->first_name ?? 'N/A' }} {{ $record->admin->last_name ?? '' }}</p>
    @elseif($type === 'checkup')
        <p><strong>Date:</strong> {{ $record->date }}</p>
        <p><strong>Staff:</strong> {{ $record->staff->first_name ?? 'N/A' }} {{ $record->staff->last_name ?? '' }}</p>
        <p><strong>Notes:</strong> {{ $record->notes ?? 'N/A' }}</p>

        @if($record->vitals)
            <h5>Vitals</h5>
            <ul>
                <li>Height: {{ $record->vitals->height ?? 'N/A' }} cm</li>
                <li>Weight: {{ $record->vitals->weight ?? 'N/A' }} kg</li>
                <li>Blood Pressure: {{ $record->vitals->blood_pressure ?? 'N/A' }}</li>
                <li>Pulse Rate: {{ $record->vitals->pulse_rate ?? 'N/A' }} bpm</li>
                <li>Temperature: {{ $record->vitals->temperature ?? 'N/A' }} °C</li>
            </ul>
        @endif

        @if($record->dental)
            <h5>Dental</h5>
            <p><strong>Status:</strong> {{ $record->dental->dental_status ?? 'N/A' }}</p>
            <p><strong>Notes:</strong> {{ $record->dental->notes ?? 'N/A' }}</p>
        @endif
    @elseif($type === 'history')
        <p><strong>Type:</strong> {{ ucfirst($record->history_type) }}</p>
        <p><strong>Description:</strong> {{ $record->description }}</p>
        <p><strong>Date Recorded:</strong> {{ $record->date_recorded }}</p>
        <p><strong>Recorded By:</strong> {{ $record->admin->first_name ?? 'N/A' }} {{ $record->admin->last_name ?? '' }}</p>
    @endif

    <a href="{{ route('patient.medical_records.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
