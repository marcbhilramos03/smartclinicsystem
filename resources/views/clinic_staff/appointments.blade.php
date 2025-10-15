@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="container py-4">
    <h1 class="mb-4">Appointments Dashboard</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!$user)
        <div class="alert alert-warning">
            You are not logged in.
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Appointments</h5>

                        @if($appointments->isEmpty())
                            <p>No appointments found.</p>
                        @else
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        {{-- <th>Patient</th> --}}
                                        <th>Department</th>
                                        <th>Program</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            {{-- <td>{{ $appointment->patient?->name ?? 'N/A' }}</td> --}}
                                            <td>{{ $appointment->department?->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->program?->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y H:i') }}</td>
                                            <td>
                                                @if($appointment->status === 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($appointment->status === 'done')
                                                    <span class="badge bg-info">Done</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($appointment->status !== 'completed')
                                                    <button type="button" class="btn btn-sm btn-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#markDoneModal{{ $appointment->id }}">
                                                        Mark as Done
                                                    </button>
                                                @else
                                                    <span class="text-muted">No actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Modals --}}
                            @foreach($appointments as $appointment)
                                @if($appointment->status !== 'completed')
                                    <div class="modal fade" id="markDoneModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="markDoneModalLabel{{ $appointment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="markDoneModalLabel{{ $appointment->id }}">Confirm Completion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to mark the appointment with 
                                                    <strong>{{ $appointment->patient?->name ?? 'N/A' }}</strong> as completed?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('clinic_staff.appointments.markDone', $appointment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Yes, Mark as Done</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
