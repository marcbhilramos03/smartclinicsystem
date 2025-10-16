@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Medical Records</h2>

    {{-- Clinic Sessions --}}
    <h4>Clinic Sessions</h4>
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>Date</th>
                <th>Reason</th>
                <th>Remedy</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clinicSessions as $session)
            <tr>
                <td>{{ $session->session_date }}</td>
                <td>{{ $session->reason }}</td>
                <td>{{ $session->remedy ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('patient.medical_records.show', ['type' => 'clinic', 'id' => $session->id]) }}" class="btn btn-primary btn-sm">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Checkups --}}
    <h4>Checkups</h4>
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>Date</th>
                <th>Staff</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkups as $checkup)
            <tr>
                <td>{{ $checkup->date }}</td>
                <td>{{ $checkup->staff->first_name ?? 'N/A' }} {{ $checkup->staff->last_name ?? '' }}</td>
                <td>{{ $checkup->notes ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('patient.medical_records.show', ['type' => 'checkup', 'id' => $checkup->id]) }}" class="btn btn-primary btn-sm">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Medical History --}}
    <h4>Medical History</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Date Recorded</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicalHistories as $history)
            <tr>
                <td>{{ ucfirst($history->history_type) }}</td>
                <td>{{ $history->description }}</td>
                <td>{{ $history->date_recorded }}</td>
                <td>
                    <a href="{{ route('patient.medical_records.show', ['type' => 'history', 'id' => $history->id]) }}" class="btn btn-primary btn-sm">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
