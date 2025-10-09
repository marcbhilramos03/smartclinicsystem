@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->first_name }} {{ $user->middle_name ?? '' }} {{ $user->last_name }} - Records</h1>
    <a href="{{ route('admin.patients.records.create', $user->user_id) }}" class="btn btn-success mb-3">Add Record</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

 @if($user->personalInformation)
    <h4>Personal Information</h4>
    <ul>
        <li><strong>School ID:</strong> {{ $user->personalInformation->school_id ?? '-' }}</li>
        <li><strong>Gender:</strong> {{ $user->personalInformation->gender ?? '-' }}</li>
        <li><strong>Date of Birth:</strong> {{ $user->personalInformation->dob ?? '-' }}</li>
        <li><strong>Contact Number:</strong> {{ $user->personalInformation->contact_number ?? '-' }}</li>
        <li><strong>Address:</strong> {{ $user->personalInformation->address ?? '-' }}</li>
    </ul>

    <h4>Emergency Contacts</h4>
@if($user->personalInformation && $user->personalInformation->emergencyContacts->isNotEmpty())
    <ul>
    @foreach($user->personalInformation->emergencyContacts as $contact)
        <li>
            <strong>Name:</strong> {{ $contact->name }} |
            <strong>Relationship:</strong> {{ $contact->relationship ?? '-' }} |
            <strong>Phone:</strong> {{ $contact->phone_number ?? '-' }}
        </li>
    @endforeach
    </ul>
@else
    <p>No emergency contact recorded.</p>
@endif

@else
    <p>No personal information recorded.</p>
@endif


   <h3>Clinic Sessions</h3>
@if($user->clinicSessions->isEmpty())
    <p>No clinic sessions recorded.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Reason / Notes</th>
                <th>Admin / Staff In Charge</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->clinicSessions as $session)
            <tr>
                <td>{{ $session->session_date }}</td>
                <td>
                    <strong>Reason:</strong> {{ Str::limit($session->reason, 50) }}<br>
                    <strong>Remedy Given:</strong> {{ Str::limit($session->remedy, 50) }}
                    @if($session->medications->isNotEmpty())
                        <br><strong>Medications:</strong>
                        <ul class="mb-0">
                            @foreach($session->medications as $med)
                                <li>{{ $med->inventory->item_name ?? '-' }} - {{ $med->dosage ?? '' }} {{ $med->duration ?? '' }}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>{{ $session->admin->first_name ?? '-' }} {{ $session->admin->middle_name ?? '' }} {{ $session->admin->last_name ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif


<h3>Medical Histories</h3>
@if($user->medicalHistories->isEmpty())
    <p>No medical history recorded.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date Recorded</th>
                <th>Type / Description</th>
                <th>Admin / Staff In Charge</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->medicalHistories as $history)
            <tr>
                <td>{{ $history->date_recorded ?? '-' }}</td>
                <td>
                    <strong>{{ ucfirst($history->history_type) }}:</strong> {{ Str::limit($history->description, 50) }}
                </td>
                <td>{{ $history->admin->first_name ?? '-' }} {{ $history->admin->last_name ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
