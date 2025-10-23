@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Patient Logbook: {{ $patient->first_name }} {{ $patient->last_name }}</h2>

    <div class="mb-3">
        <a href="{{ route('admin.patients.clinic_sessions.create', $patient->user_id) }}" class="btn btn-primary">Regular Visit</a>
        <a href="{{ route('admin.patients.medical_histories.create', $patient->user_id) }}" class="btn btn-success">Add Medical History</a>
    </div>

    <h4>Personal Information</h4>
    <ul>
        <li>Gender: {{ $patient->gender ?? '-' }}</li>
        <li>Birth Date: {{ $patient->personalInformation->date_of_birth ?? '-' }}</li>
        <li>Course: {{ $patient->personalInformation->course ?? '-' }}</li>
        <li>Grade Level: {{ $patient->personalInformation->grade_level ?? '-' }}</li>
        <li>Phone: {{ $patient->phone_number ?? '-' }}</li>
        <li>Address: {{ $patient->address ?? '-' }}</li>
    </ul>

    <hr>
    <h4>Medical Histories</h4>
    @if($patient->medicalHistories->isEmpty())
        <p>No medical histories found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Details</th>
                    <th>Incharge</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->medicalHistories->sortByDesc('created_at') as $history)
                <tr>
                    <td>{{ $history->created_at?->format('F d, Y h:i a') ?? '-' }}</td>
                    <td>Medical History</td>
                    <td>
                        Type: {{ $history->history_type ?? '-' }} <br>
                        Details: {{ $history->description ?? '-' }}
                    </td>
                    <td>{{ $history->admin->first_name ?? '-' }} {{ $history->admin->last_name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>
    <h4>Clinic Visits</h4>
    @if($patient->clinicSessions->isEmpty())
        <p>No clinic visits found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reason</th>
                    <th>Remedy</th>
                    <th>Incharge</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->clinicSessions->sortByDesc('created_at') as $clinic)
                <tr>
                    <td>{{ $clinic->created_at?->format('F d, Y h:i a') ?? '-' }}</td>
                    <td>{{ $clinic->reason ?? '-' }}</td>
                    <td>{{ $clinic->remedy ?? '-' }}</td>
                    <td>{{ $clinic->admin->first_name ?? '-' }} {{ $clinic->admin->last_name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>
    <h4>Checkups (Vitals & Dental)</h4>
    @if($patient->checkups->isEmpty())
        <p>No checkups found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Notes</th>
                    <th>Vitals / Dental Details</th>
                    <th>Incharge</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->checkups->sortByDesc('date') as $checkup)
                <tr>
                    <td>{{ $checkup->date?->format('F d, Y h:i a') ?? '-' }}</td>
                    <td>{{ $checkup->checkup_type ?? '-' }}</td>
                    <td>{{ $checkup->notes ?? '-' }}</td>
                    <td>
                        @if($checkup->vital)
                        Height: {{ $checkup->vital->height ?? '-' }} cm<br>
                        Weight: {{ $checkup->vital->weight ?? '-' }} kg<br>
                        BP: {{ $checkup->vital->blood_pressure ?? '-' }}<br>
                        Pulse: {{ $checkup->vital->pulse_rate ?? '-' }}<br>
                        Temp: {{ $checkup->vital->temperature ?? '-' }} °C<br>
                        Resp Rate: {{ $checkup->vital->respiratory_rate ?? '-' }}<br>
                        BMI: {{ $checkup->vital->bmi ?? '-' }}<br>
                        @endif

                        @if($checkup->dental)
                        Status: {{ $checkup->dental->dental_status ?? '-' }}<br>
                        Needs Treatment: {{ $checkup->dental->needs_treatment ?? '-' }}<br>
                        Treatment: {{ $checkup->dental->treatment_type ?? '-' }}<br>
                        Notes: {{ $checkup->dental->note ?? '-' }}
                        @endif
                    </td>
                    <td>{{ $checkup->staff->first_name ?? '-' }} {{ $checkup->staff->last_name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
