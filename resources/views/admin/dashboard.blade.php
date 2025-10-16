@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Total Staff -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Staff</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStaff ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Total Patients -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Patients</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatients ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Inventory Report -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.reports.inventory') }}" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Inventory Report</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">View</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Patients Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Patients Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="patientsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Inventory Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Inventory Stock</h6>
                </div>
                <div class="card-body">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Patients Chart
    const patientsCtx = document.getElementById('patientsChart').getContext('2d');
    const patientsChart = new Chart(patientsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($patientsLabels ?? []) !!},
            datasets: [{
                label: 'Number of Patients',
                data: {!! json_encode($patientsData ?? []) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.6)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });

    // Inventory Chart
    const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
    const inventoryChart = new Chart(inventoryCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($inventoryLabels ?? []) !!},
            datasets: [{
                label: 'Inventory Stock',
                data: {!! json_encode($inventoryData ?? []) !!},
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
