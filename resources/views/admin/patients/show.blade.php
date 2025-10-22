@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Patient Logbook: {{ $patient->first_name }} {{ $patient->last_name }}</h2>
<div class="mb-3">
    <a href="{{ route('admin.patients.clinic_sessions.create', $patient->user_id) }}" class="btn btn-primary">
        Regular Visit
    </a>
    <a href="{{ route('admin.patients.medical_histories.create', $patient->user_id) }}" class="btn btn-success">
        Add Medical History
    </a>
</div>

    <h4>Personal Information</h4>
    <ul>
        <li>Gender: {{ $patient->personalInformation->gender ?? '-' }}</li>
        <li>Birth Date: {{ $patient->personalInformation->date_of_birth ?? '-' }}</li>
        <li>Course: {{ $patient->personalInformation->course ?? '-' }}</li>
        <li>Grade Level: {{ $patient->personalInformation->grade_level ?? '-' }}</li>
        <li>Phone: {{ $patient->phone_number ?? '-' }}</li>
        <li>Address: {{ $patient->address ?? '-' }}</li>
    </ul>

    <hr>

    <h4>Medical Record</h4>
    @php
        $records = $patient->medicalRecords ?? collect();
        $records = $records->sortByDesc('created_at');
    @endphp

    @if($records->isEmpty())
        <p>No medical records found for this patient.</p>
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
                @foreach($records as $record)
                <tr>
                    <td>{{ optional($record->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                    <td>
                        @switch($record->recordable_type)
                            @case(App\Models\MedicalHistory::class)
                                Medical History
                                @break
                            @case(App\Models\ClinicSession::class)
                                Clinic Session
                                @break
                            @case(App\Models\Checkup::class)
                                Checkup ({{ $record->recordable->checkup_type ?? '-' }})
                                @break
                            @case(App\Models\Vitals::class)
                                Vitals
                                @break
                            @case(App\Models\Dental::class)
                                Dental
                                @break
                            @default
                                -
                        @endswitch
                    </td>
                    <td>
                        @php $rec = $record->recordable; @endphp
                        @switch($record->recordable_type)
                            @case(App\Models\MedicalHistory::class)
                                Type: {{ $rec->history_type ?? '-' }} <br>
                                Details: {{ $rec->description ?? '-' }} <br>

                                @break
                            @case(App\Models\ClinicSession::class)
                                Reason: {{ $rec->reason ?? '-' }} <br>
                                Remedy: {{ $rec->remedy ?? '-' }}
                                @break
                            @case(App\Models\Checkup::class)
                                Type: {{ $rec->checkup_type ?? '-' }} <br>
                                Notes: {{ $rec->notes ?? '-' }}
                                @break
                            @case(App\Models\Vitals::class)
                                Height: {{ $rec->height ?? '-' }} cm <br>
                                Weight: {{ $rec->weight ?? '-' }} kg <br>
                                BP: {{ $rec->blood_pressure ?? '-' }} <br>
                                Pulse: {{ $rec->pulse_rate ?? '-' }} <br>
                                Temp: {{ $rec->temperature ?? '-' }} °C <br>
                                Resp Rate: {{ $rec->respiratory_rate ?? '-' }} <br>
                                BMI: {{ $rec->bmi ?? '-' }}
                                @break
                            @case(App\Models\Dental::class)
                                Status: {{ $rec->dental_status ?? '-' }} <br>
                                Needs Treatment: {{ $rec->needs_treatment ?? '-' }} <br>
                                Treatment: {{ $rec->treatment_type ?? '-' }} <br>
                                Notes: {{ $rec->note ?? '-' }}
                                @break
                            @default
                                -
                        @endswitch
                    </td>
                    <td>
                         {{ $record->admin->first_name ?? '-' }} {{ $record->admin->credential->license_type ?? '-' }} <br>
                    </td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
