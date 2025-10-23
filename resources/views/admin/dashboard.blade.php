@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
    </div>
<div class="row">

    <!-- Import Patients Card -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-primary">
            <div class="card-body">
                <h5 class="card-title">Import Patients</h5>
                <p class="card-text">Upload patient data via CSV file.</p>
                <a href="{{ route('admin.imports.patients.form') }}" class="btn btn-primary">Go to Import</a>
            </div>
        </div>
    </div>

    <!-- Import Medical Histories Card -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-success">
            <div class="card-body">
                <h5 class="card-title">Import Medical Histories</h5>
                <p class="card-text">Upload medical history data via CSV file.</p>
                <a href="{{ route('admin.imports.medical_histories.form') }}" class="btn btn-success">Go to Import</a>
            </div>
        </div>
    </div>

</div>
    <!-- Total Counts Cards -->
    <div class="row mb-4">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Staff</h5>
                    <h2>{{ $totalStaff ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Patients</h5>
                    <h2>{{ $totalPatients ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h2>{{ $totalUsers ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Checkups</h5>
                    <h2>{{ $totalCheckups ?? 0 }}</h2>
                    <small>Vitals: {{ $vitalsCheckups ?? 0 }} | Dental: {{ $dentalCheckups ?? 0 }}</small>
                </div>
            </div>
        </div>

    </div>

    <!-- Monthly Trends Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">Monthly Trends (Last 12 Months)</h6>
        </div>
        <div class="card-body">
            <canvas id="monthlyChart" height="100"></canvas>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- Chart Initialization ---
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    let monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months ?? []),
            datasets: [
                {
                    label: 'New Patients',
                    data: @json($patientsData ?? []),
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Vitals Checkups',
                    data: @json($vitalsData ?? []),
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Dental Checkups',
                    data: @json($dentalData ?? []),
                    borderColor: '#36b9cc',
                    backgroundColor: 'rgba(54, 185, 204, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
            },
            scales: {
                y: { beginAtZero: true, stepSize: 1 }
            }
        }
    });

    // --- Update Stats Function ---
    function updateStats() {
        fetch("{{ route('admin.stats') }}")
            .then(res => res.json())
            .then(data => {
                document.querySelector('.bg-primary h2').textContent = data.totalStaff;
                document.querySelector('.bg-success h2').textContent = data.totalPatients;
                document.querySelector('.bg-info h2').textContent = data.totalUsers;
                document.querySelector('.bg-warning h2').textContent = data.totalCheckups;
                document.querySelector('.bg-warning small').textContent = 
                    `Vitals: ${data.vitalsCheckups} | Dental: ${data.dentalCheckups}`;
            })
            .catch(err => console.error('Error updating stats:', err));
    }

    // --- Update Chart Function ---
    function updateChart() {
        fetch("{{ route('admin.chart') }}")
            .then(res => res.json())
            .then(data => {
                monthlyChart.data.labels = data.months;
                monthlyChart.data.datasets[0].data = data.patientsData;
                monthlyChart.data.datasets[1].data = data.vitalsData;
                monthlyChart.data.datasets[2].data = data.dentalData;
                monthlyChart.update();
            })
            .catch(err => console.error('Error updating chart:', err));
    }

    // --- Auto refresh every 10 seconds ---
    setInterval(() => {
        updateStats();
        updateChart();
    }, 10000);
</script>


@endsection
