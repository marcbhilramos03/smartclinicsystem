@extends('layouts.app')

@section('title', 'Clinic Staff Dashboard')

@section('content')
<div class="container-fluid py-4" style="max-height:85vh; overflow-y:auto; background:#e6f4ea;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Welcome, {{ auth()->user()->name ?? 'Clinic Staff' }} 👋</h4>
            <small class="text-muted">Monitor this month’s clinic activities at a glance.</small>
        </div>
        <button class="btn btn-success rounded-pill shadow-sm px-4 py-2 mt-2">
            <i class="fa-solid fa-plus-circle me-2"></i> New Record
        </button>
    </div>

    {{-- 1️⃣ Appointments (Grouped by Date) --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4" style="background:#f0f9f0;">
        <div class="card-body">
            <h6 class="fw-bold mb-3 text-secondary">
                <i class="fa-solid fa-calendar-check me-2 text-success"></i> Appointments This Month
            </h6>

            @php
                $appointmentsByDate = $appointments->groupBy(fn($appt) => $appt->appointment_date->format('Y-m-d'));
            @endphp

            @if($appointments->count() > 0)
                @foreach($appointmentsByDate as $date => $dailyAppointments)
                    <h6 class="text-muted mt-3">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h6>
                    <ul class="list-group list-group-flush mb-2">
                        @foreach($dailyAppointments as $appt)
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2 flex-wrap">
                                <div>
                                    <strong>{{ $appt->patient->name ?? 'Patient' }}</strong><br>
                                    <small class="text-muted">{{ optional($appt->appointment_date)->format('h:i A') ?? 'N/A' }}</small>
                                </div>
                                <span class="badge rounded-pill {{ ($appt->status ?? '') === 'Completed' ? 'bg-success' : 'bg-info text-dark' }}">
                                    {{ ucfirst($appt->status ?? 'Pending') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            @else
                <p class="text-muted mt-3">No appointments scheduled for this month.</p>
            @endif
        </div>
    </div>

    {{-- 2️⃣ Recent Medical Records --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4" style="background:#eaf7f0;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h6 class="fw-bold mb-0 text-secondary">
                    <i class="fa-solid fa-heart-pulse me-2 text-danger"></i> Recent Medical Records
                </h6>
                <button class="btn btn-sm btn-success rounded-pill mt-2 mt-sm-0" type="button" data-bs-toggle="collapse" data-bs-target="#medicalRecordsList" aria-expanded="true" aria-controls="medicalRecordsList">
                    Toggle
                </button>
            </div>

            <div class="collapse show" id="medicalRecordsList">
                @if($medicalRecords->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($medicalRecords as $record)
                            <li class="list-group-item border-0 px-0 py-2 flex-wrap">
                                <strong>{{ $record->clinicSession->patient->personalInformation->first_name ?? $record->clinicSession->patient->name ?? 'Patient' }}</strong><br>
                                <small class="text-muted d-block">Diagnosis: {{ $record->diagnosis ?? 'N/A' }}</small>
                                <small class="text-muted">Session Date: {{ optional($record->clinicSession->session_date)->format('M d, Y') ?? 'N/A' }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mt-3">No recent medical records available.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- 3️⃣ Medicine Stock Alerts --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4" style="background:#f0fdf4;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h6 class="fw-bold mb-0 text-secondary">
                    <i class="fa-solid fa-capsules me-2 text-warning"></i> Medicine Stock Alerts
                </h6>
                <button class="btn btn-sm btn-success rounded-pill mt-2 mt-sm-0" type="button" data-bs-toggle="collapse" data-bs-target="#inventoryList" aria-expanded="true" aria-controls="inventoryList">
                    Toggle
                </button>
            </div>

            @php
                $lowStockItems = $inventory->filter(fn($item) => $item->quantity < 20);
            @endphp

            <div class="collapse show" id="inventoryList">
                @if($lowStockItems->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($lowStockItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2 flex-wrap">
                                <span>{{ $item->name }}</span>
                                <span class="badge rounded-pill {{ $item->quantity < 5 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                    {{ $item->quantity < 5 ? 'Low Stock' : 'Low Stock' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mt-3">No low stock items (below 20) available.</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
