@extends('layouts.app')

@section('title', 'My Medical Records')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center fw-bold">My Medical Records</h3>

    @if($records->isEmpty())
        <div class="alert alert-info text-center">No medical records found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Checkup Type</th>
                        <th>Date</th>
                        <th>Staff</th>
                        <th>Diagnosis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{ $record->clinicSession?->checkupType?->name ?? 'General Visit' }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->clinicSession?->session_date)->format('M d, Y') }}</td>
                            <td>{{ $record->clinicSession?->ClinicStaff?->personalInformation?->first_name ?? $record->clinicSession?->staff?->username ?? 'N/A' }}</td>
                            <td>{{ Str::limit($record->diagnosis ?? 'N/A', 30) }}</td>
                            <td>
                                {{-- Button to trigger modal --}}
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#recordModal{{ $record->id }}">
                                    View Details
                                </button>

                                {{-- Modal --}}
                                <div class="modal fade" id="recordModal{{ $record->id }}" tabindex="-1" aria-labelledby="recordModalLabel{{ $record->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="recordModalLabel{{ $record->id }}">
                                                    {{ $record->clinicSession?->checkupType?->name ?? 'General Visit' }} — {{ \Carbon\Carbon::parse($record->clinicSession?->session_date)->format('M d, Y') }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Staff:</strong> {{ $record->clinicSession?->ClinicStaff?->personalInformation?->first_name ?? $record->clinicSession?->staff?->username ?? 'N/A' }}</p>
                                                <p><strong>Diagnosis:</strong> {{ $record->diagnosis ?? 'N/A' }}</p>
                                                <p><strong>Treatment:</strong> {{ $record->treatment ?? 'N/A' }}</p>
                                                <p><strong>Notes:</strong> {{ $record->notes ?? 'N/A' }}</p>

                                                {{-- Vitals --}}
                                                @if($record->clinicSession?->vitals?->isNotEmpty())
                                                    <hr>
                                                    <h6 class="fw-bold text-primary">Vitals</h6>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($record->clinicSession->vitals as $vital)
                                                            <li>
                                                                BP: {{ $vital->blood_pressure ?? '-' }}, 
                                                                HR: {{ $vital->heart_rate ?? '-' }}, 
                                                                RR: {{ $vital->respiratory_rate ?? '-' }}, 
                                                                Temp: {{ $vital->temperature ?? '-' }},
                                                                Weight: {{ $vital->weight ?? '-' }},
                                                                Height: {{ $vital->height ?? '-' }},
                                                                BMI: {{ $vital->bmi ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                {{-- Prescriptions --}}
                                                @if($record->clinicSession?->prescriptions?->isNotEmpty())
                                                    <hr>
                                                    <h6 class="fw-bold text-success">Prescriptions</h6>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($record->clinicSession->prescriptions as $prescription)
                                                            <li>
                                                                {{ $prescription->inventory?->name ?? 'Medicine' }} — 
                                                                {{ $prescription->dosage ?? '-' }}, 
                                                                {{ $prescription->frequency ?? '-' }}, 
                                                                Duration: {{ $prescription->duration ?? '-' }}, 
                                                                Qty: {{ $prescription->quantity ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $records->links() }}
        </div>
    @endif
</div>
@endsection
