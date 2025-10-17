@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Patient Medical Record</h2>

    {{-- Patient Information --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>Personal Information</span>
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-light">View User</a>
    </div>
    <div class="card-body">
        <p><strong>Student ID:</strong> {{ $user->personalInformation?->school_id ?? 'N/A' }}</p>
        <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->middle_name ?? '' }} {{ $user->last_name }}</p>
        <p><strong>Contact:</strong> {{ $user->personalInformation?->contact_number ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $user->personalInformation?->address ?? 'N/A' }}</p>
    </div>
</div>
    {{-- Clinic Sessions --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Clinic Sessions</div>
        <div class="card-body">
            @if($user->clinicSessions->isEmpty())
                <p>No clinic sessions recorded.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reason</th>
                            <th>Remedy</th>
                            <th>Medications</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->clinicSessions as $session)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($session->session_date)->format('F d, Y') }}</td>
                            <td>{{ $session->reason }}</td>
                            <td>{{ $session->remedy ?? 'N/A' }}</td>
                            <td>
                                @forelse($session->medications as $med)
                                    {{ $med->inventory->item_name ?? 'Unknown' }} ({{ $med->dosage }})
                                @empty
                                    N/A
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Medical History --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">Medical History</div>
        <div class="card-body">
            @if($user->medicalHistories->isEmpty())
                <p>No medical history recorded.</p>
            @else
                <ul>
                    @foreach($user->medicalHistories as $history)
                        <li>
                            <strong>{{ ucfirst($history->history_type) }}:</strong> 
                            {{ $history->description }} 
                            ({{ \Carbon\Carbon::parse($history->date_recorded)->format('F d, Y') }})
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Checkups --}}
    <div class="card mb-5">
        <div class="card-header bg-info text-white">Checkups (Vitals & Dental)</div>
        <div class="card-body">
            @if($user->checkups->isEmpty())
                <p>No checkups recorded yet.</p>
            @else
                @foreach($user->checkups as $checkup)
                <div class="border rounded p-3 mb-3">
                    <h5 class="text-primary mb-2">Checkup on {{ \Carbon\Carbon::parse($checkup->date)->format('F d, Y') }}</h5>
                    <p><strong>Performed by:</strong> {{ $checkup->staff->first_name ?? 'N/A' }} {{ $checkup->staff->last_name ?? '' }}</p>
                    <p><strong>Notes:</strong> {{ $checkup->notes ?? 'No additional notes' }}</p>

                    {{-- Vitals --}}
                    @if($checkup->vitals)
                    <table class="table table-sm table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Height (cm)</th>
                                <th>Weight (kg)</th>
                                <th>Blood Pressure</th>
                                <th>Pulse Rate</th>
                                <th>Temperature (°C)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $checkup->vitals->height ?? 'N/A' }}</td>
                                <td>{{ $checkup->vitals->weight ?? 'N/A' }}</td>
                                <td>{{ $checkup->vitals->blood_pressure ?? 'N/A' }}</td>
                                <td>{{ $checkup->vitals->pulse_rate ?? 'N/A' }}</td>
                                <td>{{ $checkup->vitals->temperature ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                        <p>No vital records available.</p>
                    @endif

                    {{-- Dental --}}
                    @if($checkup->dental)
                        <h6 class="mt-3">Dental Record:</h6>
                        <p><strong>Status:</strong> {{ $checkup->dental->dental_status ?? 'N/A' }}</p>
                        <p><strong>Notes:</strong> {{ $checkup->dental->notes ?? 'None' }}</p>
                    @else
                        <p>No dental record available.</p>
                    @endif
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
