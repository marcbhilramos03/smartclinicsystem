@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">My Appointments</h2>

    @if($appointments->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No appointments found for your department or program.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                Upcoming Appointments
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Clinic Staff</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appt)
                                <tr>
                                    <td>
                                        {{ $appt->clinicStaff?->personalInformation->first_name ?? 'Unassigned' }}
                                        {{ $appt->clinicStaff?->personalInformation->last_name ?? '' }}
                                    </td>
                                    <td>{{ optional($appt->appointment_date)->format('M d, Y H:i') }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($appt->status) {
                                                'pending' => 'badge bg-warning text-dark',
                                                'approved' => 'badge bg-success',
                                                'completed' => 'badge bg-primary',
                                                'cancelled' => 'badge bg-danger',
                                                default => 'badge bg-secondary'
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ ucfirst($appt->status) }}</span>
                                    </td>
                                    <td>{{ $appt->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
